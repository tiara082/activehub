<?php

namespace App\Http\Controllers\User;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;


class DashboardController extends Controller
{
      public function index()
    {
        $user = Auth::user();

        return view('user.dashboard', compact('user'));
    }
}