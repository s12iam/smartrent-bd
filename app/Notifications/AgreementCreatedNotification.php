<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AgreementCreatedNotification extends Notification
{
    use Queueable;

    protected $agreement;

    public function __construct($agreement)
    {
        $this->agreement = $agreement;
    }

    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Rental Agreement Created')
            ->greeting('Hello ' . $notifiable->name)
            ->line('A rental agreement has been created for your booking.')
            ->line('Property: ' . ($this->agreement->property->title ?? 'Property'))
            ->line('Rent Amount: ' . number_format($this->agreement->rent_amount) . ' Tk')
            ->line('Start Date: ' . $this->agreement->start_date)
            ->line('End Date: ' . $this->agreement->end_date)
            ->action('View Agreement', route('agreements.show', $this->agreement))
            ->line('Thank you for using SmartRentBD.');
    }

    public function toArray($notifiable)
    {
        return [
            'message' => 'A rental agreement has been created for you.',
            'agreement_id' => $this->agreement->id,
            'property_id' => $this->agreement->property_id,
            'owner_id' => $this->agreement->owner_id,
        ];
    }
}