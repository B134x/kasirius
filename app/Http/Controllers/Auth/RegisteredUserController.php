<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    public function create(): View
    {
        return view('auth.register');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'nim'      => ['required', 'string', 'max:20', 'unique:users,nim', 'regex:/^[0-9]+$/'],
            'email'    => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ], [
            'nim.regex'  => 'NIM hanya boleh berisi angka.',
            'nim.unique' => 'NIM sudah terdaftar.',
        ]);

        User::create([
            'name'     => $request->name,
            'nim'      => $request->nim,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => 'karyawan', // default role
        ]);

        // Redirect to login — user must log in manually after registering
        return redirect()->route('login')->with('status', 'Akun berhasil dibuat. Silakan login.');
    }
}
