<x-app-layout>
    <x-slot name="header">
    <h2 class="w-full text-center font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Riwayat Pesanan Saya') }}
    </h2>
</x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                
                <h3 class="text-lg font-bold mb-4 text-gray-800">Daftar Transaksi Anda</h3>

                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse border border-gray-300 shadow-sm">
                        <thead>
                            <tr class="bg-gray-200 text-gray-800 uppercase text-sm tracking-wider">
                                <th class="p-4 border border-gray-400">Tanggal</th>
                                <th class="p-4 border border-gray-400">No. Invoice</th>
                                <th class="p-4 border border-gray-400">Layanan</th>
                                <th class="p-4 border border-gray-400">Total Tagihan</th>
                                <th class="p-4 border border-gray-400 text-center">Status</th>
                                <th class="p-4 border border-gray-400 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="text-sm">
                            @foreach($orders as $order)
                            <tr class="border-b hover:bg-gray-50 transition-colors">
                                <td class="p-4 border border-gray-300 text-gray-600">{{ $order->created_at->format('d M Y') }}</td>
                                <td class="p-4 border border-gray-300 font-semibold text-gray-800">{{ $order->nomor_invoice }}</td>
                                <td class="p-4 border border-gray-300 text-gray-600">{{ $order->product->nama }}</td>
                                <td class="p-4 border border-gray-300 font-bold text-gray-800">Rp {{ number_format($order->total_harga, 0, ',', '.') }}</td>
                                <td class="p-4 border border-gray-300 text-center">
                                    @if($order->status->value === 'Selesai')
                                        <span class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-xs font-bold">{{ $order->status->value }}</span>
                                    @elseif($order->status->value === 'Menunggu Pembayaran')
                                        <span class="px-3 py-1 bg-red-100 text-red-700 rounded-full text-xs font-bold">{{ $order->status->value }}</span>
                                    @else
                                        <span class="px-3 py-1 bg-yellow-100 text-yellow-800 rounded-full text-xs font-bold">{{ $order->status->value }}</span>
                                    @endif
                                </td>
                                <td class="p-4 border border-gray-300 text-center space-y-2">
                                    <a href="{{ route('order.invoice', $order->nomor_invoice) }}" class="block text-blue-600 hover:text-blue-800 font-semibold underline text-sm">Lihat Nota</a>
                                    
                                    @if(!$order->payment && $order->status->value === 'Menunggu Pembayaran')
                                        <a href="{{ route('order.invoice', $order->nomor_invoice) }}#form-pembayaran" class="inline-block bg-red-500 text-white px-3 py-1 rounded text-xs font-bold hover:bg-red-600 shadow-sm transition-colors">
                                            Upload Bukti
                                        </a>
                                    @endif
                                </td>
                            </tr>
                            @endforeach

                            @if($orders->isEmpty())
                            <tr>
                                <td colspan="6" class="p-8 border border-gray-300 text-center text-gray-500">
                                    Belum ada pesanan. <br>
                                    <a href="{{ route('dashboard') }}" class="text-blue-600 hover:underline mt-2 inline-block">Buat pesanan pertama Anda &rarr;</a>
                                </td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>