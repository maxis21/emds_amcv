<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DocumentController extends Controller
{
    /*
    ------------------------------------------------------------
    Document View
    ------------------------------------------------------------
    */
    public function show()
    {
        return view('all.documents');
    }
}
