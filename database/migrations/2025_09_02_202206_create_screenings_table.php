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
        Schema::create('screenings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->date('date');
            $table->time('hour');
            $table->decimal('price', 10);
            $table->unsignedBigInteger('film_id')->nullable()->index('idfilmu');
            $table->unsignedBigInteger('venue_id')->nullable()->index('idmiejsca');
            $table->string('poster_filename')->nullable();
            $table->unsignedBigInteger('user_id')->nullable()->index('idsprzedawcy');
            $table->timestamp('created_at')->nullable();
            $table->bigInteger('editor_id')->nullable();
            $table->timestamp('updated_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('screenings');
    }
};
