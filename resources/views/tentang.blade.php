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

        <!-- About Section -->
        <div class="bg-white rounded-lg shadow-md p-8 mb-8">
            <h1 class="text-3xl font-bold text-[#004aad] mb-6">Layanan Surat Rekomendasi Penelitian</h1>
            <div class="prose max-w-none">
                <p class="text-gray-600 mb-4">
                    Kantor Kesatuan Bangsa dan Politik Provinsi Kalimantan Timur menyediakan layanan penerbitan
                    Surat Rekomendasi Penelitian untuk kebutuhan akademik dan non-akademik.
                </p>
                <div class="bg-blue-50 p-4 rounded-lg mt-6">
                    <h3 class="text-lg font-semibold text-[#004aad] mb-2">Jenis Layanan:</h3>
                    <ul class="list-disc pl-6 space-y-2">
                        <li>Penelitian Mahasiswa (Skripsi/Tesis/Disertasi)</li>
                        <li>Penelitian Non-Mahasiswa (Lembaga/Instansi/Dosen)</li>
                    </ul>
                </div>
            </div>
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
                    <a href="#" class="text-[#004aad] font-semibold hover:underline flex items-center">
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
                    <p class="text-gray-600 mb-4">Untuk peneliti independen, lembaga, atau dosen</p>
                    <a href="#" class="text-[#004aad] font-semibold hover:underline flex items-center">
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
            
            <div class="grid md:grid-cols-2 gap-8">
                <!-- Mahasiswa -->
                <div class="bg-gray-50 p-6 rounded-lg border border-gray-200">
                    <div class="flex items-center mb-4">
                        <div class="w-8 h-8 bg-[#004aad] text-white rounded-full flex items-center justify-center">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path d="M12 14l9-5-9-5-9 5 9 5z"></path>
                                <path d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"></path>
                            </svg>
                        </div>
                        <h3 class="ml-3 text-lg font-semibold">Untuk Mahasiswa</h3>
                    </div>
                    <ul class="list-disc pl-6 space-y-2 text-gray-600">
                        <li>Surat pengantar dari kampus</li>
                        <li>Proposal penelitian lengkap</li>
                        <li>Fotokopi KTM yang berlaku</li>
                        <li>Formulir permohonan terisi</li>
                    </ul>
                </div>

                <!-- Non-Mahasiswa -->
                <div class="bg-gray-50 p-6 rounded-lg border border-gray-200">
                    <div class="flex items-center mb-4">
                        <div class="w-8 h-8 bg-[#004aad] text-white rounded-full flex items-center justify-center">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <h3 class="ml-3 text-lg font-semibold">Untuk Non-Mahasiswa</h3>
                    </div>
                    <ul class="list-disc pl-6 space-y-2 text-gray-600">
                        <li>Surat permohonan resmi institusi</li>
                        <li>Proposal penelitian terperinci</li>
                        <li>Legalitas institusi peneliti</li>
                        <li>Identitas peneliti utama</li>
                    </ul>
                </div>
            </div>

            <!-- Persyaratan -->
            <div class="mt-8">
                <h3 class="text-xl font-semibold text-[#004aad] mb-6">Persyaratan Dokumen</h3>
                <div class="grid gap-6 md:grid-cols-2">
                    <div class="flex items-start p-6 border rounded-lg bg-gray-50">
                        <svg class="w-6 h-6 text-[#004aad] flex-shrink-0 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        <div>
                            <h4 class="font-medium">Dokumen Wajib</h4>
                            <ul class="list-disc pl-4 text-sm text-gray-600 mt-2">
                                <li>Formulir permohonan</li>
                                <li>Proposal penelitian (PDF)</li>
                                <li>Surat pengantar institusi</li>
                            </ul>
                        </div>
                    </div>
                    
                    <div class="flex items-start p-6 border rounded-lg bg-gray-50">
                        <svg class="w-6 h-6 text-[#004aad] flex-shrink-0 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                        </svg>
                        <div>
                            <h4 class="font-medium">Dokumen Tambahan</h4>
                            <ul class="list-disc pl-4 text-sm text-gray-600 mt-2">
                                <li>Surat pernyataan orisinalitas</li>
                                <li>CV peneliti utama</li>
                                <li>Surat rekomendasi pembimbing (mahasiswa)</li>
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