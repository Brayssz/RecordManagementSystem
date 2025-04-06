<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('applicants', function (Blueprint $table) {
            $table->id('applicant_id');
            $table->string('first_name');
            $table->string('middle_name')->nullable();
            $table->string('last_name');
            $table->string('suffix', 10)->nullable();
            $table->string('citizenship');
            $table->string('gender');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('contact_number');
            $table->date('date_of_birth');
            $table->string('region');
            $table->string('province');
            $table->string('municipality');
            $table->string('barangay');
            $table->string('street');
            $table->string('postal_code');
            $table->string('marital_status');
            $table->string('profile_photo_path')->nullable();
            $table->string('status');
            $table->timestamps();
        });

        Schema::create('branches', function (Blueprint $table) {
            $table->id('branch_id');
            $table->string('contact_number');
            $table->string('email')->unique();
            $table->string('status');
            $table->string('region');
            $table->string('province');
            $table->string('municipality');
            $table->string('barangay');
            $table->string('street');
            $table->string('postal_code');
            $table->timestamps();
        });

        Schema::create('employers', function (Blueprint $table) {
            $table->id('employer_id');
            $table->string('first_name');
            $table->string('middle_name')->nullable();
            $table->string('last_name');
            $table->string('suffix', 10)->nullable();
            $table->string('gender');
            $table->string('email')->unique();
            $table->string('contact_number');
            $table->string('industry');
            $table->string('profile_photo_path')->nullable();
            $table->string('company_name');
            $table->string('status');
            $table->timestamps();
        });

        Schema::create('job_offers', function (Blueprint $table) {
            $table->id('job_id');
            $table->unsignedBigInteger('employer_id')->nullable();
            $table->string('country');
            $table->string('job_title');
            $table->string('salary');
            $table->text('job_description');
            $table->string('status');
            $table->text('job_qualifications');
            $table->integer('available_slots')->default(0);
            $table->timestamps();

            $table->foreign('employer_id')->references('employer_id')->on('employers')->onDelete('set null');
        });

        Schema::create('documents_request', function (Blueprint $table) {
            $table->id('request_id');
            $table->unsignedBigInteger('request_by')->nullable();
            $table->unsignedBigInteger('requesting_branch')->nullable();
            $table->unsignedBigInteger('application_id')->nullable();
            $table->unsignedBigInteger('approved_by')->nullable();
            $table->string('status');
            $table->timestamps();

            $table->foreign('request_by')->references('employee_id')->on('employees')->onDelete('set null');
            $table->foreign('requesting_branch')->references('branch_id')->on('branches')->onDelete('set null');
            $table->foreign('application_id')->references('application_id')->on('application_forms')->onDelete('set null');
            $table->foreign('approved_by')->references('employee_id')->on('employees')->onDelete('set null');
        });

        Schema::create('branch_schedules', function (Blueprint $table) {
            $table->id('schedule_id');
            $table->dateTime('interview_date');
            $table->time('available_start_time');
            $table->time('available_end_time');
            $table->integer('available_slots')->default(0);
            $table->unsignedBigInteger('branch_id')->nullable();
            $table->timestamps();

            $table->foreign('branch_id')->references('branch_id')->on('branches')->onDelete('set null');
        });

        Schema::create('application_forms', function (Blueprint $table) {
            $table->id('application_id');
            $table->unsignedBigInteger('applicant_id')->nullable();
            $table->unsignedBigInteger('branch_id')->nullable();
            $table->unsignedBigInteger('job_id')->nullable();
            $table->unsignedBigInteger('schedule_id')->nullable();
            $table->date('application_date');
            $table->string('status');
            $table->timestamps();

            $table->foreign('applicant_id')->references('applicant_id')->on('applicants')->onDelete('set null');
            $table->foreign('branch_id')->references('branch_id')->on('branches')->onDelete('set null');
            $table->foreign('job_id')->references('job_id')->on('job_offers')->onDelete('set null');
            $table->foreign('schedule_id')->references('schedule_id')->on('branch_schedules')->onDelete('set null');
        });

        Schema::create('employees', function (Blueprint $table) {
            $table->id('employee_id');
            $table->unsignedBigInteger('branch_id')->nullable();
            $table->string('first_name');
            $table->string('middle_name')->nullable();
            $table->string('last_name');
            $table->string('suffix', 10)->nullable();
            $table->string('gender');
            $table->string('email')->unique();
            $table->string('username')->unique();
            $table->string('password');
            $table->string('contact_number');
            $table->date('date_of_birth');
            $table->string('position');
            $table->string('region');
            $table->string('province');
            $table->string('profile_photo_path')->nullable();
            $table->string('municipality');
            $table->string('barangay');
            $table->string('street');
            $table->string('postal_code');
            $table->string('status');
            $table->timestamps();

            $table->foreign('branch_id')->references('branch_id')->on('branches')->onDelete('set null');
        });

        Schema::create('branch_interviews', function (Blueprint $table) {
            $table->id('b_interview_id');
            $table->unsignedBigInteger('branch_id')->nullable();
            $table->unsignedBigInteger('employee_id')->nullable();
            $table->unsignedBigInteger('application_id')->nullable();
            $table->time('start_time')->nullable();
            $table->time('end_time')->nullable();
            $table->string('remarks')->nullable();
            $table->integer('rating')->nullable();
            $table->string('status');
            $table->timestamps();

            $table->foreign('branch_id')->references('branch_id')->on('branches')->onDelete('set null');
            $table->foreign('employee_id')->references('employee_id')->on('employees')->onDelete('set null');
            $table->foreign('application_id')->references('application_id')->on('application_forms')->onDelete('set null');
        });

        Schema::create('employer_interviews', function (Blueprint $table) {
            $table->id('e_interview_id');
            $table->unsignedBigInteger('employer_id')->nullable();
            $table->unsignedBigInteger('application_id')->nullable();
            $table->date('interview_date');
            $table->time('interview_time');
            $table->string('meeting_link')->nullable();
            $table->string('remarks')->nullable();
            $table->integer('rating')->nullable();
            $table->string('status');
            $table->timestamps();

            $table->foreign('employer_id')->references('employer_id')->on('employers')->onDelete('set null');
            $table->foreign('application_id')->references('application_id')->on('application_forms')->onDelete('set null');
        });

        Schema::create('hirings', function (Blueprint $table) {
            $table->id('hiring_id');
            $table->unsignedBigInteger('e_interview_id')->nullable();
            $table->unsignedBigInteger('employee_id')->nullable();
            $table->unsignedBigInteger('application_id')->nullable();
            $table->string('confirmation_code')->unique();
            $table->date('confirmation_date');
            $table->string('status');
            $table->timestamps();

            $table->foreign('e_interview_id')->references('e_interview_id')->on('employer_interviews')->onDelete('set null');
            $table->foreign('employee_id')->references('employee_id')->on('employees')->onDelete('set null');
            $table->foreign('application_id')->references('application_id')->on('application_forms')->onDelete('set null');
        });

        Schema::create('deployments', function (Blueprint $table) {
            $table->id('deployment_id');
            $table->unsignedBigInteger('application_id')->nullable();
            $table->unsignedBigInteger('employee_id')->nullable();
            $table->date('schedule_departure_date');
            $table->date('actual_departure_date')->nullable();
            $table->date('end_contract_date')->nullable();
            $table->string('status');
            $table->timestamps();

            $table->foreign('application_id')->references('application_id')->on('application_forms')->onDelete('set null');
            $table->foreign('employee_id')->references('employee_id')->on('employees')->onDelete('set null');
        });

         Schema::create('documents', function (Blueprint $table) {
            $table->id('document_id');
            $table->unsignedBigInteger('application_id')->nullable();
            $table->unsignedBigInteger('employee_id')->nullable();
            $table->string('file_name');
            $table->date('upload_date');
            $table->string('document_type');
            $table->date('valid_until')->nullable();
            $table->string('status');
            $table->timestamps();

            $table->foreign('application_id')->references('application_id')->on('application_forms')->onDelete('set null');
            $table->foreign('employee_id')->references('employee_id')->on('employees')->onDelete('set null');
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email');
            $table->string('user_type');
            $table->string('token');
            $table->timestamp('created_at')->nullable();
            
            $table->primary(['email', 'user_type']);
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });

        foreach (['applicants', 'employees', 'employers'] as $table) {
            Schema::table($table, function (Blueprint $table) {
                $table->string('two_factor_code')->nullable();
                $table->timestamp('two_factor_expires_at')->nullable();
            });
        }

        Schema::create('notifications', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('type');
            $table->morphs('notifiable');
            $table->text('data');
            $table->timestamp('read_at')->nullable();
            $table->timestamps();
        });
        
    }

    /**
     * Reverse the migrations.
     */

    public function down(): void
    {
        Schema::dropIfExists('deployments');
        Schema::dropIfExists('hirings');
        Schema::dropIfExists('employer_interviews');
        Schema::dropIfExists('branch_interviews');
        Schema::dropIfExists('application_forms');
        Schema::dropIfExists('job_offers');
        Schema::dropIfExists('employers');
        Schema::dropIfExists('employees');
        Schema::dropIfExists('branch_schedules');
        Schema::dropIfExists('documents');
        Schema::dropIfExists('branches');
        Schema::dropIfExists('applicants');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
        Schema::dropIfExists('notifications');
        
        foreach (['applicants', 'employees', 'employers'] as $table) {
            Schema::table($table, function (Blueprint $table) {
                $table->dropColumn(['two_factor_code', 'two_factor_expires_at']);
            });
        }
    }
};
