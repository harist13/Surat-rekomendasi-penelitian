<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tentang Kami - PERIKOMNAS KALTIM</title>
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
        <div class="text-sm text-gray-600 mb-4 flex items-center space-x-2">
            <a href="#" class="text-blue-600 hover:underline">Beranda</a>
            <span class="text-gray-400">/</span>
            <span class="text-gray-500">Tentang Kami</span>
        </div>

        <!-- About Section -->
        <div class="bg-white rounded-lg shadow-md p-8 mb-8">
            <h1 class="text-3xl font-bold text-[#004aad] mb-6">Apa Itu PERIKOMNAS KALTIM?</h1>
            <div class="prose max-w-none">
                <p class="text-gray-600 mb-4">
                    PERIKOMNAS (Pelayanan Terpadu Satu Pintu) Kaltim merupakan unit pelayanan dibawah 
                    Kantor Kesatuan Bangsa dan Politik Provinsi Kalimantan Timur yang bertanggung jawab 
                    dalam penerbitan Surat Izin Penelitian.
                </p>
                <p class="text-gray-600 mb-4">
                    Kami menyediakan layanan perizinan penelitian terpadu untuk berbagai keperluan akademik 
                    maupun non-akademik dengan proses yang cepat dan transparan.
                </p>
                <div class="bg-blue-50 p-4 rounded-lg">
                    <h3 class="text-lg font-semibold text-[#004aad] mb-2">Fungsi Utama:</h3>
                    <ul class="list-disc pl-6 space-y-2">
                        <li>Verifikasi administrasi permohonan penelitian</li>
                        <li>Koordinasi dengan instansi terkait</li>
                        <li>Penerbitan rekomendasi penelitian</li>
                        <li>Monitoring pelaksanaan penelitian</li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Prosedur Section -->
        <div class="bg-white rounded-lg shadow-md p-8">
            <h2 class="text-2xl font-bold text-[#004aad] mb-6">Prosedur Pelayanan Penelitian</h2>
            
            <div class="grid md:grid-cols-3 gap-6">
                <!-- Step 1 -->
                <div class="bg-gray-50 p-6 rounded-lg">
                    <div class="flex items-center mb-4">
                        <div class="w-8 h-8 bg-[#004aad] text-white rounded-full flex items-center justify-center">1</div>
                        <h3 class="ml-3 text-lg font-semibold">Pemohon</h3>
                    </div>
                    <ul class="list-disc pl-6 space-y-2 text-gray-600">
                        <li>Mengisi formulir online</li>
                        <li>Upload dokumen persyaratan</li>
                        <li>Submit permohonan</li>
                    </ul>
                </div>

                <!-- Step 2 -->
                <div class="bg-gray-50 p-6 rounded-lg">
                    <div class="flex items-center mb-4">
                        <div class="w-8 h-8 bg-[#004aad] text-white rounded-full flex items-center justify-center">2</div>
                        <h3 class="ml-3 text-lg font-semibold">PTSP</h3>
                    </div>
                    <ul class="list-disc pl-6 space-y-2 text-gray-600">
                        <li>Verifikasi kelengkapan dokumen</li>
                        <li>Koordinasi dengan bidang terkait</li>
                        <li>Penerbitan tanda terima</li>
                    </ul>
                </div>

                <!-- Step 3 -->
                <div class="bg-gray-50 p-6 rounded-lg">
                    <div class="flex items-center mb-4">
                        <div class="w-8 h-8 bg-[#004aad] text-white rounded-full flex items-center justify-center">3</div>
                        <h3 class="ml-3 text-lg font-semibold">Kepala Kantor</h3>
                    </div>
                    <ul class="list-disc pl-6 space-y-2 text-gray-600">
                        <li>Penandatanganan surat</li>
                        <li>Persetujuan akhir</li>
                        <li>Pengiriman hasil</li>
                    </ul>
                </div>
            </div>

            <!-- Persyaratan -->
            <div class="mt-8">
                <h3 class="text-xl font-semibold text-[#004aad] mb-4">Persyaratan Dokumen</h3>
                <div class="grid gap-4 md:grid-cols-2">
                    <div class="flex items-start p-4 border rounded-lg">
                        <svg class="w-6 h-6 text-[#004aad] flex-shrink-0 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        <div>
                            <h4 class="font-medium">Surat Permohonan</h4>
                            <p class="text-sm text-gray-600">Dari instansi terkait</p>
                        </div>
                    </div>
                    
                    <div class="flex items-start p-4 border rounded-lg">
                        <svg class="w-6 h-6 text-[#004aad] flex-shrink-0 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        <div>
                            <h4 class="font-medium">Proposal Penelitian</h4>
                            <p class="text-sm text-gray-600">Format PDF (maks. 2MB)</p>
                        </div>
                    </div>
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
    @include('Layout.App.Footer')
</body>
</html>