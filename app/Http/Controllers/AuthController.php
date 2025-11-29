<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function loginForm()
    {
        return view('login');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('username', 'password');

        if ($credentials['username'] === 'frisoruim' && $credentials['password'] === 'frisoruim') {
            \Illuminate\Support\Facades\Session::put('is_admin', true);
            return redirect()->route('admin.index');
        }

        return back()->withErrors(['msg' => 'invalid credentials']);
    }

    public function logout()
    {
        \Illuminate\Support\Facades\Session::forget('is_admin');
        return redirect()->route('leaderboard.index');
    }
}
