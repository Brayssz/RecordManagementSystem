<?php

namespace App\Livewire\Content;

use Livewire\Component;
use App\Models\Country;
use Livewire\WithPagination;
use App\Models\JobOffer;

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
