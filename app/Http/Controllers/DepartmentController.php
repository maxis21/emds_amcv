<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Department;

class DepartmentController extends Controller
{

    /*
    ------------------------------------------------------------
    Deparments View
    ------------------------------------------------------------
    */
    public function show()
    {
        $departments = Department::get();
        return view('all.departments', compact('departments'));
    }

    public function showFiles($id)
    {
        $dptData = Department::find($id);
        return view('all.dept-files', compact('dptData'));
    }

    public function addDept(Request $request)
    {
        $data = Department::create([
            'name' => $request->input('name')
        ]);

        return back()->with('success', 'Added Department Successfully.');
    }
}
