<?php

namespace App\Http\Controllers\Content;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Branch;
use App\Models\ApplicationForm;
use Illuminate\Support\Facades\Auth;
use App\Models\EmployerInterview;
use App\Models\Applicant;
use Carbon\Carbon;

class ReportController extends Controller
{
    public function showBranchPerformanceReport(Request $request)
    {
        if ($request->ajax()) {
            $query = Branch::query();

            if ($request->filled('municipality')) {
                $query->where('municipality', 'like', '%' . $request->municipality . '%');
            }

            $branches = $query->get();

            $report = [];
            $totalRecords = 0;

            foreach ($branches as $branch) {
                $totalApplicationsQuery = ApplicationForm::where('branch_id', $branch->branch_id);

                if ($request->filled('date_range')) {
                    $dates = explode(' - ', $request->date_range);
                    $startDate = \Carbon\Carbon::createFromFormat('m/d/Y', trim($dates[0]))->startOfDay();
                    $endDate = \Carbon\Carbon::createFromFormat('m/d/Y', trim($dates[1]))->endOfDay();
                    $totalApplicationsQuery->whereBetween('application_date', [$startDate, $endDate]);
                }

                $totalApplications = $totalApplicationsQuery->count();

                $hiredApplicationsQuery = ApplicationForm::where('branch_id', $branch->branch_id)
                    ->where('status', 'Hired')->with('hiring');

                if ($request->filled('date_range')) {
                    $dates = explode(' - ', $request->date_range);
                    $startDate = \Carbon\Carbon::createFromFormat('m/d/Y', trim($dates[0]))->startOfDay();
                    $endDate = \Carbon\Carbon::createFromFormat('m/d/Y', trim($dates[1]))->endOfDay();
                    $hiredApplicationsQuery->whereHas('hiring', function ($q) use ($startDate, $endDate) {
                        $q->whereBetween('confirmation_date', [$startDate, $endDate]);
                    });
                }

                $hiredApplications = $hiredApplicationsQuery->count();


                $deployedApplicationsQuery = ApplicationForm::where('branch_id', $branch->branch_id)
                    ->where('status', 'Deployed')->with('deployment');

                if ($request->filled('date_range')) {
                    $dates = explode(' - ', $request->date_range);
                    $startDate = \Carbon\Carbon::createFromFormat('m/d/Y', trim($dates[0]))->startOfDay();
                    $endDate = \Carbon\Carbon::createFromFormat('m/d/Y', trim($dates[1]))->endOfDay();
                    $deployedApplicationsQuery->whereHas('deployment', function ($q) use ($startDate, $endDate) {
                        $q->whereBetween('actual_departure_date', [$startDate, $endDate]);
                    });
                }

                $deployedApplications = $deployedApplicationsQuery->count();

                $report[] = [
                    'branch' => $branch->municipality,
                    'total_applications' => $totalApplications,
                    'hired_applications' => $hiredApplications,
                    'deployed_applications' => $deployedApplications,
                ];

                $totalRecords++;
            }

            return response()->json([
                "draw" => intval($request->input('draw', 1)),
                "recordsTotal" => $totalRecords,
                "recordsFiltered" => $totalRecords,
                "data" => $report
            ]);
        }

        $branches = Branch::where('status', 'Active')->get();

        return view('content.branch-performance-report', compact('branches'));
    }

