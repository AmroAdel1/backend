<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function getLoginForm()
    {
        if (Auth::check()) {
            return redirect()->route('todos.index');
        }
        return view('auth.login');
    }

    public function authenticate(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $remember = $request->has('remember');

        if (Auth::attempt($validated, $remember)) {
            $request->session()->regenerate();
            return redirect()->intended(route('todos.index'))
                ->with('success', 'Welcome back, ' . Auth::user()->name . '!');
        }   //return redirect()->route('todos.index');

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    public function getRegisterForm()
    {
        if (Auth::check()) {
            return redirect()->route('todos.index');
        }
        return view("auth.register");
    }

    public function register(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'terms' => 'required|accepted',
        ]);

        //$user = User::create($validated);
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        Auth::login($user);    // auth()->login()

        return redirect()->route('todos.index')
            ->with('success', 'Welcome to MyTodos, ' . $user->name . '! Your account has been created.');

    }

    public function logout(Request $request){
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('auth.login')
            ->with('success', 'You have been logged out successfully.');
    }

    public function settings()    // Show settings page (placeholder)
    {
        return view('auth.settings');
    }
}
