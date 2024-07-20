<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (!Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            return back()->withErrors(['email' => 'Invalid credentials'])->withInput($request->except('password'));
        }

        return redirect()->intended(route('home'));
    }




    public function logout()
    {
        Auth::logout();

        return redirect('/');
    }
}
