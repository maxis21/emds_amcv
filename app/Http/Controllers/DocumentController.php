<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Models\DocumentVersion;
use App\Models\DocRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class DocumentController extends Controller
{
    /*
    ------------------------------------------------------------
    Document View
    ------------------------------------------------------------
    */
    public function show()
    {
        $DocDatas = Document::with(['document_versions', 'department'])->get();
        return view('all.documents', compact('DocDatas'));
    }

    public function uploadFile(Request $request){
        $userID = Auth::user()->id;
        $userDept = Auth::user()->department_id;
        $thisFile = $request->file('docfile');
        $docName = $request->input('name');
        // $fileName = $docName . '.pdf';

        
        $document = Document::firstOrCreate(
            ['name' => $docName, 'department_id' => $userDept],
            ['name' => $docName, 'department_id' => $userDept]
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

        if($request->hasFile('docfile')){

            $latestVersion = $document->document_versions()->count();
            $versionNumber = $latestVersion ? $latestVersion + 1 : 1;
            $versionedName = $docName . '_v' . $versionNumber;
            $fileName = $versionedName . '.pdf';
            $filePath = $thisFile->storeAs('documents', $fileName, 'public');
            $fileURL = Storage::url($filePath);
            // $lastUpdated = $document->document_versions()->latest('updated_at')->first();

            DocumentVersion::create([
                'name' => $fileName,
                'file_url' => $fileURL,
                'document_id' =>$docID,
                'uploaded_by' => $userID
            ]);

            return back()->with('success', 'Document uploaded successfully.');
        }

        else{
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

    public function requestFile(Request $request){
        $userID = Auth::user()->id;
        $docuID = $request->input('docID');
        $docPath = $request->input('docURL');
        
        DocRequest::create([
            'user_id'=>$userID,
            'document_id'=>$docuID,
            'file_url'=>$docPath
        ]);

        return back()->with('success', 'Document requested successfully.');
    }
}
