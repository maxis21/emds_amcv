<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /*
    ------------------------------------------------------------
    Login View
    ------------------------------------------------------------
    */
    public function login()
    {
        return view('login');
    }

    public function postLogin(Request $request)
    {
        $credentials = $request->validate([
            'username' => ['required'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            Auth::logoutOtherDevices($request->input('password'));
            $request->session()->regenerate();
            return redirect()->intended('to.Dashboard');
        }

        return back()->withErrors([
            'username' => 'The provided credentials do not match our records.',
        ])->onlyInput('username');
    }

    public function logout(){
        Auth::logout();

        return redirect()->intended('/');
    }

    public function register(Request $request){
        $this->validate($request, [
            'username' => ['required'],
            'password'=> ['required', 'string|min: 8'],
            'fname' => ['required'],
            'mname' => ['required'],
            'lname' => ['required'],
        ]);

        $user = User::create(
            $request->all()
        );
        
        return redirect()->back()->with('success','');
    }
}