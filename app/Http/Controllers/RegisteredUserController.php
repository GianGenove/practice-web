<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class RegisteredUserController extends Controller
{
    //

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

        return redirect()->route('home');
    }
}
