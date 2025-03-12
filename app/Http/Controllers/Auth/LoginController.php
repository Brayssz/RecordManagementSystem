<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Carbon\Carbon;
use App\Http\Controllers\Controller;
use App\Models\Applicant;
use App\Models\Employee;
use App\Models\Employer;
use App\Utils\GetUserType;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
    
        $user = $this->getUser($request->email);
    
        if (!$user || !Hash::check($request->password, $user->password)) {
            return back()->withErrors(['message' => 'Invalid credentials']);
        }
    
        $otp = mt_rand(100000, 999999);
        unset($user->user_type);
        $user->two_factor_code = $otp;
        $user->two_factor_expires_at = Carbon::now()->addMinutes(5);
        $user->save(); 
    
        // Mail::raw("Your login OTP is: $otp", function ($message) use ($request) {
        //     $message->to($request->email)->subject('Your OTP Code');
        // });

        Session::put('verification_email', $user->email);
    
        return redirect()->route('verification')->with('success', 'Login successful!');
    }
    
    
    public function showVerification()
    {
        return view('auth.login-two-factor');
    }
    private function getUser($email)
    {
        $applicant = Applicant::where('email', $email)->first();
        if ($applicant) {
            return $applicant;
        }

        $employee = Employee::where('email', $email)->first();
        if ($employee) {
            return $employee;
        }

        $employer = Employer::where('email', $email)->first();
        if ($employer) {
            return $employer;
        }

        return null;
    }

    public function verifyLoginOTP(Request $request)
    {
        $request->validate([
            'otp' => 'required|digits:6',
        ]);

        $email = Session::get('verification_email');

        $user = $this->getUser($email);

        if (!$user || $user->two_factor_code !== $request->otp) {
            return response()->json(['message' => 'Invalid OTP' .  $email], 400);
        }

        if (Carbon::now()->gt($user->two_factor_expires_at)) {
            return response()->json(['message' => 'OTP expired'], 400);
        }

        $user->two_factor_code = null;
        $user->two_factor_expires_at = null;
        $user->save(['two_factor_code', 'two_factor_expires_at']);
    
        Auth::guard($user->user_type)->login($user);

        Session::forget('verification_email');

        return response()->json([
            'message' => 'Login successful',
            'token' => $user
        ]);
    }

    public function showLogin()
    {
        return view('auth.login');
    }

    public function resendOTP(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'user_type' => 'required|in:applicant,employee,employer',
        ]);

        $user = $this->getUser($request->email, $request->user_type);

        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        $otp = mt_rand(100000, 999999);
        $user->two_factor_code = $otp;
        $user->two_factor_expires_at = Carbon::now()->addMinutes(5);
        $user->save();

        Mail::raw("Your new OTP is: $otp", function ($message) use ($request) {
            $message->to($request->email)->subject('Your New OTP Code');
        });

        return response()->json(['message' => 'New OTP sent']);
    }
    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();
        return response()->json(['message' => 'Logged out successfully']);
    }
}
