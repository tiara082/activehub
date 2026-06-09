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
            'gender'                => ['required', 'in:male,female'],
            'password'              => ['required', 'confirmed', Password::min(8)],
        ]);

        // Normalise phone: simpan tanpa prefix +62 marker duplikat
        $phone = $this->normalisePhone($request->input('phone'));

        User::create([
            'name'     => $request->input('name'),
            'email'    => $request->input('email'),
            'phone'    => $phone,
            'role'     => $request->input('role'),
            'gender'   => $request->input('gender'),
            'password' => Hash::make($request->input('password')),
        ]);

        return redirect()
            ->route('login')
            ->with('success', 'Registrasi berhasil. Silakan login dulu.');
    }

  public function updateProfile(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . Auth::id(),
            'phone' => 'nullable|string|max:20',
            'gender' => 'required|in:male,female',
        ]);

        $user = User::findOrFail(Auth::id());

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'gender' => $request->gender,
        ]);

        return back()->with('success', 'Profile berhasil diperbarui');
    }

    public function editProfile()
    {
        return view('user.edit-profile');
    }

    public function updatePassword(Request $request)
        {
            $request->validate([
                'old_password' => 'required',
                'new_password' => 'required|min:6|confirmed',
            ]);

            $user = User::findOrFail(Auth::id());

            if (!Hash::check($request->old_password, $user->password)) {
                return back()->with('error', 'Password lama salah');
            }

            $user->update([
                'password' => Hash::make($request->new_password)
            ]);

            return back()->with('success', 'Password berhasil diubah');
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
        $role = Auth::user()->role;

        $default = match ($role) {
            'admin' => route('admin.dashboard'),
            'owner' => route('owner.venue'),
            'user'  => route('user.dashboard'),
            default => route('home'),
        };

        return redirect()->intended($default);
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
