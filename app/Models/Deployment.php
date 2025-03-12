<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Deployment extends Model
{
    use HasFactory;
    protected $primaryKey = 'deployment_id';
    protected $fillable = [
        'application_id', 'employee_id', 'schedule_departure_date',
        'actual_departure_date', 'status'
    ];
}
