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
        Schema::create('yum_transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->constrained('clients')->onDelete('cascade'); // Clé étrangère vers le client
            $table->integer('amount'); // Quantité de Yums (positif pour gain, négatif pour utilisation)
            $table->enum('type', ['gain', 'utilisation']); // 'gain' ou 'utilisation'
            $table->string('description')->nullable(); // Description de la transaction (ex: "Réservation #123", "Utilisation pour réduction")
            $table->timestamps(); // created_at et updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('yum_transactions');
    }
};