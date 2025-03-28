<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Applicant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Utils\JsonUtil;

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
            'date_of_birth' => 'required|date',
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

        $applicant = Applicant::create([
            'first_name' => $request->first_name,
            'middle_name' => $request->middle_name,
            'last_name' => $request->last_name,
            'gender' => $request->gender,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'contact_number' => $request->contact_number,
            'date_of_birth' => $request->date_of_birth,
            'region' => $request->region,
            'province' => $request->province,
            'municipality' => $request->municipality,
            'barangay' => $request->barangay,
            'street' => $request->street,
            'postal_code' => $request->postal_code,
            'citizenship' => $request->citizenship,
            'status' => 'Active',
            'marital_status' => $request->marital_status,
        ]);

        // Optionally, log the user in after registration
        // Auth::login($applicant);

        return redirect()->route('login')->with('success', 'Registration successful. Please log in.');
    }
}