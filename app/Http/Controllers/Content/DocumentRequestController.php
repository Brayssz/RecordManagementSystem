<?php

namespace App\Http\Controllers\Content;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ApplicationForm;
use App\Models\DocumentsRequest;
use Illuminate\Support\Facades\Auth;

class DocumentRequestController extends Controller
{
    public function showDocumentRequest(Request $request)
    {
        if ($request->ajax()) {
            $query = DocumentsRequest::with('requester', 'approver', 'branch', 'application')
                ->whereHas('application', function ($q) {
                    $q->where('branch_id', Auth::guard("employee")->user()->branch_id);
                });

            if ($request->filled('status')) {
                $query->where('status', $request->status);
            }

            if ($request->filled('search') && !empty($request->input('search')['value'])) {
                $search = $request->input('search')['value'];
                $query->where(function ($q) use ($search) {
                    $q->where('request_id', 'like', '%' . $search . '%')
                        ->orWhere('application_id', 'like', '%' . $search . '%')
                        ->orWhereHas('application', function ($q) use ($search) {
                            $q->where('applicant_id', 'like', '%' . $search . '%');
                        })
                        ->orWhereHas('branch', function ($q) use ($search) {
                            $q->where('municipality', 'like', '%' . $search . '%');
                        });
                });
            }

            $totalRecords = $query->count();

            $orderColumnIndex = $request->input('order')[0]['column'] ?? 0;
            $orderColumn = $request->input('columns')[$orderColumnIndex]['data'] ?? 'request_id';
            $orderDirection = $request->input('order')[0]['dir'] ?? 'asc';
            $query->orderBy($orderColumn, $orderDirection);

            $start = $request->input('start', 0);
            $length = $request->input('length', 10);
            $applications = $query->skip($start)->take($length)->get();

            return response()->json([
                "draw" => intval($request->input("draw")),
                "recordsTotal" => intval($totalRecords),
                "recordsFiltered" => intval($totalRecords),
                "data" => [
                    "applications" =>  $applications,
                    "total_applications" =>  ApplicationForm::count(),
                    "total_documents_request" => DocumentsRequest::count(),
                ],
            ]);
        }

        return view('content.document-request-management');
    }
}
