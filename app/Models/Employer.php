<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Employer extends Authenticatable
{
    use HasFactory, Notifiable;
    protected $primaryKey = 'employer_id';
    protected $fillable = [
        'first_name', 'middle_name', 'last_name',
        'gender', 'email', 'password', 'industry', 'company_name', 'contact_number', 'status', 'suffix', 'profile_photo_path'
    ];
}
