<?php

namespace App\Livewire\Content;

use App\Models\Employer;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Http\UploadedFile;

class EmployerManagement extends Component
{
    use WithFileUploads;

    public $submit_func;

    public $employer;

    public $total_employer;

    public $employer_id, $first_name, $middle_name, $last_name, $suffix, $email, $contact_number, $gender, $status;
    public $industry, $company_name;

    public $photo;
    public $photoPreview;

    public function getEmployer($employerId)
    {
        $this->employer = Employer::where('employer_id', $employerId)->first();

        if ($this->employer) {
            $this->employer_id = $this->employer->employer_id;
            $this->first_name = $this->employer->first_name;
            $this->middle_name = $this->employer->middle_name;
            $this->last_name = $this->employer->last_name;
            $this->suffix = $this->employer->suffix;
            $this->email = $this->employer->email;
            $this->contact_number = $this->employer->contact_number;
            $this->gender = $this->employer->gender;
            $this->status = $this->employer->status;
            $this->industry = $this->employer->industry;
            $this->company_name = $this->employer->company_name;
            $this->photoPreview = $this->getProfilePhotoUrl($this->employer);

        } else {
            session()->flash('error', 'Employer not found.');
        }
    }

    public function getTotalEmployer()
    {
        $this->total_employer = Employer::count();
    }

    protected function rules()
    {
        return [
            'first_name' => 'required|string|max:255',
            'middle_name' => 'nullable|string|max:255',
            'last_name' => 'required|string|max:255',
            'suffix' => 'nullable|string|max:10',
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('employers', 'email')->ignore($this->employer_id, 'employer_id'),
                Rule::unique('applicants', 'email'),
                Rule::unique('employees', 'email'),
            ],
            'contact_number' => [
                'required',
                'string',
                'max:20',
                Rule::unique('employers', 'contact_number')->ignore($this->employer_id, 'employer_id'),
                Rule::unique('applicants', 'contact_number'),
                Rule::unique('employees', 'contact_number'),
            ],
            'gender' => 'required|in:Male,Female,Others',
            'industry' => 'required|string|max:255',
            'company_name' => 'required|string|max:255',
            'photo' => 'nullable|image|max:1024',
            'status' => 'nullable|string|max:255',
        ];
    }

    public function getProfilePhotoUrl(Employer $employer): string
    {
        $profilePhotoDisk = config('filesystems.default', 'public');

        return $employer->profile_photo_path
            ? Storage::disk($profilePhotoDisk)->url($employer->profile_photo_path)
            : "";
    }

    public function updateProfilePhoto(UploadedFile $photo, $employer, $storagePath = 'profile-photos')
    {
        $profilePhotoDisk = 'public';

        $fileName = 'profile_employer_' . $employer->employer_id . '_' . strtolower(str_replace(' ', '_', $employer->first_name)) . '.' . $photo->getClientOriginalExtension();

        tap($employer->profile_photo_path, function ($previous) use ($photo, $employer, $fileName, $profilePhotoDisk, $storagePath) {
            $employer->forceFill([
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

    public function deleteProfilePhoto($employer)
    {
        if (is_null($employer->profile_photo_path)) {
            return;
        }

        Storage::disk(config('filesystems.default', 'public'))->delete($employer->profile_photo_path);

        $employer->forceFill([
            'profile_photo_path' => null,
        ])->save();
    }

    public function resetFields() {
        $this->reset([
            'first_name', 'middle_name', 'last_name', 'suffix', 'email', 
            'contact_number', 'gender', 'industry', 'company_name', 
            'photo', 'status', 'photoPreview', 'employer_id'
        ]);
    }

    public function submit_employer()
    {
        $this->validate();

        if ($this->submit_func == "add-employer") {
            $employer = Employer::create([
                'first_name' => $this->first_name,
                'middle_name' => $this->middle_name,
                'last_name' => $this->last_name,
                'suffix' => $this->suffix,
                'email' => $this->email,
                'contact_number' => $this->contact_number,
                'gender' => $this->gender,
                'industry' => $this->industry,
                'company_name' => $this->company_name,
                'status' => 'Active',
                'profile_photo_path' => $photoPath ?? null,
            ]);

            if ($this->photo) {
                $this->updateProfilePhoto($this->photo, $employer);
            }

            session()->flash('message', 'Employer successfully created.');

        } else if ($this->submit_func == "edit-employer") {

            $this->employer->first_name = $this->first_name;
            $this->employer->middle_name = $this->middle_name;
            $this->employer->last_name = $this->last_name;
            $this->employer->suffix = $this->suffix;
            $this->employer->email = $this->email;
            $this->employer->contact_number = $this->contact_number;
            $this->employer->gender = $this->gender;
            $this->employer->status = $this->status;
            $this->employer->industry = $this->industry;
            $this->employer->company_name = $this->company_name;

            $this->employer->save();

            if (isset($this->photo)) {
                $this->updateProfilePhoto($this->photo, $this->employer);
            }

            session()->flash('message', 'Employer successfully updated.');
        }

        return redirect()->route('employers');
    }

    public function render()
    {
        $this->getTotalEmployer();
        return view('livewire.content.employer-management');
    }
}
