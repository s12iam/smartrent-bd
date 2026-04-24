<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class BookingRequestedNotification extends Notification
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
            'message' => 'New booking request received.',
            'booking_id' => $this->booking->id,
            'property_id' => $this->booking->property_id,
            'tenant_id' => $this->booking->tenant_id,
        ];
    }
}