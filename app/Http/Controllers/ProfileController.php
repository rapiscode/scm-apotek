<?php

namespace App\Http\Controllers;

use App\Services\FirestoreService;
use Illuminate\Http\Request;
use Throwable;

class ProfileController extends Controller
{
    public function __construct(protected FirestoreService $firestore) {}

    public function edit(Request $request)
    {
        $sessionUser = (object) $request->session()->get('firebase_user', []);
        return view('profile.edit', ['user' => $sessionUser]);
    }

    public function update(Request $request)
    {
        $sessionUser = (object) $request->session()->get('firebase_user', []);
        $uid = $sessionUser->uid ?? null;

        if (! $uid) {
            return redirect()->route('login');
        }

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
        ]);

        try {
            $payload = ['displayName' => $validated['name'], 'email' => $validated['email']];
            if (! empty($validated['password'])) {
                $payload['password'] = $validated['password'];
            }

            $this->firestore->auth()->updateUser($uid, $payload);
            $this->firestore->update('users', $uid, [
                'name' => $validated['name'],
                'email' => $validated['email'],
            ]);

            $request->session()->put('firebase_user.name', $validated['name']);
            $request->session()->put('firebase_user.email', $validated['email']);

            return back()->with('success', 'Profile berhasil diupdate.');
        } catch (Throwable $e) {
            return back()->withErrors(['email' => 'Gagal update profile: ' . $e->getMessage()]);
        }
    }
}
