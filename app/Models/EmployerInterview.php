<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployerInterview extends Model
{
    use HasFactory;
    protected $primaryKey = 'e_interview_id';
    protected $fillable = [
        'employer_id', 'application_id', 'interview_date', 'remarks', 'rating', 'status', 'meeting_link', 'interview_time'
    ];

    public function application()
    {
        return $this->belongsTo(ApplicationForm::class, 'application_id');
    }

    public function employer()
    {
        return $this->belongsTo(Employer::class, 'employer_id');
    }
}
