<?php

namespace App\Http\Controllers;

use App\Models\Match; // Ganti GameMatch menjadi Match
use Illuminate\Http\Request;

class MatchController extends Controller
{
    public function show($id)
    {
$match = Match::with('booking')->findOrFail($id);

        return view('match.detail', compact('match'));
    }
}