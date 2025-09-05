<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function showLoginForm(){
        return view("main.auth.login");
    }

    public function login(Request $request){

        $credentials = $request->validate([
            "email" => ['required'],
            "password" => ['required']
        ], ["email" => "Brak loginu!", "password" => "Brak hasła!"]);

        if(Auth::attempt($credentials)){
            $request->session()->regenerate();
            return redirect("/");
        }else{
            return back()->with('message', 'Nieprawidłowy login lub hasło.');
        }
    }

    public function logout(Request $request){
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect("/");
    }
}

