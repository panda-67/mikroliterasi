<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            AdminSeeder::class,
            ResearchAreaSeeder::class,
        ]);

        if (app()->environment('local')) {
            $this->call([
                PersonSeeder::class,
                ResearchProjectSeeder::class,
                PublicationSeeder::class,
                TeachingMaterialSeeder::class,
            ]);

            User::updateOrCreate(
                ['email' => 'student@mikroliterasi.com'],
                [
                    'name' => 'Mikroliterasi Student',
                    'role' => 'student',
                    'password' => Hash::make(
                        env('STUDENT_PASSWORD', 'student123')
                    ),
                ]
            );
        }
    }
}
