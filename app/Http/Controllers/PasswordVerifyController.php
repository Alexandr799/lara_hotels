<?php

namespace App\Http\Controllers;

use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PasswordVerifyController extends Controller
{
    public function create()
    {
        return view('auth.confirm-password');
    }

    public function store(Request $request)
    {
        if (!Hash::check($request->password, $request->user()->password)) {
            redirect()->route('password.confirm')->withErrors("Password is wrong!");
        }

        session()->passwordConfirmed();

        return redirect()->intended(RouteServiceProvider::HOME);
    }
}
