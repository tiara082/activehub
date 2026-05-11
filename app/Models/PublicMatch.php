<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PublicMatch extends Model
{
    protected $fillable = [
        'venue_id', 'title', 'sport_type', 'city',
        'scheduled_at', 'max_players', 'current_players', 'created_by'
    ];

    protected $casts = [
        'scheduled_at' => 'datetime',
    ];

    public function venue()
    {
        return $this->belongsTo(Venue::class);
    }
}