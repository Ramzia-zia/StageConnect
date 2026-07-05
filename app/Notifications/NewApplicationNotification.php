<?php

namespace App\Notifications;

use App\Models\Offer;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\DatabaseMessage;

class NewApplicationNotification extends Notification
{
    use Queueable;

    public function __construct(public Offer $offer, public User $student) {}

    public function via(object $notifiable): array
    {
        return ['database'];
    }

        public function toDatabase(object $notifiable): DatabaseMessage
    {
        return new DatabaseMessage([
            'message' => "{$this->student->name} a postulé à votre offre : {$this->offer->title}",
            'offer_id' => $this->offer->id,
            'action_url' => route('offers.applications.offer', $this->offer)
        ]);
    }
}