<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\ApplicationForm;

class NewApplicationNotification extends Notification
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

     /**
     * Get the database representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toDatabase(object $notifiable): array
    {
        $application = ApplicationForm::find($this->application_id)->with('job')->first();

        $message = 'New application from ' . $application->first_name . ' ' . $application->last_name . ' has been submitted for job ' . $application->job->job_title . '.' ; 

        return [
            'message' => $message,
            'type' => 'NewApplication'
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
