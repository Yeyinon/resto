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
        Schema::create('reservations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->references("id")->on("clients")->onDelete('cascade');
            $table->foreignId("table_id")->references("id")->on("tables")->onDelete('cascade');
            $table->bigInteger("reservation_tele");
            $table->string("reservation_email", 191);
            $table->date("reservation_date");
            $table->time("reservation_time");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservations');
    }
};
