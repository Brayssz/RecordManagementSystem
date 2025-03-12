<?php

namespace App\Http\Controllers\Content;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Employee;
use Illuminate\Support\Facades\Auth;
use App\Models\Branch;
class EmployeeController extends Controller
{
    public function showEmployees(Request $request)
    {
        if ($request->ajax()) {
            $query = Employee::with('branch');

            // if (Auth::check() && Auth::user()->position == 'Manager') {
            //     $query->where('branch_id', Auth::user()->branch_id);
            // }

            if ($request->filled('status')) {
                $query->where('status', $request->status);
            }

            if ($request->filled('position')) {
                $query->where('position', 'like', '%' . $request->position . '%');
            }

            if ($request->filled('branch_id')) {
                $query->where('branch_id', 'like', '%' . $request->branch_id . '%');
            }

            if (Auth::check()) {
                $query->where('employee_id', '!=', Auth::user()->employee_id);
            }

            if ($request->filled('search') && !empty($request->input('search')['value'])) {
                $search = $request->input('search')['value'];
                $query->where(function ($q) use ($search) {
                    $q->where('first_name', 'like', '%' . $search . '%')
                        ->orWhere('last_name', 'like', '%' . $search . '%')
                        ->orWhere('employee_id', 'like', '%' . $search . '%')
                        ->orWhere('position', 'like', '%' . $search . '%');
                });
            }

            $totalRecords = $query->count();

            $orderColumnIndex = $request->input('order')[0]['column'] ?? 0;
            $orderColumn = $request->input('columns')[$orderColumnIndex]['data'] ?? 'employee_id';
            $orderDirection = $request->input('order')[0]['dir'] ?? 'asc';
            $query->orderBy($orderColumn, $orderDirection);

            $start = $request->input('start', 0);
            $length = $request->input('length', 10);
            $employees = $query->skip($start)->take($length)->get();

            $employees->transform(function ($employee) {
                return $employee;
            });

            return response()->json([
                "draw" => intval($request->input('draw', 1)),
                "recordsTotal" => $totalRecords,
                "recordsFiltered" => $totalRecords,
                "data" => $employees
            ]);
        }

        $query = Employee::with('branch');

        if (Auth::check() && Auth::user()->position == 'Manager') {
            $query->where('branch_id', Auth::user()->branch_id);
        }

        $employees = $query->get();
        // return($employees);

        $branches = Branch::where('status', 'Active')->get();

        return view('content.employee-management', compact('employees', 'branches'));
    }

}
