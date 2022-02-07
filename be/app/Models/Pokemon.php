<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pokemon extends Model
{
    use HasFactory;

    protected $table = 'pokemons';

    protected $fillable = [
        'user_id',
        'pokemon_id',
        'liked',
        'disliked',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
