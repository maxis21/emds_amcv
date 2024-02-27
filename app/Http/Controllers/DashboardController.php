<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /*
    ------------------------------------------------------------
    Dashboard View
    ------------------------------------------------------------
    */
    public function show()
    {
        return view('all.dashboard');
    }
}
