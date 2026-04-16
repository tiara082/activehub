<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Match extends Model
{
    // Karena nama modelnya sudah 'Match' dan tabelnya 'matches', 
    // Laravel otomatis mengenali tabel 'matches' tanpa perlu $table lagi.
    
    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }
}