<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class AuthController extends Controller
{
    // ─── Login ──────────────────────────────────────────────────────────────

    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'login'    => ['required', 'string'],
            'password' => ['required'],
            'role'     => ['required', 'in:user,owner'],
        ]);

        $loginValue = trim($request->input('login'));
        $requestedRole = $request->input('role');

        // Deteksi: email atau nomor HP
        $field = filter_var($loginValue, FILTER_VALIDATE_EMAIL) ? 'email' : 'phone';

        // Normalise phone: hapus spasi, awali dengan 0 jika perlu
        if ($field === 'phone') {
            $loginValue = $this->normalisePhone($loginValue);
        }

        $credentials = [
            $field     => $loginValue,
            'password' => $request->input('password'),
        ];

        // Cek user ada atau tidak
        $user = \App\Models\User::where($field, $loginValue)->first();

        // Validasi role
        if ($user && $user->role !== $requestedRole) {
            return back()->withErrors([
                'login' => "Akun ini terdaftar sebagai " . 
                          ($user->role === 'owner' ? 'Pemilik Lapangan' : 'Pemain') . 
                          ". Silakan login dengan role yang sesuai.",
            ])->onlyInput('login');
        }

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            return $this->redirectByRole();
        }

        return back()->withErrors([
            'login' => 'Email / No. HP atau password salah.',
        ])->onlyInput('login');
    }

    // ─── Register ───────────────────────────────────────────────────────────

    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name'                  => ['required', 'string', 'max:255'],
            'email'                 => ['required', 'email', 'max:255', 'unique:users,email'],
            'phone'                 => ['required', 'string', 'max:20', 'unique:users,phone'],
            'role'                  => ['required', 'in:owner,user'],
            'password'              => ['required', 'confirmed', Password::min(8)],
        ]);

        // Normalise phone: simpan tanpa prefix +62 marker duplikat
        $phone = $this->normalisePhone($request->input('phone'));

        User::create([
            'name'     => $request->input('name'),
            'email'    => $request->input('email'),
            'phone'    => $phone,
            'role'     => $request->input('role'),
            'password' => Hash::make($request->input('password')),
        ]);

        return redirect()
            ->route('login')
            ->with('success', 'Registrasi berhasil. Silakan login dulu.');
    }

    // ─── Logout ─────────────────────────────────────────────────────────────

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }

    // ─── Helpers ────────────────────────────────────────────────────────────

    /**
     * Redirect setelah login/register sesuai role user.
     */
    private function redirectByRole()
    {
        return match (Auth::user()->role) {
            'admin' => redirect()->route('admin.dashboard'),
            'owner' => redirect()->route('owner.venue'),
            'user'  => redirect()->route('user.dashboard'),
            default => redirect()->route('home'),
        };
    }

    /**
     * Normalise nomor HP ke format lokal (08xxxx).
     * User menginput tanpa prefix +62 karena ada span "+62" di form,
     * tapi kita simpan dengan awalan 0 agar konsisten.
     *
     * Contoh: "812 3456 7890" → "08123456789"
     *         "+628123456789" → "08123456789"
     */
    private function normalisePhone(string $phone): string
    {
        // Hapus semua karakter non-digit
        $digits = preg_replace('/\D/', '', $phone);

        // Ganti awalan 62 → 0
        if (str_starts_with($digits, '62')) {
            $digits = '0' . substr($digits, 2);
        }

        // Pastikan ada awalan 0
        if (!str_starts_with($digits, '0')) {
            $digits = '0' . $digits;
        }

        return $digits;
    }
}
