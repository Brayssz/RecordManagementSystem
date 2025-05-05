<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\ApplicationForm;

class HiredApplicantBranchNotification extends Notification
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
        return ['database'];
    }
    
    public function toDatabase(object $notifiable): array
    {
        $application = ApplicationForm::where('application_id', $this->application_id)->with('applicant', 'job')->first();

        $middle_name_initial = $application->applicant->middle_name ? ' ' . substr($application->applicant->middle_name, 0, 1) . '.' : '';

        $message = 'Applicant ' . $application->applicant->first_name . $middle_name_initial . ' ' . $application->applicant->last_name . ' has been hired for the position of ' . $application->job->job_title . ' at your branch.' ; 

        return [
            'message' => $message,
            'type' => 'HiredApplicant'
        ];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->line('The introduction to the notification.')
            ->action('Notification Action', url('/'))
            ->line('Thank you for using our application!');
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
