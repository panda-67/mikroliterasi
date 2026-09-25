<?php

namespace Database\Seeders;

use App\Models\TeachingMaterial;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class TeachingMaterialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = User::where('email', 'admin@mikroliterasi.com')->first();

        if (! $admin) {
            return;
        }

        $materials = [
            [
                'title' => 'Pengantar Statistika untuk Penelitian Biologi',
                'description' => 'Materi pengantar mengenai konsep dasar statistika dan penerapannya dalam penelitian biologi.',
                'ppt_url' => 'https://drive.google.com/',
            ],
            [
                'title' => 'Desain Eksperimen dalam Penelitian Biologi',
                'description' => 'Materi mengenai prinsip dasar desain eksperimen, unit percobaan, pengulangan, dan rancangan penelitian.',
                'ppt_url' => 'https://drive.google.com/',
            ],
        ];

        foreach ($materials as $material) {
            TeachingMaterial::updateOrCreate(
                [
                    'title' => $material['title'],
                ],
                [
                    'slug' => Str::slug($material['title']),
                    'description' => $material['description'],
                    'ppt_url' => $material['ppt_url'],
                    'created_by' => $admin->id,
                ]
            );
        }
    }
}
