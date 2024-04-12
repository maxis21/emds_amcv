<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Department;
use App\Models\User;
use App\Models\UserRole;
use Illuminate\Support\Facades\Auth;

class UsersController extends Controller
{
    public function show()
    {
        $departments = Department::get();
        $users = User::get();
        return view('super_admin.users', compact('departments', 'users'));
    }

    public function Users_adminView(){
        $departments = Department::get();

        $authDept = Auth::user()->department_id;
        $users = User::whereHas('role.role', function ($query) {
            $query->where('name', '=', 'user');
        })->where('department_id', $authDept)->get();


        return view('admin.users', compact('departments', 'users'));
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
            'id'=> $id
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

    public function userUpdate(Request $request){
        $userID = $request->input('uid');
        $userData = User::findOrFail($userID);
        $userRole = UserRole::where('user_id', $userID);

        $userData->update([
            'fname' => $request->input('fname'),
            'mname' => $request->input('mname'),
            'lname' => $request->input('lname'),
            'department_id' => $request->input('department')
        ]);

        $userRole->update([
            'role_id' => $request->input('role')
        ]);

        $success_message = 'User updated successfully.';
        return back()->with('success', $success_message);
    }

    public function resetPassword(Request $request){
        $validateID = $request->validate([
            'resetid' => 'required'
        ]);

        $thisUser = User::findOrFail($validateID['resetid']);
        $thisUser->password = bcrypt('amcv-edms123');
        $thisUser->save();

        $success_message = 'Password updated successfully.';
        return back()->with('success', $success_message);
    }

} 
