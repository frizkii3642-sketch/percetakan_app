<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Enums\StatusPesanan;
use App\Enums\StatusPembayaran;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    // daftar pesanan 
    public function index()
    {
        $orders = Order::with(['user', 'product', 'payment'])->latest()->get();
        return view('admin.orders.index', compact('orders'));
    }

    // Detail Pesanan
    public function show($id)
    {
        $order = Order::with(['user', 'product', 'payment'])->findOrFail($id);

        $statuses = StatusPesanan::cases(); 

        return view('admin.orders.show', compact('order', 'statuses'));
    }

    // Verifikasi Pembayaran
    public function updatePayment(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:disetujui,ditolak'
        ]);

        $order = Order::findOrFail($id);

        if ($order->payment) {
            $order->payment->update([
                'status' => $request->status === 'disetujui' ? StatusPembayaran::DISETUJUI : StatusPembayaran::DITOLAK
            ]);

            if ($request->status === 'disetujui') {
                $order->update(['status' => StatusPesanan::MASUK_ANTRIAN_CETAK]);
            }
        }

        return back()->with('success', 'Status pembayaran berhasil diverifikasi!');
    }

    // Update Status Antrian Cetak
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|string'
        ]);

        $order = Order::findOrFail($id);
        $order->update(['status' => $request->status]);

        return back()->with('success', 'Status pesanan berhasil diperbarui!');
    }

    // Hapus pesanan
    public function destroy($id)
    {
        $order = Order::findOrFail($id);
        
        // Hapus file gambar dari penyimpanan agar tidak menumpuk
        if ($order->file_desain) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($order->file_desain);
        }
        if ($order->payment && $order->payment->bukti_transfer) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($order->payment->bukti_transfer);
        }

        // Hapus pesanan dari database
        $order->delete();

        return back()->with('success', 'Data pesanan berhasil dihapus secara permanen.');
    }
}