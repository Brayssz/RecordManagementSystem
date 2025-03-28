<?php

namespace App\Http\Controllers\Content;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ApplicationForm;
use App\Models\Branch;
use App\Models\Deployment;
use App\Models\Employer;
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

    public function showApplicantRecords(Request $request)
    {
        if ($request->ajax()) {
            $query = ApplicationForm::with('applicant', 'documents', 'job', 'branch', 'job.employer');

            if ($request->filled('status')) {
                $query->where('status', $request->status);
            }

            if ($request->filled('branch_id')) {
                $query->where('branch_id', $request->branch_id);
            }

            if ($request->filled('employer_id')) {
                $query->whereHas('job', function ($q) use ($request) {
                    $q->where('employer_id', $request->employer_id);
                });
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
                return $application;
            });

            return response()->json([
                "draw" => intval($request->input('draw', 1)),
                "recordsTotal" => $totalRecords,
                "recordsFiltered" => $totalRecords,
                "data" => $applications
            ]);
        }

        $employers = Employer::where('status', 'Active')->get();

        $applications = ApplicationForm::with('applicant', 'documents', 'job', 'branch', 'job.employer')->get();
        $branches = Branch::where('status', 'Active')->get();
        // return($applications);
        return view('content.applicant-records', compact('applications', 'employers', 'branches'));
    }

    public function showPendingEmployerApplications(Request $request)
    {
        if ($request->ajax()) {
            $query = ApplicationForm::with('applicant', 'job.employer', 'branch', 'EmployerInterview')
                ->whereIn('status', ['Reviewing', 'ScheduledEmployerInterview']);

            if ($request->filled('status')) {
                $query->where('status', $request->status);
            }
            if ($request->filled('branch_id')) {
                $query->where('branch_id', 'like', '%' . $request->branch_id . '%');
            }

            if ($request->filled('employer_id')) {
                $query->whereHas('job', function ($q) use ($request) {
                    $q->where('employer_id', $request->employer_id);
                });
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

            ->whereIn('status', ['Reviewing', 'ScheduledEmployerInterview'])->get();

        $branches = Branch::where('status', 'Active')->get();

        $employers = Employer::where('status', 'Active')->get();
        // return($applications);
        return view('content.employer-int-schedule-management', compact('applications', 'branches', 'employers'));
    }


    public function showToApproveApplications(Request $request)
    {
        if ($request->ajax()) {
            $query = ApplicationForm::with('applicant', 'job', 'branch', 'branchInterview')->where('branch_id', Auth::guard("employee")->user()->branch_id)->whereIn('status', ['Interviewed']);

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

    public function showToHireApplications(Request $request)
    {
        if ($request->ajax()) {
            $query = ApplicationForm::with('applicant', 'job', 'branch', 'employerInterview', 'job.employer')
                ->where('status', 'Waiting');

            if ($request->filled('status')) {
                $query->where('status', $request->status);
            }

            if ($request->filled('employer_id')) {
                $query->whereHas('job', function ($q) use ($request) {
                    $q->where('employer_id', $request->employer_id);
                });
            }
            if ($request->filled('rating')) {
                $query->whereHas('employerInterview', function ($q) use ($request) {
                    $q->where('rating', $request->rating);
                });
            }

            if ($request->filled('branch_id')) {
                $query->where('branch_id', $request->branch_id);
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
        $applications = ApplicationForm::with('applicant', 'job', 'branch', 'employerInterview', 'job.employer')
            ->where('status', 'Waiting')
            ->get();

        // return($applications);

        $employers = Employer::where('status', 'Active')->get();
        $branches = Branch::where('status', 'Active')->get();

        return view('content.applicant-hiring', compact('applications', 'employers', 'branches'));
    }

    public function showScheduledBranchInterviews(Request $request)
    {
        if ($request->ajax()) {
            $query = ApplicationForm::with('applicant', 'job', 'branch', 'branchInterview', 'schedule', 'job.employer')
                ->where('branch_id', Auth::guard("employee")->user()->branch_id)
                ->where('status', 'Pending');

            if ($request->filled('employer_id')) {
                $query->whereHas('job', function ($q) use ($request) {
                    $q->where('employer_id', $request->employer_id);
                });
            }

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
                return $application;
            });

            return response()->json([
                "draw" => intval($request->input('draw', 1)),
                "recordsTotal" => $totalRecords,
                "recordsFiltered" => $totalRecords,
                "data" => $applications
            ]);
        }
        $applications = ApplicationForm::with('applicant', 'job', 'branch', 'branchInterview', 'schedule', 'job.employer')
            ->where('branch_id', Auth::guard("employee")->user()->branch_id)
            ->where('status', 'Pending')
            ->whereHas('schedule', function ($q) {
                $q->whereDate('interview_date', now()->toDateString());
            })
            ->get();
        $employers = Employer::where('status', 'Active')->get();
        // return($applications);
        return view('content.scheduled-branch-interviews', compact('applications', 'employers'));
    }

    public function showScheduledEmployerInterviews(Request $request)
    {
        if ($request->ajax()) {
            $query = ApplicationForm::with('applicant', 'job.employer', 'branch', 'employerInterview')
                ->where('status', 'ScheduledEmployerInterview');

            if ($request->filled('status')) {
                $query->where('status', $request->status);
            }

            if ($request->filled('employer_id')) {
                $query->whereHas('job', function ($q) use ($request) {
                    $q->where('employer_id', $request->employer_id);
                });
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
            ->where('status', 'ScheduledEmployerInterview')
            ->whereHas('employerInterview', function ($q) {
                $q->whereDate('interview_date', now()->toDateString());
            })
            ->get();

        $branches = Branch::where('status', 'Active')->get();
        $employers = Employer::where('status', 'Active')->get();

        // return($applications);
        return view('content.scheduled-employer-interviews', compact('applications', 'branches', 'employers'));
    }

    public function showToDeployApplications(Request $request)
    {
        if ($request->ajax()) {
            $query = ApplicationForm::with('applicant', 'job', 'branch', 'employerInterview', 'job.employer', 'hiring', 'deployment')
                ->whereHas('hiring')
                ->whereIn('status', ['Hired', 'Deployed']);

            if ($request->filled('status')) {
                $query->where('status', $request->status);
            }

            if ($request->filled('employer_id')) {
                $query->whereHas('job', function ($q) use ($request) {
                    $q->where('employer_id', $request->employer_id);
                });
            }

            if ($request->filled('only_deployed') && $request->only_deployed) {
                $query->where('status', 'Deployed');
            } else {
                $query->where('status', 'Hired');
            }

            if ($request->filled('branch_id')) {
                $query->where('branch_id', $request->branch_id);
            }

            if ($request->filled('search') && !empty($request->input('search')['value'])) {
                $search = $request->input('search')['value'];
                $query->where(function ($q) use ($search) {
                    $q->where('applicant_id', 'like', '%' . $search . '%')
                        ->orWhere('branch_id', 'like', '%' . $search . '%')
                        ->orWhere('job_id', 'like', '%' . $search . '%')
                        ->orWhereHas('hiring', function ($q) use ($search) {
                            $q->where('confirmation_code', 'like', '%' . $search . '%');
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
                return $application;
            });

            return response()->json([
                "draw" => intval($request->input('draw', 1)),
                "recordsTotal" => $totalRecords,
                "recordsFiltered" => $totalRecords,
                "data" => $applications
            ]);
        }
        $applications = ApplicationForm::with('applicant', 'job', 'branch', 'employerInterview', 'job.employer', 'hiring', 'deployment')
            ->whereHas('hiring')
            ->whereIn('status', ['Hired', 'Deployed'])
            ->get();

        // return($applications);

        $employers = Employer::where('status', 'Active')->get();
        $branches = Branch::where('status', 'Active')->get();

        return view('content.applicant-deployment', compact('applications', 'employers', 'branches'));
    }
}
