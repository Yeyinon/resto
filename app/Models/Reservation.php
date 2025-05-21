<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;

    // Définir les statuts possibles de réservation
    const STATUS_PENDING = 'pending';
    const STATUS_CONFIRMED = 'confirmed';
    const STATUS_REJECTED = 'rejected';
    const STATUS_HONORED = 'honored';
    const STATUS_ARCHIVED = 'archived';
    
    // Liste des statuts possibles pour la validation
    public static $statuses = [
        self::STATUS_PENDING,
        self::STATUS_CONFIRMED,
        self::STATUS_REJECTED,
        self::STATUS_HONORED,
        self::STATUS_ARCHIVED
    ];

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

    // Portée pour obtenir les réservations actives (non honorées, non archivées)
    public function scopeActive($query)
    {
        return $query->whereNotIn('status', [self::STATUS_HONORED, self::STATUS_ARCHIVED]);
    }
    
    // Portée pour obtenir les réservations historiques (honorées ou archivées)
    public function scopeHistorical($query)
    {
        return $query->whereIn('status', [self::STATUS_HONORED, self::STATUS_ARCHIVED]);
    }
    
    // Portée pour trier par date croissante
    public function scopeOrderByDateAsc($query)
    {
        return $query->orderBy('date', 'asc')->orderBy('time', 'asc');
    }
    
    // Méthode pour confirmer une réservation
    public function confirm()
    {
        $this->status = self::STATUS_CONFIRMED;
        $this->save();
        return $this;
    }
    
    // Méthode pour rejeter une réservation
    public function reject()
    {
        $this->status = self::STATUS_REJECTED;
        $this->save();
        return $this;
    }
    
    // Méthode pour marquer une réservation comme honorée
    public function honor()
    {
        $this->status = self::STATUS_HONORED;
        $this->save();
        return $this;
    }
    
    // Méthode pour archiver une réservation
    public function archive()
    {
        $this->status = self::STATUS_ARCHIVED;
        $this->save();
        return $this;
    }
    
    // Vérifier si une réservation est en attente
    public function isPending()
    {
        return $this->status === self::STATUS_PENDING;
    }
    
    // Vérifier si une réservation est confirmée
    public function isConfirmed()
    {
        return $this->status === self::STATUS_CONFIRMED;
    }
    
    // Vérifier si une réservation est rejetée
    public function isRejected()
    {
        return $this->status === self::STATUS_REJECTED;
    }
    
    // Vérifier si une réservation est honorée
    public function isHonored()
    {
        return $this->status === self::STATUS_HONORED;
    }
    
    // Vérifier si une réservation est archivée
    public function isArchived()
    {
        return $this->status === self::STATUS_ARCHIVED;
    }
}