<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    public function create()
    {
        return view('auth.register');
    }

    public function store(Request $request)
    {
        $user = User::create([
            'full_name' => $request->get('full_name'),
            "email" => $request->get('email'),
            "password" => $request->get('password'),
        ]);
        
        Auth::login($user);
        return redirect(RouteServiceProvider::HOME);
    }
}
