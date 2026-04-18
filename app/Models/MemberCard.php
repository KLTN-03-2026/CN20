<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MemberCard extends Model
{
    protected $fillable = [
        'code',
        'name',
        'level',
        'discount',
        'total_spent'
    ];
}
