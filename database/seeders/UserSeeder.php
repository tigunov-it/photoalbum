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
        /** Create test user */
        if (!User::where('email', '=', 'test@test.com')->exists()) {
            User::factory()->create(['email' => 'test@test.com']);
        }

        User::factory(10)->create();
    }
}
