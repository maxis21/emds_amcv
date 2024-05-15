<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Department;
use App\Models\DocRequest;
use App\Models\Document;
use App\Models\DocumentVersion;
use App\Models\User;

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
        return view(
            'super_admin.dashboard',
            compact(
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
        $totalreq = DocRequest::with('document')
            ->whereHas('document', function ($query) {
                $query->where('department_id', auth()->user()->department_id);
            })
            ->where('request_status', false)
            ->count();

        $totalDocs = Document::where('department_id', auth()->user()->department_id)->count();

        $totalUploads = DocumentVersion::whereHas('document', function ($query) {
            $query->where('department_id', auth()->user()->department_id);
        })
            ->count();

        // Retrieve the total uploads grouped by month
        $totalUploadsByMonth = DocumentVersion::selectRaw('DATE_FORMAT(created_at, "%Y-%m") as month, COUNT(*) as total_uploads')
            ->whereHas('document', function ($query) {
                $query->where('department_id', auth()->user()->department_id);
            })
            ->groupBy('month')
            ->get();

        $totalOnline = User::where('isOnline', true)->where('department_id', auth()->user()->department_id)->count();
        // dd($totalUploadsByMonth);

        // Now $totalUploadsByMonth contains an array of objects, where each object has 'month' and 'total_uploads' properties

        // Pass the $totalUploadsByMonth data to your view
        return view(
            'admin.dashboard',
            compact(
                'totalreq',
                'totalDocs',
                'totalUploads',
                'totalUploadsByMonth',
                'totalOnline'
            )
        );
    }

    public function show_dashUser()
    {
        return view('users.dashboard');
    }
}
