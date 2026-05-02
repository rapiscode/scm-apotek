<?php

namespace App\Auth;

use App\Models\User;
use App\Services\FirestoreService;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Auth\UserProvider;
use Illuminate\Support\Facades\Log;
use Throwable;

class FirebaseUserProvider implements UserProvider
{
    public function __construct(protected FirestoreService $firestore)
    {
    }

    public function retrieveById($identifier): ?Authenticatable
    {
        try {
            $user = $this->firestore->find('users', (string) $identifier);
            return $user ? new User($user->toArray()) : null;
        } catch (Throwable $e) {
            Log::warning('Firebase retrieveById gagal', ['message' => $e->getMessage()]);
            return null;
        }
    }

    public function retrieveByToken($identifier, $token): ?Authenticatable
    {
        return $this->retrieveById($identifier);
    }

    public function updateRememberToken(Authenticatable $user, $token): void
    {
    }

    public function retrieveByCredentials(array $credentials): ?Authenticatable
    {
        $email = $credentials['email'] ?? null;
        if (! $email) {
            return null;
        }

        try {
            $record = $this->firestore->auth()->getUserByEmail($email);
            $profile = $this->firestore->find('users', $record->uid) ?? $this->firestore->create('users', [
                'uid' => $record->uid,
                'name' => $record->displayName ?: strtok($record->email, '@'),
                'email' => $record->email,
                'role' => 'user',
                'is_active' => true,
            ], $record->uid);

            return new User($profile->toArray());
        } catch (Throwable $e) {
            return null;
        }
    }

    public function validateCredentials(Authenticatable $user, array $credentials): bool
    {
        try {
            $email = $credentials['email'] ?? $user->email ?? null;
            $password = $credentials['password'] ?? null;

            if (! $email || ! $password) {
                return false;
            }

            $this->firestore->auth()->signInWithEmailAndPassword($email, $password);
            return (bool) ($user->is_active ?? true);
        } catch (Throwable $e) {
            return false;
        }
    }

    public function rehashPasswordIfRequired(Authenticatable $user, array $credentials, bool $force = false): void
    {
    }
}
