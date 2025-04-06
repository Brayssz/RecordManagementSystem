<?php

namespace App\Livewire\Content;

use App\Models\EmployerInterview;
use Livewire\Component;
use App\Utils\GetUserType;
use App\Utils\GetProfilePhoto;
use Illuminate\Support\Facades\Auth;
use App\Models\ApplicationForm;
use App\Models\DocumentsRequest;

class Layout extends Component
{
    public function getInterviewCount() {
        $user_type = GetUserType::getUserType();

        if($user_type == 'employee') {

            if(Auth ::user()->position == 'Admin') {
                return $this->AdminInterviewCount();
            }

            if(Auth::user()->position == 'Manager') {
                return $this->BranchInterviewCount();
            }
        }
    }

    public function getDocumentRequestCount() {

        $employee = Auth::guard('employee')->user();

        if($employee) {
            return DocumentsRequest::where('status', 'Pending')
                ->with('application')
                ->whereHas('application', function($query) use ($employee) {
                    $query->where('branch_id', $employee->branch_id);
                })
                ->count();
        }
       
    }

    public function BranchInterviewCount(){
        return ApplicationForm::with('schedule')->whereHas('schedule', function($query) {
            $query->whereDate('interview_date', now()->toDateString());
        })
        ->where('status', 'Pending')
        ->where('branch_id', Auth::user()->branch_id)->count();
    }

    public function AdminInterviewCount () {
        return EmployerInterview::with('application')
            ->whereDate('interview_date', now()->toDateString())
            ->whereHas('application', function($query) {
                $query->where('status', 'ScheduledEmployerInterview');
            })
            ->count();
    }
    
    public function render()
    {
        return view('livewire.content.layout');
    }
}
