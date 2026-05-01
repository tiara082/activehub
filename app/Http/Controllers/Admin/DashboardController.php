<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        if (Auth::user()->role !== 'admin') {
            return redirect()
                ->route('home')
                ->with('error', 'Anda tidak memiliki akses ke dashboard admin.');
        }

        $user = Auth::user();

        return view('admin.dashboard', [
            'user' => $user,
        ]);
    }
}
