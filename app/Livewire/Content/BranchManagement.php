<?php

namespace App\Livewire\Content;

use App\Models\Branch;
use Livewire\Component;
use Illuminate\Validation\Rule;

class BranchManagement extends Component
{
    public $submit_func;
    public $branch;
    public $total_branch;
    public $branch_id, $email, $contact_number, $status;
    public $region, $province, $municipality, $barangay, $street, $postal_code;

    public function render()
    {
        $this->getTotalBranch();
        return view('livewire.content.branch-management');
    }

    protected function rules()
    {
        $statusRules = $this->submit_func == "edit-branch"
            ? 'required|string|max:255'
            : 'nullable|string|max:255';

        return [
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('branches', 'email')->ignore($this->branch_id, 'branch_id'),
            ],
            'contact_number' => [
                'required',
                'string',
                'max:20',
                Rule::unique('branches', 'contact_number')->ignore($this->branch_id, 'branch_id'),
            ],
            'region' => 'required|string|max:255',
            'province' => 'required|string|max:255',
            'municipality' => 'required|string|max:255',
            'barangay' => 'required|string|max:255',
            'street' => 'required|string|max:255',
            'postal_code' => 'required|string|max:10',
            'status' => $statusRules,
        ];
    }

    public function getTotalBranch()
    {
        $this->total_branch = Branch::count();
    }

    public function resetFields()
    {
        $this->reset([
            'email',
            'contact_number',
            'region',
            'province',
            'municipality',
            'barangay',
            'street',
            'postal_code',
            'status'
        ]);
    }

    public function getBranch($branchID)
    {
        $this->branch = Branch::where('branch_id', $branchID)->first();

        $this->branch_id = $this->branch->branch_id;
        $this->email = $this->branch->email;
        $this->contact_number = $this->branch->contact_number;
        $this->status = $this->branch->status;
        $this->region = $this->branch->region;
        $this->province = $this->branch->province;
        $this->municipality = $this->branch->municipality;
        $this->barangay = $this->branch->barangay;
        $this->street = $this->branch->street;
        $this->postal_code = $this->branch->postal_code;
    }

    public function submit_branch()
    {
        $this->validate();

        if ($this->submit_func == 'add-branch') {
            Branch::create([
                'email' => $this->email,
                'contact_number' => $this->contact_number,
                'region' => $this->region,
                'province' => $this->province,
                'municipality' => $this->municipality,
                'barangay' => $this->barangay,
                'street' => $this->street,
                'status' => "Active",
                'postal_code' => $this->postal_code,
            ]);

            session()->flash('message', 'Branch successfully added!');
        } else if ($this->submit_func == 'edit-branch') {
            $this->branch->email = $this->email;
            $this->branch->contact_number = $this->contact_number;
            $this->branch->status = $this->status;
            $this->branch->region = $this->region;
            $this->branch->province = $this->province;
            $this->branch->municipality = $this->municipality;
            $this->branch->barangay = $this->barangay;
            $this->branch->street = $this->street;
            $this->branch->postal_code = $this->postal_code;

            $this->branch->save();

            session()->flash('message', 'Branch successfully updated!');
        }

        return redirect()->route('branches');
    }
}
