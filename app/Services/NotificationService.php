<?php

namespace App\Services;

use App\Models\Notification;
use App\Models\User;

class NotificationService
{
    /**
     * Kirim notifikasi ke user tertentu.
     * Cek pengaturan notifikasi user sebelum membuat notifikasi.
     */
    public static function send(int $userId, string $type, string $title, string $body, ?string $actionUrl = null): void
    {
        // Cek pengaturan notifikasi user
        $user = User::find($userId);
        if ($user) {
            // Kalau notif_pesanan dimatikan, skip semua tipe pesanan
            if ($type === 'pesanan' && !$user->notif_pesanan) return;
            // Kalau notif_promo dimatikan, skip tipe promo
            if ($type === 'promo' && !$user->notif_promo) return;
            // Kalau notif_whatsapp dimatikan, skip tipe whatsapp
            if ($type === 'whatsapp' && !$user->notif_whatsapp) return;
        }

        $defaults = Notification::defaults($type);

        Notification::create([
            'user_id'    => $userId,
            'type'       => $type,
            'title'      => $title,
            'body'       => $body,
            'icon'       => $defaults['icon'],
            'color'      => $defaults['color'],
            'action_url' => $actionUrl,
            'is_read'    => false,
        ]);
    }

    // ─── Pesanan ─────────────────────────────────────────────────────────────

    public static function pesananMasuk(int $userId, string $orderNumber): void
    {
        self::send(
            $userId,
            'pesanan',
            'Pesanan Berhasil Dibuat! 🎉',
            "Pesanan #{$orderNumber} kamu sudah kami terima dan sedang menunggu konfirmasi.",
            route('customer.pesanan')
        );
    }

    public static function pesananDiproses(int $userId, string $orderNumber): void
    {
        self::send(
            $userId,
            'pesanan',
            'Pesanan Sedang Dikemas 📦',
            "Pesanan #{$orderNumber} kamu sedang kami siapkan. Tunggu sebentar ya!",
            route('customer.pesanan')
        );
    }

    public static function pesananSiap(int $userId, string $orderNumber, string $deliveryMethod): void
    {
        $isPickup = $deliveryMethod === 'pickup';
        self::send(
            $userId,
            'pesanan',
            $isPickup ? 'Pesanan Siap Diambil! 🛍️' : 'Pesanan Siap Dikirim! 🚗',
            $isPickup
                ? "Pesanan #{$orderNumber} sudah siap. Silakan datang ke toko untuk mengambil pesananmu."
                : "Pesanan #{$orderNumber} sedang dalam perjalanan menuju alamatmu.",
            route('customer.pesanan')
        );
    }

    public static function pesananSelesai(int $userId, string $orderNumber): void
    {
        self::send(
            $userId,
            'pesanan',
            'Pesanan Selesai ✅',
            "Pesanan #{$orderNumber} telah selesai. Terima kasih sudah berbelanja di Kuesaena! Jangan lupa kasih ulasan ya 😊",
            route('customer.pesanan')
        );
    }

    public static function pesananDibatalkan(int $userId, string $orderNumber): void
    {
        self::send(
            $userId,
            'pesanan',
            'Pesanan Dibatalkan ❌',
            "Pesanan #{$orderNumber} telah dibatalkan. Hubungi kami jika ada pertanyaan.",
            route('customer.pesanan')
        );
    }

    // ─── Review ───────────────────────────────────────────────────────────────

    public static function ulasanTersimpan(int $userId): void
    {
        self::send(
            $userId,
            'pesanan',
            'Ulasan Berhasil Disimpan ⭐',
            'Terima kasih atas ulasanmu! Pendapatmu sangat berarti bagi kami.',
            null
        );
    }
}