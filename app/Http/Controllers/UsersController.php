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

    public function userRoles(Request $request){

        if($request->roles == ''){
            return redirect(route('to.Users'));
        }

        $userrole = $request->input('roles');
        $users = User::join('tbl_user_roles', 'tbl_users.id', '=', 'tbl_user_roles.user_id')
            ->join('tbl_roles', 'tbl_user_roles.role_id', '=', 'tbl_roles.id')
            ->where('tbl_roles.name', $userrole)
            ->get();

        $departments = Department::get();
        return view('all.users', compact('users','departments'));;

    }

}
