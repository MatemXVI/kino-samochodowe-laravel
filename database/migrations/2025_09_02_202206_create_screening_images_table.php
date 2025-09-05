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
        Schema::create('screening_images', function (Blueprint $table) {
            $table->unsignedBigInteger('id')->primary();
            $table->string('image_filename');
            $table->unsignedBigInteger('screening_id')->index('idseansu');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('screening_images');
    }
};
