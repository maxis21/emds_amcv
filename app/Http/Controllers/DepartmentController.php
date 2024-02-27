<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DepartmentController extends Controller
{

    /*
    ------------------------------------------------------------
    Deparments View
    ------------------------------------------------------------
    */
    public function show()
    {
        return view('all.departments');
    }
}
