<?php

namespace App\Http\Controllers\Content;

use App\Http\Controllers\Controller;
use App\Utils\GetUserType;
use Illuminate\Http\Request;

class AppController extends Controller
{
    public function showDashboard()
    {
        return view('content.dashboard');
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
}
