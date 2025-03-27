@include('Layout.App.Header')
<body class="bg-gray-50">

    <!-- Hero Section -->
    <div class="bg-gradient-to-r from-blue-600 to-indigo-600 text-white py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h1 class="text-4xl md:text-6xl font-bold mb-6">Selamat Datang di PERIKOMNAS KALTIM</h1>
            <p class="text-xl mb-8">Layanan Terpadu Untuk Kebutuhan Administrasi dan Penelitian</p>
            <div class="flex justify-center space-x-4">
                <a href="#" class="bg-white text-[#004aad] px-8 py-3 rounded-lg text-lg font-semibold hover:bg-blue-50 transition">Mulai Sekarang</a>
                <a href="#" class="border-2 border-white px-8 py-3 rounded-lg text-lg font-semibold hover:bg-white hover:text-[#004aad] transition">Pelajari Lebih</a>
            </div>
        </div>
    </div>

    <!-- Features Section -->
    <div class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-800 mb-4">Layanan Unggulan Kami</h2>
                <p class="text-gray-600 max-w-2xl mx-auto">Kami menyediakan berbagai layanan terpadu untuk memenuhi kebutuhan administrasi dan penelitian Anda</p>
            </div>

            <div class="grid md:grid-cols-3 gap-8">
                <!-- Feature 1 -->
                <div class="p-6 bg-gray-50 rounded-xl hover:shadow-lg transition">
                    <div class="w-12 h-12 bg-[#004aad] rounded-lg flex items-center justify-center mb-4">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold mb-2">Layanan Administrasi</h3>
                    <p class="text-gray-600">Pengurusan dokumen dan perizinan secara cepat dan terintegrasi</p>
                </div>

                <!-- Feature 2 -->
                <div class="p-6 bg-gray-50 rounded-xl hover:shadow-lg transition">
                    <div class="w-12 h-12 bg-[#004aad] rounded-lg flex items-center justify-center mb-4">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold mb-2">Permohonan Penelitian</h3>
                    <p class="text-gray-600">Pelayanan pengajuan izin penelitian untuk berbagai keperluan akademik</p>
                </div>

                <!-- Feature 3 -->
                <div class="p-6 bg-gray-50 rounded-xl hover:shadow-lg transition">
                    <div class="w-12 h-12 bg-[#004aad] rounded-lg flex items-center justify-center mb-4">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold mb-2">Verifikasi Online</h3>
                    <p class="text-gray-600">Sistem verifikasi dokumen secara online real-time</p>
                </div>
            </div>
        </div>
    </div>

    <!-- CTA Section -->
    <div class="bg-gradient-to-r from-[#004aad] to-blue-600 text-white py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-3xl font-bold mb-6">Siap Memulai?</h2>
            <p class="text-xl mb-8 max-w-2xl mx-auto">Daftarkan diri Anda sekarang dan nikmati kemudahan layanan terpadu kami</p>
            <a href="#" class="bg-white text-[#004aad] px-8 py-3 rounded-lg text-lg font-semibold hover:bg-blue-50 transition">Daftar Sekarang</a>
        </div>
    </div>
@include('Layout.App.footer')