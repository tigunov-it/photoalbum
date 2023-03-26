<?php

namespace Database\Seeders;

use App\Models\Album;
use App\Models\Post;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Album::all(['id', 'user_id'])
            ->each(static fn (Album $album): Collection => Post::factory(random_int(2, 3))->create([
                'user_id' => $album->user_id,
                'album_id' => $album->id,
            ]));
    }
}
