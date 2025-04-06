<?php

namespace App\Livewire\Content;

use Livewire\Component;
use App\Models\DocumentsRequest;
use Illuminate\Support\Facades\Auth;

class ApproveDocumentRequest extends Component
{
    public function approveRequest($requestId)
    {
        $documentRequest = DocumentsRequest::find($requestId);

        if ($documentRequest) {
            $documentRequest->approved_by = Auth::guard('employee')->user()->employee_id;
            $documentRequest->status = 'Approved';
            $documentRequest->save();

            session()->flash('message', 'Document request approved successfully.');
        } else {
            session()->flash('error', 'Document request not found.');
        }

        return redirect()->route('document-requests');
    }

    public function render()
    {
        return view('livewire.content.approve-document-request');
    }
}
