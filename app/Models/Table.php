<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Table extends Model
{
    use HasFactory;

    protected $fillable = [
        'number',
        'location',
        'guest_number',
        'restaurant_id',
        'status'
    ];

    // ✅ Relation correcte avec le restaurant
    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class, 'restaurant_id');
    }

    // ✅ Relation avec la réservation (si une table ne peut avoir qu'une seule réservation active)
    public function reservation()
    {
        return $this->hasMany(Reservation::class);
    }
}
