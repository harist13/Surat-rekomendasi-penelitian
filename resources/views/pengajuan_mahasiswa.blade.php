@include('Layout.App.Header')
<body class="bg-gray-50">
    <!-- Main Content -->
    <div class="max-w-7xl mx-auto px-4 py-8">
        <!-- Breadcrumbs -->
        <div class="text-sm text-gray-600 mb-4 flex items-center space-x-2">
            <a href="#" class="text-blue-600 hover:underline">Beranda</a>
            <span class="text-gray-400">/</span>
            <a href="#" class="text-blue-600 hover:underline">Layanan</a>
            <span class="text-gray-400">/</span>
            <span class="text-gray-500">Formulir Penelitian</span>
        </div>

        <div class="flex flex-col lg:flex-row gap-8">
            <!-- Left Column -->
            <div class="lg:w-2/3">
                <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                    <h1 class="text-2xl font-bold text-[#004aad] mb-6">FORMULIR PERMOHONAN PENELITIAN MAHASISWA</h1>
                    
                    <!-- Form Section -->
                    <form action="{{ route('pengajuanmahasiswa.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                        @csrf
                        <!-- Hidden Status Field -->
                        <input type="hidden" name="status" value="diproses">

                        <input type="hidden" name="no_pengajuan" id="no_pengajuan">

                        <!-- Success Message -->
                        @if (session('success'))
                            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                                <span class="block sm:inline">{{ session('success') }}</span>
                            </div>
                        @endif

                        <!-- Error Messages -->
                        @if ($errors->any())
                            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <!-- Personal Data -->
                        <div class="space-y-4">
                            <h3 class="text-lg font-semibold text-[#004aad] border-b-2 border-[#004aad] pb-2">
                                DATA PEMOHON
                            </h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium mb-1">Nama Lengkap<span class="text-red-500">*</span></label>
                                    <input type="text" name="nama_lengkap" class="w-full p-2 border rounded-md" required>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium mb-1">NIM<span class="text-red-500">*</span></label>
                                    <input type="text" name="nim" class="w-full p-2 border rounded-md" required>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium mb-1">Email<span class="text-red-500">*</span></label>
                                    <input type="email" name="email" class="w-full p-2 border rounded-md" required>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium mb-1">No. HP<span class="text-red-500">*</span></label>
                                    <input type="tel" name="no_hp" class="w-full p-2 border rounded-md" required>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium mb-1">Alamat Peneliti<span class="text-red-500">*</span></label>
                                    <textarea name="alamat_peneliti" class="w-full p-2 border rounded-md" rows="3" required></textarea>
                                </div>
                            </div>
                        </div>

                        <!-- Institution Data -->
                        <div class="space-y-4">
                            <h3 class="text-lg font-semibold text-[#004aad] border-b-2 border-[#004aad] pb-2">
                                DATA INSTANSI
                            </h3>
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-sm font-medium mb-1">Nama Instansi<span class="text-red-500">*</span></label>
                                    <input type="text" name="nama_instansi" class="w-full p-2 border rounded-md" required>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium mb-1">Alamat Instansi<span class="text-red-500">*</span></label>
                                    <textarea name="alamat_instansi" class="w-full p-2 border rounded-md" rows="3" required></textarea>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium mb-1">Jurusan/Fakultas<span class="text-red-500">*</span></label>
                                    <input type="text" name="jurusan" class="w-full p-2 border rounded-md" required>
                                </div>
                            </div>
                        </div>

                        <!-- Research Data -->
                        <div class="space-y-4">
                            <h3 class="text-lg font-semibold text-[#004aad] border-b-2 border-[#004aad] pb-2">
                                DATA PENELITIAN
                            </h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium mb-1">Judul Penelitian<span class="text-red-500">*</span></label>
                                    <textarea name="judul_penelitian" class="w-full p-2 border rounded-md" rows="3" required></textarea>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium mb-1">Lama Penelitian<span class="text-red-500">*</span></label>
                                    <input type="text" name="lama_penelitian" class="w-full p-2 border rounded-md" required>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium mb-1">Tanggal Mulai<span class="text-red-500">*</span></label>
                                    <input type="date" name="tanggal_mulai" class="w-full p-2 border rounded-md" required>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium mb-1">Tanggal Selesai<span class="text-red-500">*</span></label>
                                    <input type="date" name="tanggal_selesai" class="w-full p-2 border rounded-md" required>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium mb-1">Lokasi Penelitian<span class="text-red-500">*</span></label>
                                    <textarea name="lokasi_penelitian" class="w-full p-2 border rounded-md" rows="3" required></textarea>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium mb-1">Tujuan Penelitian<span class="text-red-500">*</span></label>
                                    <input type="text" name="tujuan_penelitian" class="w-full p-2 border rounded-md" required>
                                </div>
                                <div class="w-full">
                                    <label class="block text-sm font-medium mb-1">Anggota peneliti<span class="text-red-500">*</span></label>
                                    <textarea name="anggota_peneliti" class="p-2 border rounded-md w-full sm:min-w-[400px] md:min-w-[600px] lg:min-w-[760px]" rows="5" required></textarea>
                                </div>
                            </div>
                        </div>

                        <!-- File Upload -->
                        <div class="space-y-4">
                            <h3 class="text-lg font-semibold text-[#004aad] border-b-2 border-[#004aad] pb-2">
                                BERKAS PENDUKUNG
                            </h3>
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-sm font-medium mb-1">Surat Pengantar Instansi<span class="text-red-500">*</span></label>
                                    <input type="file" name="surat_pengantar_instansi" class="w-full p-2 border rounded-md" required>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium mb-1">Proposal Penelitian<span class="text-red-500">*</span></label>
                                    <input type="file" name="proposal_penelitian" class="w-full p-2 border rounded-md" required>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium mb-1">KTP<span class="text-red-500">*</span></label>
                                    <input type="file" name="ktp" class="w-full p-2 border rounded-md" required>
                                </div>
                            </div>
                        </div>

                        <button class="w-full bg-[#004aad] text-white py-3 rounded-md hover:bg-[#003b8a] transition flex items-center justify-center font-semibold">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4" />
                            </svg>
                            KIRIM PERMOHONAN
                        </button>
                    </form>

                </div>
            </div>

            <!-- Right Column -->
            <div class="lg:w-1/3">
                <!-- Info Box -->
                <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                    <h3 class="text-lg font-semibold text-[#004aad] mb-4">INFORMASI</h3>
                    <div class="space-y-4">
                        <div class="flex items-start space-x-2">
                            <svg class="w-5 h-5 text-[#004aad] flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <p class="text-sm text-gray-600">Pastikan semua data yang diisi valid dan benar</p>
                        </div>
                        <div class="flex items-start space-x-2">
                            <svg class="w-5 h-5 text-[#004aad] flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <p class="text-sm text-gray-600">Berkas yang diupload format PDF (maks. 2MB)</p>
                        </div>
                    </div>
                </div>

                 <!-- Survey Section -->
                <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                    <h3 class="text-lg font-semibold text-[#004aad] mb-4">SURVEY PELAYANAN</h3>
                    <div class="space-y-4">
                        <p class="text-sm text-gray-600">
                            Mohon kesediaan Bapak/Ibu/Saudara/i pengguna layanan PTSP melalui PEPADU IC dapat memberikan Feedback berupa kritik/saran yang membangun untuk meningkatkan pelayanan kami.
                        </p>
                        <a href="{{ route('survei') }}" class="w-full bg-[#004aad] text-white py-2 rounded-md hover:bg-[#003b8a] transition flex items-center justify-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            <span>Isi Survey</span>
                        </a>
                    </div>
                </div>

                <!-- Status Check -->
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h3 class="text-lg font-semibold text-[#004aad] mb-4">CEK STATUS PENGAJUAN</h3>
                    <form method="POST" action="{{ route('pantau.cek') }}" class="flex gap-2">
                        @csrf
                        <input 
                            type="text" 
                            name="no_pengajuan" 
                            placeholder="Nomor Registrasi" 
                            class="flex-1 p-2 border rounded-md"
                            required
                        >
                        <button 
                            type="submit" 
                            class="bg-[#004aad] text-white px-4 py-2 rounded-md hover:bg-[#003b8a] transition"
                        >
                            CEK
                        </button>
                    </form>
                    @if(session('error'))
                        <div class="mt-2 text-red-500 text-sm">{{ session('error') }}</div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    
</body>

@include('Layout.App.footer')
