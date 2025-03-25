<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\ApplicationForm;

class ApproveApplication extends Notification
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
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail($notifiable)
    {

        $required = ['Birth Certificate', 'Passport', 'Medical Certificate', 'NBI Clearance', 'Valid ID'];

        $documents = implode(', ', $required);

        $application = ApplicationForm::find($this->application_id)->with('applicant', 'job')->first();
        $middleInitial = $application->applicant->middle_name ? ' ' . strtoupper(substr($application->applicant->middle_name, 0, 1)) . '.' : '';
        $applicantName = $application->applicant->first_name . $middleInitial . ' ' . $application->applicant->last_name;
        $jobTitle = $application->job->job_title;

        return (new MailMessage)
            ->subject('Congratulations! Your Job Application Has Been Approved')
            ->greeting('Dear ' . $applicantName . ',')
            ->line('Congratulations! Your application for the job as **' . $jobTitle . '** has been approved.')
            ->line('Please prepare the following documents for submission:')
            ->line('📌 **Required Documents:** ' . $documents)
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
