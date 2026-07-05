<?php

namespace App\Notifications;

use App\Models\Application;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\DatabaseMessage;

class ApplicationStatusNotification extends Notification
{
    use Queueable;

    public function __construct(public Application $application) {}

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toDatabase(object $notifiable): DatabaseMessage
    {
        $statusText = match($this->application->status) {
            'interview' => 'invité à un entretien pour',
            'accepted' => 'accepté pour le stage',
            'rejected' => 'refusé pour le stage',
            default => 'mis à jour pour'
        };

        return new DatabaseMessage([
            'message' => "Votre candidature pour '{$this->application->offer->title}' a été {$statusText}.",
            'action_url' => route('applications.my')
        ]);
    }
}