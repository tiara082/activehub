<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;


class GameMatch extends Model
{
    protected $table = 'matches';

    protected $fillable = [
        'booking_id',
        'creator_id',
        'title',
        'description',
        'total_players',
        'price_per_person',
        'gender_preference',
        'status',
        'photo_url',
    ];

    protected $casts = [
        'total_players' => 'integer',
        'price_per_person' => 'integer',
    ];

    public function booking(): BelongsTo
    {
        return $this->belongsTo(Booking::class);
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'creator_id');
    }

    public function participants()
    {
        return $this->belongsToMany(
            User::class,
            'match_participants',
            'match_id',
            'user_id'
        );
    }
}