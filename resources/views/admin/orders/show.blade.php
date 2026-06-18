<x-app-layout>
    <x-slot name="header">
         <h2 class="w-full text-center font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Detail Pesanan: ') }} <span class="text-blue-600">{{ $order->nomor_invoice }}</span>
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-100 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="mb-6">
                <a href="{{ route('admin.orders.index') }}" class="inline-flex items-center text-blue-600 hover:text-blue-800 font-semibold transition-colors bg-white px-4 py-2 rounded-lg shadow-sm border border-gray-200">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    Kembali ke Daftar Pesanan
                </a>
            </div>

            @if(session('success'))
                <div class="mb-6 p-4 bg-green-100 border-l-4 border-green-500 text-green-700 rounded-lg font-semibold shadow-sm">
                    {{ session('success') }}
                </div>
            @endif

            <div class="space-y-8">
                
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    
                    <div class="lg:col-span-2 bg-white rounded-xl shadow-md border border-gray-200 overflow-hidden flex flex-col">
                        <div class="bg-blue-50 px-6 py-4 border-b border-blue-100">
                            <h3 class="text-lg font-extrabold text-blue-900">Informasi Pemesan & Pesanan</h3>
                        </div>
                        
                        <div class="p-6 grid grid-cols-2 md:grid-cols-3 gap-6 text-sm flex-1">
                            <div class="bg-gray-50 p-4 rounded-lg border border-gray-200 shadow-sm col-span-2 md:col-span-1">
                                <p class="text-gray-500 text-xs uppercase tracking-wider font-bold mb-1">Pelanggan</p>
                                <p class="font-extrabold text-gray-800 text-base">{{ $order->user->name }}</p>
                                <p class="text-gray-600">{{ $order->user->email }}</p>
                            </div>
                            <div class="bg-gray-50 p-4 rounded-lg border border-gray-200 shadow-sm">
                                <p class="text-gray-500 text-xs uppercase tracking-wider font-bold mb-1">Tanggal</p>
                                <p class="font-extrabold text-gray-800 text-base">{{ $order->created_at->format('d M Y, H:i') }}</p>
                            </div>
                            <div class="bg-gray-50 p-4 rounded-lg border border-gray-200 shadow-sm">
                                <p class="text-gray-500 text-xs uppercase tracking-wider font-bold mb-1">Layanan</p>
                                <p class="font-extrabold text-gray-800 text-base">{{ $order->product->nama }}</p>
                                <p class="text-gray-600">{{ $order->product->tipe->value }}</p>
                            </div>
                            
                            <div class="bg-gray-50 p-4 rounded-lg border border-gray-200 shadow-sm">
                                <p class="text-gray-500 text-xs uppercase tracking-wider font-bold mb-1">Dimensi</p>
                                <p class="font-extrabold text-gray-800 text-base">
                                    @if($order->panjang && $order->lebar) {{ $order->panjang }}m x {{ $order->lebar }}m @elseif($order->panjang) P: {{ $order->panjang }}m @else - @endif
                                </p>
                            </div>

                            <div class="bg-gray-50 p-4 rounded-lg border border-gray-200 shadow-sm">
                                <p class="text-gray-500 text-xs uppercase tracking-wider font-bold mb-1">Jumlah (Qty)</p>
                                <p class="font-extrabold text-gray-800 text-base">{{ $order->qty }}</p>
                            </div>

                            <div class="bg-blue-100 p-5 rounded-lg border border-blue-200 shadow-sm col-span-2 md:col-span-3 flex justify-between items-center mt-2">
                                <p class="text-blue-900 text-sm uppercase tracking-wider font-extrabold">Total Tagihan:</p>
                                <p class="font-extrabold text-blue-700 text-3xl">Rp {{ number_format($order->total_harga, 0, ',', '.') }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-xl shadow-md border border-gray-200 overflow-hidden flex flex-col">
                        <div class="bg-indigo-50 px-6 py-4 border-b border-indigo-100">
                            <h3 class="text-lg font-extrabold text-indigo-900">File Desain Pelanggan</h3>
                        </div>
                        <div class="p-6 flex-1 flex flex-col justify-center">
                            
                            @if(str_ends_with(strtolower($order->file_desain), '.pdf'))
                                <div class="w-full bg-gray-50 p-4 rounded-lg border border-gray-200 shadow-sm mb-4 flex flex-col items-center justify-center" style="height: 150px;">
                                    <svg class="w-16 h-16 text-red-500 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                                    <span class="font-bold text-gray-700">Dokumen PDF</span>
                                </div>
                            @else
                                <div class="text-center mb-4">
                                    <a href="{{ asset('storage/' . $order->file_desain) }}" target="_blank" class="block w-full bg-gray-50 p-2 rounded-lg border border-gray-200 hover:bg-gray-100 transition-colors shadow-sm">
                                        <img src="{{ asset('storage/' . $order->file_desain) }}" alt="Preview Desain" class="rounded shadow-sm mx-auto" style="height: 150px; width: 100%; object-fit: contain;">
                                    </a>
                                    <p class="text-xs text-gray-500 mt-2 font-bold uppercase tracking-wider">Klik gambar untuk perbesar</p>
                                </div>
                            @endif

                            <a href="{{ asset('storage/' . $order->file_desain) }}" target="_blank" download class="w-full bg-indigo-600 text-white py-3 rounded-lg hover:bg-indigo-700 font-extrabold text-sm shadow-md transition-colors flex justify-center items-center gap-2 mt-auto">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                                Download Desain
                            </a>
                        </div>
                    </div>

                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    
                    <div class="bg-white rounded-xl shadow-md border border-gray-200 overflow-hidden flex flex-col">
                        <div class="bg-gray-50 px-6 py-4 border-b border-gray-200">
                            <h3 class="text-lg font-extrabold text-gray-800">Verifikasi Pembayaran</h3>
                        </div>
                        <div class="p-6 flex-1 flex flex-col">
                            @if(!$order->payment)
                                <div class="text-center py-8 bg-red-50 text-red-600 rounded-lg border border-red-200 shadow-inner flex-1 flex flex-col justify-center">
                                    <svg class="w-12 h-12 mx-auto mb-3 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    <p class="font-bold">Belum ada bukti transfer.</p>
                                </div>
                            @else
                                <div class="mb-6 flex flex-col items-center">
                                    <a href="{{ asset('storage/' . $order->payment->bukti_transfer) }}" target="_blank" class="block bg-gray-50 p-2 rounded-lg border border-gray-200 hover:bg-gray-100 transition-colors shadow-sm">
                                        <img src="{{ asset('storage/' . $order->payment->bukti_transfer) }}" alt="Bukti Transfer" class="rounded shadow-sm mx-auto" style="width: 150px; height: 150px; object-fit: cover;">
                                    </a>
                                    <p class="text-xs text-gray-500 mt-2 font-bold uppercase tracking-wider">Klik gambar untuk perbesar</p>
                                </div>

                                <div class="mb-6 text-center">
                                    <p class="text-xs text-gray-500 uppercase tracking-wider font-bold mb-2">Status Pembayaran</p>
                                    <span class="inline-block px-4 py-2 rounded-md text-sm font-extrabold uppercase tracking-wider shadow-sm
                                        {{ $order->payment->status->value === 'pending' ? 'bg-yellow-100 text-yellow-800 border border-yellow-300' : ($order->payment->status->value === 'disetujui' ? 'bg-green-100 text-green-800 border border-green-300' : 'bg-red-100 text-red-800 border border-red-300') }}">
                                        {{ $order->payment->status->value }}
                                    </span>
                                </div>

                                @if($order->payment->status->value === 'pending')
                                    <form action="{{ route('admin.orders.update_payment', $order->id) }}" method="POST" class="grid grid-cols-2 gap-4 mt-auto">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" name="status" value="disetujui" class="w-full bg-green-600 text-white py-3 rounded-lg hover:bg-green-700 font-bold text-sm shadow transition-colors">Setujui</button>
                                        <button type="submit" name="status" value="ditolak" class="w-full bg-red-600 text-white py-3 rounded-lg hover:bg-red-700 font-bold text-sm shadow transition-colors">Tolak</button>
                                    </form>
                                @endif
                            @endif
                        </div>
                    </div>

                    <div class="bg-white rounded-xl shadow-md border border-gray-200 overflow-hidden flex flex-col">
                        <div class="bg-gray-50 px-6 py-4 border-b border-gray-200">
                            <h3 class="text-lg font-extrabold text-gray-800">Proses Antrian Cetak</h3>
                        </div>
                        <div class="p-6 flex flex-col flex-1">
                            <form action="{{ route('admin.orders.update_status', $order->id) }}" method="POST" class="flex flex-col flex-1">
                                @csrf
                                @method('PATCH')
                                <div class="mb-6 flex-1">
                                    <label class="block text-sm uppercase tracking-wider font-bold text-gray-700 mb-3">Pembaruan Status</label>
                                    <select name="status" class="w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-lg shadow-sm bg-gray-50 text-gray-900 font-bold p-4 cursor-pointer">
                                        @foreach($statuses as $status)
                                            <option value="{{ $status->value }}" {{ $order->status->value === $status->value ? 'selected' : '' }}>
                                                {{ $status->value }}
                                            </option>
                                        @endforeach
                                    </select>
                                    
                                    <div class="mt-6 bg-blue-50 border-l-4 border-blue-500 p-4 rounded-r-lg">
                                        <p class="text-sm text-blue-800 leading-relaxed font-medium">Pilih <strong>Masuk Antrian Cetak</strong> jika pembayaran sudah diverifikasi dan desain siap dikerjakan. Pilih <strong>Selesai</strong> jika barang sudah jadi dan siap diambil pelanggan.</p>
                                    </div>
                                </div>
                                <button type="submit" class="w-full bg-blue-600 text-white py-3 rounded-lg hover:bg-blue-700 font-extrabold shadow-md transition-colors mt-auto text-lg">
                                    Simpan Perubahan Status
                                </button>
                            </form>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>