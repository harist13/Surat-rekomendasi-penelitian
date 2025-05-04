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

        <!-- Unified Card Section -->
        <div class="bg-white rounded-xl shadow-lg overflow-hidden mb-8">
            <div class="flex flex-col md:flex-row">
                <!-- Image Section -->
                <div class="md:w-1/2 relative">
                    <img 
                        src="{{ asset('assets/images/gubernur.jpg') }}" 
                        alt="Kantor Gubernur Kaltim"
                        class="w-full h-48 md:h-[570px] object-cover transition-transform duration-300 hover:scale-105"
                    >
                </div>

                <!-- Content Section -->
                <div class="md:w-1/2 p-8 flex flex-col justify-center">
                    <h1 class="text-3xl md:text-4xl font-bold text-[#004aad] mb-6 leading-tight">
                        Layanan Surat Rekomendasi Penelitian
                    </h1>
                    <div class="space-y-4 text-gray-600 text-justify">
                        <p class="md:text-lg">
                            Kantor Kesatuan Bangsa dan Politik Provinsi Kalimantan Timur menyediakan layanan penerbitan Surat Rekomendasi Penelitian untuk kebutuhan akademik dan non-akademik melalui website resmi.
                        </p>
                        <p class="md:text-lg">
                            Sirpena adalah Surat Izin Rekomendasi Penelitian, Tujuan dari website ini adalah untuk memudahkan pelacakan status permohonan dan pengiriman berkas secara online. Namun, surat rekomendasi yang telah selesai prosesnya wajib diambil secara offline langsung di kantor.
                        </p>
                        <div class="bg-blue-50 p-6 rounded-lg mt-6">
                            <h3 class="text-xl font-semibold text-[#004aad] mb-4">Jenis Layanan:</h3>
                            <ul class="list-none space-y-3 pl-2">
                                <li class="flex items-start">
                                    <span class="text-blue-500 mr-2 mt-1">•</span>
                                    Penelitian Mahasiswa (Skripsi/Tesis/Disertasi)
                                </li>
                                <li class="flex items-start">
                                    <span class="text-blue-500 mr-2 mt-1">•</span>
                                    Penelitian Non-Mahasiswa (Lembaga/Instansi/Dosen)
                                </li>
                            </ul>
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
                    class="bg-white shadow-md px-6 py-3 rounded-lg w-full focus:ring-2 focus:ring-blue-500 focus:border-transparent" 
                    required
                />
                <button 
                    type="submit" 
                    class="bg-[#004aad] text-white px-8 py-3 rounded-lg font-semibold hover:bg-blue-600 transition whitespace-nowrap transform hover:scale-105"
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