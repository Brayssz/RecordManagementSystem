<?php

namespace App\Http\Controllers\Content;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BranchSchedule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\Branch;
use App\Models\BranchInterview;

class BranchScheduleController extends Controller
{
    public function showBranchSchedule(Request $request)
    {

        if ($request->ajax()) {
            $query = BranchSchedule::with('applications', 'applications.BranchInterview')->where('branch_id', Auth::guard('employee')->user()->branch_id);

            // Filter by interview date
            if ($request->filled('interview_date')) {
                $query->whereDate('interview_date', $request->interview_date);
            }

            // Search filter (searching schedule type, interview date)
            if ($request->filled('search') && !empty($request->input('search')['value'])) {
                $search = $request->input('search')['value'];
                $query->where(function ($q) use ($search) {
                    $q->where('interview_date', 'like', '%' . $search . '%');
                });
            }

            $totalRecords = $query->count();

            $orderColumnIndex = $request->input('order')[0]['column'] ?? 0;
            $orderColumn = $request->input('columns')[$orderColumnIndex]['data'] ?? 'schedule_id';
            $orderDirection = $request->input('order')[0]['dir'] ?? 'asc';
            $query->orderBy($orderColumn, $orderDirection);

            $start = $request->input('start', 0);
            $length = $request->input('length', 10);
            $schedules = $query->skip($start)->take($length)->get();

            return response()->json([
                "draw" => intval($request->input('draw', 1)),
                "recordsTotal" => $totalRecords,
                "recordsFiltered" => $totalRecords,
                "data" => $schedules
            ]);
        }

        

        $schedules = BranchSchedule::with('applications')->where('branch_id', Auth::guard('employee')->user()->branch_id)->get();
        // return ($schedules);
        return view('content.branch-int-schedule-management', compact('schedules'));
    }
}
