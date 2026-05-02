<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    private function generateDisplayName(): string
    {
        $animals = [
            'Kucing', 'Panda', 'Koala', 'Rubah', 'Elang',
            'Kelinci', 'Harimau', 'Serigala', 'Burung', 'Kura-kura'
        ];

        $fruits = [
            'Mangga', 'Apel', 'Jeruk', 'Anggur', 'Pisang',
            'Stroberi', 'Semangka', 'Melon', 'Nanas', 'Durian'
        ];

        do {
            $displayName = $animals[array_rand($animals)] . ' ' . $fruits[array_rand($fruits)];
        } while (User::where('display_name', $displayName)->exists());

        return $displayName;
    }

    private function redirectPath(Request $request): string
    {
        $redirectTo = $request->input('redirect_to', '/my-photography');

        if (! is_string($redirectTo) || $redirectTo === '') {
            return '/my-photography';
        }

        if (! str_starts_with($redirectTo, '/') || str_starts_with($redirectTo, '//')) {
            return '/my-photography';
        }

        return $redirectTo;
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $user = User::create([
            'name' => $request->name,
            'display_name' => $this->generateDisplayName(),
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'user',
        ]);

        Auth::login($user);

        return redirect($this->redirectPath($request))->with('success', 'Register berhasil. Nama publik kamu: ' . $user->display_name);
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            return redirect($this->redirectPath($request))->with('success', 'Login berhasil.');
        }

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->withInput();
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/my-photography')->with('success', 'Logout berhasil.');
    }
    public function updateProfile(Request $request)
{
    $user = User::findOrFail(Auth::id());

    $request->validate([
        'email' => 'required|email|unique:users,email,' . $user->id,
        'password' => 'nullable|string|min:6|confirmed',
    ]);

    $user->email = $request->email;

    if ($request->filled('password')) {
        $user->password = Hash::make($request->password);
    }

    $user->save();

    return redirect('/my-photography')->with('success', 'Profile updated successfully.');
}
}
