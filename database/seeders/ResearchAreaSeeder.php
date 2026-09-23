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
        $areas = [
            [
                'name' => 'Microbiology',
                'description' => 'Research on microorganisms, microbial diversity, physiology, and their interactions with biological systems.',
            ],
            [
                'name' => 'Environmental Microbiology',
                'description' => 'Research on microorganisms in environmental systems and their roles in ecosystem processes.',
            ],
            [
                'name' => 'Microbial Ecology',
                'description' => 'Research on microbial communities, ecological interactions, and microbial contributions to ecosystem function.',
            ],
            [
                'name' => 'Food and Industrial Microbiology',
                'description' => 'Research on microorganisms and their applications in food systems, biotechnology, and industrial processes.',
            ],
            [
                'name' => 'Molecular Microbiology',
                'description' => 'Research on microbial genetics, molecular mechanisms, and interactions at the cellular and molecular level.',
            ],
            [
                'name' => 'Biology Education',
                'description' => 'Research on biology teaching, learning processes, curriculum, and instructional approaches.',
            ],
            [
                'name' => 'Science Education',
                'description' => 'Research on science learning, scientific literacy, pedagogy, and educational innovation.',
            ],
            [
                'name' => 'Educational Assessment and Learning',
                'description' => 'Research on assessment, learning outcomes, educational measurement, and evidence-based learning strategies.',
            ],
        ];

        foreach ($areas as $area) {
            ResearchArea::updateOrCreate(
                [
                    'slug' => str()->slug($area['name']),
                ],
                [
                    'name' => $area['name'],
                    'description' => $area['description'],
                ]
            );
        }
    }
}
