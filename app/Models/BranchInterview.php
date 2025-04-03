<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BranchInterview extends Model
{
    use HasFactory;
    protected $primaryKey = 'b_interview_id';
    protected $fillable = [
        'branch_id', 'employee_id', 'application_id',
        'interview_date', 'remarks', 'rating', 'status', 'start_time', 'end_time'
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id');
    }

    public function application()
    {
        return $this->belongsTo(ApplicationForm::class, 'application_id');
    }
}
