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
        Schema::create('posts', function (Blueprint $table) {
            $table->id();

            $table->string('title');
            $table->string('slug')->unique();

            $table->text('excerpt')->nullable();
            $table->longText('content');

            $table->enum('category', [
                'research_update',
                'publication',
                'field_activity',
                'institutional',
                'announcement',
            ]);

            $table->string('featured_image')->nullable();

            $table->timestamp('published_at')->nullable();

            $table->enum('status', [
                'draft',
                'published',
                'archived',
            ])->default('draft');

            $table->foreignId('author_id')
                ->constrained('users')
                ->restrictOnDelete();

            $table->foreignId('research_project_id')
                ->nullable()
                ->constrained('research_projects')
                ->nullOnDelete();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
