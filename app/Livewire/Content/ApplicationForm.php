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

class ApplicationForm extends Component
{
    use WithFileUploads;

    public $applicant;
    public $total_applicant;

    public $applicant_id, $first_name, $middle_name, $last_name, $email, $contact_number, $date_of_birth, $gender, $status, $suffix;
    public $region, $province, $municipality, $barangay, $street, $postal_code, $citizenship, $password, $password_confirmation;
    public $marital_status; // Added marital_status attribute

    public $photo;
    public $photoPreview;

    public $branches;

    public $job_id;
    public $branch_id; // Added branch_id attribute
    public $schedule_id; // Added schedule_id attribute

    public $educational_attainments = [
        ['level' => 'Elementary', 'document' => ''],
        ['level' => 'Junior High School', 'document' => ''],
        ['level' => 'High School', 'document' => ''],
        ['level' => 'Higher', 'document' => '']
    ];

    public function addWorkExperience()
    {
        $this->work_experiences[] = ['document' => ''];
    }

    public function removeWorkExperience($index)
    {
        unset($this->work_experiences[$index]);
        $this->work_experiences = array_values($this->work_experiences);
    }

    public $work_experiences = [];

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
            $this->marital_status = $this->applicant->marital_status; // Retrieve marital_status
            $this->photoPreview = $this->getProfilePhotoUrl($this->applicant);

            $this->password = null;
            $this->password_confirmation = null;
        } else {
            session()->flash('error', 'Applicant not found.');
        }
    }

    public function getTotalApplicant()
    {
        $this->total_applicant = Applicant::count();
    }

    protected function rules()
    {
        $passwordRules = $this->applicant_id
            ? 'nullable|string|min:8|confirmed'
            : 'required|string|min:8|confirmed';
        $profilePhotoRules = $this->photoPreview ? 'nullable|image|max:1024' : 'required|image|max:1024';

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
            'schedule_id' => 'required|exists:branch_schedules,schedule_id', // Added validation rule for schedule_id
            'marital_status' => 'required|string|max:255', // Added validation rule for marital_status
            'educational_attainments.*.document' => 'nullable|image|max:1024',
            'work_experiences.*.document' => 'nullable|image|max:1024',
        ];
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

    public function deleteProfilePhoto($applicant)
    {
        if (is_null($applicant->profile_photo_path)) {
            return;
        }

        Storage::disk(config('filesystems.default', 'public'))->delete($applicant->profile_photo_path);

        $applicant->forceFill([
            'profile_photo_path' => null,
        ])->save();
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
            'branch_id', // Reset branch_id
            'schedule_id', // Reset schedule_id
            'marital_status' // Reset marital_status
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

    public function addEducationalAttainment($application_id)
    {
        foreach ($this->educational_attainments as $attainment) {
            if ($attainment['document']) {
                $this->updateDocumentPhoto($attainment['document'], $application_id, $attainment['level']);
            }
        }
    }

    public function getSchedules()
    {
        return BranchSchedule::where('available_slots', '>', 0)
            ->whereDate('interview_date', '>=', Carbon::now('Asia/Manila'))
            ->where('branch_id', $this->branch_id)
            ->get();
    }

    public function addWorkExperienceDocument($application_id)
    {
        $index = 0; // Initialize the index variable

        foreach ($this->work_experiences as $experience) {
            if ($experience['document']) {
                $this->updateDocumentPhoto($experience['document'], $application_id, 'Work Experience ' . $index);
            }
            $index++; // Increment the index variable
        }
    }

    public function updateDocumentPhoto(UploadedFile $photo, $application_id, $document_type, $storagePath = 'document-photos')
    {
        $documentDisk = env('VAPOR_ARTIFACT_NAME') ? 's3' : 'public';

        $fileName = 'document_' . $application_id . '_' . strtolower(str_replace(' ', '_', $document_type)) . '.' . $photo->getClientOriginalExtension();

        $document = Document::where('application_id', $application_id)
            ->where('document_type', $document_type)
            ->first();

        if ($document) {
            // Delete the old file from storage
            Storage::disk($documentDisk)->delete($document->file_name);
        }

        // Update or create the document record
        Document::updateOrCreate(
            [
                'application_id' => $application_id,
                'document_type' => $document_type,
            ],
            [
                'file_name' => $photo->storeAs($storagePath, $fileName, ['disk' => $documentDisk]),
                'upload_date' => now(),
                'status' => 'Active',
            ]
        );
    }

    public function checkExistingApplication() {
        
    }

    public function createApplication($applicant_id)
    {
        $application = new Application();
        $application->applicant_id = $applicant_id;
        $application->branch_id = $this->branch_id; // Set branch_id
        $application->schedule_id = $this->schedule_id; // Set schedule_id
        $application->job_id = $this->job_id;
        $application->application_date = now();
        $application->status = 'Pending';
        $application->save();

        $this->addEducationalAttainment($application->application_id);
        $this->addWorkExperienceDocument($application->application_id);

        $this->notifyEmployees($application);

        $this->decreaseScheduleSlot();

        session()->flash('message', 'Application successfully created.');

        return redirect()->route('job-offers');
    }

    public function decreaseScheduleSlot()
    {
        $branch_schedule = BranchSchedule::find($this->schedule_id);
        $branch_schedule->available_slots -= 1;
        $branch_schedule->save();
    }

    public function notifyEmployees($application) {
        $employees = Employee::where('branch_id', $application->branch_id)->get();

        foreach ($employees as $employee) {
            $employee->notify(new NewApplicationNotification($application->application_id));
        }
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
