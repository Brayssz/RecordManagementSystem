<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BranchSchedule extends Model
{
    use HasFactory;

    protected $table = 'branch_schedules';
    protected $primaryKey = 'schedule_id';
    public $timestamps = true;

    protected $fillable = [
        'interview_date',
        'available_slots',
        'branch_id',
    ];

    public function branch()
    {
        return $this->belongsTo(Branch::class, 'branch_id', 'branch_id');
    }

    public function applications()
    {
        return $this->hasMany(ApplicationForm::class, 'schedule_id', 'schedule_id');
    }
}
