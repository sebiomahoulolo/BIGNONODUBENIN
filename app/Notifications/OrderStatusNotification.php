<?php

namespace App\Notifications;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OrderStatusNotification extends Notification implements ShouldQueue
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
            ->subject('Mise à jour de votre commande #' . $this->order->id)
            ->greeting('Bonjour ' . $notifiable->name)
            ->line('Le statut de votre commande a été mis à jour.')
            ->line('Numéro de commande : #' . $this->order->id)
            ->line('Nouveau statut : ' . $this->order->status)
            ->action('Voir ma commande', route('orders.show', $this->order))
            ->line('Nous vous tiendrons informé des prochaines mises à jour.');
    }

    public function toArray($notifiable)
    {
        return [
            'order_id' => $this->order->id,
            'message' => 'Le statut de votre commande #' . $this->order->id . ' a été mis à jour',
            'status' => $this->order->status,
        ];
    }
} 