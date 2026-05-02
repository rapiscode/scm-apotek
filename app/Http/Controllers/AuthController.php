<?php

namespace App\Http\Controllers;

use App\Services\FirestoreService;
use Illuminate\Http\Request;
use Throwable;

class AuthController extends Controller
{
    public function __construct(protected FirestoreService $firestore) {}

    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        try {
            $signIn = $this->firestore->auth()->signInWithEmailAndPassword(
                $credentials['email'],
                $credentials['password']
            );

            $uid = $signIn->firebaseUserId();
            $firebaseUser = $this->firestore->auth()->getUser($uid);
            $profile = $this->firestore->find('users', $uid);

            if ($profile && isset($profile->is_active) && ! (bool) $profile->is_active) {
                return back()->withErrors(['email' => 'Akun kamu sedang nonaktif.'])->withInput();
            }

            $request->session()->regenerate();
            $request->session()->put('firebase_user', [
                'uid' => $uid,
                'name' => $profile->name ?? $firebaseUser->displayName ?? $credentials['email'],
                'email' => $profile->email ?? $firebaseUser->email ?? $credentials['email'],
                'role' => $profile->role ?? 'user',
                'is_active' => $profile->is_active ?? true,
            ]);

            return redirect()->route('dashboard');
        } catch (Throwable $e) {
            return back()->withErrors(['email' => 'Email atau password salah.'])->withInput();
        }
    }

    public function logout(Request $request)
    {
        $request->session()->forget('firebase_user');
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ]);

        try {
            $record = $this->firestore->auth()->createUser([
                'displayName' => $validated['name'],
                'email' => $validated['email'],
                'password' => $validated['password'],
                'emailVerified' => false,
                'disabled' => false,
            ]);

            $this->firestore->create('users', [
                'uid' => $record->uid,
                'name' => $validated['name'],
                'email' => $validated['email'],
                'role' => 'user',
                'is_active' => true,
            ], $record->uid);

            return redirect()->route('login')->with('success', 'Akun berhasil dibuat. Silakan login.');
        } catch (Throwable $e) {
            return back()->withErrors(['email' => 'Gagal membuat akun: ' . $e->getMessage()])->withInput();
        }
    }
}
