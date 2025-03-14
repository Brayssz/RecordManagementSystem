<?php

namespace App\Livewire\Content;

use App\Models\ApplicationForm;
use App\Models\BranchInterview;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class RecordBranchInterview extends Component
{
    public $submit_func;
    public $branch_interview;
    public $remarks;
    public $rating = 0;
    public $status;
    public $b_interview_id;

    protected function rules()
    {
        return [
            'remarks' => 'required|string|max:255',
            'rating' => 'required|integer|min:1|max:100',
        ];
    }

    public function resetFields()
    {
        $this->reset(['remarks', 'rating', 'status', 'b_interview_id']);
    }

    public function getBranchInterview($bInterviewID)
    {
        $this->branch_interview = BranchInterview::findOrFail($bInterviewID);
        $this->remarks = $this->branch_interview->remarks;
        $this->rating = $this->branch_interview->rating;
        $this->b_interview_id = $this->branch_interview->b_interview_id;
    }

    public function submitBranchInterview()
    {
        $this->validate();

        $employee = Auth::guard('employee')->user();

        $branchInterview = BranchInterview::findOrFail($this->b_interview_id);

        $branchInterview->update([
            'remarks' => $this->remarks,
            'rating' => $this->rating,
            'branch_id' => $employee->branch_id,
            'employee_id' => $employee->employee_id,
            'status' => "Completed",
        ]);

        $this->resetFields();
        $this->setApplicationStatus();
        session()->flash('message', 'Branch interview successfully submitted.');

        return redirect()->route('scheduled-branch-interviews');
    }

    public function setApplicationStatus()
    {
        $application = ApplicationForm::findOrFail($this->branch_interview->application_id);
        $application->status = "Interviewed";
        $application->save();
    }

    public function render()
    {
        return view('livewire.content.record-branch-interview');
    }
}
