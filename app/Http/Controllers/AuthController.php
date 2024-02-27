<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    /*
    ------------------------------------------------------------
    Login View
    ------------------------------------------------------------
    */
    public function login(){
        return view('login');
    }
}
