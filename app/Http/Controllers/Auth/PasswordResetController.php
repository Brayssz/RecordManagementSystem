<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use App\Models\Applicant;
use App\Models\Employee;
use App\Models\Employer;

class PasswordResetController extends Controller
{

    public function showEmailVerification()
    {
        return view('auth.email-verification');
    }

    public function sendResetLink(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        $user = $this->getUser($request->email);

        if (!$user) {
            return redirect()->back()->withErrors(['email' => 'User not found']);
        }

        $token = Str::random(60);

        DB::table('password_reset_tokens')->updateOrInsert(
            ['email' => $request->email, 'user_type' => $user->user_type],
            ['token' => Hash::make($token), 'created_at' => Carbon::now()]
        );

        $resetLink = url('/reset-password?token=' . $token . '&email=' . urlencode($request->email) . '&user_type=' . $user->user_type);

        Mail::raw("Click here to reset your password: $resetLink", function ($message) use ($request) {
            $message->to($request->email)->subject('Password Reset Request');
        });

        return redirect()->back()->with('status', 'verification-link-sent');
    }

    public function showPasswordReset()
    {
        $token = request('token');
        $email = request('email');

        return view('auth.reset-password', compact('token', 'email'));
    }

    private function getUser($email)
    {
        $applicant = Applicant::where('email', $email)->first();
        if ($applicant) {
            $applicant->user_type = 'applicant';
            return $applicant;
        }

        $employee = Employee::where('email', $email)->first();
        if ($employee) {
            $employee->user_type = 'employee';
            return $employee;
        }

        $employer = Employer::where('email', $email)->first();
        if ($employer) {
            $employer->user_type = 'employer';
            return $employer;
        }

        return null;
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'token' => 'required',
            'password' => 'required|min:8|confirmed'
        ]);

        $user = $this->getUser($request->email);

        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        $resetRequest = DB::table('password_reset_tokens')
            ->where('email', $user->email)
            ->where('user_type', $user->user_type)
            ->first();

        if (!$resetRequest || !Hash::check($request->token, $resetRequest->token)) {
            return response()->json(['message' => 'Invalid or expired token'], 400);
        }


        DB::table('password_reset_tokens')
            ->where('email', $request->email)
            ->where('user_type', $user->user_type)
            ->delete();


        unset($user->user_type);
        $user->password = Hash::make($request->password);
        $user->save();

        return redirect('/login')->with('status', 'Password reset successfully');
    }
}
