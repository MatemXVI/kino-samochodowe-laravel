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
        Schema::table('film_images', function (Blueprint $table) {
            $table->foreign(['film_id'], 'film_images_ibfk_1')->references(['id'])->on('films')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('film_images', function (Blueprint $table) {
            $table->dropForeign('film_images_ibfk_1');
        });
    }
};
