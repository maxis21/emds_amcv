<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Models\DocRequest;
use App\Models\Notification;
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
        $requestedDocs = DocRequest::with(['document', 'user'])->orderBy('updated_at', 'desc')->get();
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
        })->with(['document', 'user'])->orderBy('updated_at', 'desc')->get();
        $totalRequests = DocRequest::where('request_status', false)->count();

        return view('admin.request', compact('requestedDocs', 'totalRequests'));
    }

    // --------------------------- USER View --------------------------------
    public function show_requestUser()
    {
        $userID = Auth::user()->id;

        // $requestedDocs = DocRequest::with(['document', 'user'])->get();
        $requestedDocs = DocRequest::where('user_id', $userID)->orderBy('updated_at', 'desc')->get();

        return view('users.request', compact('requestedDocs'));
    }

    // --------------APPROVED REQUEST (FOR SUPER-ADMIN AND ADMIN ONLY)----------------------
    public function approveReq($id)
    {
        $requestData = DocRequest::with('document')->findOrFail($id);
        $requestDataID = $requestData->document->id;
        $requestData->request_status = true;
        $requestData->save();

        $userID = $requestData->user_id;
        Notification::create([
            'user_id' => $userID,
            'type' => 'Request Approved',
            'document_id' => $requestDataID,
            'message' => 'A file request had been approved.'
        ]);

        return back()->with('success', 'Request Approved');
    }

    public function declineReq(Request $request, $id)
    {
        $requestData = DocRequest::with('document')->findOrFail($id);
        $requestDataID = $requestData->document->id;
        $requestData->request_status = 2;
        $requestData->save();
        $message = $request->input('message'); 

        $userID = $requestData->user_id;
        Notification::create([
            'user_id' => $userID,
            'type' => 'Request Denied',
            'document_id' => $requestDataID,
            'message' => $message
        ]);

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
            } else {
                return redirect(route('to.request-user'));
            }
        }
        $query = DocRequest::query();

        if ($docStatus !== '') {
            $query->where('request_status', $docStatus);
        }



        if ($userRole == 'super-admin') {
            $requestedDocs = $query->orderBy('updated_at', 'desc')->get();

            return view('super_admin.request', compact('requestedDocs'));
        } elseif ($userRole == 'admin') {

            $requestedDocs = $query->whereHas('user', function ($query) use ($userDept) {
                $query->where('department_id', $userDept);
            })->orderBy('updated_at', 'desc')->get();


            return view('admin.request', compact('requestedDocs'));
        } else {
            $requestedDocs = $query->where('user_id', $userID)->orderBy('updated_at', 'desc')->get();
            return view('users.request', compact('requestedDocs'));
        }
    }


    // -------------------------DOWNLOAD DOCUMENT----------------------------
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
