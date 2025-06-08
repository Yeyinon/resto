<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Client extends Authenticatable
{
    use HasFactory, Notifiable,HasApiTokens;
    protected $guard = 'client';

    protected $fillable = [
        'name',
        'email',
        'phone',   // <--- Assurez-vous que c'est ici !
        'address',
        'password',
        'yums'
    ];
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
   protected $hidden = [
       'password',
       'remember_token',
   ];
   public function reservations(){
    return $this->hasMany(Reservation::class);
   }
   public function comments()
   {
       return $this->hasMany(Comment::class);
   }
   protected $casts = [
    'email_verified_at' => 'datetime',
];

public function yumsTransactions(): HasMany
    {
        return $this->hasMany(YumTransaction::class);
    }

}
