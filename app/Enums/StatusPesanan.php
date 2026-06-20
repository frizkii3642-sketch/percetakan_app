<?php

namespace App\Enums;

enum StatusPesanan: string {
    case MENUNGGU_PEMBAYARAN = 'Menunggu Pembayaran';
    case MASUK_ANTRIAN_CETAK = 'Masuk Antrian Cetak';
    case SELESAI = 'Selesai';
    case DIBATALKAN = 'Dibatalkan';
}