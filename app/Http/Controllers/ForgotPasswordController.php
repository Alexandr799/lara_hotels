<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;

class ForgotPasswordController extends Controller
{
    public function create(Request $request)
    {

        return view('auth.forgot-password');
    }

    public function store(Request $request)
    {
        $request->validate([
            "email" => ['required','string','email'],
        ]);

        $status = Password::sendResetLink($request->only('email'));

        if ($status === Password::RESET_LINK_SENT) {
            return back()->with('status', trans($status));
        } else {
            return back()->withInput($request->only('email'))
                ->withErrors(trans($status));
        }
    }
}
