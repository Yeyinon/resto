<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id',
        'table_id',
        'restaurant_id',         // Added restaurant_id
        'reservation_date',
        'reservation_time',
        'reservation_tele',      // Added missing field
        'reservation_email',     // Added missing field
        'guest_number',
        'special_requests',
        'status'
    ];

    protected $casts = [
        'reservation_date' => 'date'
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function table()
    {
        return $this->belongsTo(Table::class);
    }

    // Méthode pour accéder directement au restaurant via la table
    public function restaurant()
    {
        return $this->hasOneThrough(
            Restaurant::class,
            Table::class,
            'id', // Clé étrangère sur la table "tables"
            'id', // Clé primaire sur la table "restaurants"
            'table_id', // Clé étrangère locale sur la table "reservations"
            'restaurant_id' // Clé étrangère locale sur la table "tables"
        );
    }
}