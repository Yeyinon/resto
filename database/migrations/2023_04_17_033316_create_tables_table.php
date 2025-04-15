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
        Schema::create('tables', function (Blueprint $table) {
            $table->id();
            $table->integer('guest_number');
            $table->string('number', 191);
            $table->string('status', 191)->default('Disponible');
            $table->foreignId('restaurant_id')->references("id")->on("restaurants")->onDelete('cascade');
            $table->string('location', 191);
            $table->timestamps();
            $table->unique(['number', 'restaurant_id']);
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tables');
    }
};
