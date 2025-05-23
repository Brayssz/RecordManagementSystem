<?php

namespace App\Http\Controllers\Content;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ApplicationForm;
use App\Models\Branch;
use Illuminate\Support\Facades\Auth;

class DocumentController extends Controller
{
    public function showApplicantDocuments(Request $request)
    {
        if ($request->ajax()) {
            $query = ApplicationForm::with('applicant', 'documents', 'job', 'branch')
                ->where('branch_id', Auth::guard("employee")->user()->branch_id)
                ->where('status', 'Submitting');

            if ($request->filled('status')) {
                $query->where('status', $request->status);
            }

            if ($request->filled('search') && !empty($request->input('search')['value'])) {
                $search = $request->input('search')['value'];
                $query->where(function ($q) use ($search) {
                    $q->where('applicant_id', 'like', '%' . $search . '%')
                        ->orWhere('branch_id', 'like', '%' . $search . '%')
                        ->orWhere('job_id', 'like', '%' . $search . '%')
                        ->orWhereHas('applicant', function ($q) use ($search) {
                            $q->where('first_name', 'like', '%' . $search . '%')
                                ->orWhere('middle_name', 'like', '%' . $search . '%')
                                ->orWhere('last_name', 'like', '%' . $search . '%');
                        })
                        ->orWhereHas('job', function ($q) use ($search) {
                            $q->where('job_title', 'like', '%' . $search . '%')
                                ->orWhere('country', 'like', '%' . $search . '%');
                        })
                        ->orWhereHas('branch', function ($q) use ($search) {
                            $q->where('municipality', 'like', '%' . $search . '%');
                        });
                });
            }

            $totalRecords = $query->count();

            $orderColumnIndex = $request->input('order')[0]['column'] ?? 0;
            $orderColumn = $request->input('columns')[$orderColumnIndex]['data'] ?? 'application_id';
            $orderDirection = $request->input('order')[0]['dir'] ?? 'asc';
            $query->orderBy($orderColumn, $orderDirection);

            $start = $request->input('start', 0);
            $length = $request->input('length', 10);
            $applications = $query->skip($start)->take($length)->get();

            $applications->transform(function ($application) {
                $application->employee_position = Auth::guard('employee')->user()->position ?? null;
                return $application;
            });

            return response()->json([
                "draw" => intval($request->input('draw', 1)),
                "recordsTotal" => $totalRecords,
                "recordsFiltered" => $totalRecords,
                "data" => $applications
            ]);
        }
        $applications = ApplicationForm::with('applicant', 'documents', 'job', 'branch')->where('branch_id', Auth::guard("employee")->user()->branch_id)->where('status', 'Submitting')->get();
        $branches = Branch::where('status', 'Active')->get();
        // return($applications);
        return view('content.document-management', compact('applications', 'branches'));
    }

}
