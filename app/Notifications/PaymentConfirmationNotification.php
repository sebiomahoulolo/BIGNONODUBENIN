<?php

namespace App\Notifications;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PaymentConfirmationNotification extends Notification implements ShouldQueue
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
            ->subject('Confirmation de paiement - Commande #' . $this->order->id)
            ->greeting('Bonjour ' . $notifiable->name)
            ->line('Nous avons bien reçu votre paiement.')
            ->line('Numéro de commande : #' . $this->order->id)
            ->line('Montant payé : ' . number_format($this->order->total, 0, ',', ' ') . ' FCFA')
            ->action('Voir ma commande', route('orders.show', $this->order))
            ->line('Merci de votre confiance !');
    }

    public function toArray($notifiable)
    {
        return [
            'order_id' => $this->order->id,
            'message' => 'Paiement confirmé pour la commande #' . $this->order->id,
            'amount' => $this->order->total,
        ];
    }
} 