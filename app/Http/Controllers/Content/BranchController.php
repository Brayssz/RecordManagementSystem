<?php

namespace App\Http\Controllers\Content;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Branch;

class BranchController extends Controller
{
    public function showBranches(Request $request)
    {
        if ($request->ajax()) {
            $query = Branch::query();

            if ($request->filled('status')) {
                $query->where('status', $request->status);
            }

            if ($request->filled('search') && !empty($request->input('search')['value'])) {
                $search = $request->input('search')['value'];
                $query->where(function ($q) use ($search) {
                    $q->where('contact_number', 'like', '%' . $search . '%')
                        ->orWhere('email', 'like', '%' . $search . '%')
                        ->orWhere('region', 'like', '%' . $search . '%')
                        ->orWhere('province', 'like', '%' . $search . '%')
                        ->orWhere('municipality', 'like', '%' . $search . '%')
                        ->orWhere('barangay', 'like', '%' . $search . '%')
                        ->orWhere('street', 'like', '%' . $search . '%')
                        ->orWhere('postal_code', 'like', '%' . $search . '%');
                });
            }

            $totalRecords = $query->count();

            $orderColumnIndex = $request->input('order')[0]['column'] ?? 0;
            $orderColumn = $request->input('columns')[$orderColumnIndex]['data'] ?? 'branch_id';
            $orderDirection = $request->input('order')[0]['dir'] ?? 'asc';
            $query->orderBy($orderColumn, $orderDirection);

            $start = $request->input('start', 0);
            $length = $request->input('length', 10);
            $branches = $query->skip($start)->take($length)->get();

            $branches->transform(function ($branch) {
                return $branch;
            });

            return response()->json([
                "draw" => intval($request->input('draw', 1)),
                "recordsTotal" => $totalRecords,
                "recordsFiltered" => $totalRecords,
                "data" => $branches
            ]);
        }
        $branches = Branch::all();
        // return($branches);
        return view('content.branch-management', compact('branches'));
    }
}
