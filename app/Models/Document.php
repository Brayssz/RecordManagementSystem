<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    use HasFactory;
    protected $primaryKey = 'document_id';
    protected $fillable = [
        'application_id', 'employee_id', 'file_name', 'upload_date',
        'document_type', 'valid_until', 'status'
    ];
}
