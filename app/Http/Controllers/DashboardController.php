<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Department;
use App\Models\DocRequest;
use App\Models\Document;
use App\Models\DocumentVersion;

class DashboardController extends Controller
{
    /*
    ------------------------------------------------------------
    Dashboard View
    ------------------------------------------------------------
    */
    public function show()
    {
        $totalreq = DocRequest::where('request_status', false)->count();
        $totalDpt = Department::count();
        $totalDocs = Document::count();
        $totalUploads = DocumentVersion::all();

        // Retrieve the total uploads grouped by month
        $totalUploadsByMonth = DocumentVersion::selectRaw('DATE_FORMAT(created_at, "%Y-%m") as month, COUNT(*) as total_uploads')
            ->groupBy('month')
            ->get();

        // dd($totalUploadsByMonth);

        // Now $totalUploadsByMonth contains an array of objects, where each object has 'month' and 'total_uploads' properties

        // Pass the $totalUploadsByMonth data to your view
        return view('super_admin.dashboard', compact(
            'totalDpt',
            'totalreq',
            'totalDocs',
            'totalUploads',
            'totalUploadsByMonth'
        )
        );
    }

    public function show_dashAdmin()
    {
        return view('admin.dashboard');
    }

    public function show_dashUser()
    {
        return view('users.dashboard');
    }
}
