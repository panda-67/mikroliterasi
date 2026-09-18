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
        Schema::create('publication_people', function (Blueprint $table) {
            $table->foreignId('publication_id')
                ->constrained('publications')
                ->cascadeOnDelete();

            $table->foreignId('person_id')
                ->constrained('people')
                ->cascadeOnDelete();

            $table->unsignedSmallInteger('author_order')->nullable();

            $table->primary([
                'publication_id',
                'person_id',
            ]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('publication_people');
    }
};
