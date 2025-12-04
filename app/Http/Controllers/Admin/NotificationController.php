<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = Notification::latest()->paginate(20);
        return view('admin.notifications.index', compact('notifications'));
    }

    public function getUnread()
    {
        $notifications = Notification::unread()
            ->latest()
            ->limit(10)
            ->get();

        $unreadCount = Notification::unread()->count();

        return response()->json([
            'success' => true,
            'unread_count' => $unreadCount,
            'notifications' => $notifications,
        ]);
    }

    public function markAsRead(Notification $notification)
    {
        $notification->markAsRead();

        return response()->json([
            'success' => true,
            'message' => 'Notifikasi ditandai sudah dibaca',
        ]);
    }

    public function markAllAsRead()
    {
        Notification::unread()->update([
            'is_read' => true,
            'read_at' => now(),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Semua notifikasi ditandai sudah dibaca',
        ]);
    }

    public function destroy(Notification $notification)
    {
        $notification->delete();

        if (request()->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Notifikasi dihapus',
            ]);
        }

        return redirect()->back()->with('success', 'Notifikasi dihapus');
    }
}
