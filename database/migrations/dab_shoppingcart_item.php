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
        Schema::create('ab_shoppingcart_item', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ab_shoppingcart_id')->references('id')->on('ab_shoppingcart')->cascadeOnDelete();
            $table->foreignId('ab_article_id')->references('id')->on('ab_article')->cascadeOnDelete();
            $table->timestamp('ab_createdate')->default(now());
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ab_shoppingcart_item');
    }
};
