<?php

namespace App\Livewire\Content;

use App\Models\BranchSchedule;
use App\Notifications\Reschedule;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\ApplicationForm;

class BranchScheduleManagement extends Component
{
    public $submit_func;
    public $schedule;
    public $total_schedules;
    public $interview_date;
    public $available_slots = 0;
    public $schedule_id;
    public $available_start_time;
    public $available_end_time;

    protected function rules()
    {
        return [
            'interview_date' => [
                'required',
                'date',
                'after:today',
                Rule::unique('branch_schedules', 'interview_date')
                    ->where(function ($query) {
                        return $query->where('branch_id', Auth::guard('employee')->user()->branch_id);
                    })
                    ->ignore($this->schedule_id, 'schedule_id'),
            ],
            'available_slots' => 'required|integer|min:1',
            'available_start_time' => 'required|date_format:H:i',
            'available_end_time' => 'required|date_format:H:i|after:available_start_time',
        ];
    }

    public function getTotalSchedules()
    {
        $this->total_schedules = BranchSchedule::count();
    }

    public function resetFields()
    {
        $this->reset([
            'interview_date',
            'available_slots',
            'schedule_id',
            'available_start_time',
            'available_end_time',
        ]);
    }

    public function getSchedule($scheduleID)
    {
        $this->schedule = BranchSchedule::findOrFail($scheduleID);
        $this->interview_date = $this->schedule->interview_date;
        $this->available_slots = $this->schedule->available_slots;
        $this->schedule_id = $this->schedule->schedule_id;
        $this->available_start_time = Carbon::parse($this->schedule->available_start_time)->format('H:i');
        $this->available_end_time = Carbon::parse($this->schedule->available_end_time)->format('H:i');
    }

    public function submitSchedule()
    {
        $this->validate();

        if ($this->submit_func == 'add-schedule') {
            BranchSchedule::create([
                'interview_date' => $this->interview_date,
                'available_slots' => $this->available_slots,
                'branch_id' => Auth::guard('employee')->user()->branch_id,
                'available_start_time' => $this->available_start_time,
                'available_end_time' => $this->available_end_time,
            ]);

            session()->flash('message', 'Schedule successfully added!');
        } elseif ($this->submit_func == 'edit-schedule') {
            $this->schedule->update([
                'interview_date' => $this->interview_date,
                'available_slots' => $this->available_slots,
                'available_start_time' => $this->available_start_time,
                'available_end_time' => $this->available_end_time,
            ]);

            $date = Carbon::parse($this->interview_date)->format('F j, Y') . "( " . Carbon::parse($this->available_start_time)->format('h:i A') . " - " . Carbon::parse($this->available_end_time)->format('h:i A') ." )";
            $this->sendRescheduleEmail($date);

            session()->flash('message', 'Schedule successfully updated!');
        }

        return redirect()->route('branch-schedules');
    }

    public function sendRescheduleEmail($date)
    {

        $applications = ApplicationForm::with('applicant')->where('schedule_id' ,$this->schedule_id)->get();

        foreach ($applications as $application) {

            $application->applicant->notify(new Reschedule($application->application_id, $date));
            
        }

    }

    public function render()
    {
        $this->getTotalSchedules();
        return view('livewire.content.branch-schedule-management');
    }
}
