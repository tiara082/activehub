<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Venue;
use App\Models\Booking;
use Illuminate\Support\Facades\Hash;

class OwnerProfileController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        // Ambil data venue milik owner
        $venues = Venue::where('owner_id', $user->id)->with('fields')->get();
        
        $fieldIds = $venues->flatMap(function($venue) {
            return $venue->fields->pluck('id');
        });
        
        $totalRevenue = Booking::whereIn('field_id', $fieldIds)
            ->where('status', 'completed')
            ->sum('total_price');
        
        $venueData = $venues->map(function($venue) {
            return (object) [
                'name' => $venue->name,
                'total_fields' => $venue->fields->count(),
                'fields_list' => $venue->fields->pluck('name')->implode(', ')
            ];
        });
        
        return view('owner.profile', compact('user', 'venueData', 'totalRevenue'));
    }
    
    // public function update(Request $request)
    // {
    //     $user = Auth::user();
        
    //     $request->validate([
    //         'name' => 'required|string|max:255',
    //         'phone' => 'nullable|string|max:15',
    //     ]);
        
    //     $user->update([
    //         'name' => $request->name,
    //         'phone' => $request->phone,
    //     ]);
        
    //     return redirect()->back()->with('success', 'Profile berhasil diupdate');
    // }
    
    // public function changePassword(Request $request)
    // {
    //     $request->validate([
    //         'current_password' => 'required',
    //         'new_password' => 'required|min:6|confirmed',
    //     ]);
        
    //     $user = Auth::user();
        
    //     if (!Hash::check($request->current_password, $user->password)) {
    //         return back()->withErrors(['current_password' => 'Password saat ini salah']);
    //     }
        
    //     $user->update([
    //         'password' => Hash::make($request->new_password),
    //     ]);
        
    //     return back()->with('success', 'Password berhasil diubah');
    // }
}