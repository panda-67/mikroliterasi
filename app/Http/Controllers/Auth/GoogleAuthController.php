<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;
use Laravel\Socialite\Two\InvalidStateException;
use Throwable;

class GoogleAuthController extends Controller
{
    public function redirect()
    {
        return Socialite::driver('google')->redirect();
    }

    public function callback(Request $request)
    {
        try {
            $googleUser = Socialite::driver('google')->user();
        } catch (InvalidStateException $e) {
            return redirect()->route('login')
                ->withErrors([
                    'google' => 'Sesi autentikasi Google tidak valid. Silakan coba kembali.',
                ]);
        } catch (Throwable $e) {
            report($e);

            return redirect()->route('login')
                ->withErrors([
                    'google' => 'Autentikasi Google gagal. Silakan coba kembali.',
                ]);
        }

        $googleId = $googleUser->getId();
        $email = strtolower(trim($googleUser->getEmail() ?? ''));
        $name = $googleUser->getName() ?: 'Google User';

        // Pastikan Google menyatakan email telah terverifikasi.
        $emailVerified = filter_var(
            $googleUser->user['email_verified'] ?? false,
            FILTER_VALIDATE_BOOLEAN
        );

        if (!$email || !$googleId || !$emailVerified) {
            return redirect()->route('login')
                ->withErrors([
                    'google' => 'Email Google tidak valid atau belum terverifikasi.',
                ]);
        }

        // Periksa apakah Google ID sudah terhubung ke akun lain.
        $linkedUser = User::where('google_id', $googleId)->first();

        if ($linkedUser) {
            if ($linkedUser->email !== $email || $linkedUser->role !== 'student') {
                return redirect()->route('login')
                    ->withErrors([
                        'google' => 'Akun Google ini tidak dapat digunakan untuk login.',
                    ]);
            }

            Auth::login($linkedUser);
            $request->session()->regenerate();

            return redirect()->intended('/dashboard');
        }

        // Cari akun berdasarkan email.
        $user = User::where('email', $email)->first();

        if ($user) {
            // Google Sign-In hanya diperbolehkan untuk mahasiswa.
            if ($user->role !== 'student') {
                return redirect()->route('login')
                    ->withErrors([
                        'google' => 'Akun ini tidak diizinkan menggunakan Google Sign-In. Gunakan login biasa.',
                    ]);
            }

            // Jangan menimpa Google ID yang sudah terhubung.
            if ($user->google_id !== null) {
                return redirect()->route('login')
                    ->withErrors([
                        'google' => 'Akun ini sudah terhubung dengan akun Google lain.',
                    ]);
            }

            $user->google_id = $googleId;
            $user->email_verified_at ??= now();
            $user->save();
        } else {
            // Registrasi otomatis hanya untuk role student.
            $user = User::create([
                'name' => $name,
                'email' => $email,
                'google_id' => $googleId,
                'role' => 'student',
                'password' => Str::random(64),
            ]);

            $user->email_verified_at = now();
            $user->save();
        }

        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->intended('/dashboard');
    }
}
