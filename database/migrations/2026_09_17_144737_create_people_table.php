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
        Schema::create('people', function (Blueprint $table) {
            $table->id();

            $table->string('name');
            $table->string('slug')->unique();

            $table->string('photo')->nullable();
            $table->string('position')->nullable();

            $table->text('short_bio')->nullable();
            $table->longText('bio')->nullable();

            $table->string('email')->nullable();
            $table->string('website')->nullable();

            $table->string('scopus')->nullable();
            $table->string('google_scholar')->nullable();
            $table->string('orcid')->nullable();
            $table->string('sinta')->nullable();

            $table->text('education')->nullable();
            $table->text('research_interests')->nullable();

            $table->enum('status', [
                'active',
                'inactive',
            ])->default('active');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('people');
    }
};
