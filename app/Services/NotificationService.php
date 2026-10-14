<?php

namespace App\Services;

use App\Models\Notification;
use App\Models\Order;

class NotificationService
{
    /**
     * Créer une notification
     */
    public function create($userId, $type, $title, $message, $link = null, $isCustomer = false)
    {
        $data = [
            'type' => $type,
            'title' => $title,
            'message' => $message,
            'link' => $link,
            'is_read' => false
        ];

        if ($isCustomer) {
            $data['customer_id'] = $userId;
        } else {
            $data['user_id'] = $userId;
        }

        return Notification::create($data);
    }

    /**
     * Notifier un changement de statut de commande
     */
    public function notifyOrderStatusChange(Order $order)
    {
        if (!$order->customer_id) {
            return;
        }

        $statusMessages = [
            'En Cours' => 'Votre commande est en cours de traitement.',
            'Livré' => 'Votre commande a été livrée avec succès.',
            'Annulé' => 'Votre commande a été annulée.'
        ];

        $message = $statusMessages[$order->status] ?? 'Le statut de votre commande a changé.';

        return $this->create(
            $order->customer_id,
            'order_status',
            'Statut de commande mis à jour',
            $message,
            route('admin.orders.show', $order->id)
        );
    }

    /**
     * Notifier un changement de statut de paiement
     */
    public function notifyPaymentStatusChange(Order $order)
    {
        // Cette méthode n'est plus utilisée avec la structure actuelle
        // mais conservée pour compatibilité
        return null;
    }

    /**
     * Marquer une notification comme lue
     */
    public function markAsRead(Notification $notification)
    {
        $notification->update(['is_read' => true]);
        return $notification;
    }

    /**
     * Marquer toutes les notifications comme lues
     */
    public function markAllAsRead($userId, $isCustomer = false)
    {
        $query = Notification::where('is_read', false);
        
        if ($isCustomer) {
            $query->where('customer_id', $userId);
        } else {
            $query->where('user_id', $userId);
        }
        
        return $query->update(['is_read' => true]);
    }

    /**
     * Obtenir le nombre de notifications non lues
     */
    public function getUnreadCount($userId, $isCustomer = false)
    {
        $query = Notification::where('is_read', false);
        
        if ($isCustomer) {
            $query->where('customer_id', $userId);
        } else {
            $query->where('user_id', $userId);
        }
        
        return $query->count();
    }

    /**
     * Notifier une nouvelle commande
     */
    public function notifyNewOrder(Order $order)
    {
        if (!$order->customer_id) {
            return;
        }

        return $this->create(
            $order->customer_id,
            'new_order',
            'Nouvelle commande',
            "Votre commande #{$order->order_number} a été créée avec succès.",
            route('admin.orders.show', $order->id),
            true // isCustomer = true
        );
    }
}
