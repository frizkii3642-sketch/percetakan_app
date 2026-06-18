<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Product;
use App\Enums\StatusPesanan;
use App\Enums\TipeProduk;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::where('user_id', Auth::id())->latest()->get();
        
        return view('order.index', compact('orders'));
    }

    public function create($kategori)
    {
        $kategori_format = strtoupper(str_replace('-', '_', $kategori));
        $kategori_valid = ['BANNER', 'DTF', 'ART_PAPER'];
        if (!in_array($kategori_format, $kategori_valid)) {
            abort(404);
        }

        $products = Product::where('tipe', $kategori_format)->get();

        return view('order.create', compact('products', 'kategori_format'));
    }

    public function cancel($id)
    {
        $order = Order::where('user_id', Auth::id())->findOrFail($id);
        $order->update(['status' => \App\Enums\StatusPesanan::DIBATALKAN]);

        return back()->with('success', 'Pesanan berhasil dibatalkan.');
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'panjang' => 'nullable|numeric|min:0.1',
            'lebar' => 'nullable|numeric|min:0.1',
            'qty' => 'required|integer|min:1',
            'file_desain' => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120',
        ]);

        $product = Product::findOrFail($request->product_id);
        $total_harga = 0;

        $panjang = $request->panjang;
        $lebar = $request->lebar;

        if ($product->tipe === TipeProduk::BANNER) {
            if (!$panjang || !$lebar) {
                return back()->withErrors(['error' => 'Untuk cetak BANNER, Panjang dan Lebar wajib diisi!'])->withInput();
            }
            $total_harga = $panjang * $lebar * $product->harga * $request->qty;

        } elseif ($product->tipe === TipeProduk::DTF) {
            if (!$panjang) {
                return back()->withErrors(['error' => 'Untuk cetak DTF, Panjang wajib diisi!'])->withInput();
            }
            $total_harga = $panjang * $product->harga * $request->qty;
            $lebar = null; // Aman: kita hanya mengubah variabel lokal, bukan $request

        } elseif ($product->tipe === TipeProduk::ART_PAPER) {
            $total_harga = $product->harga * $request->qty;
            $panjang = null;
            $lebar = null;
        }

        $path_file = $request->file('file_desain')->store('desain_pelanggan', 'public');
        $nomor_invoice = 'INV-' . date('Ymd') . '-' . strtoupper(Str::random(5));

        $order = Order::create([
            'user_id' => Auth::id(),
            'product_id' => $product->id,
            'nomor_invoice' => $nomor_invoice,
            'panjang' => $panjang,
            'lebar' => $lebar,
            'qty' => $request->qty,
            'total_harga' => $total_harga,
            'file_desain' => $path_file,
            'status' => StatusPesanan::MENUNGGU_PEMBAYARAN,
        ]);

        return redirect()->route('order.invoice', $order->nomor_invoice)
        ->with('success', 'Pesanan berhasil dibuat!');
    }

    public function invoice($nomor_invoice)
    {
        $order = Order::where('nomor_invoice', $nomor_invoice)->firstOrFail();
        return view('order.invoice', compact('order'));
    }
}