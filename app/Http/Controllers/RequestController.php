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

    // ======================= Show View Functions for the three user roles ==================
    public function show()
    {
        $requestedDocs = DocRequest::with(['document', 'user'])->get();
        $totalRequests = DocRequest::where('request_status', false)->count();
        return view('super_admin.request', compact('requestedDocs', 'totalRequests'));
    }

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

    public function show_requestUser()
    {
        $userID = Auth::user()->id;

        // $requestedDocs = DocRequest::with(['document', 'user'])->get();
        $requestedDocs = DocRequest::where('user_id', $userID)->get();
        $totalRequests = DocRequest::where('request_status', false)->count();

        return view('users.request', compact('requestedDocs', 'totalRequests'));
    }

    public function approveReq($id)
    {
        $requestData = DocRequest::findOrFail($id);
        $requestData->request_status = true;
        $requestData->save();

        return back()->with('success', 'Request Approved');
    }

    public function fileStatus(Request $request)
    {
        $docStatus = $request->fileStatus;

        if ($request->fileStatus === null) {
            return redirect(route('to.Request'));
        }

        $docStatus = filter_var($docStatus, FILTER_VALIDATE_BOOLEAN);


        $requestedDocs = DocRequest::where('request_status', $docStatus)->get();
        $totalRequests = DocRequest::where('request_status', false)->count();

        $userRole = Auth::user()->role->role->name;
        if ($userRole == 'super-admin') {
            return view('super_admin.request', compact('requestedDocs', 'totalRequests'));
        } elseif ($userRole == 'admin') {
            return view('admin.request', compact('requestedDocs', 'totalRequests'));
        }
    }

    public function download_document($id)
    {
        $document = DocRequest::findorFail($id);

        $fileUrlRecheck = str_replace('/', DIRECTORY_SEPARATOR, $document->file_url);
        $filepathFinal = str_replace('storage', '', $fileUrlRecheck);
        $filepath = storage_path('app\public'. $filepathFinal);
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
