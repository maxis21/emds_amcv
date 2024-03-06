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
            'error' => 'The provided credentials do not match our records.',
        ]);
    }

    public function logout(){
        Auth::logout();

        return redirect()->intended('/');
    }

    public function register(Request $request){
        $this->validate($request, [
            'fname' => ['required'],
            'mname' => ['required'],
            'lname' => ['required'],
            'department' => ['required'],
            'userrole' => ['required']
        ]);

        $userpass = 'amcv1234';

        $user = new User();

        $user->fill([
            'fname' => $request->input('fname'),
            'mname' => $request->input('mname'),
            'lname' => $request->input('lname'),
            'password' => $userpass,
            'department_id' => $request->input('department')
        ]);

        $user->save();

        return redirect()->back()->with('success','');
       
    }
}