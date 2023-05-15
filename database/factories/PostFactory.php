<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Storage;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
final class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $image = $this->faker->image(Storage::disk('s3cache')->path(''), 400, 400, 'post', false);

        return [
            'title' => $this->faker->sentence(),
            'description' => $this->faker->realText(),
            'image' => $image,
            'image_small' => $image,
            'image_medium' => $image,
            'image_large' => $image,
        ];
    }
}
