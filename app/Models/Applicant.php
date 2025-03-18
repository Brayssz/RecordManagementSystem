<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class Applicant extends Authenticatable
{
    use HasFactory, Notifiable;
    protected $primaryKey = 'applicant_id';
    protected $fillable = [
        'first_name', 'middle_name', 'last_name', 'gender', 'email', 'password',
        'contact_number', 'date_of_birth', 'region', 'province', 'municipality',
        'barangay', 'street', 'postal_code','citizenship', 'status', 'suffix', 'profile_photo_path', 'marital_status'
    ];
}
