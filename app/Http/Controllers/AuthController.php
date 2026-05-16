<?php

namespace App\Http\Controllers;

use App\Services\FirestoreService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Throwable;

class AuthController extends Controller
{
    public function __construct(
        protected FirestoreService $firestore 
    ) {}

    public function showlogin()
    {
        return view('auth.login');
    }

    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'fullname' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'min:6'],
            'password' => ['required', 'string', 'min:6'],
        ]);

        try {
            $userRecord = $this->firestore->auth()->createUser([
                'displayName' => $validated['fullname'],
                'email' => $validated['email'],
                'password' => $validated['password'],
                'emailVerified' => false,
                'disabled' => false,
            ]);

            $uid = $userRecord->uid;

            $this->firestore->create('users', [
                'id' => $uid,
                'fullname' => $validated['fullname'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
                'role' => 'user',
                'is_active' => true,
                'created_at' => now()->toDateTimeString(),
                'updated_at' => now()->toDateTimeString(),
            ], $uid);

            return redirect()
                ->route('login')
                ->with('success', 'Registration successful. Please login.');

        } catch (Throwable $e) {
            return back()
                ->withErrors(['email' => 'Gagal membuat akun: ' . $e->getMessage(),])
                ->withInput();
        }
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
                return back()
                    ->withErrors([
                        'email' => 'Akun kamu sedang nonaktif.', 
                    ])
                    ->withInput();
            }

            $request->session()->regenerate();

            $request->session()->put('firebase_user', [
                'uid' => $uid,
                'fullname' => $profile->fullname ?? $firebaseUser->displayName ?? $credentials['email'],
                'email' => $profile->email ?? $firebaseUser->email ?? $credentials['email'],
                'role' => $profile->role ?? 'user',
                'is_active' => $profile->is_active ?? true,
            ]);

            return redirect()->route('dashboard');
        } catch (Throwable $e) {
            return back()
                ->withErrors(['email' => 'Email atau password salah.' ,])
                ->withInput();
        }
    }

    public function logout(Request $request)
    {
        $request->session()->forget('firebase_user');

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}