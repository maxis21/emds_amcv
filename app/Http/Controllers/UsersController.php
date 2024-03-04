<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Department;

class UsersController extends Controller
{
    public function show(){
        $departments = Department::get();
        return view('all.users', compact('departments'));
    }
}
