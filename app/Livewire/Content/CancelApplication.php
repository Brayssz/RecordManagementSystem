<?php

namespace App\Livewire\Content;

use Livewire\Component;
use App\Models\ApplicationForm;

class CancelApplication extends Component
{
    public $application_id;

    public function checkApplicationStatus()
    {
        return ApplicationForm::where("application_id", $this->application_id)
            ->where("status", '!=', 'Pending')
            ->exists();
    }

    public function cancelApplication()
    {
        $application = ApplicationForm::findOrFail($this->application_id);
        $application->update([
            'status' => 'Cancelled'
        ]);
        
        session()->flash('message','Application Cancelled Successfully!');

        return redirect()->route('my-applications');
    }

    public function render()
    {
        return view('livewire.content.cancel-application');
    }
}
