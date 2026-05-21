<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Model;

class Field extends Model
{
    protected $fillable = [
        'venue_id',
        'name',
        'sport_type',
        'price_per_hour',
        'capacity',
        'is_indoor',
    ];

    protected $casts = [
        'is_indoor' => 'boolean',
    ];

    public function venue(): BelongsTo
    {
        return $this->belongsTo(Venue::class);
    }

    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class);
    }

    public function timeSlots(): HasMany
    {
        return $this->hasMany(TimeSlot::class);
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }
}
