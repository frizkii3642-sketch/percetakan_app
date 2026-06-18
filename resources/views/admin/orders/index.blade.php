<x-app-layout>
    <x-slot name="header">
         <h2 class="w-full text-center font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Panel Admin - Kelola Pesanan') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-bold mb-4">Daftar Semua Pesanan Masuk</h3>

                <div class="overflow-x-auto mt-4">
                    <table class="w-full text-left border-collapse border border-gray-400 shadow-sm">
                        <thead>
                            <tr class="bg-gray-200 text-gray-800 uppercase text-sm tracking-wider">
                                <th class="py-4 px-6 border border-gray-400 font-bold">No. Invoice</th>
                                <th class="py-4 px-6 border border-gray-400 font-bold">Pelanggan</th>
                                <th class="py-4 px-6 border border-gray-400 font-bold">Layanan</th>
                                <th class="py-4 px-6 border border-gray-400 font-bold text-right">Total Bayar</th>
                                <th class="py-4 px-6 border border-gray-400 font-bold text-center">Status Pesanan</th>
                                <th class="py-4 px-6 border border-gray-400 font-bold text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="text-sm">
                            @foreach($orders as $order)
                            <tr class="hover:bg-blue-50 transition-colors duration-200 bg-white">
                                <td class="py-4 px-6 border border-gray-300 font-bold text-blue-700 whitespace-nowrap">
                                    {{ $order->nomor_invoice }}
                                </td>
                                <td class="py-4 px-6 border border-gray-300 font-medium text-gray-800">
                                    {{ $order->user->name }}
                                </td>
                                <td class="py-4 px-6 border border-gray-300 text-gray-700">
                                    {{ $order->product->nama }}
                                </td>
                                <td class="py-4 px-6 border border-gray-300 font-bold text-gray-800 text-right whitespace-nowrap">
                                    Rp {{ number_format($order->total_harga, 0, ',', '.') }}
                                </td>
                                <td class="py-4 px-6 border border-gray-300 text-center">
                                    <span class="px-3 py-1.5 rounded-full text-xs font-bold uppercase tracking-wider whitespace-nowrap
                                        {{ $order->status->value === 'Selesai' ? 'bg-green-100 text-green-800' : ($order->status->value === 'Menunggu Pembayaran' ? 'bg-red-100 text-red-800' : 'bg-yellow-100 text-yellow-800') }}">
                                        {{ $order->status->value }}
                                    </span>
                                </td>
                                <td class="py-4 px-6 border border-gray-300 text-center">
                                    <div class="flex flex-col gap-2 items-center w-28 mx-auto">
                                        <a href="{{ route('admin.orders.show', $order->id) }}" class="w-full bg-blue-600 text-white px-3 py-1.5 rounded-md hover:bg-blue-700 shadow-sm text-xs font-bold transition-transform hover:scale-105">
                                            Detail & Proses
                                        </a>
                                        
                                        <form action="{{ route('admin.orders.destroy', $order->id) }}" method="POST" class="w-full">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" onclick="return confirm('HAPUS PERMANEN? File desain dan bukti transfer juga akan terhapus dari sistem.')" class="w-full bg-red-600 text-white px-3 py-1.5 rounded-md hover:bg-red-700 shadow-sm text-xs font-bold transition-transform hover:scale-105">
                                                Hapus Pesanan
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach

                            @if($orders->isEmpty())
                            <tr>
                                <td colspan="6" class="py-10 border border-gray-300 text-center text-gray-500 text-base font-medium bg-white">
                                    Belum ada pesanan masuk.
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