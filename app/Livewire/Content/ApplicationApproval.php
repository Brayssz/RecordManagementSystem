<?php

namespace App\Livewire\Content;

use Livewire\Component;
use App\Models\ApplicationForm;
use App\Notifications\ApproveApplication;

class ApplicationApproval extends Component
{
    public $application_id;

    public function approveApplication()
    {
        $application = ApplicationForm::find($this->application_id);
        $application->status = 'Submitting';
        $application->save();

        session()->flash('message', 'Application approved.');
        $this->sendApprovalEmail();

        return redirect()->route('approve-applications');
    }

    public function sendApprovalEmail()
    {
        $application = ApplicationForm::with('applicant')->find($this->application_id);

        $application->applicant->notify(new ApproveApplication($this->application_id));
    }

    public function rejectApplication()
    {
        $application = ApplicationForm::find($this->application_id);
        $application->status = 'Rejected';
        $application->save();

        session()->flash('message', 'Application rejected.');

        return redirect()->route('approve-applications');
    }

    public function render()
    {
        return view('livewire.content.application-approval');
    }
}
