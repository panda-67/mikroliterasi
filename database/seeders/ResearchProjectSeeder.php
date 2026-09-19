<?php

namespace Database\Seeders;

use App\Models\ResearchProject;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ResearchProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ResearchProject::factory()
            ->count(15)
            ->create();
    }
}
