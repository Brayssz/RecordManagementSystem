<?php

namespace App\Livewire\Content;

use App\Models\Applicant;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use App\Actions\Fortify\PasswordValidationRules;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class ApplicantManagement extends Component
{
    use WithFileUploads;

    public $submit_func;

    public $applicant;

    public $total_applicant;

    public $applicant_id, $first_name, $middle_name, $last_name, $suffix, $email, $contact_number, $date_of_birth, $gender, $status;
    public $region, $province, $municipality, $barangay, $street, $postal_code, $password, $password_confirmation;
    public $citizenship;

    public $photo;
    public $photoPreview;

    public function getApplicant($applicantId)
    {
        $this->applicant = Applicant::where('applicant_id', $applicantId)->first();

        if ($this->applicant) {
            $this->applicant_id = $this->applicant->applicant_id;
            $this->first_name = $this->applicant->first_name;
            $this->middle_name = $this->applicant->middle_name;
            $this->last_name = $this->applicant->last_name;
            $this->suffix = $this->applicant->suffix;
            $this->email = $this->applicant->email;
            $this->contact_number = $this->applicant->contact_number;
            $this->date_of_birth = $this->applicant->date_of_birth;
            $this->gender = $this->applicant->gender;
            $this->status = $this->applicant->status;
            $this->region = $this->applicant->region;
            $this->province = $this->applicant->province;
            $this->municipality = $this->applicant->municipality;
            $this->barangay = $this->applicant->barangay;
            $this->street = $this->applicant->street;
            $this->postal_code = $this->applicant->postal_code;
            $this->citizenship = $this->applicant->citizenship;
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
            'suffix' => 'nullable|string|max:10',
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
            'photo' => 'nullable|image|max:1024',
            'status' => 'nullable|string|max:255',
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

    public function resetFields() {
        $this->reset([
            'first_name', 'middle_name', 'last_name', 'suffix', 'email', 
            'contact_number', 'date_of_birth', 'gender',
            'region', 'province', 'municipality', 'barangay', 
            'street', 'postal_code', 'password', 'photo', 
            'status', 'photoPreview', 'applicant_id', 'citizenship'
        ]);
    }

    public function submit_applicant()
    {
        $this->validate();

        if ($this->submit_func == "add-applicant") {
            $applicant = Applicant::create([
                'first_name' => $this->first_name,
                'middle_name' => $this->middle_name,
                'last_name' => $this->last_name,
                'suffix' => $this->suffix,
                'email' => $this->email,
                'contact_number' => $this->contact_number,
                'date_of_birth' => $this->date_of_birth,
                'gender' => $this->gender,
                'region' => $this->region,
                'province' => $this->province,
                'municipality' => $this->municipality,
                'barangay' => $this->barangay,
                'status' => 'Active',
                'street' => $this->street,
                'postal_code' => $this->postal_code,
                'citizenship' => $this->citizenship,
                'password' => bcrypt($this->password), 
                'profile_photo_path' => $photoPath ?? null,
            ]);

            if ($this->photo) {
                $this->updateProfilePhoto($this->photo, $applicant);
            }

            session()->flash('message', 'Applicant successfully created.');

        } else if ($this->submit_func == "edit-applicant") {

            $this->applicant->first_name = $this->first_name;
            $this->applicant->middle_name = $this->middle_name;
            $this->applicant->last_name = $this->last_name;
            $this->applicant->suffix = $this->suffix;
            $this->applicant->email = $this->email;
            $this->applicant->contact_number = $this->contact_number;
            $this->applicant->date_of_birth = $this->date_of_birth;
            $this->applicant->gender = $this->gender;
            $this->applicant->status = $this->status;
            $this->applicant->region = $this->region;
            $this->applicant->province = $this->province;
            $this->applicant->municipality = $this->municipality;
            $this->applicant->barangay = $this->barangay;
            $this->applicant->street = $this->street;
            $this->applicant->postal_code = $this->postal_code;
            $this->applicant->citizenship = $this->citizenship;

            if (isset($this->password)) {
                $this->applicant->password = bcrypt($this->password);
            }

            $this->applicant->save();

            if (isset($this->photo)) {
                $this->updateProfilePhoto($this->photo, $this->applicant);
            }

            session()->flash('message', 'Applicant successfully updated.');
        }

        return redirect()->route('applicants');
    }

    public function render()
    {
        $this->getTotalApplicant();
        return view('livewire.content.applicant-management');
    }
}
