<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        if (Auth::check()) {
            return redirect('/portal/home')->with('info', 'Anda masih login, pastikan logout untuk login akun lain.');
        }
        
        return view('pages.auth.login');
    }

    public function login(Request $request)
    {
        $this->ensureIsNotRateLimited($request);

        $credentials = $request->validate([
            'email' => ['required', 'email', 'max:255'],
            'password' => ['required', 'string', 'min:3'],
        ], [
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.max' => 'Email maksimal 255 karakter.',
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password minimal 3 karakter.',
        ]);

        $remember = $request->boolean('remember-me');

        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();
            
            RateLimiter::clear($this->throttleKey($request));
            
            return redirect()->intended('/portal/home')
                ->with('success', 'Login berhasil! Selamat datang kembali.');
        }

        RateLimiter::hit($this->throttleKey($request));

        return back()
            ->with('error', 'Email atau password salah. Silakan coba lagi.');
    }

    protected function ensureIsNotRateLimited(Request $request)
    {
        $maxAttempts = 5;

        if (RateLimiter::tooManyAttempts($this->throttleKey($request), $maxAttempts)) {
            $seconds = RateLimiter::availableIn($this->throttleKey($request));
            $minutes = ceil($seconds / 60);

            return back()
                ->with('warning', "Terlalu banyak percobaan login. Tunggu {$minutes} menit sebelum mencoba lagi.")
                ->onlyInput('email');
        }
    }

    protected function throttleKey(Request $request)
    {
        return strtolower($request->input('email')) . '|' . $request->ip();
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect('/portal')->with('success', 'Anda telah logout dari sistem.');
    }
}
