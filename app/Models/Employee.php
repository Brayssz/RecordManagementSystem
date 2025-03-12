<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Employee extends Authenticatable
{
    use HasFactory, Notifiable;
    
    protected $primaryKey = 'employee_id';
    
    protected $fillable = [
        'branch_id', 'first_name', 'middle_name', 'last_name', 'gender',
        'email', 'username', 'password', 'contact_number', 'date_of_birth',
        'position', 'region', 'province', 'municipality', 'barangay',
        'street', 'postal_code', 'status', 'suffix', 'profile_photo_path'
    ];

    public function branch()
    {
        return $this->belongsTo(Branch::class, 'branch_id');
    }
}
