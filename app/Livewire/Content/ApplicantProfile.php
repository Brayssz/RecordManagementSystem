<?php

namespace App\Livewire\Content;

use Livewire\Component;
use App\Models\Applicant;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;
use Livewire\WithFileUploads;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Hash;

class ApplicantProfile extends Component
{
    use WithFileUploads;

    public $applicant;
    public $applicant_id, $first_name, $middle_name, $last_name, $email, $contact_number, $date_of_birth, $gender, $region, $province, $municipality, $barangay, $street, $postal_code, $citizenship, $status, $suffix, $marital_status, $password, $password_confirmation;

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
            $this->email = $this->applicant->email;
            $this->contact_number = $this->applicant->contact_number;
            $this->date_of_birth = $this->applicant->date_of_birth;
            $this->gender = $this->applicant->gender;
            $this->region = $this->applicant->region;
            $this->province = $this->applicant->province;
            $this->municipality = $this->applicant->municipality;
            $this->barangay = $this->applicant->barangay;
            $this->street = $this->applicant->street;
            $this->postal_code = $this->applicant->postal_code;
            $this->citizenship = $this->applicant->citizenship;
            $this->status = $this->applicant->status;
            $this->suffix = $this->applicant->suffix;
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

        return [
            'first_name' => 'required|string|max:255',
            'middle_name' => 'nullable|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('applicants')->ignore($this->applicant_id),
            ],
            'contact_number' => 'required|string|max:20|unique:applicants,contact_number,' . $this->applicant_id,
            'date_of_birth' => 'required|date|before:today',
            'gender' => 'required|in:Male,Female,Others',
            'region' => 'required|string|max:255',
            'province' => 'required|string|max:255',
            'municipality' => 'required|string|max:255',
            'barangay' => 'required|string|max:255',
            'street' => 'required|string|max:255',
            'postal_code' => 'required|string|max:10',
            'citizenship' => 'required|string|max:255',
            'suffix' => 'nullable|string|max:255',
            'marital_status' => 'required|string|max:255',
            'password' => $passwordRules,
            'photo' => 'nullable|image|max:1024',
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

        $fileName = 'profile_' . $applicant->applicant_id . '_' . strtolower(str_replace(' ', '_', $applicant->first_name)) . '.' . $photo->getClientOriginalExtension();

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
            'first_name', 'middle_name', 'last_name', 'email',
            'contact_number', 'date_of_birth', 'gender',
            'region', 'province', 'municipality', 'barangay',
            'street', 'postal_code', 'citizenship', 'suffix',
            'marital_status', 'password', 'photo', 'status', 'photoPreview'
        ]);
    }

    public function saveProfile()
    {
        $this->applicant->first_name = $this->first_name;
        $this->applicant->middle_name = $this->middle_name;
        $this->applicant->last_name = $this->last_name;
        $this->applicant->email = $this->email;
        $this->applicant->contact_number = $this->contact_number;
        $this->applicant->date_of_birth = $this->date_of_birth;
        $this->applicant->gender = $this->gender;
        $this->applicant->region = $this->region;
        $this->applicant->province = $this->province;
        $this->applicant->municipality = $this->municipality;
        $this->applicant->barangay = $this->barangay;
        $this->applicant->street = $this->street;
        $this->applicant->postal_code = $this->postal_code;
        $this->applicant->citizenship = $this->citizenship;
        $this->applicant->suffix = $this->suffix;
        $this->applicant->marital_status = $this->marital_status;
        $this->applicant->status = $this->status;

        if (isset($this->password)) {
            $this->applicant->password = Hash::make($this->password);
        }

        $this->applicant->save();

        if (isset($this->photo)) {
            $this->updateProfilePhoto($this->photo, $this->applicant);
        }

        session()->flash('message', 'Applicant successfully updated.');

        return redirect()->route('profile');
    }

    public function mount()
    {
        $this->getApplicant(Auth::guard('applicant')->user()->applicant_id);
    }

    public function render()
    {
        return view('livewire.content.applicant-profile');
    }
}
