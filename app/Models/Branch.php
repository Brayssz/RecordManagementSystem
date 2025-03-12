<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Branch extends Model
{
    use HasFactory, Notifiable;
    protected $primaryKey = 'branch_id';
    protected $fillable = [
        'contact_number', 'email', 'status', 'region', 'province',
        'municipality', 'barangay', 'street', 'postal_code'
    ];
}
