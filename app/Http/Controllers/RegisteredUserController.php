<?php

namespace App\Http\Controllers;

use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class RegisteredUserController extends Controller
{
    //
    public function index()
    {
        return view('email.registered-user');
    }

    public function create()
    {
        return view('register');
    }

    public function store(Request $request)
    {
        $validate = $request->validate([
            'first_name' => [
                'required',
                'string',
                'min:4',
                'max:250'
            ],
            'last_name' => [
                'required',
                'string',
                'min:4',
                'max:250'
            ],
            'email' => [
                'required',
                'email:rfc,dns',
                'unique:users'
            ],
            'password' => [
                'required',
                'string',
                'min:8',
                'confirmed'
            ]
        ]);

        $user = User::create($validate);

        Auth::login(($user));

        // Dispatch Registered Event
        event(new Registered($user));

        return redirect()->route('verification.notice');
    }

    public function verify(EmailVerificationRequest $request)
    {
        // Execute Email Verification
        $request->fulfill();

        return redirect()->route('home')->with('message', 'Email Verified Successfully!');
    }

    public function resend(Request $request)
    {
        $request->user()->sendEmailVerificationNotification();

        return back()->with('message', 'Verification link sent!');
    }
}
