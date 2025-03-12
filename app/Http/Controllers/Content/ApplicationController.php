<?php

namespace App\Http\Controllers\Content;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ApplicationController extends Controller
{
    public function showApplicationForm(Request $request)
    {
        $job_id = $request->job_id;
        return view('content.application-form', compact('job_id'));
    }
}
