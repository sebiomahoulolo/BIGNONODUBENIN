<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use App\Services\NotificationService;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    protected $notificationService;

    public function __construct(NotificationService $notificationService)
    {
        $this->notificationService = $notificationService;
    }

    public function index()
    {
        $notifications = auth()->user()->notifications()
            ->latest()
            ->take(10)
            ->get();

        return view('admin.notifications.index', compact('notifications'));
    }

    public function markAsRead(Notification $notification)
    {
        $this->notificationService->markAsRead($notification);

        return back()->with('success', 'Notification marquée comme lue.');
    }

    public function markAllAsRead()
    {
        $this->notificationService->markAllAsRead(auth()->id());

        return back()->with('success', 'Toutes les notifications ont été marquées comme lues.');
    }

    public function getUnreadCount()
    {
        $count = $this->notificationService->getUnreadCount(auth()->id());

        return response()->json(['count' => $count]);
    }
} 