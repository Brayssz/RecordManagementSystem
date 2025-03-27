<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\ApplicationForm;

class Reschedule extends Notification
{
    use Queueable;

    public $application_id; 
    public $new_schedule;

    /**
     * Create a new notification instance.
     */
    public function __construct($application_id, $new_schedule)
    {
        $this->application_id = $application_id;
        $this->new_schedule = $new_schedule;
    }
    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $application = ApplicationForm::where('application_id', $this->application_id)->with('applicant', 'job')->first();
        $middleInitial = $application->applicant->middle_name ? ' ' . strtoupper(substr($application->applicant->middle_name, 0, 1)) . '.' : '';
        $applicantName = $application->applicant->first_name . $middleInitial . ' ' . $application->applicant->last_name;
        $jobTitle = $application->job->job_title;
        $newSchedule = $this->new_schedule; 

        return (new MailMessage)
            ->subject('Important: Your Job Interview Schedule Has Been Rescheduled')
            ->greeting('Dear ' . $applicantName . ',')
            ->line('We would like to inform you that your interview for the position of **' . $jobTitle . '** has been rescheduled.')
            ->line('📅 **New Schedule:** ' . $newSchedule)
            ->action('Visit Site', url('/'))
            ->line('If you have any questions, feel free to contact us.');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
