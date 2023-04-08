<?php

namespace Tests\Feature\Http\Controllers\V1;

use App\Models\Album;
use App\Models\User;
use Aws\Rekognition\RekognitionClient;
use Aws\Result;
use Illuminate\Filesystem\FilesystemAdapter;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Mockery;
use Mockery\MockInterface;
use Symfony\Component\HttpFoundation\StreamedResponse;
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
        $user = User::factory()
            ->has(Album::factory(random_int(1, 3)))
            ->create();

        $response = $this->actingAs($user)->get(route('v1.albums.index'));

        $response->assertOk()->assertJson(['data' => []]);
    }

    public function test_unauthenticated_user_can_not_create_album(): void
    {
        $image = UploadedFile::fake()->image('image.jpg');
        $album = Album::factory()->make(['image' => $image]);

        $this->mock('overload:' . RekognitionClient::class, static function (MockInterface $mock): void {
            $mock->shouldNotReceive('detectModerationLabels');
        });

        $response = $this->post(route('v1.albums.store'), $album->toArray());

        $response->assertUnauthorized();
    }

    public function test_authenticated_user_can_create_album(): void
    {
        $user = User::factory()->create();
        $image = UploadedFile::fake()->image('image.jpg');
        $album = Album::factory()->make(['image' => $image]);

        $this->mock('overload:' . RekognitionClient::class, static function (MockInterface $mock): void {
            $mock->shouldReceive('detectModerationLabels')->once()->andReturn(new Result);
        });

        $response = $this->actingAs($user)->post(route('v1.albums.store'), $album->toArray());

        $response->assertCreated()->assertJson($album->only(['title', 'description', 'is_public']));

        $this->assertDatabaseHas(Album::class, [
            'id' => $response->json('id'),
            'user_id' => $user->id,
            'title' => $album->title,
            'description' => $album->description,
            'is_public' => $album->is_public,
        ]);
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
        $album = Album::factory()->for($user)->create();
        $filesystemAdapterMock = $this->mock(FilesystemAdapter::class, static function (MockInterface $mock) use (
            $album,
        ): void {
            $mock->shouldReceive('fileExists')
                ->once()
                ->with($album->image)
                ->andReturn(true);
            $mock->shouldReceive('download')
                ->once()
                ->with($album->image)
                ->andReturn(new StreamedResponse);
        });
        Storage::shouldReceive('disk')
            ->twice()
            ->with('s3')
            ->andReturn($filesystemAdapterMock);

        $response = $this->actingAs($user)->get(route('v1.albums.show.s3cover', ['album' => $album->id]));

        $response->assertOk();
    }
}
