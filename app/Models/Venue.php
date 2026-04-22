<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Model;

class Venue extends Model
{
   protected $fillable = ['owner_id', 'name', 'location', 'latitude', 'longitude', 'description'];

   protected $casts = [
      'latitude' => 'decimal:6',
      'longitude' => 'decimal:6',
   ];

   public function owner(): BelongsTo
   {
      return $this->belongsTo(User::class, 'owner_id');
   }

   public function fields(): HasMany
   {
      return $this->hasMany(Field::class);
   }
}
