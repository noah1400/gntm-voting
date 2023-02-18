<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    
    public function login(Request $request) {

        //check if already logged in
        if (Auth::check()) {
            return redirect()->intended('settings');
        }

        // login user
        // redirect to settings

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            return redirect()->intended('settings');
        }

        return back()->withErrors([
            'email' => 'Falsche E-Mail-Adresse oder falsches Passwort. Du Depp!',
        ]);
    }

}