    public function showHiredApplicantReport(Request $request)
    {
        if ($request->ajax()) {

            $query = ApplicationForm::query()->whereIn('status', ['Hired', 'Deployed'])->with('applicant', 'branch', 'job', 'hiring');

            if (Auth::guard('employee')->user()->position == 'Manager') {
                $query = $query->where('branch_id', Auth::guard('employee')->user()->branch_id);
            }
            if ($request->filled('branch_id')) {
                $query->where('branch_id', $request->branch_id);
            }

            if ($request->filled('date_range')) {
                $dates = explode(' - ', $request->date_range);
                $startDate = \Carbon\Carbon::createFromFormat('m/d/Y', trim($dates[0]))->startOfDay();
                $endDate = \Carbon\Carbon::createFromFormat('m/d/Y', trim($dates[1]))->endOfDay();
                $query->whereHas('hiring', function ($q) use ($startDate, $endDate) {
                    $q->whereBetween('confirmation_date', [$startDate, $endDate]);
                });
            }

            $applications = $query->get();

            $report = [];
            $totalRecords = 0;

            foreach ($applications as $application) {
                $report[] = [
                    'applicant_name' => $application->applicant->first_name . ' ' . ($application->applicant->middle_name ? substr($application->applicant->middle_name, 0, 1) . '. ' : '') . $application->applicant->last_name,
                    'branch' => $application->branch->municipality,
                    'job_title' => $application->job->job_title,
                    'application_date' => $application->hiring->confirmation_date,
                    'referral_code' => $application->hiring->confirmation_code,
                ];

                $totalRecords++;
            }

            return response()->json([
                "draw" => intval($request->input('draw', 1)),
                "recordsTotal" => $totalRecords,
                "recordsFiltered" => $totalRecords,
                "data" => $report
            ]);
        }

        $branches = Branch::where('status', 'Active')->get();
        return view('content.hired-applicant-report', compact('branches'));
    }

    public function showApplicantDeploymentReport(Request $request)
    {
        if ($request->ajax()) {
            $query = ApplicationForm::query()->where('status', 'Deployed')->with('applicant', 'branch', 'job', 'hiring', 'deployment');

            if (Auth::guard('employee')->user()->position == 'Manager') {
                $query = $query->where('branch_id', Auth::guard('employee')->user()->branch_id);
            }

            if ($request->filled('branch_id')) {
                $query->where('branch_id', $request->branch_id);
            }

            if ($request->filled('date_range')) {
                $dates = explode(' - ', $request->date_range);
                $startDate = \Carbon\Carbon::createFromFormat('m/d/Y', trim($dates[0]))->startOfDay();
                $endDate = \Carbon\Carbon::createFromFormat('m/d/Y', trim($dates[1]))->endOfDay();
                $query->whereHas('deployment', function ($q) use ($startDate, $endDate) {
                    $q->whereBetween('actual_departure_date', [$startDate, $endDate]);
                });
            }

            $applications = $query->get();

            $report = [];
            $totalRecords = 0;

            foreach ($applications as $application) {
                $report[] = [
                    'applicant_name' => $application->applicant->first_name . ' ' . ($application->applicant->middle_name ? substr($application->applicant->middle_name, 0, 1) . '. ' : '') . $application->applicant->last_name,
                    'branch' => $application->branch->municipality,
                    'job_title' => $application->job->job_title,
                    'schedule_departure_date' => $application->deployment->schedule_departure_date,
                    'actual_departure_date' => $application->deployment->actual_departure_date,
                    'referral_code' => $application->hiring->confirmation_code,
                ];

                $totalRecords++;
            }

            return response()->json([
                "draw" => intval($request->input('draw', 1)),
                "recordsTotal" => $totalRecords,
                "recordsFiltered" => $totalRecords,
                "data" => $report
            ]);
        }

        $branches = Branch::where('status', 'Active')->get();
        return view('content.applicant-deployment-report', compact('branches'));
    }

