<?php

namespace Database\Seeders;

use App\Models\ResearchArea;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ResearchAreaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ResearchArea::factory()
            ->count(10)
            ->create();
    }
}
