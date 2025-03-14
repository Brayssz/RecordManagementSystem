<?php

namespace App\Livewire\Content;

use App\Models\EmployerInterview;
use App\Models\ApplicationForm;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class RecordEmployerInterview extends Component
{
    public $submit_func;
    public $branch_interview;
    public $remarks;
    public $rating = 0;
    public $status;
    public $e_interview_id;

    protected function rules()
    {
        return [
            'remarks' => 'required|string|max:255',
            'rating' => 'required|integer|min:1|max:100',
        ];
    }

    public function resetFields()
    {
        $this->reset(['remarks', 'rating', 'status', 'e_interview_id']);
    }

    public function getBranchInterview($bInterviewID)
    {
        $this->branch_interview = EmployerInterview::findOrFail($bInterviewID);
        $this->remarks = $this->branch_interview->remarks;
        $this->rating = $this->branch_interview->rating;
        $this->e_interview_id = $this->branch_interview->e_interview_id;
    }

    public function submitEmployerInterview()
    {
        $this->validate();

        $employer = Auth::guard('employer')->user();

        $employerInterview = EmployerInterview::findOrFail($this->e_interview_id);

        $employerInterview->update([
            'remarks' => $this->remarks,
            'rating' => $this->rating,
            'branch_id' => $employer->branch_id,
            'employer_id' => $employer->employer_id,
            'status' => "Completed",
        ]);

        $this->resetFields();
        $this->setApplicationStatus();
        session()->flash('message', 'Employer interview successfully submitted.');

        return redirect()->route('scheduled-employer-interviews');
    }

    public function setApplicationStatus()
    {
        $application = ApplicationForm::findOrFail($this->branch_interview->application_id);
        $application->status = "Waiting";
        $application->save();
    }
    public function render()
    {
        return view('livewire.content.record-employer-interview');
    }
}
