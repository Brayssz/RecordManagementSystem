<?php

namespace App\Livewire\Content;

use Livewire\Component;
use App\Models\Country;
use Livewire\WithPagination;
use App\Models\JobOffer;
use Illuminate\Support\Facades\Auth;
use App\Models\ApplicationForm;


class JobOffers extends Component
{
    use WithPagination;


    public $search = '';
    public $filter = '';

    public $countries;

    protected $queryString = ['search', 'filter'];

    // public function updatingSearch()
    // {
    //     $this->resetPage();
    // }

    // public function updatingFilter()
    // {
    //     $this->resetPage();
    // }

    public function checkExistingApplication()
    {
        $application = ApplicationForm::where('applicant_id', Auth::guard('applicant')->user()->applicant_id)
            ->first();

        if ($application) {
            if ($application->status == 'Deployed') {
                $endContractDate = $application->deployment->end_contract_date;
                if ($endContractDate && \Carbon\Carbon::parse($endContractDate)->isBefore(now())) {
                    return ['status' => false, 'message' => ''];
                } else {
                    return ['status' => true, 'message' => 'You have currently ongoing contract that ends on ' . \Carbon\Carbon::parse($endContractDate)->format('F j, Y')];
                }
            } else if ($application->status == 'Rejected' || $application->status == 'Cancelled')  {
                return ['status' => false, 'message' => ''];
            } else {
                return ['status' => true, 'message' => 'Application in progress.'];
            }
        }

        return ['status' => false, 'message' => ''];
    }

    public function getJobOffers($page = 1, $searchQuery = '')
    {
        $search = $searchQuery;

        $jobOffers = JobOffer::with('employer')->where('available_slots', '>', 0)->where(function ($query) use ($search) {
            $query->where('job_title', 'like', '%' . $search . '%')
                ->orWhere('job_qualifications', 'like', '%' . $search . '%')
                ->orWhere('job_description', 'like', '%' . $search . '%');
        });


        $jobOffers = $jobOffers->paginate(6, ['*'], 'page', $page); // Fetch 6 jobs per page

        return response()->json($jobOffers);
    }

    public function render()
    {
        return view('livewire.content.job-offers');
    }
}
