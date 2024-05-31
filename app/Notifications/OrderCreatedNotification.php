<?php

namespace App\Notifications;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OrderCreatedNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    protected $order;

    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $addr = $this->order->billingAddress;

        return (new MailMessage)
            ->subject("New Order #{$this->order->number}")
            ->from('notification@multi_store.com', 'MultiStore') //will replace the default value from .env
            ->greeting("Hi {$notifiable->name}")
            ->line("A new Order ({$this->order->number}) has been created by {$addr->name} from {$addr->country_name}") //paragraph
            ->action('View Order', url('/dashboard')) // button
            ->line('Thank you for using our application!'); // paragraph
    }

    public function toDatabase(object $notifiable)
    {
        $addr = $this->order->billingAddress;

        return [
            'message' => "A new Order ({$this->order->number}) has been created by {$addr->name} from {$addr->country_name}",
            'icon' => 'fas fa-file',
            'url' => url('/dashboard'),
            'order_id' => $this->order->id
        ];
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
