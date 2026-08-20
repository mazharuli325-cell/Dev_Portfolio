<?php

namespace Database\Seeders;

use App\Models\PortfolioProfile;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::query()->updateOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Portfolio Admin',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ],
        );

        PortfolioProfile::query()->updateOrCreate(
            ['id' => 1],
            PortfolioProfile::defaultAttributes(),
        );
    }
}
