<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FieldController extends Controller
{
    /** GET /fields — daftar lapangan (public) */
    public function index(Request $request)
    {
        return view('fields.index');
    }

    /** GET /fields/{field} — detail lapangan (public) */
    public function show($field)
    {
        return view('fields.show', compact('field'));
    }
}
