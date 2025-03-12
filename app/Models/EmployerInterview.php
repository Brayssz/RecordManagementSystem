<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployerInterview extends Model
{
    use HasFactory;
    protected $primaryKey = 'e_interview_id';
    protected $fillable = [
        'employer_id', 'application_id', 'interview_date', 'remarks', 'rating', 'status'
    ];
}
