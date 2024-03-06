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

    public function register(Request $request)
    {
        $this->validate($request, [
            'fname' => 'required',
            'mname' => 'required',
            'lname' => 'required',
        ]);

        $lastname = $request->input('lname');
        $firstname = $request->input('fname');
        $middlename = $request->input('mname');

        // Get the first letter of the last name
        $firstLetterLastName = substr($lastname, 0, 1);

        // Get the first letter of the middle name
        $firstLetterMiddleName = substr($middlename, 0, 1);

        // Create the username
        $username = $firstLetterLastName . '.' . $firstname . $firstLetterMiddleName;

        $user = User::create([
            'fname' => $firstname,
            'mname' => $middlename,
            'lname' => $lastname,
            'username' => $username, // Assign the created username
            'password' => bcrypt('amcv-edms123'),
            'department_id'=> $request->input('dept_id'),
            'isActive'=> 1,
        ]);

        return response()->json(['success']);
    }

    public function destroy($id)
    {

    }

}
