<?php

namespace App\Livewire\Content;

use Livewire\Component;
use App\Models\ApplicationForm;
use App\Models\DocumentsRequest;
use Illuminate\Support\Facades\Auth;

class SubmitDocumentRequest extends Component
{
    public function requestDocuments($applicationId)
    {
        $application = ApplicationForm::find($applicationId);

        if ($application) {
            $documentRequest = new DocumentsRequest();
            $documentRequest->request_by = Auth::guard('employee')->user()->employee_id;
            $documentRequest->requesting_branch = Auth::guard('employee')->user()->branch_id;
            $documentRequest->application_id = $application->application_id;
            $documentRequest->status = 'Pending';
            $documentRequest->save();

            session()->flash('message', 'Document request submitted successfully.');
        } else {
            session()->flash('error', 'Application not found.');
        }
        return redirect()->route('application-records');
    }
    public function render()
    {
        return view('livewire.content.submit-document-request');
    }
}
