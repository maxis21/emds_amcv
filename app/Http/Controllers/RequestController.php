<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Models\DocRequest;
use Illuminate\Contracts\Cache\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;


class RequestController extends Controller
{
    /*
    ------------------------------------------------------------
    Login View
    ------------------------------------------------------------
    */

    // ======================= Show View Functions for the three user roles ==================\

    // --------------------------- SUPER-ADMIN View --------------------------------
    public function show()
    {
        $requestedDocs = DocRequest::with(['document', 'user'])->get();
        $totalRequests = DocRequest::where('request_status', false)->count();
        return view('super_admin.request', compact('requestedDocs', 'totalRequests'));
    }

    // --------------------------- ADMIN View --------------------------------
    public function showRequest_adminView()
    {

        $userDept = Auth::user()->department_id;

        // $requestedDocs = DocRequest::with(['document', 'user'])->get();
        $requestedDocs = DocRequest::wherehas('user', function ($query) use ($userDept) {
            $query->where('department_id', $userDept);
        })->with(['document', 'user'])->get();
        $totalRequests = DocRequest::where('request_status', false)->count();

        return view('admin.request', compact('requestedDocs', 'totalRequests'));
    }

    // --------------------------- USER View --------------------------------
    public function show_requestUser()
    {
        $userID = Auth::user()->id;

        // $requestedDocs = DocRequest::with(['document', 'user'])->get();
        $requestedDocs = DocRequest::where('user_id', $userID)->get();

        return view('users.request', compact('requestedDocs'));
    }

    // --------------APPROVED REQUEST (FOR SUPER-ADMIN AND ADMIN ONLY)----------------------
    public function approveReq($id)
    {
        $requestData = DocRequest::findOrFail($id);
        $requestData->request_status = true;
        $requestData->save();

        return back()->with('success', 'Request Approved');
    }


    // --------------------FILE STATUS SELECT---------------------------
    public function fileStatus(Request $request)
    {
        $userRole = Auth::user()->role->role->name;
        $userDept = Auth::user()->department_id;
        $userID = Auth::user()->id;
        $docStatus = $request->fileStatus;

        if ($request->fileStatus === null) {
            if ($userRole == 'super-admin') {
                return redirect(route('to.Request'));
            } elseif ($userRole == 'admin') {
                return redirect(route('to.Request.admin'));
            }
            else{
                return redirect(route('to.request-user'));
            }
        }
        $docStatus = filter_var($docStatus, FILTER_VALIDATE_BOOLEAN);



        if ($userRole == 'super-admin') {
            $requestedDocs = DocRequest::where('request_status', $docStatus)->get();

            return view('super_admin.request', compact('requestedDocs'));
        } elseif ($userRole == 'admin') {

            $requestedDocs = DocRequest::wherehas('user', function ($query) use ($userDept) {
                $query->where('department_id', $userDept);
            })->where('request_status', $docStatus)->get();


            return view('admin.request', compact('requestedDocs'));
        } else {
            $requestedDocs = DocRequest::where('user_id', $userID)->where('request_status', $docStatus)->get();
            return view('users.request', compact('requestedDocs'));


        }
    }

    public function download_document($id)
    {
        $document = DocRequest::findorFail($id);

        $fileUrlRecheck = str_replace('/', DIRECTORY_SEPARATOR, $document->file_url);
        $filepathFinal = str_replace('storage', '', $fileUrlRecheck);
        $filepath = storage_path('app\public' . $filepathFinal);
        if (!File::exists($filepath)) {
            abort(404);
        }


        $fileContent = File::get($filepath);
        $fileName = basename($filepath);

        return response($fileContent, 200, [
            'Content-Type' => 'application/octet-stream',
            'Content-Disposition' => "attachment; filename=\"$fileName\"",
        ]);
    }
}
