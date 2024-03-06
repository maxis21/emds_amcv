<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserRole;
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
            'fname' => 'required',
            'mname' => 'required',
            'lname' => 'required',
        ]);

        $lastname = $request->input('lname');
        $firstname = $request->input('fname');
        $middlename = $request->input('mname');

        // Get the first letter of the last name
        $firstLetterLastName = substr($lastname, 0, 1);

        // Get the first letter of the middle name
        $firstLetterMiddleName = substr($middlename, 0, 1);

        // Create the username
        $username = $firstLetterLastName . '.' . $firstname . $firstLetterMiddleName;
        $username = strtolower($username);
        $user = User::create([
            'fname' => $firstname,
            'mname' => $middlename,
            'lname' => $lastname,
            'username' => $username, // Assign the created username
            'password' => bcrypt('amcv-edms123'),
            'department_id'=> $request->input('department'),
        ]);

        $userRole = UserRole::create([
            'user_id' => $user->id,
            'role_id' => $request->input('role')
        ]);

        return redirect()->back()->with('success');
       
    }
}