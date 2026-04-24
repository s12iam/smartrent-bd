<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class BookingRejectedNotification extends Notification
{
    use Queueable;

    protected $booking;

    public function __construct($booking)
    {
        $this->booking = $booking;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toArray($notifiable)
    {
        return [
            'message' => 'Your booking request has been rejected.',
            'booking_id' => $this->booking->id,
            'property_id' => $this->booking->property_id,
            'owner_id' => $this->booking->owner_id,
        ];
    }
}