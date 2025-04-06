<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class ApplicationForm extends Model
{
    use HasFactory;
    protected $primaryKey = 'application_id';
    protected $fillable = [
        'applicant_id', 'branch_id', 'job_id', 'application_date', 'status', 'marital_status', 'schedule_id'
    ];

    public function applicant()
    {
        return $this->belongsTo(Applicant::class, 'applicant_id');
    }

    public function documents()
    {
        return $this->hasMany(Document::class, 'application_id');
    }

    public function job()
    {
        return $this->belongsTo(JobOffer::class, 'job_id');
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class, 'branch_id');
    }

    public function branchInterview()
    {
        return $this->hasOne(BranchInterview::class, 'application_id');
    }

    public function employerInterview()
    {
        return $this->hasOne(EmployerInterview::class, 'application_id');
    }

    public function schedule()
    {
        return $this->belongsTo(BranchSchedule::class, 'schedule_id');
    }

    public function hiring()
    {
        return $this->hasOne(Hiring::class, 'application_id');
    }

    public function deployment()
    {
        return $this->hasOne(Deployment::class, 'application_id');
    }

    public function isDocumentsAccessible()
    {
        $employee = Auth::guard('employee')->user();

        if ($employee->position == 'Admin') {
            return true;
        }

        $employeeBranchId = $employee->branch_id;

        if ($this->branch_id == $employeeBranchId) {
            return true;
        }

        $requestDocument = DocumentsRequest::where('application_id', $this->application_id)
            ->where('requesting_branch', $employeeBranchId)
            ->first();

        if ($requestDocument) {
            if ($requestDocument->status == 'Approved') {
                return true;
            } else if ($requestDocument->status == 'Pending') {
                return 'PendingApproval';
            }
        }

        return false;
    }
}
