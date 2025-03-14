<?php

namespace App\Livewire\Content;

use Livewire\Component;
use App\Models\ApplicationForm;

class ApplicationApproval extends Component
{
    public $application_id;

    public function approveApplication()
    {
        $application = ApplicationForm::find($this->application_id);
        $application->status = 'Submitting';
        $application->save();

        session()->flash('message', 'Application approved.');

        return redirect()->route('approve-applications');
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