    public function showBranchInterviewReport(Request $request)
    {
        if ($request->ajax()) {
            $query = ApplicationForm::query()->where('status', '!=', 'Pending')->with('applicant', 'branch', 'job', 'hiring', 'deployment', 'branchInterview', 'branchInterview.employee');

            if (Auth::guard('employee')->user()->position == 'Manager') {
                $query = $query->where('branch_id', Auth::guard('employee')->user()->branch_id);
            }

            if ($request->filled('branch_id')) {
                $query->where('branch_id', $request->branch_id);
            }

            if ($request->filled('date_range')) {
                $dates = explode(' - ', $request->date_range);
                $startDate = \Carbon\Carbon::createFromFormat('m/d/Y', trim($dates[0]))->startOfDay();
                $endDate = \Carbon\Carbon::createFromFormat('m/d/Y', trim($dates[1]))->endOfDay();
                $query->whereHas('branchInterview', function ($q) use ($startDate, $endDate) {
                    $q->whereBetween('created_at', [$startDate, $endDate]);
                });
            }

            $applications = $query->get();

            $report = [];
            $totalRecords = 0;

            foreach ($applications as $application) {
                $interviewer = $application->branchInterview->employee;
                $interviewerName = $interviewer->first_name . ' ' . ($interviewer->middle_name ? substr($interviewer->middle_name, 0, 1) . '. ' : '') . $interviewer->last_name;

                $report[] = [
                    'applicant_name' => $application->applicant->first_name . ' ' . ($application->applicant->middle_name ? substr($application->applicant->middle_name, 0, 1) . '. ' : '') . $application->applicant->last_name,
                    'branch' => $application->branch->municipality,
                    'job_title' => $application->job->job_title,
                    'rating' => $application->branchInterview->rating,
                    'interview_date' => $application->branchInterview->created_at,
                    'interviewer' => $interviewerName,
                    'remarks' => $application->branchInterview->remarks,
                ];

                $totalRecords++;
            }

            return response()->json([
                "draw" => intval($request->input('draw', 1)),
                "recordsTotal" => $totalRecords,
                "recordsFiltered" => $totalRecords,
                "data" => $report
            ]);
        }

        $branches = Branch::where('status', 'Active')->get();
        return view('content.branch-interview-report', compact('branches'));
    }

    public function showEmployerInterviewReport(Request $request)
    {
        if ($request->ajax()) {
            $query = EmployerInterview::query()->with('application.applicant', 'application.branch', 'application.job', 'application.hiring', 'employer');

            if (Auth::guard('employee')->user()->position == 'Manager') {
                $query = $query->whereHas('application', function ($q) {
                    $q->where('branch_id', Auth::guard('employee')->user()->branch_id);
                });
            }

            if ($request->filled('branch_id')) {
                $query->whereHas('application', function ($q) use ($request) {
                    $q->where('branch_id', $request->branch_id);
                });
            }

            if ($request->filled('date_range')) {
                $dates = explode(' - ', $request->date_range);
                $startDate = \Carbon\Carbon::createFromFormat('m/d/Y', trim($dates[0]))->startOfDay();
                $endDate = \Carbon\Carbon::createFromFormat('m/d/Y', trim($dates[1]))->endOfDay();
                $query->whereBetween('interview_date', [$startDate, $endDate]);
            }

            $interviews = $query->get();

            $report = [];
            $totalRecords = 0;

            foreach ($interviews as $interview) {
                $application = $interview->application;
                $applicant = $application->applicant;
                $employer = $interview->employer;
                $report[] = [
                    'applicant_name' => $applicant->first_name . ' ' . ($applicant->middle_name ? substr($applicant->middle_name, 0, 1) . '. ' : '') . $applicant->last_name,
                    'branch' => $application->branch->municipality,
                    'job_title' => $application->job->job_title,
                    'rating' => $interview->rating,
                    'interview_date' => $interview->interview_date,
                    'interviewer' => $employer->first_name . ' ' . ($employer->middle_name ? substr($employer->middle_name, 0, 1) . '. ' : '') . $employer->last_name,
                    'remarks' => $interview->remarks,
                    'referral_code' => $application->hiring->confirmation_code,
                ];

                $totalRecords++;
            }

            return response()->json([
                "draw" => intval($request->input('draw', 1)),
                "recordsTotal" => $totalRecords,
                "recordsFiltered" => $totalRecords,
                "data" => $report
            ]);
        }

        $branches = Branch::where('status', 'Active')->get();
        return view('content.employer-interview-report', compact('branches'));
    }

