<?php

namespace App\Services;

use App\Models\User;
use App\Models\Order;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;

class NotificationService
{
    /**
     * Envoyer une notification pour une nouvelle commande
     */
    public function notifyNewOrder(Order $order)
    {
        // Notifier l'administrateur
        $admin = User::where('is_admin', true)->first();
        if ($admin) {
            Notification::send($admin, new \App\Notifications\NewOrderNotification($order));
        }

        // Notifier le client
        if ($order->user) {
            Notification::send($order->user, new \App\Notifications\OrderConfirmationNotification($order));
        }
    }

    /**
     * Envoyer une notification pour le statut d'une commande
     */
    public function notifyOrderStatus(Order $order)
    {
        if ($order->user) {
            Notification::send($order->user, new \App\Notifications\OrderStatusNotification($order));
        }
    }

    /**
     * Envoyer une notification pour le paiement
     */
    public function notifyPayment(Order $order)
    {
        if ($order->user) {
            Notification::send($order->user, new \App\Notifications\PaymentConfirmationNotification($order));
        }
    }
}