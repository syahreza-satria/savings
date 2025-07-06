<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Laravel\Socialite\Facades\Socialite;

class AuthController extends Controller
{
    public function showRegisterForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::create([
            'name' => $validatedData['name'],
            'username' => $validatedData['username'],
            'email' => $validatedData['email'],
            'password' => bcrypt($validatedData['password']),
        ]);

        // Login user setelah registrasi
        auth()->login($user);

        return redirect()->route('app')->with('success', 'Registration successful!');
    }

    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials, $request->remember)) {
            $request->session()->regenerate();
            return redirect()->intended('/');
        }

        return back()->withErrors([
            'email' => 'Invalid credentials',
        ])->onlyInput('email');

    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }

    public function destroy_user(Request $request, $id)
    {
        // Authorization check - only allow admins or the user themselves to delete
        if (auth()->id() != $id && !auth()->user()->is_admin) {
            return back()->with('error', 'You are not authorized to delete this user.');
        }

        DB::beginTransaction();
        try {
            $user = User::with(['bills', 'savings'])->findOrFail($id);

            // Delete all related bills first
            $user->bills()->delete();

            // Delete all related savings
            $user->savings()->delete();

            // If user is deleting their own account, logout first
            if (auth()->id() == $id) {
                Auth::logout();
            }

            // Finally delete the user
            $user->delete();

            DB::commit();

            // Redirect appropriately based on who did the deletion
            if (auth()->check() && auth()->user()->is_admin) {
                return redirect()->route('users.index')->with('success', 'User deleted successfully.');
            }

            return redirect()->route('login')->with('success', 'Your account has been deleted.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Failed to delete user: ' . $e->getMessage());
        }
    }

     public function googleRedirect()
    {
        return Socialite::driver('google')->redirect();
    }

    public function googleCallback()
    {
        $googleUser = Socialite::driver('google')->user();
        // dd($googleUser);
        $user = User::whereEmail($googleUser->email)->first();
        if (!$user) {
            $user = User::create([
                'name' => $googleUser->name,
                'email' => $googleUser->email,
            ]);
        }
        Auth::login($user);

        return redirect()->route('app')->with('success', 'Selamat kamu telah berhasil mendaftarkan diri kamu!');
    }
}
