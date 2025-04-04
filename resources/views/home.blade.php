@include('Layout.App.Header')
<body class="bg-gray-50">

    <!-- Hero Section -->
    <div class="relative h-[500px] overflow-hidden">
        <!-- Background Image dengan Overlay -->
        <div class="absolute inset-0 z-0">
            <img 
                src="{{ asset('assets/images/gubernur.jpg') }}" 
                alt="Office Background"
                class="w-full h-full object-cover"
                loading="lazy"
            />
            <div class="absolute inset-0 bg-gradient-to-r from-gray-900/60 to-gray-900/40"></div>
        </div>

        <!-- Konten -->
        <div class="relative z-10 h-full flex items-center">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center text-white">
                <h1 class="text-4xl md:text-6xl font-bold mb-6 leading-tight">
                    Surat Rekomendasi Penelitian<br>
                    <span class="text-blue-300">Kesbangpol Kaltim</span>
                </h1>
                <p class="text-xl mb-8 max-w-2xl mx-auto md:text-2xl">
                    Layanan Terpadu Pengajuan Surat Rekomendasi Penelitian untuk Mahasiswa dan Peneliti
                </p>
                <div class="flex flex-col sm:flex-row justify-center gap-4">
                    <a href="#" class="bg-white text-[#004aad] px-8 py-3 rounded-lg text-lg font-semibold hover:bg-blue-50 transition-transform transform hover:scale-105">
                        Ajukan Sekarang
                    </a>
                    <a href="#" class="border-2 border-white px-8 py-3 rounded-lg text-lg font-semibold hover:bg-white hover:text-[#004aad] transition-transform transform hover:scale-105">
                        Lihat Persyaratan
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Features Section -->
    <div class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-800 mb-4">Jenis Layanan</h2>
                <p class="text-gray-600 max-w-2xl mx-auto">Pilih layanan sesuai dengan status penelitian Anda</p>
            </div>

            <div class="grid md:grid-cols-2 gap-8">
                <!-- Mahasiswa -->
                <div class="p-6 bg-gray-50 rounded-xl hover:shadow-lg transition">
                    <div class="w-12 h-12 bg-[#004aad] rounded-lg flex items-center justify-center mb-4">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path d="M12 14l9-5-9-5-9 5 9 5z"></path>
                            <path d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold mb-2">Penelitian Mahasiswa</h3>
                    <p class="text-gray-600 mb-4">Layanan pengajuan surat rekomendasi untuk penelitian akademik (skripsi, tesis, disertasi)</p>
                    <ul class="text-gray-600 list-disc pl-5">
                        <li>Mahasiswa S1/S2/S3</li>
                        <li>Penelitian dari kampus</li>
                        <li>Maksimal 6 bulan</li>
                    </ul>
                </div>

                <!-- Non-Mahasiswa -->
                <div class="p-6 bg-gray-50 rounded-xl hover:shadow-lg transition">
                    <div class="w-12 h-12 bg-[#004aad] rounded-lg flex items-center justify-center mb-4">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold mb-2">Penelitian Non-Mahasiswa</h3>
                    <p class="text-gray-600 mb-4">Layanan pengajuan untuk peneliti independen, lembaga, atau instansi pemerintah/swasta</p>
                    <ul class="text-gray-600 list-disc pl-5">
                        <li>Peneliti individu/organisasi</li>
                        <li>Penelitian terapan</li>
                        <li>Kerjasama institusi</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- Proses Section -->
    <div class="py-16 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-800 mb-4">Tahapan Pengajuan</h2>
                <p class="text-gray-600 max-w-2xl mx-auto">Proses pengajuan surat rekomendasi yang cepat dan transparan</p>
            </div>

            <div class="grid md:grid-cols-4 gap-8">
                <div class="text-center p-4">
                    <div class="w-16 h-16 bg-[#004aad] rounded-full flex items-center justify-center mx-auto mb-4">
                        <span class="text-white font-bold text-xl">1</span>
                    </div>
                    <h3 class="font-semibold mb-2">Registrasi Online</h3>
                    <p class="text-sm text-gray-600">Buat akun dan lengkapi profil</p>
                </div>
                <div class="text-center p-4">
                    <div class="w-16 h-16 bg-[#004aad] rounded-full flex items-center justify-center mx-auto mb-4">
                        <span class="text-white font-bold text-xl">2</span>
                    </div>
                    <h3 class="font-semibold mb-2">Upload Dokumen</h3>
                    <p class="text-sm text-gray-600">Upload proposal dan persyaratan</p>
                </div>
                <div class="text-center p-4">
                    <div class="w-16 h-16 bg-[#004aad] rounded-full flex items-center justify-center mx-auto mb-4">
                        <span class="text-white font-bold text-xl">3</span>
                    </div>
                    <h3 class="font-semibold mb-2">Verifikasi Admin</h3>
                    <p class="text-sm text-gray-600">Proses verifikasi 1-3 hari kerja</p>
                </div>
                <div class="text-center p-4">
                    <div class="w-16 h-16 bg-[#004aad] rounded-full flex items-center justify-center mx-auto mb-4">
                        <span class="text-white font-bold text-xl">4</span>
                    </div>
                    <h3 class="font-semibold mb-2">Download Surat</h3>
                    <p class="text-sm text-gray-600">Cetak surat rekomendasi resmi</p>
                </div>
            </div>
        </div>
    </div>

    <!-- CTA Section -->
    <div class="bg-gradient-to-r from-[#004aad] to-blue-600 text-white py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-3xl font-bold mb-6">Ajukan Surat Rekomendasi Sekarang!</h2>
            <p class="text-xl mb-8 max-w-2xl mx-auto">Dapatkan kemudahan pengajuan surat rekomendasi penelitian secara online melalui sistem terintegrasi kami</p>
            <div class="flex justify-center space-x-4">
                <a href="#" class="bg-white text-[#004aad] px-8 py-3 rounded-lg text-lg font-semibold hover:bg-blue-50 transition">Ajukan Online</a>
                <a href="#" class="border-2 border-white px-8 py-3 rounded-lg text-lg font-semibold hover:bg-white hover:text-[#004aad] transition">Cek Status</a>
            </div>
        </div>
    </div>

@include('Layout.App.footer')