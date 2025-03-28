<?php

namespace App\Http\Controllers\Content;

use App\Http\Controllers\Controller;
use App\Utils\GetUserType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Branch;
use App\Models\Employee;
use App\Models\JobOffer;
use App\Models\Applicant;
use App\Models\ApplicationForm;
use App\Models\EmployerInterview;
use Illuminate\Support\Facades\DB;
use App\Models\Hiring;
use App\Models\Deployment;

class AppController extends Controller
{
    public function showDashboard()
    {
        if (!session()->has('auth_user_type')) {
            return redirect()->route('login');
        } else if (session('auth_user_type') == 'applicant') {
            return view('content.applicant-dashboard');
        } else if (session('auth_user_type') == 'employee') {
            if (Auth::user()->position == 'Admin') {
                return $this->adminDashboard();
            } else if (Auth::user()->position == 'Manager') {
                return view('content.manager-dashboard');
            } else if (Auth::user()->position == 'Clerk') {
                return view('content.clerk-dashboard');
            }
        } else if (session('auth_user_type') == 'employer') {
            return view('content.employer-dashboard');
        } else {
            return redirect()->route('login');
        }

        // return view('content.admin-dashboard');
    }


    public function adminDashboard()
    {
        $total_branch = Branch::where('status', 'Active')->count();
        $total_employees = Employee::where('status', 'Active')->count();
        $total_applicants = Applicant::where('status', 'Active')->count();
        $total_jobs = JobOffer::where('status', 'Active')->count();

        $unscheduled_applications = ApplicationForm::where('status', 'Reviewing')->count();
        $scheduled_interviews =  EmployerInterview::with('application')
            ->whereDate('interview_date', now()->toDateString())
            ->whereHas('application', function ($query) {
                $query->where('status', 'ScheduledEmployerInterview');
            })
            ->count();
        $pending_hiring = ApplicationForm::where('status', 'Waiting')->count();
        $pending_deployment = ApplicationForm::where('status', 'Hired')->count();

        $scheduled_interviews_list = ApplicationForm::with('applicant', 'job.employer', 'branch', 'employerInterview', 'job')
            ->where('status', 'ScheduledEmployerInterview')
            ->get();

        return view('content.admin-dashboard', compact('total_branch', 'total_employees', 'total_applicants', 'total_jobs', 'unscheduled_applications', 'scheduled_interviews', 'pending_hiring', 'pending_deployment', 'scheduled_interviews_list'));
    }

    public function showProfile()
    {
        $userType = GetUserType::getUserType();

        if ($userType == 'applicant') {
            return view('content.applicant-profile');
        } else if ($userType == 'employee') {
            return view('content.employee-profile');
        } else if ($userType == 'employer') {
            return view('content.employer-profile');
        } else {
            return redirect()->route('login');
        }
    }

    public function getApplicationChartData()
    {
        $hired = Hiring::select(
            DB::raw("MONTH(confirmation_date) as month"),
            DB::raw("COUNT(*) as total")
        )
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('total', 'month')
            ->toArray();

        $deployed = Deployment::select(
            DB::raw("MONTH(actual_departure_date) as month"),
            DB::raw("COUNT(*) as total")
        )
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('total', 'month')
            ->toArray();

        $months = range(1, 12);
        $hiredData = [];
        $deployedData = [];

        foreach ($months as $month) {
            $hiredData[] = $hired[$month] ?? 0;
            $deployedData[] = $deployed[$month] ?? 0;
        }

        return response()->json([
            'hired' => $hiredData,
            'deployed' => $deployedData,
        ]);
    }

    public function showCapture(Request $request)
    {
        return view('content.capture');
    }
}
