<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MatchParticipant extends Model
{
    const UPDATED_AT = null;

    protected $table = 'match_participants';

    protected $fillable = [
        'match_id',
        'user_id',
        'payment_proof',
        'payment_status',
    ];

    public function match(): BelongsTo
    {
        return $this->belongsTo(GameMatch::class, 'match_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
