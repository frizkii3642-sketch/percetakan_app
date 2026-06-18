<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Payment;
use App\Enums\StatusPembayaran;

class PaymentController extends Controller
{
    public function store(Request $request, $order_id)
    {
        // 1. Validasi file gambar (maksimal 2MB)
        $request->validate([
            'bukti_transfer' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // 2. Pastikan pesanan itu benar-benar ada
        $order = Order::findOrFail($order_id);

        // 3. Simpan file foto ke folder storage/app/public/bukti_pembayaran
        $path_foto = $request->file('bukti_transfer')->store('bukti_pembayaran', 'public');

        // 4. Masukkan data ke tabel payments
        Payment::create([
            'order_id' => $order->id,
            'bukti_transfer' => $path_foto,
            'status' => StatusPembayaran::PENDING,
        ]);

        // 5. Kembalikan ke halaman nota dengan pesan sukses
        return back()->with('success', 'Bukti pembayaran berhasil diunggah! Silakan tunggu konfirmasi Admin.');
    }
}