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
}
