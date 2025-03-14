<?php

namespace App\Http\Controllers\Content;

use App\Http\Controllers\Controller;
use App\Utils\GetUserType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AppController extends Controller
{
    public function showDashboard()
    {
        if (!session()->has('auth_user_type')) {
            return redirect()->route('login');
        } else if (session('auth_user_type') == 'applicant') {
            return view('content.applicant-dashboard');
        } else if (session('auth_user_type') == 'employee') {
            if(Auth::user()->position == 'Admin') {
                return view('content.admin-dashboard');
            } else if(Auth::user()->position == 'Manager'){
                return view('content.manager-dashboard');
            } else if(Auth::user()->position == 'Clerk'){
                return view('content.staff-dashboard');
            } 
        } else if (session('auth_user_type') == 'employer') {
            return view('content.employer-dashboard');
        } else {
            return redirect()->route('login');
        }
    }

    public function showProfile()
    {
        $userType = GetUserType::getUserType();

        if($userType == 'applicant') {
            return view('content.applicant-profile');
        } else if($userType == 'employee') {
            return view('content.employee-profile');
        } else if($userType == 'employer') {
            return view('content.employer-profile');
        } else {
            return redirect()->route('login');
        }
    }

    public function showCapture(Request $request)
    {
        return view('content.capture');
    }
}
