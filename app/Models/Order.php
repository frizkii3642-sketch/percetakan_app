<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Enums\StatusPesanan;

class Order extends Model
{
    protected $guarded = [];

    protected $casts = [
        'status' => StatusPesanan::class,
    ];

    // Relasi: Pesanan ini milik User siapa
    public function user() {
        return $this->belongsTo(User::class);
    }

    // Relasi: Pesanan ini untuk Produk apa
    public function product() {
        return $this->belongsTo(Product::class);
    }

    // Relasi: Pesanan ini punya 1 data pembayaran
    public function payment() {
        return $this->hasOne(Payment::class);
    }
}