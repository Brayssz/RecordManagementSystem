<?php

namespace App\Livewire\Content;

use App\Models\ApplicationForm;
use App\Models\BranchInterview;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Notifications\ApproveApplication;


class RecordBranchInterview extends Component
{
    public $submit_func;
    public $branch_interview;
    public $remarks;
    public $rating = 0;
    public $status;
    public $b_interview_id;

    public $application_id;

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

        if ($this->b_interview_id !== null) {
            $branchInterview = BranchInterview::findOrFail($this->b_interview_id);

            $branchInterview->update([
                'remarks' => $this->remarks,
                'rating' => $this->rating,
                'branch_id' => $employee->branch_id,
                'employee_id' => $employee->employee_id,
                'application_id' => $this->application_id,
                'status' => "Completed",
            ]);

            session()->flash('message', 'Branch interview successfully updated.');
        } else {
            BranchInterview::create([
                'remarks' => $this->remarks,
                'rating' => $this->rating,
                'branch_id' => $employee->branch_id,
                'employee_id' => $employee->employee_id,
                'application_id' => $this->application_id,
                'status' => "Completed",
            ]);

            if($this->rating >= 5){
                $this->approveApplication();
            } else {
                $this->rejectApplication();
            }

            session()->flash('message', 'Branch interview successfully created.');
        }

        $this->resetFields();

        return redirect()->route('scheduled-branch-interviews');
    }

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

    public function setApplicationStatus()
    {
        $application = ApplicationForm::findOrFail($this->application_id);
        $application->status = "Interviewed";
        $application->save();
    }

    public function render()
    {
        return view('livewire.content.record-branch-interview');
    }
}
