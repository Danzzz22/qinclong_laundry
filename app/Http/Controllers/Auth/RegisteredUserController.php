<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Tampilkan halaman register
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Proses register user baru
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        // Buat user baru, default role = user
        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => 'user', // default role user
        ]);

        event(new Registered($user));

        // Auto login setelah register
        Auth::login($user);

        // Arahkan sesuai role
        if ($user->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }

        // Kalau user biasa, langsung ke form pemesanan
        return redirect()->route('user.orders.create');
    }
}
