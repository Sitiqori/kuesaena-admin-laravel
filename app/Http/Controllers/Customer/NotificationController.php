<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    // Halaman semua notifikasi
    public function index()
    {
        $user = Auth::user();

        // Filter berdasarkan pengaturan notifikasi user
        $query = Notification::where('user_id', $user->id)->latest();

        $allowed = [];
        if ($user->notif_pesanan)  $allowed[] = 'pesanan';
        if ($user->notif_promo)    $allowed[] = 'promo';
        if ($user->notif_whatsapp) $allowed[] = 'whatsapp';
        $allowed[] = 'sistem';
        $query->whereIn('type', $allowed);

        $notifications = $query->get();

        // Mark all as read
        Notification::where('user_id', $user->id)
            ->where('is_read', false)
            ->update(['is_read' => true]);

        return view('customer.pages.notifikasi.index', compact('notifications'));
    }

    // Popup data (AJAX) - hanya 5 terbaru, belum dibaca
    public function popup()
    {
        $user = Auth::user();

        // Filter berdasarkan pengaturan notifikasi user
        $query = Notification::where('user_id', $user->id)->latest();

        $allowed = [];
        if ($user->notif_pesanan)  $allowed[] = 'pesanan';
        if ($user->notif_promo)    $allowed[] = 'promo';
        if ($user->notif_whatsapp) $allowed[] = 'whatsapp';
        // Selalu tampilkan tipe 'sistem'
        $allowed[] = 'sistem';

        $query->whereIn('type', $allowed);

        $notifications = $query->take(5)->get();

        $unread = (clone $query)->where('is_read', false)->count();

        return response()->json([
            'notifications' => $notifications,
            'unread'        => $unread,
        ]);
    }

    // Mark single as read
    public function markRead($id)
    {
        Notification::where('user_id', Auth::id())
            ->where('id', $id)
            ->update(['is_read' => true]);

        return response()->json(['success' => true]);
    }

    // Mark all as read
    public function markAllRead()
    {
        Notification::where('user_id', Auth::id())
            ->where('is_read', false)
            ->update(['is_read' => true]);

        return response()->json(['success' => true]);
    }

    // Delete single
    public function destroy($id)
    {
        Notification::where('user_id', Auth::id())->where('id', $id)->delete();
        return redirect()->back()->with('success', 'Notifikasi dihapus.');
    }

    // Delete all
    public function destroyAll()
    {
        Notification::where('user_id', Auth::id())->delete();
        return redirect()->back()->with('success', 'Semua notifikasi dihapus.');
    }
}