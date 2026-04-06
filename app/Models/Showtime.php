<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Showtime extends Model
{
   protected $fillable = [
    'movie',
    'room',
    'start',
    'end',
    'format',
    'price'
    ];
    public function movie()
    {
        return $this->belongsTo(Movie::class);
    }
}
