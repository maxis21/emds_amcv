<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Department;
use App\Models\DocRequest;
use App\Models\Document;

class DashboardController extends Controller
{
    /*
    ------------------------------------------------------------
    Dashboard View
    ------------------------------------------------------------
    */
    public function show()
    {
        $totalreq = DocRequest::where('request_status', false)->count();
        $totalDpt = Department::count();
        $totalDocs = Document::count();
        return view('super_admin.dashboard', compact('totalDpt', 'totalreq', 'totalDocs'));
    }

    public function show_dashAdmin()
    {
        return view('admin.dashboard');
    }

    public function show_dashUser(){
        return view('users.dashboard');
    }
}
