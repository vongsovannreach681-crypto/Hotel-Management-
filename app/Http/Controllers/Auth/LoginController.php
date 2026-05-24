<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Guest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    private const ADMIN_EMAIL = 'reach@gmail.com';
    private const ADMIN_PASSWORD = 'reach123!@#';

    public function create()
    {
        return view('auth.login');
    }

    public function store(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        if (
            $credentials['email'] === self::ADMIN_EMAIL &&
            $credentials['password'] === self::ADMIN_PASSWORD
        ) {
            $admin = User::firstOrCreate(
                ['email' => self::ADMIN_EMAIL],
                [
                    'name' => 'Admin',
                    'password' => Hash::make(self::ADMIN_PASSWORD),
                ]
            );

            if (!Hash::check(self::ADMIN_PASSWORD, $admin->password)) {
                $admin->password = Hash::make(self::ADMIN_PASSWORD);
                $admin->save();
            }

            Auth::login($admin, $request->boolean('remember'));
            $request->session()->regenerate();

            return redirect()->route('dashboard.index')->with('success', 'Welcome, Admin.');
        }

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();
            $this->syncGuestFromAuthenticatedUser();
            return redirect()->intended(route('user.home'))->with('success', 'Welcome back!');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    public function destroy(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('user.home')->with('success', 'Logged out successfully.');
    }

    private function syncGuestFromAuthenticatedUser(): void
    {
        $user = Auth::user();

        if (! $user) {
            return;
        }

        $guest = Guest::firstOrCreate(
            ['email' => $user->email],
            [
                'name' => $user->name,
                'status' => 'active',
            ]
        );

        if ($guest->name !== $user->name) {
            $guest->name = $user->name;
            $guest->save();
        }
    }
}
