<?php

namespace App\Livewire\Content;

use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use App\Models\Document;
use App\Models\ApplicationForm as Application;
use Illuminate\Support\Facades\Auth;

class ViewDocuments extends Component
{

    use WithFileUploads;

    public $photo;
    public $application_id;
    public $document_type;
    public $photoPreview;
    public $message;
    public $required = ['Birth Certificate', 'Passport', 'Medical Certificate', 'NBI Clearance', 'Valid ID'];

    public function getDocumentPhotoUrl()
    {
        $document = Document::where('application_id', $this->application_id)
            ->where('document_type', $this->document_type)
            ->first();

        if (!$document) {
            return "";
        }

        $documentDisk = env('VAPOR_ARTIFACT_NAME') ? 's3' : config('filesystems.default', 'public');

        return Storage::disk($documentDisk)->url($document->file_name);
    }

    public function getDocument() {
        $this->photoPreview = $this->getDocumentPhotoUrl();
    }

    public function render()
    {
        return view('livewire.content.view-documents');
    }
}
