<?php

namespace App\Utils;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class GetUserType
{
    public static function getUserType()
    {
        return Session::get('auth_user_type');;
    }
}