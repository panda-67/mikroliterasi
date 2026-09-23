<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

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
            ]);
        }
    }
}
