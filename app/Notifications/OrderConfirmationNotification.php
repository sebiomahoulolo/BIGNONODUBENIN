<?php

namespace App\Notifications;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OrderConfirmationNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $order;

    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Confirmation de votre commande #' . $this->order->id)
            ->greeting('Bonjour ' . $notifiable->name)
            ->line('Nous avons bien reçu votre commande.')
            ->line('Numéro de commande : #' . $this->order->id)
            ->line('Montant total : ' . number_format($this->order->total, 0, ',', ' ') . ' FCFA')
            ->action('Voir ma commande', route('orders.show', $this->order))
            ->line('Nous vous tiendrons informé de l\'avancement de votre commande.');
    }

    public function toArray($notifiable)
    {
        return [
            'order_id' => $this->order->id,
            'message' => 'Votre commande #' . $this->order->id . ' a été confirmée',
            'total' => $this->order->total,
        ];
    }
} 