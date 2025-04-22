<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobOffer extends Model
{
    use HasFactory;
    protected $primaryKey = 'job_id';
    protected $fillable = [
        'employer_id', 'country', 'job_title', 'salary', 'job_description', 'status', 'job_qualifications', 'available_slots'
    ];

    public function employer()
    {
        return $this->belongsTo(Employer::class, 'employer_id');
    }

    public function applications()
    {
        return $this->hasMany(ApplicationForm::class, 'job_id');
    }
}
