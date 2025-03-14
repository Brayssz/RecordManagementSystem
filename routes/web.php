<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\PasswordResetController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Content\AppController;
use App\Http\Controllers\Auth\ApplicantRegisterController;
use App\Http\Controllers\Content\ApplicantController;
use App\Http\Controllers\Content\ApplicationController;
use App\Http\Controllers\Content\BranchController;
use App\Http\Controllers\Content\DocumentController;
use App\Http\Controllers\Content\EmployeeController;
use App\Http\Controllers\Content\EmployerController;
use App\Http\Controllers\Content\JobOfferController;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['employee'])->group(function () {});

Route::middleware(['employer'])->group(function () {

});

Route::middleware(['applicant'])->group(function () {

    Route::get('/job-offers', [JobOfferController::class, 'listJobOffers'])->name('job-offers');

    Route::get('/apply', [ApplicationController::class, 'showApplicationForm'])->name('apply');

    Route::get('/my-applications', [ApplicationController::class, 'showMyApplications'])->name('my-applications');
});

Route::post('/verify-email', [PasswordResetController::class, 'sendResetLink'])->name('verify-email');
Route::post('/password-reset', [PasswordResetController::class, 'resetPassword'])->name('password-reset');

Route::post('/login', [LoginController::class, 'login'])->name('login');
Route::post('/verify-login-otp', [LoginController::class, 'verifyLoginOTP']);
Route::post('/resend-otp', [LoginController::class, 'resendOTP']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/login', [LoginController::class, 'showLogin'])->name('login');
Route::get('/verification', [LoginController::class, 'showVerification'])->name('verification');

Route::get('/email-verification', [PasswordResetController::class, 'showEmailVerification'])->name('email-verification');
Route::get('/reset-password', [PasswordResetController::class, 'showPasswordReset'])->name('reset-password');

Route::get('/dashboard', [AppController::class, 'showDashboard'])->name('dashboard')->name('dashboard');

Route::get('/register', [ApplicantRegisterController::class, 'showRegistrationForm'])->name('register');

Route::post('/register', [ApplicantRegisterController::class, 'register']);

Route::get('/profile', [AppController::class, 'showProfile'])->name('profile');

Route::get('/employees', [EmployeeController::class, 'showEmployees'])->name('employees');

Route::get('/applicants', [ApplicantController::class, 'showApplicants'])->name('applicants');

Route::get('/branches', [BranchController::class, 'showBranches'])->name('branches');

Route::get('/employers', [EmployerController::class, 'showEmployers'])->name('employers');

Route::get('/jobs', [JobOfferController::class, 'showJobOffers'])->name('jobs');

Route::get('/branch-pending-applications', [ApplicationController::class, 'showPendingBranchApplications'])->name('branch-pending-applications');

Route::get('/scheduled-branch-interviews', [ApplicationController::class, 'showScheduledBranchInterviews'])->name('scheduled-branch-interviews');

Route::get('/capture ', [AppController::class, 'showCapture'])->name('capture');

Route::get('/applicant-documents', [DocumentController::class, 'showApplicantDocuments'])->name('applicant-documents');