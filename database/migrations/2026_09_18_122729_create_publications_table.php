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
        Schema::create('publications', function (Blueprint $table) {
            $table->id();

            $table->string('title');
            $table->string('slug')->unique();

            $table->enum('publication_type', [
                'journal_article',
                'conference_paper',
                'book',
                'book_chapter',
                'technical_report',
                'policy_brief',
                'thesis',
                'dataset',
                'other',
            ]);

            $table->string('journal')->nullable();
            $table->string('publisher')->nullable();

            $table->unsignedSmallInteger('year')->nullable();
            $table->string('volume')->nullable();
            $table->string('issue')->nullable();
            $table->string('pages')->nullable();

            $table->string('doi')->nullable();
            $table->string('url')->nullable();

            $table->longText('abstract')->nullable();

            $table->string('file')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('publications');
    }
};
