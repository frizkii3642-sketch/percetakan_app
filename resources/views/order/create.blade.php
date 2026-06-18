<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Pesanan Baru: <span class="text-blue-600">{{ str_replace('_', ' ', $kategori_format) }}</span>
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            
            <div class="mb-6">
                <a href="{{ route('dashboard') }}" class="inline-flex items-center text-blue-600 hover:text-blue-800 font-semibold transition-colors bg-white px-4 py-2 rounded-lg shadow-sm border border-gray-200">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    Kembali ke Katalog
                </a>
            </div>

            <div class="bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden">
                
                <div class="bg-gradient-to-r from-blue-600 to-indigo-700 px-8 py-6 text-white">
                    <h2 class="text-2xl font-extrabold mb-1">Form Pemesanan Cetak</h2>
                    <p class="text-blue-100 text-sm">Lengkapi detail ukuran dan unggah desain Anda di bawah ini.</p>
                </div>

                @if ($errors->any())
                    <div class="m-8 mb-0 p-4 bg-red-50 border-l-4 border-red-500 text-red-700 rounded-r-lg shadow-sm">
                        <ul class="list-disc list-inside font-medium text-sm">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('order.store') }}" method="POST" enctype="multipart/form-data" class="p-8">
                    @csrf
                    
                    @if($kategori_format === 'DTF')
                        <input type="hidden" name="product_id" value="{{ $products->first()->id }}">
                        
                        <div class="bg-orange-50 border border-orange-200 rounded-xl p-6 mb-8 flex items-center gap-5 shadow-sm">
                            <div class="w-14 h-14 bg-orange-100 text-orange-600 rounded-full flex items-center justify-center shadow-inner">
                                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01"></path></svg>
                            </div>
                            <div>
                                <p class="text-xs font-bold text-orange-800 uppercase tracking-wider mb-1">Layanan Terpilih Otomatis</p>
                                <p class="text-xl font-extrabold text-orange-900">{{ $products->first()->nama }}</p>
                                <p class="text-sm text-orange-700 mt-1">Harga Dasar: <strong>Rp {{ number_format($products->first()->harga, 0, ',', '.') }}</strong> / meter panjang</p>
                            </div>
                        </div>
                    @else
                        <div class="mb-8">
                            <label class="block text-sm font-bold text-gray-700 mb-2">Pilih Jenis Bahan Cetak</label>
                            <select name="product_id" required class="w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-xl shadow-sm bg-gray-50 text-gray-800 p-4 font-medium cursor-pointer">
                                <option value="">-- Klik Disini Untuk Memilih Bahan --</option>
                                @foreach($products as $product)
                                    <option value="{{ $product->id }}">
                                        {{ $product->nama }} - Rp {{ number_format($product->harga, 0, ',', '.') }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    @endif

                    @if($kategori_format === 'BANNER')
                        <div class="grid grid-cols-2 gap-6 mb-6">
                            <div class="bg-gray-50 p-4 rounded-xl border border-gray-200">
                                <label class="block text-sm font-bold text-gray-700 mb-2">Panjang (Meter)</label>
                                <input type="number" step="0.1" name="panjang" required value="{{ old('panjang') }}" placeholder="Contoh: 1.5" class="w-full border-gray-300 focus:border-blue-500 rounded-lg shadow-sm">
                            </div>
                            <div class="bg-gray-50 p-4 rounded-xl border border-gray-200">
                                <label class="block text-sm font-bold text-gray-700 mb-2">Lebar (Meter)</label>
                                <input type="number" step="0.1" name="lebar" required value="{{ old('lebar') }}" placeholder="Contoh: 2" class="w-full border-gray-300 focus:border-blue-500 rounded-lg shadow-sm">
                            </div>
                        </div>
                    @elseif($kategori_format === 'DTF')
                        <div class="bg-gray-50 p-4 rounded-xl border border-gray-200 mb-6">
                            <label class="block text-sm font-bold text-gray-700 mb-2">Panjang Area Cetak (Meter)</label>
                            <input type="number" step="0.1" name="panjang" required value="{{ old('panjang') }}" placeholder="Contoh: 1.5" class="w-full border-gray-300 focus:border-blue-500 rounded-lg shadow-sm">
                            <p class="text-xs text-gray-500 mt-2">*Lebar mengikuti standar area cetak mesin DTF (umumnya 58cm).</p>
                        </div>
                    @endif

                    <div class="mb-8">
                        <label class="block text-sm font-bold text-gray-700 mb-2">Jumlah Cetak (Qty)</label>
                        <input type="number" name="qty" required min="1" value="{{ old('qty', 1) }}" class="w-1/3 min-w-[150px] border-gray-300 focus:border-blue-500 rounded-xl shadow-sm bg-gray-50 p-3 text-lg font-bold">
                    </div>

                    <h3 class="text-lg font-extrabold text-gray-800 border-b-2 border-gray-100 pb-2 mb-6 mt-4">Unggah File Desain</h3>
                    
                    <div class="mb-8 bg-blue-50 p-6 rounded-xl border border-blue-200">
                        <label class="block text-sm font-bold text-blue-900 mb-3">Pilih File (JPG, PNG, atau PDF)</label>
                        <input type="file" name="file_desain" required accept=".jpg,.jpeg,.png,.pdf" class="w-full bg-white border border-blue-300 p-3 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm">
                        <p class="text-xs text-blue-700 mt-3 font-medium">Pastikan file memiliki resolusi yang tinggi agar hasil cetak tidak pecah (Maksimal ukuran file: 5MB).</p>
                    </div>

                    <div class="mt-10">
                        <button type="submit" class="w-full bg-blue-600 text-white px-6 py-4 rounded-xl hover:bg-blue-700 font-extrabold text-lg shadow-lg hover:shadow-xl transition-all transform hover:-translate-y-1">
                            Hitung Total & Buat Pesanan Sekarang
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</x-app-layout>