    public function showRegisteredApplicantsReport(Request $request)
    {
        if ($request->ajax()) {
            $query = Applicant::query();

            if ($request->filled('branch_id')) {
                $query->where('branch_id', $request->branch_id);
            }

            if ($request->filled('date_range')) {
                $dates = explode(' - ', $request->date_range);
                $startDate = \Carbon\Carbon::createFromFormat('m/d/Y', trim($dates[0]))->startOfDay();
                $endDate = \Carbon\Carbon::createFromFormat('m/d/Y', trim($dates[1]))->endOfDay();
                $query->whereBetween('created_at', [$startDate, $endDate]);
            }

            $applicants = $query->get();

            $report = [];
            $totalRecords = 0;

            foreach ($applicants as $applicant) {
                $address = $applicant->street . ', ' . $applicant->barangay . ', ' . $applicant->municipality . ', ' . $applicant->province . ', ' . $applicant->region . ', ' . $applicant->postal_code;
                $report[] = [
                    'applicant_name' => $applicant->first_name . ' ' . ($applicant->middle_name ? substr($applicant->middle_name, 0, 1) . '. ' : '') . $applicant->last_name,
                    'contact_number' => $applicant->contact_number,
                    'email' => $applicant->email,
                    'date_registered' => $applicant->created_at,
                    'address' => $address,
                    'status' => $applicant->status,
                ];

                $totalRecords++;
            }

            return response()->json([
                "draw" => intval($request->input('draw', 1)),
                "recordsTotal" => $totalRecords,
                "recordsFiltered" => $totalRecords,
                "data" => $report
            ]);
        }

        $branches = Branch::where('status', 'Active')->get();
        return view('content.registered-applicants-report', compact('branches'));
    }

    public function getFullStatusText($status)
    {
        $statuses = [
            "Pending" => "Pending for Manager Interview",
            "Interviewed" => "Interviewed",
            "Submitting" => "Submitting Documents",
            "Reviewing" => "Reviewing Application",
            "ScheduledBranchInterview" => "Scheduled for Branch Interview",
            "ScheduledEmployerInterview" => "Scheduled for Employer Interview",
            "Waiting" => "Waiting to be Hired",
            "Hired" => "Waiting to be Deployed",
            "Deployed" => "Deployed With Departure Schedule",
            "Cancelled" => "Canceled Application",
            "Rejected" => "Rejected Application",
        ];

        return $statuses[$status] ?? "Unknown";
    }

    public function showApplicationsReport(Request $request)
    {
        if ($request->ajax()) {
            $query = ApplicationForm::query()->with('applicant', 'branch', 'job', 'hiring', 'deployment', 'branchInterview', 'branchInterview.employee');

            if (Auth::guard('employee')->user()->position == 'Manager') {
                $query = $query->where('branch_id', Auth::guard('employee')->user()->branch_id);
            }

            if ($request->filled('branch_id')) {
                $query->where('branch_id', $request->branch_id);
            }

            if ($request->filled('date_range')) {
                $dates = explode(' - ', $request->date_range);
                $startDate = Carbon::createFromFormat('m/d/Y', trim($dates[0]))->startOfDay();
                $endDate = Carbon::createFromFormat('m/d/Y', trim($dates[1]))->endOfDay();
                $query->whereBetween('application_date', [$startDate, $endDate]);
            }

            $applications = $query->get();

            $report = [];
            $totalRecords = 0;

            foreach ($applications as $application) {

                $report[] = [
                    'applicant_name' => $application->applicant->first_name . ' ' . ($application->applicant->middle_name ? substr($application->applicant->middle_name, 0, 1) . '. ' : '') . $application->applicant->last_name,
                    'branch' => $application->branch->municipality,
                    'job_title' => $application->job->job_title,
                    'application_date' => $application->created_at,
                    'status' => $this->getFullStatusText($application->status),
                ];

                $totalRecords++;
            }

            return response()->json([
                "draw" => intval($request->input('draw', 1)),
                "recordsTotal" => $totalRecords,
                "recordsFiltered" => $totalRecords,
                "data" => $report
            ]);
        }

        $branches = Branch::where('status', 'Active')->get();
        return view('content.application-report', compact('branches'));
    }


}
