<?php

namespace App\Utils;
use Illuminate\Support\Facades\Auth;


class GetUserType
{
    public static function getUserType()
    {
        $user = Auth::user();

        if ($user->employee_id) {
            return 'employee';
        } elseif ($user->applicant_id) {
            return 'applicant';
        } elseif ($user->employer_id) {
            return 'employer';
        }

        return 'unknown';
    }
}