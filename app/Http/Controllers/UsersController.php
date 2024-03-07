<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Department;
use App\Models\User;
use App\Models\UserRole;

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
        if($user->isActive)
        $message = 'Record has been updated successfully!';
        else
        $message = 'User account has successfully disabled.';

        return back()->with('success', $message);
    }

    public function fetch($id)
    {
        $user = User::findOrFail($id);
        $firstname = $user->fname;
        $mname =  $user->mname;
        $lastname = $user->lname;
        $department_id = $user->department_id;

        $roles = UserRole::where('user_id', $user->id)->first();

        return response()->json([
            'fname'=> $firstname,
            'mname'=> $mname,
            'lname'=> $lastname,
            'department_id'=> $department_id,
            'role'=> $roles->role_id,
        ]);
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
