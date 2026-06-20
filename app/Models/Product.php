<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Enums\TipeProduk;

class Product extends Model
{
    protected $guarded = [];

    protected $casts = [
        'tipe' => 'string',
    ];

    // Relasi: Produk ini dipakai di banyak pesanan
    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}