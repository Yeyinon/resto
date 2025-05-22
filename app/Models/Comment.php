<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id',
        'restaurant_id',
        'rating',
        'content',
    ];

    protected $casts = [
        'rating' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Relation avec le client
     */
    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    /**
     * Relation avec le restaurant
     */
    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class);
    }

    /**
     * Scope pour obtenir les commentaires d'un restaurant
     */
    public function scopeForRestaurant($query, $restaurantId)
    {
        return $query->where('restaurant_id', $restaurantId);
    }

    /**
     * Scope pour obtenir les commentaires par note
     */
    public function scopeByRating($query, $rating)
    {
        return $query->where('rating', $rating);
    }

    /**
     * Scope pour obtenir les commentaires récents
     */
    public function scopeRecent($query)
    {
        return $query->orderBy('created_at', 'desc');
    }

    /**
     * Méthode pour obtenir le texte de la note
     */
    public function getRatingTextAttribute()
    {
        $ratingTexts = [
            1 => 'Très décevant',
            2 => 'Décevant',
            3 => 'Correct',
            4 => 'Très bien',
            5 => 'Excellent'
        ];

        return $ratingTexts[$this->rating] ?? 'Non noté';
    }

    /**
     * Méthode pour obtenir les étoiles HTML
     */
    public function getStarsHtmlAttribute()
    {
        $html = '';
        for ($i = 1; $i <= 5; $i++) {
            if ($i <= $this->rating) {
                $html .= '<i class="fas fa-star star-filled"></i>';
            } else {
                $html .= '<i class="fas fa-star star-empty"></i>';
            }
        }
        return $html;
    }
}