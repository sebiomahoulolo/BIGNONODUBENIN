<?php

namespace App\Notifications;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewOrderNotification extends Notification implements ShouldQueue
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
            ->subject('Nouvelle commande #' . $this->order->id)
            ->greeting('Bonjour ' . $notifiable->name)
            ->line('Une nouvelle commande a été passée.')
            ->line('Numéro de commande : #' . $this->order->id)
            ->line('Montant total : ' . number_format($this->order->total, 0, ',', ' ') . ' FCFA')
            ->action('Voir la commande', route('admin.orders.show', $this->order))
            ->line('Merci de traiter cette commande dans les plus brefs délais.');
    }

    public function toArray($notifiable)
    {
        return [
            'order_id' => $this->order->id,
            'message' => 'Nouvelle commande #' . $this->order->id,
            'total' => $this->order->total,
        ];
    }
} 