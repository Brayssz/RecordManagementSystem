<?php

namespace App\Livewire\Content;

use App\Models\Employee;
use App\Models\Branch;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class EmployeeManagement extends Component
{
    use WithFileUploads;

    public $submit_func;

    public $employee;

    public $total_employee;

    public $employee_id, $first_name, $middle_name, $last_name, $suffix, $email, $username, $contact_number, $date_of_birth, $gender, $branch_id, $status, $position;
    public $region, $province, $municipality, $barangay, $street, $postal_code, $password, $password_confirmation;

    public $photo;
    public $photoPreview;

    public $branches;

    public function getEmployee($employeeId)
    {
        $this->employee = Employee::where('employee_id', $employeeId)->first();

        if ($this->employee) {
            $this->employee_id = $this->employee->employee_id;
            $this->first_name = $this->employee->first_name;
            $this->middle_name = $this->employee->middle_name;
            $this->last_name = $this->employee->last_name;
            $this->suffix = $this->employee->suffix;
            $this->email = $this->employee->email;
            $this->username = $this->employee->username;
            $this->contact_number = $this->employee->contact_number;
            $this->date_of_birth = $this->employee->date_of_birth;
            $this->gender = $this->employee->gender;
            $this->branch_id = $this->employee->branch_id;
            $this->status = $this->employee->status;
            $this->position = $this->employee->position;
            $this->region = $this->employee->region;
            $this->province = $this->employee->province;
            $this->municipality = $this->employee->municipality;
            $this->barangay = $this->employee->barangay;
            $this->street = $this->employee->street;
            $this->postal_code = $this->employee->postal_code;
            $this->photoPreview = $this->getProfilePhotoUrl($this->employee);

            $this->password = null;
            $this->password_confirmation = null;
        } else {
            session()->flash('error', 'Employee not found.');
        }
    }

    public function getTotalEmployee()
    {
        $this->total_employee = Employee::where('employee_id', '!=', Auth::user()->employee_id)->count();
    }

    protected function rules()
    {
        $passwordRules = $this->employee_id
            ? 'nullable|string|min:8|confirmed'
            : 'required|string|min:8|confirmed';

        return [
            'first_name' => 'required|string|max:255',
            'middle_name' => 'nullable|string|max:255',
            'last_name' => 'required|string|max:255',
            'suffix' => 'nullable|string|max:10',
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('employees', 'email')->ignore($this->employee_id, 'employee_id'),
                Rule::unique('applicants', 'email'),
                Rule::unique('employers', 'email'),
            ],
            'username' => [
                'required',
                'string',
                'max:255',
                Rule::unique('employees', 'username')->ignore($this->employee_id, 'employee_id'),
                Rule::unique('employers', 'username'),
            ],
            'contact_number' => [
                'required',
                'string',
                'max:20',
                Rule::unique('employees', 'contact_number')->ignore($this->employee_id, 'employee_id'),
                Rule::unique('applicants', 'contact_number'),
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
            'password' => $passwordRules,
            'photo' => 'nullable|image|max:1024',
            'branch_id' => [
                'required',
                'integer',
                Rule::exists('branches', 'branch_id'),
            ],
            'status' => 'nullable|string|max:255',
            'position' => 'nullable|string|max:255',
        ];
    }

    public function getBranches()
    {
        $this->branches = Branch::where('status', 'Active')->get();
    }

    public function getAllBranches()
    {
        return Branch::where('status', 'Active')->get();
    }

    public function render()
    {
        $this->getBranches();
        $this->getTotalEmployee();

        return view('livewire.content.employee-management', ['branches' => $this->branches]);
    }

    public function getProfilePhotoUrl(Employee $employee): string
    {
        $profilePhotoDisk = config('filesystems.default', 'public');

        return $employee->profile_photo_path
            ? Storage::disk($profilePhotoDisk)->url($employee->profile_photo_path)
            : "";
    }

    public function updateProfilePhoto(UploadedFile $photo, $employee, $storagePath = 'profile-photos')
    {
        $profilePhotoDisk = 'public';

        $fileName = 'profile_' . $employee->employee_id . '_' . strtolower(str_replace(' ', '_', $employee->first_name)) . '.' . $photo->getClientOriginalExtension();

        tap($employee->profile_photo, function ($previous) use ($photo, $employee, $fileName, $profilePhotoDisk, $storagePath) {
            $employee->forceFill([
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

    public function deleteProfilePhoto($employee)
    {
        if (is_null($employee->profile_photo)) {
            return;
        }

        Storage::disk(config('filesystems.default', 'public'))->delete($employee->profile_photo);

        $employee->forceFill([
            'profile_photo' => null,
        ])->save();
    }

    public function resetFields()
    {
        $this->reset([
            'first_name', 'middle_name', 'last_name', 'suffix', 'email',
            'username', 'contact_number', 'date_of_birth', 'gender',
            'region', 'province', 'municipality', 'barangay',
            'street', 'postal_code', 'password', 'photo',
            'branch_id', 'position', 'status', 'photoPreview'
        ]);
    }

    public function submit_employee()
    {
        if (Auth::user()->position == 'Manager') {
            $this->branch_id = Auth::user()->branch_id;
        }

        $this->validate();

        if ($this->submit_func == "add-employee") {
            $employee = Employee::create([
                'first_name' => $this->first_name,
                'middle_name' => $this->middle_name,
                'last_name' => $this->last_name,
                'suffix' => $this->suffix,
                'email' => $this->email,
                'username' => $this->username,
                'contact_number' => $this->contact_number,
                'date_of_birth' => $this->date_of_birth,
                'gender' => $this->gender,
                'region' => $this->region,
                'province' => $this->province,
                'municipality' => $this->municipality,
                'barangay' => $this->barangay,
                'street' => $this->street,
                'postal_code' => $this->postal_code,
                'password' => bcrypt($this->password),
                'status' => "Active",
                'profile_photo' => $photoPath ?? null,
                'branch_id' => $this->branch_id,
                'position' => $this->position,
            ]);

            if ($this->photo) {
                $this->updateProfilePhoto($this->photo, $employee);
            }

            session()->flash('message', 'Employee successfully created.');

        } else if ($this->submit_func == "edit-employee") {
            $this->employee->first_name = $this->first_name;
            $this->employee->middle_name = $this->middle_name;
            $this->employee->last_name = $this->last_name;
            $this->employee->suffix = $this->suffix;
            $this->employee->email = $this->email;
            $this->employee->username = $this->username;
            $this->employee->contact_number = $this->contact_number;
            $this->employee->date_of_birth = $this->date_of_birth;
            $this->employee->gender = $this->gender;
            $this->employee->branch_id = $this->branch_id;
            $this->employee->status = $this->status;
            $this->employee->position = $this->position;
            $this->employee->region = $this->region;
            $this->employee->province = $this->province;
            $this->employee->municipality = $this->municipality;
            $this->employee->barangay = $this->barangay;
            $this->employee->street = $this->street;
            $this->employee->postal_code = $this->postal_code;

            if (isset($this->password)) {
                $this->employee->password = $this->password;
            }

            $this->employee->save();

            if (isset($this->photo)) {
                $this->updateProfilePhoto($this->photo, $this->employee);
            }

            session()->flash('message', 'Employee successfully updated.');
        }

        return redirect()->route('employees');
    }
}
