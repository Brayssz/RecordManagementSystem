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
use Illuminate\Validation\ValidationException;
use App\Services\TextractService;
use Illuminate\Support\Facades\Route;
use App\Models\Applicant;

class SubmitDocuments extends Component
{

    use WithFileUploads;

    public $photo;

    public $photo_upload;
    public $application_id;
    public $document_type;
    public $photoPreview;
    public $message;
    public $required = ['Birth Certificate', 'Passport', 'Medical Certificate', 'NBI Clearance', 'Valid ID'];
    public $error = [];

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
    public function getDocument()
    {
        $this->photoPreview = $this->getDocumentPhotoUrl();
    }

    public function saveDocumentPhoto()
    {
        $this->validate([
            'photo' => 'nullable|string',
            'photo_upload' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($this->photo_upload == null && $this->photo == null) {
            throw ValidationException::withMessages([
                'photo' => 'Please upload a photo or provide a valid photo.',
            ]);
        }

        if ($this->photo_upload != null) {
            
            if (in_array($this->document_type, ['Medical Certificate', 'NBI Clearance', 'Passport'])) {
                $this->validateDocuments($this->photo_upload);
            }

            $this->updateDocumentPhoto($this->photo_upload, $this->application_id, $this->document_type);
        }

        if ($this->photo != null) {
            $photo = $this->photo;
            $photo = str_replace('data:image/png;base64,', '', $photo);
            $photo = str_replace(' ', '+', $photo);
            $photo = base64_decode($photo);

            $tempFilePath = tempnam(sys_get_temp_dir(), 'photo');
            file_put_contents($tempFilePath, $photo);

            $uploadedFile = new UploadedFile($tempFilePath, 'photo.png', 'image/png', null, true);

            if (in_array($this->document_type, ['Medical Certificate', 'NBI Clearance', 'Passport'])) {
                $this->validateDocuments($uploadedFile);
            }

            $this->updateDocumentPhoto($uploadedFile, $this->application_id, $this->document_type);
        }
        // dd(url()->current());

        $this->js('window.location.reload()');
    }

    public function validateDocuments($photo)
    {
        $this->error = [];
        $application = Application::where('application_id', $this->application_id)->first();
        $applicant = Applicant::where('applicant_id', $application->applicant_id)->first();

        $textractService = new TextractService();
        $photoText = $textractService->extractText($photo->getRealPath());

        $normalizedPhotoText = strtolower(trim(preg_replace('/\s+/', ' ', $photoText)));

        // dd($normalizedPhotoText);

        if ($this->document_type == 'Medical Certificate') {
            $this->validateMedicalCertificate($normalizedPhotoText);
        }

        if ($this->document_type == 'NBI Clearance') {
            $this->validateNBIClearance($normalizedPhotoText);
        }

        if ($this->document_type == 'Passport') {
            $this->validatePassport($normalizedPhotoText);
        }

        $this->validateApplicantName($normalizedPhotoText, $applicant);
    }

    private function validatePassport($normalizedPhotoText)
    {
        $passportKeywords = [
            'passport', 'travel document', 'passport number', 'issued by', 'date of issue',
            'date of expiry', 'place of issue', 'holder\'s signature', 'nationality', 'passport type',
            'passport holder', 'passport details', 'passport information', 'passport id', 'passport document', 'pasaporte'
        ];

        $isPassport = false;
        foreach ($passportKeywords as $keyword) {
            if (stripos($normalizedPhotoText, $keyword) !== false) {
                $isPassport = true;
                break;
            }
        }

        if (!$isPassport) {
            $this->error['valid'] = true;
            $this->error['message'] = 'The uploaded document is not recognized as a passport.';
            throw ValidationException::withMessages([
                'photo' => 'The uploaded document is not recognized as a passport.',
            ]);
        }
    }

    private function validateNBIClearance($normalizedPhotoText)
    {
        $nbiKeywords = [
            'nbi clearance', 'national bureau of investigation', 'criminal record', 'no criminal record',
            'clearance certificate', 'nbi', 'investigation report', 'background check', 'no pending case',
            'certificate of clearance', 'nbi certificate', 'nbi report'
        ];

        $isNBI = false;
        foreach ($nbiKeywords as $keyword) {
            if (stripos($normalizedPhotoText, $keyword) !== false) {
                $isNBI = true;
                break;
            }
        }

        if (!$isNBI) {
            $this->error['valid'] = true;
            $this->error['message'] = 'The uploaded document is not recognized as an NBI clearance.';
            throw ValidationException::withMessages([
                'photo' => 'The uploaded document is not recognized as an NBI clearance.',
            ]);
        }
    }

    private function validateMedicalCertificate($normalizedPhotoText)
    {
        $medicalCertificateKeywords = [
            'medical certificate', 'fit to work', 'fit to study', 'fit for duty', 'medical clearance',
            'physician', 'doctor', 'clinic', 'hospital', 'health assessment', 'medical evaluation',
            'certified by', 'medical practitioner', 'health status', 'medical report', 'physical examination',
            'health check', 'medical fitness', 'certification of health', 'medical findings'
        ];

        $fitKeywords = [
            'fit for duty', 'physically fit', 'fit for work/school', 'no restrictions',
            'cleared for activity', 'medically cleared', 'healthy', 'no significant findings',
            'able to perform tasks', 'no medical issues', 'fit to work', 'fit to study',
            'good health', 'no health risks', 'no impairments', 'fully capable', 'no limitations',
            'fit for employment', 'fit for physical activities', 'fit for responsibilities'
        ];

        $isMedicalCertificate = false;
        foreach ($medicalCertificateKeywords as $keyword) {
            if (stripos($normalizedPhotoText, $keyword) !== false) {
                $isMedicalCertificate = true;
                break;
            }
        }

        if (!$isMedicalCertificate) {
            $this->error['valid'] = true;
            $this->error['message'] = 'The uploaded document is not recognized as a medical certificate.';
            throw ValidationException::withMessages([
                'photo' => 'The uploaded document is not recognized as a medical certificate.',
            ]);
        }

        $isFit = false;
        foreach ($fitKeywords as $keyword) {
            if (stripos($normalizedPhotoText, $keyword) !== false) {
                $isFit = true;
                break;
            }
        }

        if (!$isFit) {
            $this->error['type'] = 'medical';
            $this->error['message'] = 'The medical certificate does not indicate the applicant is physically fit.';
            throw ValidationException::withMessages([
                'photo' => 'The medical certificate does not indicate the applicant is physically fit.',
            ]);
        }
    }

    private function validateApplicantName($normalizedPhotoText, $applicant)
    {
        $expectedNameParts = array_filter([
            strtolower(trim($applicant->first_name)),
            strtolower(trim($applicant->middle_name)),
            strtolower(trim($applicant->last_name)),
        ]);

        foreach ($expectedNameParts as $namePart) {
            if (stripos($normalizedPhotoText, $namePart) === false) {
                $this->error['valid'] = true;
                $this->error['message'] = 'The name on the uploaded document does not match the applicant\'s name.';
                throw ValidationException::withMessages([
                    'photo' => 'The name on the uploaded document does not match the applicant\'s name.',
                ]);
            }
        }
    }

    public function rejectApplication() 
    {
        $application = Application::where('application_id', $this->application_id)->first();
        $application->status = "Rejected";
        $application->save();

        session()->flash('message', 'Application rejected successfully.');

        return redirect()->route('applicant-documents');
    }

    // public function validatePersonalIDDocs()
    // {
    //     $this->error = []; 

    //     $applicant = Auth::guard('applicant')->user();

    //     $textractService = new TextractService();

    //     $validIdText = $textractService->extractText($this->valid_id->getRealPath());
    //     $birthCertText = $textractService->extractText($this->birth_certificate->getRealPath());

    //     $normalizedValidIdText = strtolower(trim(preg_replace('/\s+/', ' ', $validIdText)));
    //     $normalizedBirthCertText = strtolower(trim(preg_replace('/\s+/', ' ', $birthCertText)));

    //     $idTypeKeywords = [
    //         'Passport' => ['passport', 'travel document', 'pasaporte'],
    //         'Driver\'s License' => ['driver\'s license', 'license', 'dl'],
    //         'SSS ID' => ['sss id', 'social security system'],
    //         'PhilHealth ID' => ['philhealth id', 'philhealth'],
    //         'Voter\'s ID' => ['voter\'s id', 'voter', 'comelec'],
    //         'National ID' => ['national id', 'philippine identification', 'phil id', 'pambansang pagkakakilanlan'],
    //     ];

    //     $birthCertKeywords = ['birth certificate', 'certificate of live birth', 'birth record'];

    //     $keywords = $idTypeKeywords[$this->valid_id_type] ?? [];

    //     $idTypeMatch = false;
    //     foreach ($keywords as $keyword) {
    //         if (stripos($normalizedValidIdText, $keyword) !== false) {
    //             $idTypeMatch = true;
    //             break;
    //         }
    //     }

    //     if (!$idTypeMatch) {
    //         $this->error['valid'] = true;
    //         $this->error['message'] = 'The uploaded valid ID does not match the specified ID type.';
    //         throw ValidationException::withMessages([
    //             'valid_id' => 'The uploaded valid ID does not match the specified ID type.',
    //         ]);
    //     }

    //     $birthCertMatch = false;
    //     foreach ($birthCertKeywords as $keyword) {
    //         if (stripos($normalizedBirthCertText, $keyword) !== false) {
    //             $birthCertMatch = true;
    //             break;
    //         }
    //     }

    //     if (!$birthCertMatch) {
    //         $this->error['valid'] = true;
    //         $this->error['message'] = 'The uploaded document is not recognized as a valid birth certificate.';
    //         throw ValidationException::withMessages([
    //             'birth_certificate' => 'The uploaded document is not recognized as a valid birth certificate.',
    //         ]);
    //     }

    //     $expectedNameParts = array_filter([
    //         strtolower(trim($applicant->first_name)),
    //         strtolower(trim($applicant->middle_name)),
    //         strtolower(trim($applicant->last_name)),
    //     ]);

    //     foreach ($expectedNameParts as $namePart) {
    //         if (stripos($normalizedValidIdText, $namePart) === false) {
    //             $this->error['valid'] = true;
    //             $this->error['message'] = 'The name on the valid ID does not match the applicant\'s name.';
    //             throw ValidationException::withMessages([
    //                 'valid_id' => 'The name on the valid ID does not match the applicant\'s name.',
    //             ]);
    //         }

    //         if (stripos($normalizedBirthCertText, $namePart) === false) {
    //             $this->error['valid'] = true;
    //             $this->error['message'] = 'The name on the birth certificate does not match the applicant\'s name.';
    //             throw ValidationException::withMessages([
    //                 'birth_certificate' => 'The name on the birth certificate does not match the applicant\'s name.',
    //             ]);
    //         }
    //     }
    // }

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
                'employee_id' => 1,
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
