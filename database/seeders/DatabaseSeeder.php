<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\Employer;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        DB::table('branches')->insert([
            [
                'contact_number' => '09123456789',
                'email'         => 'branch1@example.com',
                'status'        => 'Active',
                'region'        => 'NCR',
                'province'      => 'Metro Manila',
                'municipality'  => 'Manila',
                'barangay'      => 'Barangay 1',
                'street'        => 'Branch Street 1',
                'postal_code'   => '1000',
                'created_at'    => now(),
                'updated_at'    => now(),
            ],
            [
                'contact_number' => '09234567890',
                'email'         => 'branch2@example.com',
                'status'        => 'Inactive',
                'region'        => 'Region IV-A',
                'province'      => 'Cavite',
                'municipality'  => 'Bacoor',
                'barangay'      => 'Barangay 2',
                'street'        => 'Branch Street 2',
                'postal_code'   => '4102',
                'created_at'    => now(),
                'updated_at'    => now(),
            ]
        ]);

        DB::table('employees')->insert([
            [
                'branch_id'     => 1, 
                'first_name'    => 'Admin',
                'middle_name'   => 'Super',
                'last_name'     => 'User',
                'gender'        => 'Male',
                'email'         => 'admin@example.com',
                'username'      => 'admin123',
                'password'      => Hash::make('password123'), 
                'contact_number' => '09123456789',
                'date_of_birth' => '1990-01-01',
                'position'      => 'Admin',
                'region'        => 'NCR',
                'province'      => 'Metro Manila',
                'municipality'  => 'Manila',
                'barangay'      => 'Barangay 1',
                'street'        => 'Admin Street',
                'postal_code'   => '1000',
                'status'        => 'Active',
                'created_at'    => now(),
                'updated_at'    => now(),
            ],
            [
                'branch_id'     => 2, 
                'first_name'    => 'John',
                'middle_name'   => 'Doe',
                'last_name'     => 'Smith',
                'gender'        => 'Male',
                'email'         => ' ',
                'username'      => 'johndoe',
                'password'      => Hash::make('password123'),
                'contact_number' => '09234567890',
                'date_of_birth' => '1995-05-15',
                'position'      => 'Manager',
                'region'        => 'Region IV-A',
                'province'      => 'Cavite',
                'municipality'  => 'Bacoor',
                'barangay'      => 'Barangay 2',
                'street'        => 'Manager Street',
                'postal_code'   => '4102',
                'status'        => 'Active',
                'created_at'    => now(),
                'updated_at'    => now(),
            ]
        ]);

        DB::table('applicants')->insert([
            [
                'first_name'    => 'Admin',
                'middle_name'   => 'Super',
                'last_name'     => 'User',
                'gender'        => 'Male',
                'email'         => 'admin@examples.com',
                'password'      => Hash::make('password123'), 
                'contact_number' => '09123456789',
                'date_of_birth' => '1990-01-01',
                'region'        => 'NCR',
                'citizenship'   => 'NCR',
                'province'      => 'Metro Manila',
                'municipality'  => 'Manila',
                'barangay'      => 'Barangay 1',
                'street'        => 'Admin Street',
                'postal_code'   => '1000',
                'status'        => 'Active',
                'created_at'    => now(),
                'updated_at'    => now(),
            ],
           
        ]);

        Employer::create([
            'first_name' => 'John',
            'middle_name' => 'A.',
            'last_name' => 'Doe',
            'gender' => 'Male',
            'email' => 'johndoe@example.com',
            'password' => Hash::make('securepassword'),
            'industry' => 'IT',
            'company_name' => 'Tech Solutions',
            'contact_number' => '1234567890',
            'status' => 'Active',
            'suffix' => 'Jr.',
            'profile_photo_path' => 'uploads/profile_photos/johndoe.jpg',
        ]);
    }
}
