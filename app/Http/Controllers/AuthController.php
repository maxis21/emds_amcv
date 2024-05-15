<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserRole;
use App\Events\UserLoggedIn;
use App\Events\UserLoggedOut;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Event;

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
            $user = Auth::user();
            if (!$user->isActive) {
                // User is disabled, prevent login
                Auth::logout();
                return back()->with('error', 'Your account has been disabled. Please contact support.');
            }

          
            Event::dispatch(new UserLoggedIn($user));

            if (Auth::user()->role->role->name == 'super-admin') {
                return redirect()->intended(route('to.Dashboard'));
            } elseif (Auth::user()->role->role->name == 'admin') {
                return redirect()->intended(route('to.DashAdmin'));
            } elseif (Auth::user()->role->role->name == 'user') {
                return redirect()->intended(route('to.DashUser'));
            } else {
                return back()->withErrors([
                    'error' => 'There is a problem upon logging in.',
                ]);
            }
        }

        return back()->withErrors([
            'error' => 'The provided credentials do not match our records.',
        ]);
    }

    public function logout()
    {
        $user = Auth::user();
        $user->isOnline = 0;
        $user->save();
        Event::dispatch(new UserLoggedOut($user));
        Auth::logout();

        return redirect()->intended('/');
    }

    public function register(Request $request)
    {
        $this->validate($request, [
            'fname' => 'required',
            'mname' => 'required',
            'lname' => 'required',
        ]);

        $lastname = $request->input('lname');
        $firstname = $request->input('fname');
        $middlename = $request->input('mname');

        // Get the first letter of the last name
        $firstLetterLastName = strtolower(substr($lastname, 0, 1));

        // Get the first letter of the middle name
        $firstLetterMiddleName = strtolower(substr($middlename, 0, 1));


        // Create the username
        $username = $firstLetterLastName . '.' . strtolower($firstname) . $firstLetterMiddleName;

        $user = User::create([
            'fname' => $firstname,
            'mname' => $middlename,
            'lname' => $lastname,
            'username' => $username, // Assign the created username
            'password' => bcrypt('amcv-edms123'),
            'department_id' => $request->input('department'),
        ]);

        $userRole = UserRole::create([
            'user_id' => $user->id,
            'role_id' => $request->input('role')
        ]);

        return redirect()->back()->with('success', 'User Added Successfully.');

    }
}