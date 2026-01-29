<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserManagementController extends Controller
{
    public function index(Request $request)
    {
        $q = $request->query('q');
        $role = $request->query('role');
        $active = $request->query('active'); // "1" / "0" / null

        $users = User::query()
            ->when($q, fn($query) => $query->where(function ($w) use ($q) {
                $w->where('name', 'like', "%{$q}%")
                  ->orWhere('email', 'like', "%{$q}%");
            }))
            ->when($role, fn($query) => $query->where('role', $role))
            ->when($active !== null && $active !== '', fn($query) => $query->where('is_active', (bool) $active))
            ->orderByDesc('id')
            ->paginate(10)
            ->withQueryString();

        $roles = ['admin', 'user', 'kasir']; // sesuaikan kebutuhan

        return view('users.index', compact('users', 'roles', 'q', 'role', 'active'));
    }

    public function create()
    {
        $roles = ['admin', 'user', 'kasir'];
        return view('users.create', compact('roles'));
    }

    public function store(Request $request)
    {
        $roles = ['admin', 'user', 'kasir'];

        $data = $request->validate([
            'name' => ['required','string','max:255'],
            'email' => ['required','email','max:255','unique:users,email'],
            'password' => ['required','string','min:8'],
            'role' => ['required', Rule::in($roles)],
            'is_active' => ['nullable','boolean'],
        ]);

        $data['password'] = Hash::make($data['password']);
        $data['is_active'] = $request->boolean('is_active');

        User::create($data);

        return redirect()->route('users.index')->with('success', 'User berhasil dibuat.');
    }

    public function edit(User $user)
    {
        $roles = ['admin', 'user', 'kasir'];
        return view('users.edit', compact('user', 'roles'));
    }

    public function update(Request $request, User $user)
    {
        $roles = ['admin', 'user', 'kasir'];

        $data = $request->validate([
            'name' => ['required','string','max:255'],
            'email' => ['required','email','max:255', Rule::unique('users','email')->ignore($user->id)],
            'password' => ['nullable','string','min:8'],
            'role' => ['required', Rule::in($roles)],
            'is_active' => ['nullable','boolean'],
        ]);

        if (!empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }

        $data['is_active'] = $request->boolean('is_active');

        $user->update($data);

        return redirect()->route('users.index')->with('success', 'User berhasil diupdate.');
    }

    public function toggle(User $user)
    {
        // biar ga mematikan akun sendiri (opsional)
        if (auth()->id() === $user->id) {
            return back()->with('error', 'Tidak bisa menonaktifkan akun sendiri.');
        }

        $user->update(['is_active' => !$user->is_active]);

        return back()->with('success', 'Status user berhasil diubah.');
    }

    public function destroy(User $user)
    {
        if (auth()->id() === $user->id) {
            return back()->with('error', 'Tidak bisa menghapus akun sendiri.');
        }

        $user->delete();

        return back()->with('success', 'User berhasil dihapus.');
    }
}
