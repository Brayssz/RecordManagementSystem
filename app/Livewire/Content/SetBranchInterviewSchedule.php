<?php

namespace App\Livewire\Content;

use Livewire\Component;
use App\Models\BranchInterview;
use App\Models\ApplicationForm;

class SetBranchInterviewSchedule extends Component
{
    public $interview_date;
    public $application_id;

    public function render()
    {
        return view('livewire.content.set-branch-interview-schedule');
    }

    public function setInterviewSchedule()
    {
        $this->validate([
            'interview_date' => 'required|date|after:today',
        ]);

        $branchInterview = BranchInterview::firstOrNew(['application_id' => $this->application_id]);
        $branchInterview->interview_date = $this->interview_date;
        $branchInterview->status = 'Pending';
        $branchInterview->save();

        $this->updateApplicationStatus();  

        session()->flash('message', 'Interview schedule set successfully.');

        return redirect()->route('branch-pending-applications');
    }

    public function updateApplicationStatus()
    {
        $application = ApplicationForm::find($this->application_id);
        $application->status = 'ScheduledBranchInterview';
        $application->save();

    }
}
