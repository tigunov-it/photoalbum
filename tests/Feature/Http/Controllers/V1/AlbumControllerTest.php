<?php

namespace Tests\Feature\Http\Controllers\V1;

use App\Models\Album;
use App\Models\User;
use Aws\Rekognition\RekognitionClient;
use Aws\Result;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Mockery;
use Mockery\MockInterface;
use Tests\TestCase;

class AlbumControllerTest extends TestCase
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

        $this->instance(
            RekognitionClient::class,
            Mockery::mock('overload:' . RekognitionClient::class, static function (MockInterface $mock) {
                $mock->shouldNotReceive('detectModerationLabels');
            }),
        );

        $response = $this->post(route('v1.albums.store'), $album->toArray());

        $response->assertUnauthorized();
    }

    public function test_authenticated_user_can_create_album(): void
    {
        $user = User::factory()->create();
        $image = UploadedFile::fake()->image('image.jpg');
        $album = Album::factory()->make(['image' => $image]);

        $this->instance(
            RekognitionClient::class,
            Mockery::mock('overload:' . RekognitionClient::class, static function (MockInterface $mock) {
                $mock->shouldReceive('detectModerationLabels')->once()->andReturn(new Result);
            }),
        );

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
}
