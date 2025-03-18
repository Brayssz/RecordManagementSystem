<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hiring extends Model
{
    use HasFactory;
    protected $primaryKey = 'hiring_id';
    
    protected $fillable = [
        'e_interview_id', 'employee_id', 'application_id',
        'confirmation_code', 'confirmation_date', 'status'
    ];

    public function application()
    {
        return $this->belongsTo(ApplicationForm::class, 'application_id');
    }
}
