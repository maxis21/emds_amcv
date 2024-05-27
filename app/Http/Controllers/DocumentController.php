<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Document;
use App\Models\DocumentVersion;
use App\Models\DocRequest;
use App\Models\Folder;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class DocumentController extends Controller
{
    /*
    ------------------------------------------------------------
    Document View - FOR SUPER-ADMIN
    ------------------------------------------------------------
    */
    public function show($folderId = null)
    {
        $folders = null;
        $breadcrumbs = [];
        $departments = Department::get();

        if ($folderId) {
            $currentFolder = Folder::with('department', 'documents.document_versions')->findOrFail($folderId);
            $folders = $currentFolder->children;
            $documents = $currentFolder->documents;
            $breadcrumbs = $currentFolder->getAncestors();
        } else {
            $folders = Folder::with('department', 'documents.document_versions')->whereNull('parent_id')->get();
            $documents = Document::with('document_versions')->whereNull('folder_id')->get();
        }

        return view('super_admin.documents', compact('folders', 'breadcrumbs', 'departments', 'documents', 'folderId'));
    }

    public function trackFile($folderId = null)
    {
        $folders = null;
        $breadcrumbs = [];
        $departments = Department::get();


        if ($folderId) {
            $currentFolder = Folder::with('department', 'documents.document_versions')->findOrFail($folderId);
            $folders = $currentFolder->children;
            $documents = $currentFolder->documents;
            $breadcrumbs = $currentFolder->getAncestors();
        } else {
            $folders = Folder::whereNull('parent_id')->get();
        }


        return view('super_admin.documents', compact('folders', 'breadcrumbs', 'departments', 'documents', 'folderId'));
    }

    /*
    ------------------------------------------------------------
    Document View - FOR ADMIN
    ------------------------------------------------------------
    */

    public function show_docADminview($folderId = null)
    {
        $folders = null;
        $breadcrumbs = [];
        $departments = Department::get();
        $userDept = Auth::user()->department_id;


        if ($folderId) {
            $currentFolder = Folder::where('department_id', $userDept)->with('department', 'documents.document_versions')->findOrFail($folderId);
            $folders = $currentFolder->children;
            $documents = $currentFolder->documents;
            $breadcrumbs = $currentFolder->getAncestors();
        } else {
            $folders = Folder::where('department_id', $userDept)->with('department', 'documents.document_versions')->whereNull('parent_id')->get();
            $documents = Document::with('document_versions')->where('department_id', $userDept)->whereNull('folder_id')->get();
        }


        return view('admin.documents', compact('folders', 'breadcrumbs', 'departments', 'documents', 'folderId'));
    }

    public function adminTrackFile($folderId = null)
    {
        $folders = null;
        $breadcrumbs = [];
        $departments = Department::get();
        $userDept = Auth::user()->department_id;


        if ($folderId) {
            $currentFolder = Folder::where('department_id', $userDept)->with('department', 'documents.document_versions')->findOrFail($folderId);
            $folders = $currentFolder->children;
            $documents = $currentFolder->documents;
            $breadcrumbs = $currentFolder->getAncestors();
        } else {
            $folders = Folder::where('department_id', $userDept)->whereNull('parent_id')->get();
        }


        return view('admin.documents', compact('folders', 'breadcrumbs', 'departments', 'documents', 'folderId'));
    }


    /*
    ------------------------------------------------------------
    Document View - FOR USERS
    ------------------------------------------------------------
    */

    public function show_docUserview($folderId = null)
    {

        $folders = null;
        $breadcrumbs = [];
        $departments = Department::get();
        $userDept = Auth::user()->department_id;


        if ($folderId) {
            $currentFolder = Folder::where('department_id', $userDept)->with('department', 'documents.document_versions')->findOrFail($folderId);
            $folders = $currentFolder->children;
            $documents = $currentFolder->documents;
            $breadcrumbs = $currentFolder->getAncestors();
        } else {
            $folders = Folder::where('department_id', $userDept)->with('department', 'documents.document_versions')->whereNull('parent_id')->get();
            $documents = Document::with('document_versions')->where('department_id', $userDept)->whereNull('folder_id')->get();
        }


        return view('users.documents', compact('folders', 'breadcrumbs', 'departments', 'documents', 'folderId'));
    }

    public function userTrackFile($name, $folderId = null)
    {
        $folders = null;
        $breadcrumbs = [];
        $departments = Department::get();
        $userDept = Auth::user()->department_id;


        if ($folderId) {
            $currentFolder = Folder::where('department_id', $userDept)->with('department', 'documents.document_versions')->findOrFail($folderId);
            $folders = $currentFolder->children;
            $documents = $currentFolder->documents;
            $breadcrumbs = $currentFolder->getAncestors();
        } else {
            $folders = Folder::where('department_id', $userDept)->whereNull('parent_id')->get();
        }


        return view('users.documents', compact('folders', 'breadcrumbs', 'departments', 'documents', 'folderId'));
    }

    /*
    ------------------------------------------------------------
    Creating Folders
    ------------------------------------------------------------
    */

    public function createFolder(Request $request)
    {
        $userDept = Auth::user()->department_id;
        $userRole = Auth::user()->role->role->name;
        $validatedData = $request->validate([
            'name' => 'required|string',
            'parent_id' => 'nullable',
            'dptFolder' => 'nullable'
        ]);
        $currentFolderId = $validatedData['parent_id'];

        if ($userRole == 'super-admin') {
            $folder = Folder::create([
                'name' => $validatedData['name'],
                'parent_id' => $currentFolderId,
                'department_id' => $validatedData['dptFolder']
            ]);
        } else {
            $folder = Folder::create([
                'name' => $validatedData['name'],
                'parent_id' => $currentFolderId,
                'department_id' => $userDept
            ]);
        }

        return back()->with('success', 'Document uploaded successfully.');
    }


    /*
    ------------------------------------------------------------
    Uploading Files
    ------------------------------------------------------------
    */

    public function uploadFile(Request $request)
    {
        $userID = Auth::user()->id;
        $userDept = Auth::user()->department_id;
        $thisFile = $request->file('docfile');
        $docName = $request->input('name');
        $folderID = $request->input('parent_id');
        $userRole = Auth::user()->role->role->name;
        // $fileName = $docName . '.pdf';


        $document = Document::firstOrCreate(
            ['name' => $docName, 'department_id' => $userDept, 'folder_id' => $folderID],
            ['name' => $docName, 'department_id' => $userDept, 'folder_id' => $folderID]
        );

        $docID = $document->id;

        // Check if the doc exist through name search
        // $docExist = Document::where('name', $docName)
        //                         ->where('department_id', $userDept)
        //                         ->first();

        // if(!$docExist){
        //     Create a new Docu Data
        //     $newDoc = Document::create([
        //         'name' => $request->input('name'),
        //         'department_id' => $userDept
        //     ]);

        //     $documentID = $newDoc->id;
        // }
        // else{

        //     $documentID = $docExist->id;
        // }

        if ($request->hasFile('docfile')) {

            $latestVersion = $document->document_versions()->count();
            $versionNumber = $latestVersion ? $latestVersion + 1 : 1;
            $versionedName = $docName . '_v' . $versionNumber;
            $fileName = $versionedName . '.pdf';
            $filePath = $thisFile->storeAs('documents', $fileName, 'public');
            $fileURL = Storage::url($filePath);
            // $lastUpdated = $document->document_versions()->latest('updated_at')->first();

            if ($userRole == 'user') {
                DocumentVersion::create([
                    'name' => $fileName,
                    'file_url' => $fileURL,
                    'document_id' => $docID,
                    'uploaded_by' => $userID,
                    'approval_status' => 'Pending'
                ]);

                Notification::create([
                    'user_id' => $userID,
                    'type' => 'File Upload',
                    'message' => 'A file has been uploaded.',
                    'document_id' => $docID
                ]);
            } else {
                DocumentVersion::create([
                    'name' => $fileName,
                    'file_url' => $fileURL,
                    'document_id' => $docID,
                    'uploaded_by' => $userID
                ]);

                Notification::create([
                    'user_id' => $userID,
                    'type' => 'File Upload',
                    'message' => 'A file has been uploaded.',
                    'document_id' => $docID
                ]);
            }

            return back()->with('success', 'Document uploaded successfully.');
        } else {
            return back()->with('error', 'There was a problem uploading the document.');
        }


        // $newDoc = Document::create([
        //     'name' => $request->input('name'),
        //     'department_id' => $userDept
        // ]);

        // if($request){
        //     $filePath = $thisFile->storeAs('documents', $fileName, 'public');
        // }

        // Storage::disk('public')->put($fileName , $thisFile);

        // return back()->with('success', 'Added Document Successfully.');

    }



    /*
    ------------------------------------------------------------
    Requesting Files - For Users Only
    ------------------------------------------------------------
    */
    public function requestFile(Request $request)
    {
        $userID = Auth::user()->id;
        $docuID = $request->input('docID');
        $docPath = $request->input('docURL');

        DocRequest::create([
            'user_id' => $userID,
            'document_id' => $docuID,
            'file_url' => $docPath
        ]);

        Notification::create([
            'user_id' => $userID,
            'type' => 'File Request',
        ]);

        return back()->with('success', 'Document requested successfully.');
    }


    /*
    ------------------------------------------------------------
    View File
    ------------------------------------------------------------
    */
    public function viewFile($originalFile)
    {
        $docuFile = DocumentVersion::findOrFail($originalFile);
        $fileUrl = ltrim($docuFile->file_url, '/');
        $fileUrlEdit = str_replace('storage/', '', $fileUrl);
        $filePath = storage_path('app/public/' . $fileUrlEdit);

        return response()->file($filePath);
    }

    /*
    ------------------------------------------------------------
    View File
    ------------------------------------------------------------
    */
    public function viewUserUploads()
    {

        $authDept = Auth::user()->department_id;
        $authRole = Auth::user()->role->role->name;


        $departments = Department::get();
        if ($authRole == 'super-admin') {
            $documents = Document::with(['document_versions', 'department'])
                ->whereHas('document_versions', function ($query) {
                    $query->where('approval_status', 'Pending')->orWhere('approval_status', 'Approved')->orWhere('approval_status', 'Denied');
                })
                ->leftJoin('tbl_document_versions', 'tbl_documents.id', '=', 'tbl_document_versions.document_id')
                ->select('tbl_documents.*', \DB::raw('MAX(tbl_document_versions.updated_at) as latest_version_update'))
                ->groupBy('tbl_documents.id')
                ->orderBy('latest_version_update', 'desc')
                ->get();
            return view('super_admin.user_uploads', compact('documents'));
        } elseif ($authRole == 'admin') {
            $documents = Document::with(['document_versions', 'department'])
                ->whereHas('document_versions', function ($query) {
                    $query->where('approval_status', 'Pending')->orWhere('approval_status', 'Approved')->orWhere('approval_status', 'Denied');
                })
                ->where('department_id', $authDept)
                ->leftJoin('tbl_document_versions', 'tbl_documents.id', '=', 'tbl_document_versions.document_id')
                ->select('tbl_documents.*', \DB::raw('MAX(tbl_document_versions.updated_at) as latest_version_update'))
                ->groupBy('tbl_documents.id')
                ->orderBy('latest_version_update', 'desc')
                ->get();
            return view('admin.user_uploads', compact('documents'));
        }
    }


    /*
    ------------------------------------------------------------
    Approve File Upload from the user
    ------------------------------------------------------------
    */

    public function approveFile($id)
    {
        $uploadedData = DocumentVersion::findOrFail($id);
        $uploadedData->approval_status = 'Approved';
        $uploadedData->save();

        $userID = $uploadedData->uploaded_by;
        Notification::create([
            'user_id' => $userID,
            'type' => 'File Upload Approved',
        ]);

        return back()->with('success', 'File Approved');
    }


    /*
    ------------------------------------------------------------
    Decline File Upload from the user
    ------------------------------------------------------------
    */

    public function declineFile($id)
    {
        $uploadedData = DocumentVersion::findOrFail($id);
        $uploadedData->approval_status = 'Denied';
        $uploadedData->save();

        $userID = $uploadedData->uploaded_by;
        Notification::create([
            'user_id' => $userID,
            'type' => 'File Upload Denied',
        ]);

        return back()->with('success', 'File Declined');
    }

    /*
    ------------------------------------------------------------
    Open file path
    ------------------------------------------------------------
    */
    public function showPath($id)
    {
        $folderPath = '';
    }
}
