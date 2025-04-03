<?php

namespace App\Livewire\Content;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Applicant;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use App\Models\Branch;
use App\Models\ApplicationForm as Application;
use App\Models\BranchSchedule;
use App\Models\Content;
use App\Models\Document;
use App\Models\Employee;
use App\Notifications\NewApplicationNotification;
use Carbon\Carbon;
use App\Models\JobOffer;
use App\Services\TextractService;
use Illuminate\Validation\ValidationException;
use App\Models\BranchInterview;

class ApplicationForm extends Component
{
    use WithFileUploads;

    public $applicant;
    public $total_applicant;

    public $applicant_id, $first_name, $middle_name, $last_name, $email, $contact_number, $date_of_birth, $gender, $status, $suffix;
    public $region, $province, $municipality, $barangay, $street, $postal_code, $citizenship, $password, $password_confirmation, $start_time;
    public $marital_status;

    public $photo;
    public $photoPreview;

    public $branches;

    public $job_id;
    public $branch_id;
    public $schedule_id;

    public $valid_id;
    public $valid_id_type;

    public $birth_certificate;

    public $error = [];

    public $progress = 0;

    public function getBranches()
    {
        $this->branches = Branch::where('status', 'Active')->get();
    }

    public function getApplicant($applicantId)
    {
        $this->applicant = Applicant::where('applicant_id', $applicantId)->first();

        if ($this->applicant) {
            $this->applicant_id = $this->applicant->applicant_id;
            $this->first_name = $this->applicant->first_name;
            $this->middle_name = $this->applicant->middle_name;
            $this->last_name = $this->applicant->last_name;
            $this->email = $this->applicant->email;
            $this->contact_number = $this->applicant->contact_number;
            $this->date_of_birth = $this->applicant->date_of_birth;
            $this->gender = $this->applicant->gender;
            $this->status = $this->applicant->status;
            $this->suffix = $this->applicant->suffix;
            $this->region = $this->applicant->region;
            $this->province = $this->applicant->province;
            $this->municipality = $this->applicant->municipality;
            $this->barangay = $this->applicant->barangay;
            $this->street = $this->applicant->street;
            $this->postal_code = $this->applicant->postal_code;
            $this->citizenship = $this->applicant->citizenship;
            $this->marital_status = $this->applicant->marital_status;
            $this->photoPreview = $this->getProfilePhotoUrl($this->applicant);

            $this->password = null;
            $this->password_confirmation = null;
        } else {
            session()->flash('error', 'Applicant not found.');
        }
    }

