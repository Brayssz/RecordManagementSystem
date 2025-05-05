<?php

namespace App\Livewire\Content;

use Livewire\Component;
use App\Models\ApplicationForm;
use App\Models\Hiring;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use App\Notifications\HireApplicant as HireApplicantNotification;
use App\Notifications\HiredApplicantBranchNotification;
use App\Models\Employee;

class HireApplicant extends Component
{
    public $application_id;

    public function hireApplicant()
    {
        $application = ApplicationForm::find($this->application_id);
        $application->status = 'Hired';
        $application->save();

        session()->flash('message', 'Application approved.');

        $this->hiring();
        $this->sendHiredNotification();
        $this->sendHiredEmail();

        return redirect()->route('hire-applicants');
    }


    public function sendHiredNotification()
    {
        $application = ApplicationForm::with('applicant')->find($this->application_id);

        $branch_managers = Employee::where('branch_id', $application->branch_id)
            ->where('position', 'Manager')
            ->get();

        foreach ($branch_managers as $manager) {
            $manager->notify(new HiredApplicantBranchNotification($this->application_id));
        }
    }

    public function sendHiredEmail()
    {
        $application = ApplicationForm::with('applicant')->find($this->application_id);

        $application->applicant->notify(new HireApplicantNotification($this->application_id));
    }

    public function hiring() {
        $application = ApplicationForm::with('employerInterview')->find($this->application_id);
       
        Hiring::create([
            'e_interview_id' => $application->employerInterview->e_interview_id,
            'employee_id' => Auth::user()->employee_id,
            'application_id' => $this->application_id,
            'status' => 'Hired',
            'confirmation_code' => $this->generateUniqueConfirmationCode(),
            'confirmation_date' => now(),
        ]);
    }
    
    private function generateUniqueConfirmationCode() {
        do {
            $code = Str::upper('RD' . '-' . mt_rand(1000, 9999));
        } while (Hiring::where('confirmation_code', $code)->exists());

        return $code;
    }

    public function render()
    {
        return view('livewire.content.hire-applicant');
    }
}
