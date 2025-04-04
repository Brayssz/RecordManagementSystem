<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\PasswordResetController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Content\AppController;
use App\Http\Controllers\Auth\ApplicantRegisterController;
use App\Http\Controllers\Content\ApplicantController;
use App\Http\Controllers\Content\ApplicationController;
use App\Http\Controllers\Content\BranchController;
use App\Http\Controllers\Content\BranchScheduleController;
use App\Http\Controllers\Content\DocumentController;
use App\Http\Controllers\Content\EmployeeController;
use App\Http\Controllers\Content\EmployerController;
use App\Http\Controllers\Content\JobOfferController;
use App\Http\Controllers\Content\PDFController;
use App\Http\Controllers\Content\ReportController;
use App\Http\Controllers\Content\TextractController;

Route::get('/', function () {
    return view('auth.login');
});

Route::middleware(['employee'])->group(function () {
    Route::get('/applicant-documents', [DocumentController::class, 'showApplicantDocuments'])->name('applicant-documents');

    Route::get('/approve-applications', [ApplicationController::class, 'showToApproveApplications'])->name('approve-applications');

    Route::get('/hire-applicants', [ApplicationController::class, 'showToHireApplications'])->name('hire-applicants');

    Route::get('/deploy-applicants', [ApplicationController::class, 'showToDeployApplications'])->name('deploy-applicants');
     
    Route::get('/jobs', [JobOfferController::class, 'showJobOffers'])->name('jobs');

    Route::get('/application-records', [ApplicationController::class, 'showApplicantRecords'])->name('application-records');

    Route::get('/employer-pending-applications', [ApplicationController::class, 'showPendingEmployerApplications'])->name('employer-pending-applications');

    Route::get('/scheduled-employer-interviews', [ApplicationController::class, 'showScheduledEmployerInterviews'])->name('scheduled-employer-interviews');
});

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


Route::get('/scheduled-branch-interviews', [ApplicationController::class, 'showScheduledBranchInterviews'])->name('scheduled-branch-interviews');

Route::get('/capture ', [AppController::class, 'showCapture'])->name('capture');

Route::get('/branch-schedules', [BranchScheduleController::class, 'showBranchSchedule'])->name('branch-schedules');

Route::get('/get-application-chart-data', [AppController::class, 'getApplicationChartData']);



Route::get('/branch-performance-report', [ReportController::class, 'showBranchPerformanceReport']);

Route::get('/hired-applicant-report', [ReportController::class, 'showHiredApplicantReport']);

Route::get('/applicant-deployment-report', [ReportController::class, 'showApplicantDeploymentReport']);

Route::get('/branch-interview-report', [ReportController::class, 'showBranchInterviewReport']);

Route::get('/employer-interview-report', [ReportController::class, 'showEmployerInterviewReport']);

Route::get('/registered-applicants-report', [ReportController::class, 'showRegisteredApplicantsReport']);

Route::get('/applications-report', [ReportController::class, 'showApplicationsReport']);



Route::get('/generate-branch-performance-report', [PDFController::class, 'showBranchPerformanceReport']);

Route::get('/generate-hired-applicant-report', [PDFController::class, 'showHiredApplicantReport']);

Route::get('/generate-applicant-deployment-report', [PDFController::class, 'showApplicantDeploymentReport']);

Route::get('/generate-branch-interview-report', [PDFController::class, 'showBranchInterviewReport']);

Route::get('/generate-employer-interview-report', [PDFController::class, 'showEmployerInterviewReport']);

Route::get('/generate-registered-applicants-report', [PDFController::class, 'showRegisteredApplicantsReport']);

Route::get('/generate-applications-report', [PDFController::class, 'showApplicationsReport']);



Route::get('/ocr-upload', function () {
    return view('content.ocr');
});

Route::post('/ocr', [TextractController::class, 'processImage']);