    protected function rules()
    {
        $passwordRules = $this->applicant_id
            ? 'nullable|string|min:8|confirmed'
            : 'required|string|min:8|confirmed';
        $profilePhotoRules = $this->photoPreview ? 'nullable|image|max:2048' : 'required|image|max:2048';

        return [
            'first_name' => 'required|string|max:255',
            'middle_name' => 'nullable|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('applicants', 'email')->ignore($this->applicant_id, 'applicant_id'),
                Rule::unique('employees', 'email'),
                Rule::unique('employers', 'email'),
            ],
            'contact_number' => [
                'required',
                'string',
                'max:20',
                Rule::unique('applicants', 'contact_number')->ignore($this->applicant_id, 'applicant_id'),
                Rule::unique('employees', 'contact_number'),
                Rule::unique('employers', 'contact_number'),
            ],
            'date_of_birth' => 'required|date|before:today',
            'gender' => 'required|in:Male,Female,Others',
            'region' => 'required|string|max:255',
            'province' => 'required|string|max:255',
            'municipality' => 'required|string|max:255',
            'barangay' => 'required|string|max:255',
            'street' => 'required|string|max:255',
            'postal_code' => 'required|string|max:10',
            'citizenship' => 'required|string|max:255',
            'password' => $passwordRules,
            'photo' => $profilePhotoRules,
            'status' => 'nullable|string|max:255',
            'suffix' => 'nullable|string|max:255',
            'branch_id' => 'required|exists:branches,branch_id',
            'schedule_id' => 'required|exists:branch_schedules,schedule_id',
            'marital_status' => 'required|string|max:255',
            'valid_id' => 'required|image|max:2048', 
            'valid_id_type' => 'required|string|max:255', 
            'birth_certificate' => 'required|image|max:2048', 
            'start_time' => 'required|date_format:H:i',
        ];
    }

    public function validatePersonalIDDocs()
    {
        $this->error = []; 

        $applicant = Auth::guard('applicant')->user();

        $textractService = new TextractService();

        $validIdText = $textractService->extractText($this->valid_id->getRealPath());
        $birthCertText = $textractService->extractText($this->birth_certificate->getRealPath());

        $normalizedValidIdText = strtolower(trim(preg_replace('/\s+/', ' ', $validIdText)));
        $normalizedBirthCertText = strtolower(trim(preg_replace('/\s+/', ' ', $birthCertText)));

        $idTypeKeywords = [
            'Passport' => ['passport', 'travel document', 'pasaporte'],
            'Driver\'s License' => ['driver\'s license', 'license', 'dl'],
            'SSS ID' => ['sss id', 'social security system'],
            'PhilHealth ID' => ['philhealth id', 'philhealth'],
            'Voter\'s ID' => ['voter\'s id', 'voter', 'comelec'],
            'National ID' => ['national id', 'philippine identification', 'phil id', 'pambansang pagkakakilanlan'],
        ];

        $birthCertKeywords = ['birth certificate', 'certificate of live birth', 'birth record'];

        $keywords = $idTypeKeywords[$this->valid_id_type] ?? [];

        $idTypeMatch = false;
        foreach ($keywords as $keyword) {
            if (stripos($normalizedValidIdText, $keyword) !== false) {
                $idTypeMatch = true;
                break;
            }
        }

        if (!$idTypeMatch) {
            $this->error['valid'] = true;
            $this->error['message'] = 'The uploaded valid ID does not match the specified ID type.';
            throw ValidationException::withMessages([
                'valid_id' => 'The uploaded valid ID does not match the specified ID type.',
            ]);
        }

        $birthCertMatch = false;
        foreach ($birthCertKeywords as $keyword) {
            if (stripos($normalizedBirthCertText, $keyword) !== false) {
                $birthCertMatch = true;
                break;
            }
        }

        if (!$birthCertMatch) {
            $this->error['valid'] = true;
            $this->error['message'] = 'The uploaded document is not recognized as a valid birth certificate.';
            throw ValidationException::withMessages([
                'birth_certificate' => 'The uploaded document is not recognized as a valid birth certificate.',
            ]);
        }

        $expectedNameParts = array_filter([
            strtolower(trim($applicant->first_name)),
            strtolower(trim($applicant->middle_name)),
            strtolower(trim($applicant->last_name)),
        ]);

        foreach ($expectedNameParts as $namePart) {
            if (stripos($normalizedValidIdText, $namePart) === false) {
                $this->error['valid'] = true;
                $this->error['message'] = 'The name on the valid ID does not match the applicant\'s name.';
                throw ValidationException::withMessages([
                    'valid_id' => 'The name on the valid ID does not match the applicant\'s name.',
                ]);
            }

            if (stripos($normalizedBirthCertText, $namePart) === false) {
                $this->error['valid'] = true;
                $this->error['message'] = 'The name on the birth certificate does not match the applicant\'s name.';
                throw ValidationException::withMessages([
                    'birth_certificate' => 'The name on the birth certificate does not match the applicant\'s name.',
                ]);
            }
        }
    }


    public function updateBirthCertificate(UploadedFile $photo, $application_id, $storagePath = 'birth-certificates')
    {
        $documentDisk = env('VAPOR_ARTIFACT_NAME') ? 's3' : 'public';

        $fileName = 'birth_certificate_' . $application_id . '.' . $photo->getClientOriginalExtension();

        $document = Document::where('application_id', $application_id)
            ->where('document_type', 'Birth Certificate')
            ->first();

        if ($document) {
            Storage::disk($documentDisk)->delete($document->file_name);
        }

        Document::updateOrCreate(
            [
                'application_id' => $application_id,
                'document_type' => 'Birth Certificate',
            ],
            [
                'file_name' => $photo->storeAs($storagePath, $fileName, ['disk' => $documentDisk]),
                'upload_date' => now(),
                'status' => 'Active',
            ]
        );
    }

    public function updateValidId(UploadedFile $photo, $application_id, $valid_id_type, $storagePath = 'valid-ids')
    {
        $documentDisk = env('VAPOR_ARTIFACT_NAME') ? 's3' : 'public';

        $fileName = 'valid_id_' . $application_id . '_' . strtolower(str_replace(' ', '_', $valid_id_type)) . '.' . $photo->getClientOriginalExtension();

        $document = Document::where('application_id', $application_id)
            ->where('document_type', 'Valid ID')
            ->first();

        if ($document) {
            Storage::disk($documentDisk)->delete($document->file_name);
        }

        Document::updateOrCreate(
            [
                'application_id' => $application_id,
                'document_type' => 'Valid ID',
            ],
            [
                'file_name' => $photo->storeAs($storagePath, $fileName, ['disk' => $documentDisk]),
                'upload_date' => now(),
                'status' => 'Active',
            ]
        );
    }


    public function createApplication($applicant_id)
    {
        $this->validatePersonalIDDocs();

        $application = new Application();
        $application->applicant_id = $applicant_id;
        $application->branch_id = $this->branch_id;
        $application->schedule_id = $this->schedule_id;
        $application->job_id = $this->job_id;
        $application->application_date = now();
        $application->status = 'Pending';
        $application->save();

        if ($this->valid_id) {
            $this->updateValidId($this->valid_id, $application->application_id, $this->valid_id_type);
        }

        if ($this->birth_certificate) {
            $this->updateBirthCertificate($this->birth_certificate, $application->application_id);
        }

        $this->notifyEmployees($application);
 
        $this->decreaseJobOfferSlot();

        $this->createBranchInterview($application->application_id);

        session()->flash('message', 'Application successfully created.');

        return redirect()->route('job-offers');
    }


    public function decreaseJobOfferSlot()
    {
        $jobOffer = JobOffer::find($this->job_id);
        $jobOffer->available_slots -= 1;
        $jobOffer->save();
    }

    public function getAvailableTimes($schedule_id)
    {
        $schedule = BranchSchedule::find($schedule_id);

        if (!$schedule) {
            throw ValidationException::withMessages([
                'schedule_id' => 'The selected schedule does not exist.',
            ]);
        }

        $availableTimes = [];
        $startTime = Carbon::parse($schedule->available_start_time);
        $endTime = Carbon::parse($schedule->available_end_time);

        while ($startTime->copy()->addMinutes(90)->lte($endTime)) {
            // Skip 12:00 PM to 1:00 PM
            if ($startTime->format('H:i') === '12:00' || $startTime->format('H:i') === '12:30') {
                $startTime->addMinutes(90);
                continue;
            }

            $conflict = BranchInterview::whereHas('application', function ($query) use ($schedule_id) {
                $query->where('schedule_id', $schedule_id);
            })
            ->where(function ($query) use ($startTime) {
                $query->whereBetween('start_time', [$startTime, $startTime->copy()->addMinutes(90)])
                    ->orWhereBetween('end_time', [$startTime, $startTime->copy()->addMinutes(90)])
                    ->orWhere(function ($query) use ($startTime) {
                        $query->where('start_time', '<=', $startTime)
                            ->where('end_time', '>=', $startTime->copy()->addMinutes(90));
                    });
            })
            ->exists();

            if (!$conflict) {
                $availableTimes[] = $startTime->format('H:i');
            }

            $startTime->addMinutes(90);
        }

        return $availableTimes;
    }

    public function createBranchInterview($application_id) {
        $startTime = Carbon::createFromFormat('H:i', $this->start_time);

        BranchInterview::create([
            'application_id' => $application_id,
            'start_time' => $startTime,
            'end_time' => $startTime->copy()->addMinutes(90),
            'status' => "Pending",
        ]);
    }

    public function getProfilePhotoUrl(Applicant $applicant): string
    {
        $profilePhotoDisk = config('filesystems.default', 'public');

        return $applicant->profile_photo_path
            ? Storage::disk($profilePhotoDisk)->url($applicant->profile_photo_path)
            : "";
    }

    public function updateProfilePhoto(UploadedFile $photo, $applicant, $storagePath = 'profile-photos')
    {
        $profilePhotoDisk = 'public';

        $fileName = 'profile_applicant_' . $applicant->applicant_id . '_' . strtolower(str_replace(' ', '_', $applicant->first_name)) . '.' . $photo->getClientOriginalExtension();

        tap($applicant->profile_photo_path, function ($previous) use ($photo, $applicant, $fileName, $profilePhotoDisk, $storagePath) {
            $applicant->forceFill([
                'profile_photo_path' => $photo->storeAs(
                    $storagePath,
                    $fileName,
                    ['disk' => $profilePhotoDisk]
                ),
            ])->save();

            if ($previous) {
                Storage::disk($profilePhotoDisk)->delete($previous);
            }
        });
    }

    public function resetFields()
    {
        $this->reset([
            'first_name',
            'middle_name',
            'last_name',
            'email',
            'contact_number',
            'date_of_birth',
            'gender',
            'region',
            'province',
            'municipality',
            'barangay',
            'street',
            'postal_code',
            'password',
            'photo',
            'status',
            'suffix',
            'citizenship',
            'photoPreview',
            'branch_id',
            'schedule_id',
            'marital_status',
            'valid_id',
            'valid_id_type',
            'birth_certificate',
            'start_time',
        ]);
    }

    public function submit_application()
    {
        $this->validate();

        $this->applicant->first_name = $this->first_name;
        $this->applicant->middle_name = $this->middle_name;
        $this->applicant->last_name = $this->last_name;
        $this->applicant->email = $this->email;
        $this->applicant->contact_number = $this->contact_number;
        $this->applicant->date_of_birth = $this->date_of_birth;
        $this->applicant->gender = $this->gender;
        $this->applicant->status = $this->status;
        $this->applicant->suffix = $this->suffix;
        $this->applicant->region = $this->region;
        $this->applicant->province = $this->province;
        $this->applicant->municipality = $this->municipality;
        $this->applicant->barangay = $this->barangay;
        $this->applicant->street = $this->street;
        $this->applicant->postal_code = $this->postal_code;
        $this->applicant->citizenship = $this->citizenship;
        $this->applicant->marital_status = $this->marital_status; // Save marital_status

        $this->applicant->save();

        if (isset($this->photo)) {
            $this->updateProfilePhoto($this->photo, $this->applicant);
        }


        $this->createApplication($this->applicant->applicant_id);
    }

    public function notifyEmployees($application)
    {
        $employees = Employee::where('branch_id', $application->branch_id)->get();

        foreach ($employees as $employee) {
            $employee->notify(new NewApplicationNotification($application->application_id));
        }
    }
    public function getSchedules()
    {
        return BranchSchedule::whereDate('interview_date', '>=', Carbon::now('Asia/Manila'))
            ->where('branch_id', $this->branch_id)
            ->get()
            ->filter(function ($schedule) {
                return !empty($this->getAvailableTimes($schedule->schedule_id));
            });
    }

    public function mount($job_id)
    {
        $this->job_id = $job_id;

        $this->getApplicant(Auth::guard('applicant')->user()->applicant_id);
        $this->getBranches();
    }

    public function render()
    {
        return view('livewire.content.application-form');
    }
}
