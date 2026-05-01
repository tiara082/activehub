<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        if (Auth::user()->role !== 'owner') {
            return redirect()
                ->route('home')
                ->with('error', 'Role Anda tidak sesuai untuk akses dashboard owner. Anda hanya bisa mengakses sebagai ' . ucfirst(Auth::user()->role) . '.');
        }

        $user = Auth::user();

        return view('owner.dashboard', [
            'user' => $user,
        ]);
    }
}
