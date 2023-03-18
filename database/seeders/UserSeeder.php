<?php

namespace Database\Seeders;

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
        User::factory(10)->create();

        /** Create test user if not exists */
        if (!User::where('email', '=', 'user@example.com')->exists()) {
            User::factory()->create(['email' => 'user@example.com']);
        }
    }
}
