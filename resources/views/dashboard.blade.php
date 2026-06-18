<x-app-layout>

    <div class="relative bg-cover bg-center h-80" style="background-image: url('https://images.unsplash.com/photo-1629904853716-f0bc54eea481?auto=format&fit=crop&w=1600&q=80');">
        <div class="absolute inset-0 bg-gradient-to-r from-blue-900/90 to-black/70"></div>
        
        <div class="relative max-w-7xl mx-auto h-full px-4 sm:px-6 lg:px-8 flex flex-col justify-center text-white">
            <h1 class="text-4xl md:text-5xl font-extrabold mb-4">Percetakan Digital Profesional</h1>
            <p class="text-lg md:text-xl max-w-2xl text-gray-200 leading-relaxed mb-6">
                Percetakan kami melayani cetak Banner / Spanduk, Sablon Kaos DTF, dan Cetak Kertas Art Paper. Kami berkomitmen memberikan hasil cetak berkualitas tinggi dengan harga terbaik dan proses pengerjaan yang cepat.
            </p>
            <div>
                <span class="bg-blue-600 text-white px-4 py-2 rounded-full text-sm font-semibold shadow-lg">Buka 24 Jam via Online</span>
            </div>
        </div>
    </div>

    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="mb-8 text-center">
                <h3 class="text-3xl font-bold text-gray-800">Katalog Layanan Kami</h3>
                <div class="w-24 h-1 bg-blue-600 mx-auto mt-4 mb-2 rounded-full"></div>
                <p class="text-gray-500">Pilih layanan di bawah ini untuk mulai memesan desain Anda.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                
                <a href="{{ route('order.create', 'banner') }}" class="group bg-white rounded-2xl shadow-md hover:shadow-2xl transition-all duration-300 overflow-hidden flex flex-col border border-gray-100 transform hover:-translate-y-1">
                    <div class="h-48 overflow-hidden bg-gray-200">
                        <img src="https://soerabaja45.co.id/wp-content/uploads/2022/01/608fe56fbf6295a32eba65adcd65afc53dd475fe_s2_n2.png" alt="Cetak Banner" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                    </div>
                    <div class="p-6 flex-1 flex flex-col">
                        <h4 class="text-xl font-bold text-gray-800 mb-2 group-hover:text-blue-600 transition-colors">Cetak Banner & Spanduk</h4>
                        <p class="text-sm text-gray-600 mb-4 flex-1">Solusi promosi outdoor/indoor Anda. Harga dihitung presisi per meter persegi berdasarkan bahan Flexi atau Albatros.</p>
                        <div class="mt-auto w-full text-center bg-blue-50 text-blue-700 font-bold py-2 rounded-lg group-hover:bg-blue-600 group-hover:text-white transition-colors">
                            Pesan Sekarang &rarr;
                        </div>
                    </div>
                </a>

                <a href="{{ route('order.create', 'dtf') }}" class="group bg-white rounded-2xl shadow-md hover:shadow-2xl transition-all duration-300 overflow-hidden flex flex-col border border-gray-100 transform hover:-translate-y-1">
                    <div class="h-48 overflow-hidden bg-gray-200">
                        <img src="https://images.unsplash.com/photo-1562157873-818bc0726f68?auto=format&fit=crop&w=600&q=80" alt="Sablon DTF" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                    </div>
                    <div class="p-6 flex-1 flex flex-col">
                        <h4 class="text-xl font-bold text-gray-800 mb-2 group-hover:text-blue-600 transition-colors">Sablon DTF (Direct to Film)</h4>
                        <p class="text-sm text-gray-600 mb-4 flex-1">Cetak desain sablon siap press ke kaos atau pakaian. Harga ekonomis dihitung berdasarkan meter panjang cetakan.</p>
                        <div class="mt-auto w-full text-center bg-blue-50 text-blue-700 font-bold py-2 rounded-lg group-hover:bg-blue-600 group-hover:text-white transition-colors">
                            Pesan Sekarang &rarr;
                        </div>
                    </div>
                </a>

                <a href="{{ route('order.create', 'art-paper') }}" class="group bg-white rounded-2xl shadow-md hover:shadow-2xl transition-all duration-300 overflow-hidden flex flex-col border border-gray-100 transform hover:-translate-y-1">
                    <div class="h-48 overflow-hidden bg-gray-200">
                        <img src="https://images.unsplash.com/photo-1586075010923-2dd4570fb338?auto=format&fit=crop&w=600&q=80" alt="Art Paper" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                    </div>
                    <div class="p-6 flex-1 flex flex-col">
                        <h4 class="text-xl font-bold text-gray-800 mb-2 group-hover:text-blue-600 transition-colors">Cetak Art Paper / Brosur</h4>
                        <p class="text-sm text-gray-600 mb-4 flex-1">Cetak lembaran berkualitas tinggi untuk kebutuhan brosur, poster, atau kartu nama dengan berbagai ketebalan.</p>
                        <div class="mt-auto w-full text-center bg-blue-50 text-blue-700 font-bold py-2 rounded-lg group-hover:bg-blue-600 group-hover:text-white transition-colors">
                            Pesan Sekarang &rarr;
                        </div>
                    </div>
                </a>

            </div>
        </div>
    </div>
</x-app-layout>