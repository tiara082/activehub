<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Model;

class Venue extends Model
{
    protected $fillable = [
        'owner_id', 'name', 'sport_type', 'location', 'city', 
        'latitude', 'longitude', 'description', 'rules',
        'open_time', 'close_time', 'facilities', 'photo_url', 'price_per_hour'
    ];

    protected $casts = [
        'latitude' => 'decimal:6',
        'longitude' => 'decimal:6',
        'facilities' => 'array',
        'sport_type' => 'array',
    ];

   public function owner(): BelongsTo
   {
      return $this->belongsTo(User::class, 'owner_id');
   }

   public function fields(): HasMany
   {
      return $this->hasMany(Field::class);
   }

   public function reviews()
   {
      return $this->hasManyThrough(Review::class, Field::class);
   }
}
