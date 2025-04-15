<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Plat extends Model
{
    use HasFactory;
    protected $fillable = ['nom', 'prix', 'photo', 'menu_id'];

    public function menu()
{
    return $this->belongsTo(Menu::class);
}

}
