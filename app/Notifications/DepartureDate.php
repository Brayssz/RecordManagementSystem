<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\ApplicationForm;

class DepartureDate extends Notification
{
    use Queueable;

    public $application_id; 
    public $departure_date;

    /**
     * Create a new notification instance.
     */
    public function __construct($application_id, $departure_date)
    {
        $this->application_id = $application_id;
        $this->departure_date = $departure_date;
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

        dd($application);
        $middleInitial = $application->applicant->middle_name ? ' ' . strtoupper(substr($application->applicant->middle_name, 0, 1)) . '.' : '';
        $applicantName = $application->applicant->first_name . $middleInitial . ' ' . $application->applicant->last_name;
        $jobTitle = $application->job->job_title;
        $departureDate = $this->departure_date; 

        return (new MailMessage)
            ->subject('Important: Your Departure Date Information')
            ->greeting('Dear ' . $applicantName . ',')
            ->line('We are pleased to inform you that your departure date for the position of **' . $jobTitle . '** has been scheduled.')
            ->line('📅 ' . $departureDate)
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
