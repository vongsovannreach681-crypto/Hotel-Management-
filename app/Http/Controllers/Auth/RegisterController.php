<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Guest;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function create()
    {
        return view('auth.register');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        event(new Registered($user));

        Auth::login($user);
        $this->syncGuestFromUser($user->name, $user->email);

        return redirect()->route('user.home')->with('success', 'Account created successfully. Welcome!');
    }

    private function syncGuestFromUser(string $name, string $email): void
    {
        $guest = Guest::firstOrCreate(
            ['email' => $email],
            [
                'name' => $name,
                'status' => 'active',
            ]
        );

        if ($guest->name !== $name) {
            $guest->name = $name;
            $guest->save();
        }
    }
}
