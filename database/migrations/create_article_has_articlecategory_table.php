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
        Schema::create('ab_article_has_articlecategory', function (Blueprint $table) {
            $table->id()->comment('Primärschlüssel');
            $table->unsignedInteger('ab_articlecategory_id')->references('id')->on('ab_articlecategory')->comment('Referenz auf eine Artikelkategorie');
            $table->unsignedInteger('ab_article_id')->references('id')->on('ab_article')->comment('Referenz auf einen Artikel');
            $table->UNIQUE(['ab_articlecategory_id', 'ab_article_id']);
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ab_article_has_articlecategory');
    }
};
