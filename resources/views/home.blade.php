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
                    <a href="{{ route('layanan') }}" class="bg-white text-[#004aad] px-8 py-3 rounded-lg text-lg font-semibold hover:bg-blue-50 transition-transform transform hover:scale-105">
                        Ajukan Sekarang
                    </a>
                    <a href="{{ route('syarat') }}" class="border-2 border-white px-8 py-3 rounded-lg text-lg font-semibold hover:bg-white hover:text-[#004aad] transition-transform transform hover:scale-105">
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
                    <p class="text-gray-600 mb-4">Layanan pengajuan untuk peneliti seperti dosen, lembaga, atau instansi pemerintah/swasta</p>
                    <ul class="text-gray-600 list-disc pl-5">
                        <li>Peneliti individu/organisasi</li>
                        <li>Penelitian lembaga survei</li>
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
                    <h3 class="font-semibold mb-2">Memilih Jenis penelitian</h3>
                    <p class="text-sm text-gray-600">Peneliti Memilih jenis penelitian mahasiswa atau non mahasiswa</p>
                </div>
                <div class="text-center p-4">
                    <div class="w-16 h-16 bg-[#004aad] rounded-full flex items-center justify-center mx-auto mb-4">
                        <span class="text-white font-bold text-xl">2</span>
                    </div>
                    <h3 class="font-semibold mb-2">Mengisi Formulir</h3>
                    <p class="text-sm text-gray-600">Peneliti mengisi formulir pendaftaran dan mengupload dokumen persyaratan</p>
                </div>
                <div class="text-center p-4">
                    <div class="w-16 h-16 bg-[#004aad] rounded-full flex items-center justify-center mx-auto mb-4">
                        <span class="text-white font-bold text-xl">3</span>
                    </div>
                    <h3 class="font-semibold mb-2">Verifikasi Berkas Dan Pembuatan Surat</h3>
                    <p class="text-sm text-gray-600">Proses verifikasi dan Pembuatan Surat 1-2 hari kerja</p>
                </div>
                <div class="text-center p-4">
                    <div class="w-16 h-16 bg-[#004aad] rounded-full flex items-center justify-center mx-auto mb-4">
                        <span class="text-white font-bold text-xl">4</span>
                    </div>
                    <h3 class="font-semibold mb-2">Penerbitan surat</h3>
                    <p class="text-sm text-gray-600">Surat telah diterbitkan dan siap diambil langsung ke kantor</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Petunjuk Pengajuan Section -->
    <div class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-lg shadow-md p-8">
                <h2 class="text-3xl font-bold text-[#004aad] mb-6 text-center">Petunjuk Pengajuan Izin Penelitian</h2>
                
                <div class="grid md:grid-cols-2 gap-8 mt-8">
                    <!-- Kolom Kiri -->
                    <div class="space-y-6">
                        <div class="flex items-start">
                            <div class="w-10 h-10 bg-[#004aad] rounded-full flex items-center justify-center flex-shrink-0 mr-4">
                                <span class="text-white font-bold">1</span>
                            </div>
                            <div>
                                <h3 class="font-semibold text-lg mb-2">Persiapkan Dokumen Lengkap</h3>
                                <p class="text-gray-700 leading-relaxed">
                                    Pastikan semua dokumen persyaratan telah disiapkan dalam format PDF/JPG. Dokumen wajib meliputi: Surat Pengantar dari Institusi, Proposal Penelitian, Identitas Pemohon, dan dokumen pendukung lainnya sesuai kebutuhan penelitian.
                                </p>
                            </div>
                        </div>
                        
                        <div class="flex items-start">
                            <div class="w-10 h-10 bg-[#004aad] rounded-full flex items-center justify-center flex-shrink-0 mr-4">
                                <span class="text-white font-bold">2</span>
                            </div>
                            <div>
                                <h3 class="font-semibold text-lg mb-2">Registrasi Online</h3>
                                <p class="text-gray-700 leading-relaxed">
                                    Lakukan pendaftaran melalui sistem online ini dengan mengisi formulir pengajuan secara lengkap. Pastikan data yang dimasukkan sesuai dengan dokumen resmi (nama lengkap, institusi, dan judul penelitian).
                                </p>
                            </div>
                        </div>
                        
                        <div class="flex items-start">
                            <div class="w-10 h-10 bg-[#004aad] rounded-full flex items-center justify-center flex-shrink-0 mr-4">
                                <span class="text-white font-bold">3</span>
                            </div>
                            <div>
                                <h3 class="font-semibold text-lg mb-2">Unggah Dokumen</h3>
                                <p class="text-gray-700 leading-relaxed">
                                    Upload semua dokumen persyaratan melalui form yang telah disediakan. Pastikan file terbaca dengan baik dan ukuran maksimal 2MB per file.
                                </p>
                            </div>
                        </div>
                    </div
                    
                    <!-- Catatan Penting -->
                    <div class="space-y-6">
                        <div class="flex items-start">
                            <div class="w-10 h-10 bg-[#004aad] rounded-full flex items-center justify-center flex-shrink-0 mr-4">
                                <span class="text-white font-bold">4</span>
                            </div>
                            <div>
                                <h3 class="font-semibold text-lg mb-2">Verifikasi Data</h3>
                                <p class="text-gray-700 leading-relaxed">
                                    Tim Kesbangpol akan melakukan verifikasi dokumen dalam 1-2 hari kerja. Pantau email/SMS notifikasi untuk informasi perkembangan pengajuan.
                                </p>
                            </div>
                        </div>
                        
                        <div class="flex items-start">
                            <div class="w-10 h-10 bg-[#004aad] rounded-full flex items-center justify-center flex-shrink-0 mr-4">
                                <span class="text-white font-bold">5</span>
                            </div>
                            <div>
                                <h3 class="font-semibold text-lg mb-2">Revisi Dokumen (Jika diperlukan)</h3>
                                <p class="text-gray-700 leading-relaxed">
                                    Jika terdapat kekurangan/dokumen perlu revisi, pemohon akan mendapat pemberitahuan melalui email/SMS. Lakukan perbaikan maksimal 3 hari kerja setelah menerima pemberitahuan tersebut.
                                </p>
                            </div>
                        </div>
                        
                        <div class="flex items-start">
                            <div class="w-10 h-10 bg-[#004aad] rounded-full flex items-center justify-center flex-shrink-0 mr-4">
                                <span class="text-white font-bold">6</span>
                            </div>
                            <div>
                                <h3 class="font-semibold text-lg mb-2">Pengambilan Surat Rekomendasi</h3>
                                <p class="text-gray-700 leading-relaxed">
                                    Jika pengajuan disetujui, surat rekomendasi dapat diambil langsung di kantor Kesbangpol Kaltim atau melalui kurir dengan menunjukkan nomor pengajuan dan identitas pemohon.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Catatan Penting -->
                <div class="mt-8 p-6 bg-blue-50 rounded-lg border border-blue-200">
                    <h3 class="font-bold text-blue-800 mb-3 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                        </svg>
                        Catatan Penting
                    </h3>
                    <ul class="space-y-2 text-blue-800">
                        <li class="flex items-start">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 flex-shrink-0 mt-0.5" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                            </svg>
                            Masa berlaku surat rekomendasi adalah 6 bulan sejak tanggal diterbitkan
                        </li>
                        <li class="flex items-start">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 flex-shrink-0 mt-0.5" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                            </svg>
                            Pemohon wajib melaporkan hasil penelitian ke Kesbangpol Kaltim setelah penelitian selesai
                        </li>
                        <li class="flex items-start">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 flex-shrink-0 mt-0.5" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                            </svg>
                            Untuk pertanyaan teknis hubungi (0541) 1234567 ext. 123 atau email penelitian@kesbangpolkaltim.id
                        </li>
                    </ul>
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
                <a href="{{ route('layanan') }}" class="bg-white text-[#004aad] px-8 py-3 rounded-lg text-lg font-semibold hover:bg-blue-50 transition">Ajukan Online</a>
                <a href="{{ route('pantau') }}" class="border-2 border-white px-8 py-3 rounded-lg text-lg font-semibold hover:bg-white hover:text-[#004aad] transition">Cek Status</a>
            </div>
        </div>
    </div>

@include('Layout.App.footer')