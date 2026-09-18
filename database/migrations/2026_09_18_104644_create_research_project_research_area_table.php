<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('research_project_research_area', function (Blueprint $table) {
            $table->foreignId('research_project_id')
                ->constrained('research_projects')
                ->cascadeOnDelete();

            $table->foreignId('research_area_id')
                ->constrained('research_areas')
                ->cascadeOnDelete();

            $table->primary([
                'research_project_id',
                'research_area_id',
            ]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('research_project_research_area');
    }
};
