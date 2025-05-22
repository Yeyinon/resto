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
        Schema::create('comments', function (Blueprint $table) {
          
            Schema::create('comments', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('client_id');
                $table->unsignedBigInteger('restaurant_id');
                $table->integer('rating')->comment('Note de 1 à 5 étoiles');
                $table->text('content')->comment('Contenu du commentaire');
                $table->timestamps();
                
                // Clés étrangères
                $table->foreign('client_id')->references('id')->on('clients')->onDelete('cascade');
                $table->foreign('restaurant_id')->references('id')->on('restaurants')->onDelete('cascade');
                
                // Index pour les performances
                $table->index(['restaurant_id', 'created_at']);
                $table->index('rating');
                
                // Contrainte unique : un client ne peut commenter qu'une fois par restaurant
                $table->unique(['client_id', 'restaurant_id']);
            });;
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comments');
    }
};
