<?php

namespace App\Filament\Pages\Auth;

use Filament\Auth\Pages\Login as BaseLogin;
use Illuminate\Validation\ValidationException;
use App\Models\User;

class Login extends BaseLogin
{
    public function authenticate(): ?\Filament\Auth\Http\Responses\Contracts\LoginResponse
    {
        $data = $this->form->getState();
        $email = $data['email'] ?? null;

        if ($email) {
            $user = User::where('email', $email)->first();

            // Jika user ditemukan tapi bukan admin (misal role 'user' atau 'owner')
            if ($user && $user->role !== 'admin') {
                throw ValidationException::withMessages([
                    'data.email' => 'Akses ditolak: Akun ini tidak memiliki izin sebagai Administrator.',
                ]);
            }
        }

        // Lanjutkan ke proses login bawaan Filament
        return parent::authenticate();
    }
}
