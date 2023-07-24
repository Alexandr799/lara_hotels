<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

class ResetPasswordController extends Controller
{
    public function create(Request $request)
    {

        return view('auth.reset-password', ['request' => $request]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'token' => 'required|string',
            "email" => 'required|string|email',
            "password" => 'required|confirmed|min:8',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'token', 'password_confirmation'),
            function (User $user) use ($request) {
                $user->forceFill([
                    'password'=>Hash::make($request->password),
                    'remember_token'=>Str::random(60)
                ])->save();
            }
        );

        if ($status === Password::PASSWORD_RESET) {
            return redirect()->route('login');
        } else {
            return back()->withInput($request->only('email', '_token'))->withErrors(trans($status));
        }
    }
}
