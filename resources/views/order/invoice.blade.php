<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Nota Pesanan') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            
            @if(session('success'))
                <div class="mb-4 p-4 bg-green-100 text-green-700 rounded-md">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border-t-4 border-blue-600">
                <div class="flex justify-between items-center mb-6 border-b pb-4">
                    <div>
                        <h3 class="text-2xl font-bold text-gray-800">INVOICE</h3>
                        <p class="text-gray-500">{{ $order->nomor_invoice }}</p>
                    </div>
                    <div class="text-right">
                        <span class="px-3 py-1 bg-yellow-100 text-yellow-800 rounded-full text-sm font-semibold">
                            {{ $order->status->value }}
                        </span>
                        <p class="text-sm mt-2">Tanggal: {{ $order->created_at->format('d M Y, H:i') }}</p>
                    </div>
                </div>

                @if($order->status->value === 'Selesai')
                    <div class="mb-8 bg-green-50 border border-green-200 rounded-xl p-6 text-center shadow-sm">
                        <div class="w-8 h-8 bg-green-100 text-green-600 rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        </div>
                        <h4 class="text-2xl font-extrabold text-green-800 mb-2">Pesanan Telah Selesai!</h4>
                        <p class="text-green-700 font-medium">Pesanan Anda telah berhasil dicetak dan siap. <br>Silakan ambil ke tempat percetakan kami dengan menunjukkan <strong class="uppercase border-b-2 border-green-700">{{ $order->nomor_invoice }}</strong> ini sebagai bukti pengambilan.</p>
                    </div>
                @endif

                <div class="mb-6">
                    <h4 class="font-semibold text-lg border-b mb-2">Detail Pemesanan</h4>
                    <table class="w-full text-left text-sm">
                        <tr>
                            <th class="py-2 w-1/3">Produk / Layanan</th>
                            <td class="py-2">: {{ $order->product->nama }} ({{ $order->product->tipe->value }})</td>
                        </tr>
                        
                        @if($order->product->tipe === \App\Enums\TipeProduk::BANNER)
                            <tr>
                                <th class="py-2">Ukuran (P x L)</th>
                                <td class="py-2">: {{ $order->panjang }} meter x {{ $order->lebar }} meter</td>
                            </tr>
                        @elseif($order->product->tipe === \App\Enums\TipeProduk::DTF)
                            <tr>
                                <th class="py-2">Panjang Cetak</th>
                                <td class="py-2">: {{ $order->panjang }} meter</td>
                            </tr>
                        @endif
                        
                        <tr>
                            <th class="py-2">Jumlah (Qty)</th>
                            <td class="py-2">: {{ $order->qty }}</td>
                        </tr>
                        <tr>
                            <th class="py-2">Harga Dasar</th>
                            <td class="py-2">: Rp {{ number_format($order->product->harga, 0, ',', '.') }}</td>
                        </tr>
                    </table>
                </div>

                <div class="bg-gray-100 p-4 rounded-md flex justify-between items-center">
                    <span class="text-lg font-bold text-gray-700">TOTAL TAGIHAN:</span>
                    <span class="text-2xl font-extrabold text-blue-600">Rp {{ number_format($order->total_harga, 0, ',', '.') }}</span>
                </div>

                <div class="mt-8 border-t pt-6" id="form-pembayaran">
                    @if(!$order->payment)
                        <div class="bg-blue-50 rounded-lg p-6 border border-blue-100">
                            <h4 class="font-bold text-blue-800 mb-2">Instruksi Pembayaran</h4>
                            <p class="text-sm text-blue-700 mb-4">Silakan transfer sebesar <strong>Rp {{ number_format($order->total_harga, 0, ',', '.') }}</strong> ke rekening berikut:</p>
                            
                            <div class="bg-white p-3 rounded-md border border-gray-200 mb-4 flex items-center justify-between">
                                <div>
                                    <p class="text-xs text-gray-500 uppercase tracking-wider font-bold">Bank BCA</p>
                                    <p class="text-lg font-mono font-bold text-gray-800">123-456-7890</p>
                                    <p class="text-sm text-gray-600">a.n. Percetakan Digital</p>
                                </div>
                            </div>

                            <form action="{{ route('payment.store', $order->id) }}" method="POST" enctype="multipart/form-data" class="mt-4 space-y-4">
                                @csrf
                                
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Upload Bukti Transfer (JPG/PNG)</label>
                                    <input type="file" name="bukti_transfer" required accept="image/*" class="w-full border border-gray-300 p-2 rounded-md shadow-sm bg-white text-sm">
                                </div>
                                
                                <div>
                                    <button type="submit" class="w-full text-white font-bold py-3 px-4 rounded-lg shadow-md block text-center text-sm uppercase tracking-wider hover:opacity-90 transition-opacity" style="background-color: #16a34a !important; color: #ffffff !important;">
                                        Klik Disini Untuk Kirim Bukti Pembayaran
                                    </button>
                                </div>
                            </form>
                        </div>
                    @else
                        <div class="bg-gray-50 rounded-lg p-6 border border-gray-200 text-center">
                            @if($order->payment->status->value === 'pending')
                                <div class="text-yellow-600 mb-2">
                                    <svg class="w-12 h-12 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                </div>
                                <h4 class="font-bold text-lg text-gray-800">Pembayaran Sedang Diverifikasi</h4>
                                <p class="text-sm text-gray-500 mt-1">Kami telah menerima bukti pembayaran Anda. Admin kami akan segera memverifikasinya.</p>
                            @elseif($order->payment->status->value === 'disetujui')
                                <div class="text-green-600 mb-2">
                                    <svg class="w-12 h-12 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                </div>
                                <h4 class="font-bold text-lg text-gray-800">Pembayaran Berhasil!</h4>
                                <p class="text-sm text-gray-500 mt-1">Pesanan Anda sudah lunas dan segera masuk ke antrian cetak.</p>
                            @else
                                <div class="text-red-600 mb-2">
                                    <svg class="w-12 h-12 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                </div>
                                <h4 class="font-bold text-lg text-gray-800">Pembayaran Ditolak</h4>
                                <p class="text-sm text-gray-500 mt-1">Bukti pembayaran tidak valid. Silakan hubungi Admin.</p>
                            @endif
                        </div>
                    @endif
                </div>
                @if($order->status->value !== 'Selesai' && $order->status->value !== 'Dibatalkan')
                    <div class="mt-12 bg-red-50 border border-red-200 rounded-xl p-6 shadow-sm">
                        <h4 class="text-lg font-bold text-red-800 mb-2">Ingin Membatalkan Pesanan?</h4>
                        <p class="text-sm text-red-700 mb-4 leading-relaxed">
                            <strong>Peringatan PENTING:</strong> Jika Anda membatalkan pesanan ini, uang yang telah Anda transfer <strong>TIDAK DAPAT DIKEMBALIKAN (No Refund)</strong> dalam kondisi apapun. Harap pastikan keputusan Anda sebelum menekan tombol di bawah ini.
                        </p>
                        
                        <form action="{{ route('order.cancel', $order->id) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <button type="submit" onclick="return confirm('APAKAH ANDA YAKIN? Uang yang ditransfer tidak bisa dikembalikan.')" class="bg-red-600 text-white px-5 py-2.5 rounded-lg hover:bg-red-700 font-bold text-sm shadow-md transition-colors">
                                Ya, Batalkan Pesanan Ini
                            </button>
                        </form>
                    </div>
                @elseif($order->status->value === 'Dibatalkan')
                    <div class="mt-12 bg-gray-100 border border-gray-300 rounded-xl p-6 text-center shadow-sm">
                        <h4 class="text-xl font-bold text-gray-600 mb-1">Pesanan Dibatalkan</h4>
                        <p class="text-sm text-gray-500">Pesanan ini telah dibatalkan dan tidak akan diproses lebih lanjut.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>