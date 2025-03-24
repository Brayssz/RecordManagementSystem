<?php

namespace App\Http\Controllers\Content;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Branch;
use App\Models\ApplicationForm;
use Illuminate\Support\Facades\Auth;


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
            
            $query = ApplicationForm::query()->where('status', 'Hired')->with('applicant', 'branch', 'job', 'hiring');

            if(Auth::guard('employee')->user()->position == 'Manager') {
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

            if(Auth::guard('employee')->user()->position == 'Manager') {
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


     public function showApplicantDeploymentReport(Request $request)
    {
        if ($request->ajax()) {
            $query = ApplicationForm::query()->where('status', 'Deployed')->with('applicant', 'branch', 'job', 'hiring', 'deployment');

            if(Auth::guard('employee')->user()->position == 'Manager') {
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
}
 