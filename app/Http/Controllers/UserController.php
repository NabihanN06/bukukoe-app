<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function signupForm()
    {
        return view("auth.signup");
    }

    public function register(Request $request)
    {
        $request->validate([
            "name" => "required|string|min:3",
            "email"=> "required|email|unique:users",
            "password"=> "required|string|min:6|confirmed",
        ]);
        // dd($request->all());
        try {

            $user = User::create([
                "name"=> $request->name,
                "email"=> $request->email,
                "password"=> bcrypt($request->password),
                // "password" => Hash::make($request->password),
            ]);

            if ($user) {
                Auth::login($user);
                return redirect()->route("dashboard.index");
            } else {
                throw new \Exception("Failed to register");
            }

        } catch (\Exception $e) {
            // dd($e->getMessage());
            return redirect()->back()->with("error", $e->getMessage());
        }
    }

    public function signinForm()
    {
        return view("auth.signin");
    }

    public function login(Request $request)
    {
        $request->validate([
            "email"=> "required|email|exists:users",
            "password"=> "required|string|min:6",
        ]);

        try {

            $credentials = $request->only("email","password");
    
            if (Auth::attempt($credentials)) {
                $request->session()->regenerate();
                
                return redirect()->route("dashboard.index");
            }
    
            return redirect()->back()->withErrors([
                "email"=> "The provided credentials do not match our records.",
            ])->onlyInput("email");
        } catch (\Exception $e) {
            // dd($e->getMessage());
            return redirect()->back()->with("error", $e->getMessage());
        }

    }
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route("sign-in-form");
    }
}
