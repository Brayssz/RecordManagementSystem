<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DocumentsRequest extends Model
{
    use HasFactory;

    protected $table = 'documents_request';
    protected $primaryKey = 'request_id';

    protected $fillable = [
        'request_by',
        'requesting_branch',
        'application_id',
        'approved_by',
        'status',
    ];

    public function requester()
    {
        return $this->belongsTo(Employee::class, 'request_by', 'employee_id');
    }

    public function approver()
    {
        return $this->belongsTo(Employee::class, 'approved_by', 'employee_id');
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class, 'requesting_branch', 'branch_id');
    }

    public function application()
    {
        return $this->belongsTo(ApplicationForm::class, 'application_id', 'application_id');
    }
}
