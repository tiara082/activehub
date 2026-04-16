<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Field extends Model
{
    protected $fillable = [
        'venue_id',
        'name',
        'sport_type',
        'price_per_hour',
        'capacity',
        'is_indoor'
    ];
}
