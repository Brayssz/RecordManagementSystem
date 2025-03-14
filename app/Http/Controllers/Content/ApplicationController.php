<?php

namespace App\Http\Controllers\Content;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ApplicationForm;
use App\Models\Branch;
use Illuminate\Support\Facades\Auth;

class ApplicationController extends Controller
{
    public function showApplicationForm(Request $request)
    {
        $job_id = $request->job_id;
        return view('content.application-form', compact('job_id'));
    }

    public function showMyApplications(Request $request)
    {
        if ($request->ajax()) {
            $query = ApplicationForm::with('applicant', 'documents', 'job', 'branch')->where('applicant_id', Auth::guard("applicant")->user()->applicant_id);

            if ($request->filled('status')) {
                $query->where('status', $request->status);
            }

            if ($request->filled('search') && !empty($request->input('search')['value'])) {
                $search = $request->input('search')['value'];
                $query->where(function ($q) use ($search) {
                    $q->where('applicant_id', 'like', '%' . $search . '%')
                        ->orWhere('branch_id', 'like', '%' . $search . '%')
                        ->orWhere('job_id', 'like', '%' . $search . '%');
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
                return $application;
            });

            return response()->json([
                "draw" => intval($request->input('draw', 1)),
                "recordsTotal" => $totalRecords,
                "recordsFiltered" => $totalRecords,
                "data" => $applications
            ]);
        }
        $applications = ApplicationForm::with('applicant', 'documents', 'job', 'branch')->where('applicant_id', Auth::guard("applicant")->user()->applicant_id)->get();
        $branches = Branch::where('status', 'Active')->get();
        // return($applications);
        return view('content.my-applications', compact('applications', 'branches'));
    }

    public function showPendingBranchApplications(Request $request)
    {
        if ($request->ajax()) {
            $query = ApplicationForm::with('applicant', 'job', 'branch', 'branchInterview')->where('branch_id', Auth::guard("employee")->user()->branch_id)->whereIn('status', ['Pending', 'ScheduledBranchInterview']);

            if ($request->filled('status')) {
                $query->where('status', $request->status);
            }

            if ($request->filled('search') && !empty($request->input('search')['value'])) {
                $search = $request->input('search')['value'];
                $query->where(function ($q) use ($search) {
                    $q->where('applicant_id', 'like', '%' . $search . '%')
                        ->orWhere('branch_id', 'like', '%' . $search . '%')
                        ->orWhere('job_id', 'like', '%' . $search . '%');
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
                return $application;
            });

            return response()->json([
                "draw" => intval($request->input('draw', 1)),
                "recordsTotal" => $totalRecords,
                "recordsFiltered" => $totalRecords,
                "data" => $applications
            ]);
        }
        $applications = ApplicationForm::with('applicant', 'job', 'branch', 'branchInterview')->where('branch_id', Auth::guard("employee")->user()->branch_id)->whereIn('status', ['Pending', 'ScheduledBranchInterview'])->get();

        // return($applications);
        return view('content.branch-int-schedule-management', compact('applications'));
    }

    public function showPendingEmployerApplications(Request $request)
    {
        if ($request->ajax()) {
            $query = ApplicationForm::with('applicant', 'job.employer', 'branch', 'EmployerInterview')
                ->whereHas('job.employer', function ($q) {
                    $q->where('employer_id', Auth::guard("employer")->user()->employer_id);
                })
                ->whereIn('status', ['Reviewing', 'ScheduledEmployerInterview']);

            if ($request->filled('status')) {
                $query->where('status', $request->status);
            }

            if ($request->filled('search') && !empty($request->input('search')['value'])) {
                $search = $request->input('search')['value'];
                $query->where(function ($q) use ($search) {
                    $q->where('applicant_id', 'like', '%' . $search . '%')
                        ->orWhere('branch_id', 'like', '%' . $search . '%')
                        ->orWhere('job_id', 'like', '%' . $search . '%');
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
                return $application;
            });

            return response()->json([
                "draw" => intval($request->input('draw', 1)),
                "recordsTotal" => $totalRecords,
                "recordsFiltered" => $totalRecords,
                "data" => $applications
            ]);
        }
        $applications = ApplicationForm::with('applicant', 'job.employer', 'branch', 'EmployerInterview')
            ->whereHas('job.employer', function ($q) {
                $q->where('employer_id', Auth::guard("employer")->user()->employer_id);
            })
            ->whereIn('status', ['Reviewing', 'ScheduledEmployerInterview'])->get();

        // return($applications);
        return view('content.employer-int-schedule-management', compact('applications'));
    }


    public function showToApproveApplications(Request $request)
    {
        if ($request->ajax()) {
            $query = ApplicationForm::with('applicant', 'job', 'branch', 'branchInterview')->where('branch_id', Auth::guard("employee")->user()->branch_id)->whereIn('status', ['Pending', 'Interviewed']);

            if ($request->filled('status')) {
                $query->where('status', $request->status);
            }

            if ($request->filled('search') && !empty($request->input('search')['value'])) {
                $search = $request->input('search')['value'];
                $query->where(function ($q) use ($search) {
                    $q->where('applicant_id', 'like', '%' . $search . '%')
                        ->orWhere('branch_id', 'like', '%' . $search . '%')
                        ->orWhere('job_id', 'like', '%' . $search . '%');
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
                return $application;
            });

            return response()->json([
                "draw" => intval($request->input('draw', 1)),
                "recordsTotal" => $totalRecords,
                "recordsFiltered" => $totalRecords,
                "data" => $applications
            ]);
        }
        $applications = ApplicationForm::with('applicant', 'job', 'branch', 'branchInterview')->where('branch_id', Auth::guard("employee")->user()->branch_id)->whereIn('status', ['Pending', 'ScheduledBranchInterview'])->get();

        // return($applications);
        return view('content.application-approval', compact('applications'));
    }

    public function showScheduledBranchInterviews(Request $request)
    {
        if ($request->ajax()) {
            $query = ApplicationForm::with('applicant', 'job', 'branch', 'branchInterview')
                ->where('branch_id', Auth::guard("employee")->user()->branch_id)
                ->where('status', 'ScheduledBranchInterview')
                ->whereHas('branchInterview', function ($q) {
                    $q->whereDate('interview_date', now()->toDateString());
                });

            if ($request->filled('status')) {
                $query->where('status', $request->status);
            }

            if ($request->filled('search') && !empty($request->input('search')['value'])) {
                $search = $request->input('search')['value'];
                $query->where(function ($q) use ($search) {
                    $q->where('applicant_id', 'like', '%' . $search . '%')
                        ->orWhere('branch_id', 'like', '%' . $search . '%')
                        ->orWhere('job_id', 'like', '%' . $search . '%');
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
                return $application;
            });

            return response()->json([
                "draw" => intval($request->input('draw', 1)),
                "recordsTotal" => $totalRecords,
                "recordsFiltered" => $totalRecords,
                "data" => $applications
            ]);
        }
        $applications = ApplicationForm::with('applicant', 'job', 'branch', 'branchInterview')
            ->where('branch_id', Auth::guard("employee")->user()->branch_id)
            ->where('status', 'ScheduledBranchInterview')
            ->whereHas('branchInterview', function ($q) {
                $q->whereDate('interview_date', now()->toDateString());
            })
            ->get();

        // return($applications);
        return view('content.scheduled-branch-interviews', compact('applications'));
    }

    public function showScheduledEmployerInterviews(Request $request)
    {
        if ($request->ajax()) {
            $query = ApplicationForm::with('applicant', 'job.employer', 'branch', 'employerInterview')
                ->whereHas('job.employer', function ($q) {
                    $q->where('employer_id', Auth::guard("employer")->user()->employer_id);
                })
                ->where('status', 'ScheduledEmployerInterview')
                ->whereHas('employerInterview', function ($q) {
                    $q->whereDate('interview_date', now()->toDateString());
                });

            if ($request->filled('status')) {
                $query->where('status', $request->status);
            }

            if ($request->filled('search') && !empty($request->input('search')['value'])) {
                $search = $request->input('search')['value'];
                $query->where(function ($q) use ($search) {
                    $q->where('applicant_id', 'like', '%' . $search . '%')
                        ->orWhere('branch_id', 'like', '%' . $search . '%')
                        ->orWhere('job_id', 'like', '%' . $search . '%');
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
                return $application;
            });

            return response()->json([
                "draw" => intval($request->input('draw', 1)),
                "recordsTotal" => $totalRecords,
                "recordsFiltered" => $totalRecords,
                "data" => $applications
            ]);
        }
        $applications = ApplicationForm::with('applicant', 'job.employer', 'branch', 'employerInterview')
            ->whereHas('job.employer', function ($q) {
                $q->where('employer_id', Auth::guard("employer")->user()->employer_id);
            })
            ->where('status', 'ScheduledEmployerInterview')
            ->whereHas('employerInterview', function ($q) {
                $q->whereDate('interview_date', now()->toDateString());
            })
            ->get();

        // return($applications);
        return view('content.scheduled-employer-interviews', compact('applications'));
    }
}
