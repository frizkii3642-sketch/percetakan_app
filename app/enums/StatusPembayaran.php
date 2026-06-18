<?php
namespace App\Enums;

enum StatusPembayaran: string {
    case PENDING = 'pending';
    case DISETUJUI = 'disetujui';
    case DITOLAK = 'ditolak';
}