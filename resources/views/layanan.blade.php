<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Layanan Rekomendasi Penelitian - Kesbangpol Kaltim</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Heroicons -->
    <script src="https://unpkg.com/@heroicons/v2.0.18/24/outline/index.js"></script>
</head>
<body class="bg-gray-50">
    <!-- Header -->
    @include('Layout.App.Header')

    <!-- Main Content -->
    <div class="max-w-7xl mx-auto px-4 py-8">
        <!-- Breadcrumbs -->
        <div class="text-sm text-gray-600 mb-8 flex items-center space-x-2">
            <a href="#" class="text-blue-600 hover:underline">Beranda</a>
            <span class="text-gray-400">/</span>
            <span class="text-gray-500">Rekomendasi Penelitian</span>
        </div>


        <!-- Pilih Layanan Section -->
        <div class="bg-white rounded-lg shadow-md p-8 mb-8">
            <h2 class="text-2xl font-bold text-[#004aad] mb-8">Pilih Jenis Layanan</h2>
            
            <div class="grid md:grid-cols-2 gap-8">
                <!-- Layanan Mahasiswa -->
                <div class="bg-gray-50 p-6 rounded-lg hover:shadow-lg transition duration-300 border border-gray-200">
                    <div class="flex items-center mb-4">
                        <div class="w-12 h-12 bg-[#004aad] rounded-lg flex items-center justify-center mr-4">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path d="M12 14l9-5-9-5-9 5 9 5z"></path>
                                <path d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold">Penelitian Mahasiswa</h3>
                    </div>
                    <p class="text-gray-600 mb-4">Untuk keperluan akademik (Skripsi, Tesis, Disertasi)</p>
                    <a href="{{ route('pengajuanmahasiswa') }}" class="text-[#004aad] font-semibold hover:underline flex items-center">
                        Ajukan Sekarang
                        <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                        </svg>
                    </a>
                </div>

                <!-- Layanan Non-Mahasiswa -->
                <div class="bg-gray-50 p-6 rounded-lg hover:shadow-lg transition duration-300 border border-gray-200">
                    <div class="flex items-center mb-4">
                        <div class="w-12 h-12 bg-[#004aad] rounded-lg flex items-center justify-center mr-4">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold">Penelitian Non-Mahasiswa</h3>
                    </div>
                    <p class="text-gray-600 mb-4">Untuk peneliti seperti dosen, lembaga, atau instansi pemerintah/swasta</p>
                    <a href="{{ route('pengajuannonmahasiswa') }}" class="text-[#004aad] font-semibold hover:underline flex items-center">
                        Ajukan Sekarang
                        <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                        </svg>
                    </a>
                </div>
            </div>
        </div>

        <!-- Prosedur Section -->
        <div class="bg-white rounded-lg shadow-md p-8 mb-8">
            <h2 class="text-2xl font-bold text-[#004aad] mb-8">Prosedur Pengajuan Rekomendasi</h2>

            <!-- Timeline Prosedur -->
            <div class="space-y-6">
                <!-- Step 1 -->
                <div class="flex items-start border-l-4 border-[#004aad] pl-4">
                    <div class="w-8 flex-shrink-0 text-[#004aad] font-bold">1</div>
                    <div>
                        <h3 class="font-semibold">Pengajuan Permohonan</h3>
                        <p class="text-sm text-gray-600 mt-1">
                            Pemohon mengajukan surat permohonan rekomendasi ke bagian Kepala kesbangpol dengan mengirimkan surat pengantar dari instansi
                        </p>
                        <div class="mt-2 text-sm text-gray-500">
                            <span class="font-medium">Waktu:</span> 30 Menit<br>
                            <span class="font-medium">Output:</span> Surat Balasan Permohonan
                        </div>
                    </div>
                </div>

                <!-- Step 2 -->
                <div class="flex items-start border-l-4 border-[#004aad] pl-4">
                    <div class="w-8 flex-shrink-0 text-[#004aad] font-bold">2</div>
                    <div>
                        <h3 class="font-semibold">Disposisi ke Bagian bidang wasnas</h3>
                        <p class="text-sm text-gray-600 mt-1">
                            Kepala kesbangpol meneruskan surat pemohon ke Kepala Bagian bidang wasnas (kewaspadaan nasional dan penanganan Konflik)
                        </p>
                        <div class="mt-2 text-sm text-gray-500">
                            <span class="font-medium">Waktu:</span> 30-60 Menit<br>
                            <span class="font-medium">Output:</span> Lembar Disposisi
                        </div>
                    </div>
                </div>

                <!-- Step 3 -->
                <div class="flex items-start border-l-4 border-[#004aad] pl-4">
                    <div class="w-8 flex-shrink-0 text-[#004aad] font-bold">3</div>
                    <div>
                        <h3 class="font-semibold">Disposisi ke bagian divisi Analisis Kebijakan ahli muda</h3>
                        <p class="text-sm text-gray-600 mt-1">
                            Kepala bidang wasnas meneruskan surat pemohon ke divisi analisis kebijakan ahli muda atau pelayanan rekomendasi penelitian untuk dilakukan analisis dan rekomendasi
                        </p>
                        <div class="mt-2 text-sm text-gray-500">
                            <span class="font-medium">Waktu:</span> 15 Menit<br>
                            <span class="font-medium">Output:</span> Lembar Disposisi
                        </div>
                    </div>
                </div>

                <!-- Step 4 -->
                <div class="flex items-start border-l-4 border-[#004aad] pl-4">
                    <div class="w-8 flex-shrink-0 text-[#004aad] font-bold">4</div>
                    <div>
                        <h3 class="font-semibold">Verifikasi Administratif</h3>
                        <p class="text-sm text-gray-600 mt-1">
                            Pemeriksaan kelengkapan dokumen dan persyaratan oleh staff analisis kebijakan ahli muda
                        </p>
                        <div class="mt-2 text-sm text-gray-500">
                            <span class="font-medium">Waktu:</span> 10 Menit<br>
                            <span class="font-medium">Output:</span> Surat pemohon rekomendasi penelitian
                        </div>
                    </div>
                </div>

                <!-- Step 5 -->
                <div class="flex items-start border-l-4 border-[#004aad] pl-4">
                    <div class="w-8 flex-shrink-0 text-[#004aad] font-bold">5</div>
                    <div>
                        <h3 class="font-semibold">Membuat draft surat rekomendasi</h3>
                        <p class="text-sm text-gray-600 mt-1">
                            Analisa kebijakan ahli muda membuat draft surat rekomendasi penelitian berdasarkan hasil verifikasi dokumen dan persyaratan
                        </p>
                        <div class="mt-2 text-sm text-gray-500">
                            <span class="font-medium">Waktu:</span> 10 Menit<br>
                            <span class="font-medium">Output:</span> Draft surat rekomendasi penelitian
                        </div>
                    </div>
                </div>

                <!-- Step 6 -->
                <div class="flex items-start border-l-4 border-[#004aad] pl-4">
                    <div class="w-8 flex-shrink-0 text-[#004aad] font-bold">6</div>
                    <div>
                        <h3 class="font-semibold">Persetujuan kepala bidang</h3>
                        <p class="text-sm text-gray-600 mt-1">
                            Kepala bidang wasnas menandatangani surat rekomendasi penelitian yang telah dibuat oleh staff analisis kebijakan ahli muda
                        </p>
                        <div class="mt-2 text-sm text-gray-500">
                            <span class="font-medium">Waktu:</span> 10 Menit<br>
                            <span class="font-medium">Output:</span> Draft surat rekomendasi penelitian
                        </div>
                    </div>
                </div>

                <!-- Step 7 -->
                <div class="flex items-start border-l-4 border-[#004aad] pl-4">
                    <div class="w-8 flex-shrink-0 text-[#004aad] font-bold">7</div>
                    <div>
                        <h3 class="font-semibold">Pengambilan surat rekomendasi penelitian</h3>
                        <p class="text-sm text-gray-600 mt-1">
                            Pemohon mengambil surat rekomendasi penelitian yang telah ditandatangani oleh kepala bidang wasnas di kantor kesbangpol kaltim bagian divisi analisis kebijakan ahli muda
                        </p>
                        <div class="mt-2 text-sm text-gray-500">
                            <span class="font-medium">Waktu:</span> 10 Menit<br>
                            <span class="font-medium">Output:</span> Draft surat rekomendasi penelitian
                        </div>
                    </div>
                </div>

                <!-- Step 5-8 (ditampilkan ringkas) -->
                <div class="bg-gray-50 p-4 rounded-lg">
                    <h4 class="text-sm font-semibold text-[#004aad] mb-2">Tahap Finalisasi:</h4>
                    <ul class="list-disc pl-6 space-y-2 text-sm text-gray-600">
                        <li>Penerbitan draft rekomendasi (30 Menit)</li>
                        <li>Persetujuan Kepala Bagian (30 Menit)</li>
                        <li>Penandatanganan dokumen (5 Menit)</li>
                        <li>Serah terima ke pemohon (5 Menit)</li>
                    </ul>
                </div>
            </div>

            <!-- Catatan -->
            <div class="mt-6 p-4 bg-yellow-50 rounded-lg border border-yellow-200">
                <p class="text-sm text-yellow-700">
                    ⏰ Total waktu prosedur: <strong>2-3 Jam Kerja</strong><br>
                    📍 Konfirmasi kelengkapan dokumen sebelum pengajuan untuk menghindari penundaan
                </p>
            </div>
        </div>

                <!-- Petunjuk Pengajuan Section -->
        <div class="bg-white rounded-lg shadow-md p-8 mb-8">
            <h2 class="text-2xl font-bold text-[#004aad] mb-6">Petunjuk Pengajuan Izin Penelitian</h2>
            
            <div class="space-y-4 text-gray-700">
                <p class="leading-relaxed">
                    <span class="font-semibold">1. Persiapkan Dokumen Lengkap:</span><br>
                    Pastikan semua dokumen persyaratan telah disiapkan dalam format PDF/JPG. Dokumen wajib meliputi: Surat Pengantar dari Institusi, Proposal Penelitian, Identitas Pemohon, dan dokumen pendukung lainnya sesuai kebutuhan penelitian.
                </p>

                <p class="leading-relaxed">
                    <span class="font-semibold">2. Registrasi Online:</span><br>
                    Lakukan pendaftaran melalui sistem online ini dengan mengisi formulir pengajuan secara lengkap. Pastikan data yang dimasukkan sesuai dengan dokumen resmi (nama lengkap, institusi, dan judul penelitian).
                </p>

                <p class="leading-relaxed">
                    <span class="font-semibold">3. Unggah Dokumen:</span><br>
                    Upload semua dokumen persyaratan melalui form yang telah disediakan. Pastikan file terbaca dengan baik dan ukuran maksimal 2MB per file.
                </p>

                <p class="leading-relaxed">
                    <span class="font-semibold">4. Verifikasi Data:</span><br>
                    Tim Kesbangpol akan melakukan verifikasi dokumen dalam 1-2 hari kerja. Pantau email/SMS notifikasi untuk informasi perkembangan pengajuan.
                </p>

                <p class="leading-relaxed">
                    <span class="font-semibold">5. Revisi Dokumen (Jika diperlukan):</span><br>
                    Jika terdapat kekurangan/dokumen perlu revisi, pemohon akan mendapat pemberitahuan melalui email/SMS. Lakukan perbaikan maksimal 3 hari kerja setelah menerima pemberitahuan tersebut.
                </p>

                <p class="leading-relaxed">
                    <span class="font-semibold">6. Pengambilan Surat Rekomendasi:</span><br>
                    Jika pengajuan disetujui, surat rekomendasi dapat diambil langsung di kantor Kesbangpol Kaltim atau melalui kurir dengan menunjukkan nomor pengajuan dan identitas pemohon.
                </p>

                <div class="mt-6 p-4 bg-blue-50 rounded-lg">
                    <p class="text-sm text-blue-800">
                        📌 Catatan Penting:<br>
                        • Masa berlaku surat rekomendasi adalah 6 bulan sejak tanggal diterbitkan<br>
                        • Pemohon wajib melaporkan hasil penelitian ke Kesbangpol Kaltim setelah penelitian selesai<br>
                        • Untuk pertanyaan teknis hubungi (0541) 1234567 ext. 123 atau email penelitian@kesbangpolkaltim.id
                    </p>
                </div>
            </div>
        </div>

        <!-- Status Check Section -->
        <div class="mt-8 bg-[#add8e6] p-8 rounded-lg flex flex-col items-center">
            <h3 class="text-2xl font-bold mb-4">Cek Status Permohonan</h3>
            <p class="mb-6 text-center">Masukkan Nomor Pengajuan Anda untuk memantau perkembangan permohonan penelitian</p>
            <form method="POST" action="{{ route('pantau.cek') }}" class="flex flex-col md:flex-row items-center gap-4 w-full max-w-2xl">
                @csrf
                <input 
                    type="text" 
                    name="no_pengajuan" 
                    placeholder="Masukkan Nomor Pengajuan" 
                    class="bg-white shadow-md px-6 py-3 rounded-lg w-full" 
                    required
                />
                <button 
                    type="submit" 
                    class="bg-[#004aad] text-white px-8 py-3 rounded-lg font-semibold hover:bg-blue-600 transition whitespace-nowrap"
                >
                    Lacak Status
                </button>
            </form>
            @if(session('error'))
                <div class="mt-4 text-red-500 text-sm">{{ session('error') }}</div>
            @endif
        </div>
    </div>

    <!-- Footer -->
    @include('Layout.App.footer')
</body>
</html>