<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Department;
use App\Models\DocRequest;
use App\Models\Document;
use App\Models\DocumentVersion;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /*
    ------------------------------------------------------------
    Dashboard View
    ------------------------------------------------------------
    */
    public function show()
    {
        $docRequests = DocRequest::all();
        $totalreq = $docRequests->where('request_status', false)->count();
        $totalDpt = Department::all();
        $totalDocs = Document::withCount('requests')->get();
        $totalUploads = DocumentVersion::all();

        $deptLabels = $totalDpt->pluck('name');
        $deptFileCounts = $totalDocs
            ->pluck('requests_count')
            ->toArray();

        // Grouping by department_id
        $deptFileCounts = collect($deptFileCounts)->groupBy('department_id')->toArray();

        //dd($deptFileCounts);
        // Retrieve the total uploads grouped by month
        $totalUploadsByMonth = DocumentVersion::selectRaw('DATE_FORMAT(created_at, "%Y-%m") as month, COUNT(*) as total_uploads')
            ->groupBy('month')
            ->get();

        // dd($totalUploadsByMonth);

        // Now $totalUploadsByMonth contains an array of objects, where each object has 'month' and 'total_uploads' properties

        // Pass the $totalUploadsByMonth data to your view


        // For the notifications
        $notifs = Notification::orderBy('created_at', 'desc')->with(['user', 'documents'])->get();
        return view(
            'super_admin.dashboard',
            compact(
                'totalDpt',
                'totalreq',
                'totalDocs',
                'totalUploads',
                'totalUploadsByMonth',
                'deptLabels',
                'notifs'
            )
        );
    }

    public function show_dashAdmin()
    {

        $authDept = Auth::user()->department_id;

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


        // For the notifications
        $notifs = Notification::whereHas('user', function ($query) use ($authDept) {
            $query->where('department_id', $authDept);
        })->with(['user'])->orderBy('created_at', 'desc')->get();


        
        return view(
            'admin.dashboard',
            compact(
                'totalreq',
                'totalDocs',
                'totalUploads',
                'totalUploadsByMonth',
                'totalOnline',
                'notifs'
            )
        );
    }

    public function show_dashUser()
    {

        $userID = Auth::user()->id;

        // For the notifications
        $notifs = Notification::with(['user', 'documents'])->orderBy('created_at', 'desc')->where('user_id', $userID)->get();

        return view('users.dashboard', compact('notifs'));
    }

    public function markAsRead(Request $request){
        $requestID = $request->input('markAsRead');

        $notifications = Notification::findorFail($requestID);
        $notifications->is_read = true;
        $notifications->save();

        return redirect()->back()->with('success', 'Notification marked as read');
    }
}
