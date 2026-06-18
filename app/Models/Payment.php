<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Enums\StatusPembayaran;

class Payment extends Model
{
    protected $guarded = [];

    protected $casts = [
        'status' => StatusPembayaran::class,
    ];

    // Relasi: Pembayaran ini untuk pesanan mana
    public function order() {
        return $this->belongsTo(Order::class);
    }
}