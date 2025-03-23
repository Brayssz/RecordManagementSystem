<?php

namespace App\Http\Controllers\Content;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\JobOffer;
use Illuminate\Support\Facades\Auth;

class JobOfferController extends Controller
{
    public function showJobOffers(Request $request)
    {
        if ($request->ajax()) {
            $query = JobOffer::where('status', 'Active')->with('employer');

            if ($request->filled('status')) {
                $query->where('status', $request->status);
            }

            if ($request->filled('search') && !empty($request->input('search')['value'])) {
                $search = $request->input('search')['value'];
                $query->where(function ($q) use ($search) {
                    $q->where('job_title', 'like', '%' . $search . '%')
                        ->orWhere('country', 'like', '%' . $search . '%')
                        ->orWhere('job_description', 'like', '%' . $search . '%');
                });
            }

            $totalRecords = $query->count();

            $orderColumnIndex = $request->input('order')[0]['column'] ?? 0;
            $orderColumn = $request->input('columns')[$orderColumnIndex]['data'] ?? 'job_id';
            $orderDirection = $request->input('order')[0]['dir'] ?? 'asc';
            $query->orderBy($orderColumn, $orderDirection);

            $start = $request->input('start', 0);
            $length = $request->input('length', 10);
            $jobOffers = $query->skip($start)->take($length)->get();

            $jobOffers->transform(function ($jobOffer) {
                return $jobOffer;
            });

            return response()->json([
                "draw" => intval($request->input('draw', 1)),
                "recordsTotal" => $totalRecords,
                "recordsFiltered" => $totalRecords,
                "data" => $jobOffers
            ]);
        }

        
        $jobOffers = JobOffer::where('status', 'Active')->with('employer')->get();
        // return($jobOffers);
        return view('content.job-offer-management', compact('jobOffers'));
    }

    public function listJobOffers(Request $request) 
    {
        return view('content.job-offers');
    }
}
