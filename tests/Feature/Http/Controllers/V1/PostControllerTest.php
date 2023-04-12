<?php

namespace Tests\Feature\Http\Controllers\V1;

use App\Models\Album;
use App\Models\Post;
use App\Models\User;
use Aws\Rekognition\RekognitionClient;
use Aws\Result;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Mockery\MockInterface;
use Tests\TestCase;

final class PostControllerTest extends TestCase
{
    public function test_user_can_create_post(): void
    {
        $user = User::factory()->create();
        $album = Album::factory()->for($user)->create();
        $image = UploadedFile::fake()->image('image.jpg');
        $post = Post::factory()->make([
            'album_id' => $album->id,
            'image' => $image,
        ]);

        $this->mock('overload:' . RekognitionClient::class, static function (MockInterface $mock): void {
            $mock->shouldReceive('detectModerationLabels')->once()->andReturn(new Result);
        });
        Storage::fake('s3');

        $response = $this->actingAs($user)->post(route('v1.posts.store'), $post->toArray());

        $response->assertCreated()->assertJson($post->only(['album_id', 'title', 'description']));

        $this->assertDatabaseHas(Post::class, [
            'id' => $response->json('id'),
            'user_id' => $user->id,
            'album_id' => $post->album_id,
            'title' => $post->title,
            'description' => $post->description,
        ]);
        Storage::disk('s3')->assertExists([
            $response->json('image'),
            $response->json('image_small'),
            $response->json('image_medium'),
            $response->json('image_large'),
        ]);
    }
}
