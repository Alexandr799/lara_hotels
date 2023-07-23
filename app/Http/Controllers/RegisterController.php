<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Providers\RouteServiceProvider;
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
        $request->validate([
            'full_name' => 'required|string',
            "email" => 'required|string|email|unique:users',
            "password" => 'required|confirmed|min:8',
        ]);

        $user = User::create([
            'full_name' => $request->get('full_name'),
            "email" => $request->get('email'),
            "password" => Hash::make($request->get('password')),
        ]);

        Auth::login($user);
        return redirect(RouteServiceProvider::HOME);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        return redirect('/');
    }
}
