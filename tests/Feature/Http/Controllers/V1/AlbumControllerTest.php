<?php

namespace Tests\Feature\Http\Controllers\V1;

use App\Models\Album;
use App\Models\User;
use Aws\Rekognition\RekognitionClient;
use Aws\Result;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Testing\TestResponse;
use Mockery\MockInterface;
use Tests\TestCase;

final class AlbumControllerTest extends TestCase
{
    public function test_unauthenticated_user_can_not_view_listing_of_albums(): void
    {
        $response = $this->get(route('v1.albums.index'));

        $response->assertUnauthorized();
    }

    public function test_authenticated_user_can_view_listing_of_albums(): void
    {
        $user = User::factory()->create();
        $albums = Album::factory(random_int(1, 3))->for($user)->create();

        $response = $this->actingAs($user)->get(route('v1.albums.index'));

        $response->assertOk()->assertJson(['data' => []]);
        $albums->each(static fn (Album $album): TestResponse => $response->assertJsonFragment($album->toArray()));
    }

    public function test_unauthenticated_user_can_not_create_album(): void
    {
        $image = UploadedFile::fake()->image('image.jpg');
        $album = Album::factory()->make(['image' => $image]);

        $this->mock('overload:' . RekognitionClient::class, static function (MockInterface $mock): void {
            $mock->shouldNotReceive('detectModerationLabels');
        });
        Storage::fake('s3');
        Storage::fake('s3cache');

        $response = $this->post(route('v1.albums.store'), $album->toArray());

        $response->assertUnauthorized();
        Storage::disk('s3')->assertDirectoryEmpty('uploads');
    }

    public function test_authenticated_user_can_create_album(): void
    {
        $user = User::factory()->create();
        $image = UploadedFile::fake()->image('image.jpg');
        $album = Album::factory()->make(['image' => $image]);

        $this->mock('overload:' . RekognitionClient::class, static function (MockInterface $mock): void {
            $mock->shouldReceive('detectModerationLabels')->once()->andReturn(new Result);
        });
        Storage::fake('s3');
        Storage::fake('s3cache');

        $response = $this->actingAs($user)->post(route('v1.albums.store'), $album->toArray());

        $response->assertCreated()->assertJson($album->only(['title', 'description', 'is_public']));

        $this->assertDatabaseHas(Album::class, [
            'id' => $response->json('id'),
            'user_id' => $user->id,
            'title' => $album->title,
            'description' => $album->description,
            'is_public' => $album->is_public,
        ]);
        Storage::disk('s3')->assertExists($response->json('image'));
    }

    public function test_users_can_not_view_other_users_private_albums(): void
    {
        $user1 = User::factory()->create();
        $album = Album::factory()->for($user1)->create(['is_public' => false]);
        $user2 = User::factory()->create();

        $response = $this->actingAs($user2)->get(route('v1.albums.show', ['album' => $album->id]));

        $response->assertForbidden();
    }

    public function test_users_can_view_other_users_public_albums(): void
    {
        $user1 = User::factory()->create();
        $album = Album::factory()->for($user1)->create(['is_public' => true]);
        $user2 = User::factory()->create();

        $response = $this->actingAs($user2)->get(route('v1.albums.show', ['album' => $album->id]));

        $response->assertOk()->assertJson($album->toArray());
    }

    public function test_users_can_view_own_private_albums(): void
    {
        $user = User::factory()->create();
        $album = Album::factory()->for($user)->create(['is_public' => false]);

        $response = $this->actingAs($user)->get(route('v1.albums.show', ['album' => $album->id]));

        $response->assertOk()->assertJson($album->toArray());
    }

    public function test_user_can_view_albums_cover(): void
    {
        $user = User::factory()->create();
        $image = UploadedFile::fake()->image('image.jpg');
        $album = Album::factory()->for($user)->create();

        Storage::fake('s3');
        Storage::fake('s3cache');
        Storage::disk('s3')->putFileAs($image, $album->image);

        $response = $this->actingAs($user)->get(route('v1.albums.show.s3cover', ['album' => $album->id]));

        $response->assertOk();
    }

    public function test_user_can_download_zip(): void
    {
        $user = User::factory()->create();
        $image = UploadedFile::fake()->image('image.jpg');
        $album = Album::factory()->for($user)->create(['created_at' => '2023-01-01 00:00:00']);

        Storage::fake('s3');
        Storage::fake('s3cache');

        Storage::disk('s3')->put("uploads/{$user->username}/2023-01-01_00:00:00", $image);

        $response = $this->actingAs($user)->get(route('v1.albums.download-zip', ['album' => $album->id]));

        $response->assertOk();
    }

    public function test_user_can_update_album(): void
    {
        $user = User::factory()->create();
        $albumCreated = Album::factory()->for($user)->create();
        $image = UploadedFile::fake()->image('image.jpg');
        $albumUpdate = Album::factory()->make(['image' => $image]);

        $this->mock('overload:' . RekognitionClient::class, static function (MockInterface $mock): void {
            $mock->shouldReceive('detectModerationLabels')->once()->andReturn(new Result);
        });
        Storage::fake('s3');
        Storage::fake('s3cache');

        $response = $this->actingAs($user)->put(
            route('v1.albums.update', ['album' => $albumCreated->id]),
            $albumUpdate->toArray(),
        );

        $response->assertNoContent();

        $this->assertDatabaseHas(Album::class, [
            'id' => $albumCreated->id,
            'user_id' => $user->id,
            'title' => $albumUpdate->title,
            'description' => $albumUpdate->description,
            'is_public' => $albumUpdate->is_public,
        ]);
        Storage::disk('s3')->assertExists($albumCreated->refresh()->image);
    }

    public function test_user_can_delete_album(): void
    {
        $user = User::factory()->create();
        $image = UploadedFile::fake()->image('image.jpg');
        $album = Album::factory()->for($user)->create();

        Storage::fake('s3');
        Storage::fake('s3cache');
        Storage::disk('s3')->putFileAs($image, $album->image);

        $response = $this->actingAs($user)->delete(route('v1.albums.destroy', ['album' => $album->id]));

        $response->assertNoContent();

        $this->assertDatabaseMissing(Album::class, [
            'id' => $album->id,
        ]);
        Storage::disk('s3')->assertMissing($album->image);
    }
}
