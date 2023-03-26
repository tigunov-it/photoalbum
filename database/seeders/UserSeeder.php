<?php

namespace Database\Seeders;

use App\Models\Album;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory(5)->has(Album::factory(random_int(1, 3)))->create();

        /** Create test user if not exists */
        if (!User::where('email', '=', 'user@example.com')->exists()) {
            User::factory()
                ->has(Album::factory(random_int(1, 3)))
                ->create(['email' => 'user@example.com']);
        }
    }
}
