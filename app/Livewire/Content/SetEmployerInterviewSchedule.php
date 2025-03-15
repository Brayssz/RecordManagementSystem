<?php

namespace App\Livewire\Content;

use App\Models\EmployerInterview;
use App\Models\ApplicationForm;
use Livewire\Component;

class SetEmployerInterviewSchedule extends Component
{
    public $interview_date;
    public $interview_time;
    public $meeting_link;
    public $application_id;

    public function setInterviewSchedule()
    {
        $this->validate([
            'interview_date' => 'required|date|after_or_equal:today',
            'interview_time' => 'required|date_format:H:i',
            'meeting_link' => 'required|url',
        ]);

        $branchInterview = EmployerInterview::firstOrNew(['application_id' => $this->application_id]);
        $branchInterview->interview_date = $this->interview_date;
        $branchInterview->interview_time = $this->interview_time;
        $branchInterview->meeting_link = $this->meeting_link;
        $branchInterview->status = 'Pending';
        $branchInterview->save();

        $this->updateApplicationStatus();  

        session()->flash('message', 'Interview schedule set successfully.');

        return redirect()->route('branch-pending-applications');
    }

    public function updateApplicationStatus()
    {
        $application = ApplicationForm::find($this->application_id);
        $application->status = 'ScheduledEmployerInterview';
        $application->save();
    }

    public function render()
    {
        return view('livewire.content.set-employer-interview-schedule');
    }
}
