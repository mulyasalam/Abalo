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
        Schema::create('ab_article', function (Blueprint $table) {
            $table->id()
                ->comment('Primärschlüssel');
            $table->string('ab_name', 80)->unique()
                ->comment('Name');
            $table->integer('ab_price')
                ->comment('Preis in Cent');;
            $table->string('ab_description', 1000)
                ->comment('Beschreibung, die die Güte oder die Beschaffenheit näher darstellt. Wird durch den "Ersteller" (ab_user) gepflegt');
            $table->unsignedInteger('ab_creator_id')
                ->comment('Referenz auf den/die Nutzer:in, der den Artikel erstellt hat und verkaufen möchte');
            $table->foreign('ab_creator_id')->references('id')->on('ab_user');

            $table->timestamp('ab_createdate')->default(now())->comment('Zeitpunkt der Erstellung des Artikels');
        });



    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ab_article');
        /*Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');*/
    }
};
