<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /**
     * Display login page.
     *
     * @return Renderable
     */
    public function show()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $request->session()->regenerate();
            $user = Auth::user();
            $role = $user->role->name ?? '';

        switch ($role) {
            case 'admin':
                return redirect()->route('admin.dashboard');
            case 'pharmacist':
                return redirect()->route('stock.view');
            case 'medical-assistant':
                return redirect()->route('sales.history');
            case 'accountant':
                return redirect()->route('accountant.dashboard');
            default:
                return redirect()->route('home');

        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }
}

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
