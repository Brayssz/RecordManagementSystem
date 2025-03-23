<?php

namespace App\Livewire\Content;

use Livewire\Component;
use App\Models\Deployment;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Models\ApplicationForm;

class DeployApplicant extends Component
{
    public $schedule_departure_date;
    public $actual_departure_date;
    public $application_id;
    public $deployment_id;

    protected $rules = [
        'schedule_departure_date' => 'required|date|after:today',
        'actual_departure_date' => 'nullable|date|after:today',
    ];

    public function getDeployment()
    {
        $deployment = Deployment::find($this->deployment_id);

        if ($deployment) {
            $this->schedule_departure_date = $deployment->schedule_departure_date;
            $this->actual_departure_date = $deployment->actual_departure_date;
        }
    }

    public function updateApplicationStatus() {
        $application = ApplicationForm::find($this->application_id);
        $application->status = 'Deployed';
        $application->save();
    }
    
    public function deployApplicant()
    {
        $this->validate();

        Deployment::create([
            'schedule_departure_date' => $this->schedule_departure_date,
            'status' => 'scheduled',
            'application_id' => $this->application_id,
            'employee_id' => Auth::user()->employee_id,
        ]);

        session()->flash('message', 'Applicant deployed successfully.');

        $this->resetInputFields();

        return redirect()->route('deploy-applicants');
    }

    public function rescheduleDeparture()
    {
        $this->validate();

        $deployment = Deployment::find($this->deployment_id);

        if ($deployment) {
            $deployment->update([
                'actual_departure_date' => $this->actual_departure_date,
                'schedule_departure_date' => $this->schedule_departure_date,
                'status' => 'rescheduled',
            ]);

            session()->flash('message', 'Departure rescheduled successfully.');

            $this->updateApplicationStatus();

            $this->resetInputFields();

            return redirect()->route('deploy-applicants');
        } else {
            session()->flash('error', 'Deployment not found.');
        }
    }

    private function resetInputFields()
    {
        $this->schedule_departure_date = null;
        $this->actual_departure_date = null;
        $this->application_id = null;
        $this->deployment_id = null;
    }

    public function render()
    {
        return view('livewire.content.deploy-applicant');
    }
}
