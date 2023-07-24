<?php

namespace App\Http\Controllers;

use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function create()
    {
        return view('auth.login');
    }

    public function store(Request $request)
    {
        $request->validate([
            "email" => 'required|string|email',
            "password" => 'required|string',
        ]);


        if (Auth::attempt($request->only('email', 'password'), $request->boolean('remember'))){
            return redirect()->intended(RouteServiceProvider::HOME);
        } else {
            $request->session()->regenerate();
            return redirect()->back()->withInput()->withErrors(['noAuth'=>'No auth! Email or password is wrong!']);
        }
    }
}
