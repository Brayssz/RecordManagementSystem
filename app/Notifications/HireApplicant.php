<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\ApplicationForm;

class HireApplicant extends Notification
{
    use Queueable;

    public $application_id; 

    /**
     * Create a new notification instance.
     */
    public function __construct($application_id)
    {
        $this->application_id = $application_id;
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
        $application = ApplicationForm::find($this->application_id)->with('applicant', 'job')->first();
        $middleInitial = $application->applicant->middle_name ? ' ' . strtoupper(substr($application->applicant->middle_name, 0, 1)) . '.' : '';
        $applicantName = $application->applicant->first_name . $middleInitial . ' ' . $application->applicant->last_name;
        $jobTitle = $application->job->job_title;

        return (new MailMessage)
            ->subject('Congratulations! You Have Been Hired')
            ->greeting('Dear ' . $applicantName . ',')
            ->line('We are pleased to inform you that you have been hired for the position of **' . $jobTitle . '**.')
            ->line('Please prepare the following documents for submission:')
            ->line('You will receive further information regarding your departure date via email.')
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
