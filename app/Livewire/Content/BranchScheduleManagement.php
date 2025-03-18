<?php

namespace App\Livewire\Content;

use App\Models\BranchSchedule;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;

class BranchScheduleManagement extends Component
{
    public $submit_func;
    public $schedule;
    public $total_schedules;
    public $interview_date;
    public $available_slots = 0;
    public $schedule_id;

    protected function rules()
    {
        return [

            'interview_date' => [
                'required',
                'date',
                'after:today',
                Rule::unique('branch_schedules', 'interview_date')->ignore($this->schedule_id, 'schedule_id'),
            ],
            'available_slots' => 'required|integer|min:1',
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
        ]);
    }

    public function getSchedule($scheduleID)
    {
        $this->schedule = BranchSchedule::findOrFail($scheduleID);
        $this->interview_date = $this->schedule->interview_date;
        $this->available_slots = $this->schedule->available_slots;
        $this->schedule_id = $this->schedule->schedule_id;
    }

    public function submitSchedule()
    {
        $this->validate();

        if ($this->submit_func == 'add-schedule') {
            BranchSchedule::create([
                'interview_date' => $this->interview_date,
                'available_slots' => $this->available_slots,
                'branch_id' => Auth::guard('employee')->user()->branch_id,
            ]);

            session()->flash('message', 'Schedule successfully added!');
        } elseif ($this->submit_func == 'edit-schedule') {
            $this->schedule->update([
                'interview_date' => $this->interview_date,
                'available_slots' => $this->available_slots,
            ]);

            session()->flash('message', 'Schedule successfully updated!');
        }

        return redirect()->route('branch-schedules');
    }

    public function render()
    {
        $this->getTotalSchedules();
        return view('livewire.content.branch-schedule-management');
    }
}
