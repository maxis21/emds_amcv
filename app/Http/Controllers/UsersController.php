<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Department;
use App\Models\User;

class UsersController extends Controller
{
    public function show()
    {
        $departments = Department::get();
        $users = User::get();
        return view('all.users', compact('departments', 'users'));
    }

    public function update(Request $request, $id)
    {

    }
    public function active(Request $request)
    {
        $user = User::findOrFail($request->input('id'));
        $user->isActive = $request->input('status');
        $user->update();

        return back()->with('success','Record has been updated successfully!');
    }

}
