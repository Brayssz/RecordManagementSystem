<?php

namespace App\Livewire\Content;

use Livewire\Component;
use App\Models\ApplicationForm;
use App\Models\Applicant;
use Illuminate\Support\Facades\Storage;

class ViewApplication extends Component
{
    public $applicant_id, $first_name, $middle_name, $last_name, $suffix, $email, $contact_number, $date_of_birth, $gender, $status;
    public $region, $province, $municipality, $barangay, $street, $postal_code, $password, $password_confirmation;
    public $citizenship, $marital_status, $branch, $schedule;

    public $photo;
    public $photoPreview;

    public function getApplication($application_id) {
        $application = ApplicationForm::where('application_id', $application_id)->with('applicant', 'branch')->first();

        if ($application) {
            $this->applicant_id = $application->applicant->applicant_id;
            $this->first_name = $application->applicant->first_name;
            $this->middle_name = $application->applicant->middle_name;
            $this->last_name = $application->applicant->last_name;
            $this->suffix = $application->applicant->suffix;
            $this->email = $application->applicant->email;
            $this->contact_number = $application->applicant->contact_number;
            $this->date_of_birth = $application->applicant->date_of_birth;
            $this->gender = $application->applicant->gender;
            $this->marital_status = $application->applicant->marital_status;
            $this->region = $application->applicant->region;
            $this->province = $application->applicant->province;
            $this->municipality = $application->applicant->municipality;
            $this->barangay = $application->applicant->barangay;
            $this->street = $application->applicant->street;
            $this->postal_code = $application->applicant->postal_code;
            $this->citizenship = $application->applicant->citizenship;

            $this->branch = $application->branch->municipality;
            $this->photoPreview = $this->getProfilePhotoUrl($application->applicant);
        }
    }

    public function getProfilePhotoUrl(Applicant $applicant): string
    {
        $profilePhotoDisk = config('filesystems.default', 'public');

        return $applicant->profile_photo_path
            ? Storage::disk($profilePhotoDisk)->url($applicant->profile_photo_path)
            : "";
    }

    public function render()
    {
        return view('livewire.content.view-application');
    }
}
