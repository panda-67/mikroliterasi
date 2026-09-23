<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Seed administrator accounts.
     */
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@mikroliterasi.com'],
            [
                'name' => 'Mikroliterasi Admin',
                'role' => 'admin',
                'password' => Hash::make(
                    env('ADMIN_PASSWORD', 'admin123')
                ),
            ]
        );

        User::updateOrCreate(
            ['email' => 'editor@mikroliterasi.com'],
            [
                'name' => 'Mikroliterasi Editor',
                'role' => 'editor',
                'password' => Hash::make(
                    env('EDITOR_PASSWORD', 'editor123')
                ),
            ]
        );
    }
}
