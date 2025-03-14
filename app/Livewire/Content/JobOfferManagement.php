<?php

namespace App\Livewire\Content;

use App\Models\Employer;
use App\Models\JobOffer;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\Http\UploadedFile;

class JobOfferManagement extends Component
{
    use WithFileUploads;

    public $submit_func;

    public $job_offer;

    public $total_job_offers;

    public $job_id, $country, $job_title, $range_from, $range_to, $job_description, $status, $job_qualifications, $available_slots;

    public $employers;

    public function getEmployers()
    {
        $this->employers = Employer::where('status', 'Active')->get();
    }

    public function getJobOffer($jobId)
    {
        $this->job_offer = JobOffer::where('job_id', $jobId)->first();

        if ($this->job_offer) {
            $this->job_id = $this->job_offer->job_id;
            $this->country = $this->job_offer->country;
            $this->job_title = $this->job_offer->job_title;
            $this->job_description = $this->job_offer->job_description;
            $this->status = $this->job_offer->status;
            $this->job_qualifications = $this->job_offer->job_qualifications;
            $this->available_slots = $this->job_offer->available_slots;
            if (isset($this->job_offer->salary)) {
                [$from, $to] = explode('-', $this->job_offer->salary);
    
                $from = (int) $from;
                $to = (int) $to;
    
                $this->range_from =  $from;
                $this->range_to = $to;
            }
        } else {
            session()->flash('error', 'Job offer not found.');
        }
    }

    public function getTotalJobOffers()
    {
        $this->total_job_offers = JobOffer::count();
    }

    protected function rules()
    {
        $rules = [
            'country' => 'required|string|max:255',
            'job_title' => 'required|string|max:255',
            'range_from' => [
                'required',
                'integer',
                'min:10000',
                'max:500000',
                function ($attribute, $value, $fail) {
                    if (isset($this->range_to) && $value > $this->range_to) {
                        $fail("The from value must not be greater than the to value.");
                    }
                },
            ],
            'range_to' => [
                'required',
                'integer',
                'min:10000',
                'max:500000',
                function ($attribute, $value, $fail) {
                    $rangeFrom = request('range_from'); 
                    if ($rangeFrom && $value < $rangeFrom) {
                        $fail("The to value must be greater than or equal to the from value.");
                    }
                },
            ],
            'job_description' => 'required|string',
            'job_qualifications' => 'required|string',
            'available_slots' => 'required|integer',
        ];

        if ($this->job_id !== null) {
            $rules['status'] = 'required|string|max:255';
        }

        return $rules;
    }
    public function resetFields() {
        $this->reset([
            'country', 'job_title', 'range_from', 'range_to', 
            'job_description', 'status', 'job_id', 'job_qualifications', 'available_slots'
        ]);
    }

    public function submit_job_offer()
    {
        // dd();
        $this->validate();

        if ($this->submit_func == "add-job-offer") {
            JobOffer::create([
                'employer_id' => Auth::guard('employer')->user()->employer_id,
                'country' => $this->country,
                'job_title' => $this->job_title,
                'salary' => $this->range_from . ' - ' . $this->range_to,
                'job_description' => $this->job_description,
                'status' => "Active",
                'job_qualifications' => $this->job_qualifications,
                'available_slots' => $this->available_slots,
            ]);

            session()->flash('message', 'Job offer successfully created.');

        } else if ($this->submit_func == "edit-job-offer") {

            $this->job_offer->country = $this->country;
            $this->job_offer->job_title = $this->job_title;
            $this->job_offer->salary = $this->range_from . ' - ' . $this->range_to;
            $this->job_offer->job_description = $this->job_description;
            $this->job_offer->status = $this->status;
            $this->job_offer->job_qualifications = $this->job_qualifications;
            $this->job_offer->available_slots = $this->available_slots;

            $this->job_offer->save();

            session()->flash('message', 'Job offer successfully updated.');
        }

        return redirect()->route('jobs');
    }

    public function render()
    {
        $this->getTotalJobOffers();
        $this->getEmployers();
        return view('livewire.content.job-offer-management');
    }
}
