<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Showtime extends Model
{
  protected $fillable = [
    'movie_id',
    'date',
    'start_time',
    'end_time',
    'room',
    'format',
    'price',
    'status'
];
public function movie()
{
    return $this->belongsTo(Movie::class);
}
}
