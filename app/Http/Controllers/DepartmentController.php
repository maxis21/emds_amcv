<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Department;
use App\Models\Document;
use App\Models\DocRequest;
use App\Models\User;
use Illuminate\Support\Facades\DB;

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
        return view('super_admin.departments', compact('departments'));
    }

    public function showFiles($id)
    {

        $dptData = Department::find($id);
        $dptfiles = Document::with('document_versions')->where('department_id', $id)->get();

        $total_dptDocs = Document::where('department_id', $id)->count();

        $total_dptRequest = DocRequest::wherehas('user', function ($query) use ($id){
            $query->where('department_id', $id);
        })->with(['document', 'user'])->where('request_status', 0)->count();

        $total_dptUsers = User::where('department_id', $id)->count();

        return view('super_admin.dept-files', compact(
            'dptData',
            'dptfiles',
            'total_dptDocs',
            'total_dptRequest',
            'total_dptUsers'
        ));
    }

    public function addDept(Request $request)
    {
        $data = Department::create([
            'name' => $request->input('name')
        ]);

        return back()->with('success', 'Added Department Successfully.');
    }
}
