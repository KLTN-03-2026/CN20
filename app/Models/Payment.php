<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'order_code',
        'movie',
        'show_date',
        'show_time',
        'seats',
        'amount',
        'method',
        'status'
    ];
}
