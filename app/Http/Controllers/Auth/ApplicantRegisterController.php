<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Applicant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Utils\JsonUtil;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use App\Notifications\ApplicantEmailVerification;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Auth;

class ApplicantRegisterController extends Controller
{
    public function showRegistrationForm()
    {
        $jsonResponse = JsonUtil::getJsonFromPublic('location.json');
        $locationData = $jsonResponse->getData(true);

        // return($locationData);

        return view('auth.applicant-registration', compact('locationData'));
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string|max:255',
            'middle_name' => 'nullable|string|max:255',
            'last_name' => 'required|string|max:255',
            'gender' => 'required|string|max:10',
            'email' => 'required|string|email|max:255|unique:applicants|unique:employees|unique:employers',
            'password' => 'required|string|min:8|confirmed',
            'contact_number' => 'required|string|max:20',
            'date_of_birth' => 'required|date|after_or_equal:1975-01-01|before_or_equal:2003-12-31',
            'region' => 'required|string|max:255',
            'province' => 'required|string|max:255',
            'municipality' => 'required|string|max:255',
            'barangay' => 'required|string|max:255',
            'street' => 'required|string|max:255',
            'postal_code' => 'required|string|max:10',
            'citizenship' => 'required|string|max:255',
            'marital_status' => 'required|string|max:255',
            'terms' => 'accepted',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $token = Str::uuid()->toString();
        Cache::put('applicant_register_' . $token, $request->all(), now()->addMinutes(30));

        $verificationUrl = route('applicant.verify.email', ['token' => $token]);

        Notification::route('mail', $request->email)
            ->notify(new ApplicantEmailVerification($verificationUrl));

        return view('auth.check-your-email');
        
    }

    public function verifyEmail($token)
    {
        $data = Cache::get('applicant_register_' . $token);

        if (!$data) {
            return redirect()->route('login')->with('error', 'Verification link expired or invalid.');
        }

        // Create applicant
        $user = Applicant::create([
            'first_name' => $data['first_name'],
            'middle_name' => $data['middle_name'],
            'last_name' => $data['last_name'],
            'gender' => $data['gender'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'contact_number' => $data['contact_number'],
            'date_of_birth' => $data['date_of_birth'],
            'region' => $data['region'],
            'province' => $data['province'],
            'municipality' => $data['municipality'],
            'barangay' => $data['barangay'],
            'street' => $data['street'],
            'postal_code' => $data['postal_code'],
            'citizenship' => $data['citizenship'],
            'status' => 'Active',
            'marital_status' => $data['marital_status'],
        ]);

        Cache::forget('applicant_register_' . $token);

        return view('auth.verified');
    }
}
