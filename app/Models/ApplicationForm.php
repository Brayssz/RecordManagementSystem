<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApplicationForm extends Model
{
    use HasFactory;
    protected $primaryKey = 'application_id';
    protected $fillable = [
        'applicant_id', 'branch_id', 'job_id', 'application_date', 'status'
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
}
