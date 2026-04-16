<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $fillable = [
    'user_id',
    'field_id',
    'time_slot_id',
    'total_price',
    'status',
    'is_public_match'
    ];
}
