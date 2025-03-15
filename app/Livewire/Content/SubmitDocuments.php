<?php

namespace App\Livewire\Content;

use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use App\Models\Document;
use App\Models\ApplicationForm as Application;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class SubmitDocuments extends Component
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

    public function submitApplication($applicationId)
    {
        $application = Application::find($applicationId);
        $application->status = "Reviewing";
        $application->save();

        session()->flash('message', 'Documents submitted successfully.');

        return redirect()->route('applicant-documents');
    }

    public function isDocumentsComplete($application_id)
    {
        $this->message = 'Please upload the following documents:';

        $documents = Application::find($application_id)
            ->documents()
            ->whereIn('document_type', $this->required)
            ->pluck('document_type')
            ->toArray();

        $missingDocuments = array_diff($this->required, $documents);

        if (count($missingDocuments) > 0) {
            $this->message .= ' ' . implode(', ', $missingDocuments);

            return false;
        }

        return true;
    }
    public function getDocument() {
        $this->photoPreview = $this->getDocumentPhotoUrl();
    }

    public function saveDocumentPhoto()
    {
        // dd($this->photo);
        $this->validate([
            'photo' => 'required|string',
        ]);
        
        $photo = $this->photo;
        $photo = str_replace('data:image/png;base64,', '', $photo);
        $photo = str_replace(' ', '+', $photo);
        $photo = base64_decode($photo);

        $tempFilePath = tempnam(sys_get_temp_dir(), 'photo');
        file_put_contents($tempFilePath, $photo);

        $uploadedFile = new UploadedFile($tempFilePath, 'photo.png', 'image/png', null, true);

        $this->updateDocumentPhoto($uploadedFile, $this->application_id, $this->document_type);

        return redirect()->route('applicant-documents');
    }

    public function updateDocumentPhoto(UploadedFile $photo, $application_id, $document_type, $storagePath = 'document-photos')
    {
        $documentDisk = env('VAPOR_ARTIFACT_NAME') ? 's3' : 'public';

        $fileName = 'document_' . $application_id . '_' . strtolower(str_replace(' ', '_', $document_type)) . '.' . $photo->getClientOriginalExtension();

        $document = Document::where('application_id', $application_id)
            ->where('document_type', $document_type)
            ->first();

        if ($document) {
            Storage::disk($documentDisk)->delete($document->file_name);
        }

        Document::updateOrCreate(
            [
                'application_id' => $application_id,
                'document_type' => $document_type,
            ],
            [
                'file_name' => $photo->storeAs($storagePath, $fileName, ['disk' => $documentDisk]),
                'employee_id' => Auth::guard("employee")->user()->employee_id,
                'upload_date' => now(),
                'status' => 'Updated',
            ]
        );
    }

    public function render()
    {
        return view('livewire.content.submit-documents');
    }
}
