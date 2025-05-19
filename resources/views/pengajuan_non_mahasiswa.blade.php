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
            <div class="lg:w-2/3">
                <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                    <h1 class="text-2xl font-bold text-[#004aad] mb-6">FORMULIR PERMOHONAN PENELITIAN NON MAHASISWA</h1>
                    
                    <!-- Form Section -->
                    <form action="{{ route('pengajuannonmahasiswa.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
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

                        <!-- Notifikasi Pengajuan Sebelumnya Ditolak -->
                        @if(isset($nonMahasiswa) && isset($rejectionReason))
                        <div class="bg-yellow-100 border-l-4 border-yellow-500 p-4 mb-6">
                            <div class="flex items-start">
                                <div class="flex-shrink-0">
                                    <svg class="h-5 w-5 text-yellow-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <h3 class="text-sm font-medium text-yellow-800">Pengajuan Sebelumnya Ditolak</h3>
                                    <div class="mt-2 text-sm text-yellow-700">
                                        <p><strong>Alasan Penolakan:</strong> {{ $rejectionReason }}</p>
                                        <p class="mt-1">Silahkan perbaiki data dan dokumen Anda sesuai dengan alasan penolakan di atas. Dokumen sebelumnya dapat dilihat dengan mengklik "Lihat dokumen sebelumnya" di bawah masing-masing field upload.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif

                        <!-- Hidden field untuk menandai ini adalah pengajuan ulang -->
                        @if(isset($nonMahasiswa))
                            <input type="hidden" name="existing_id" value="{{ $nonMahasiswa->id }}">
                            <input type="hidden" name="no_pengajuan" value="{{ $nonMahasiswa->no_pengajuan }}">
                        @endif

                        <!-- Data Peneliti -->
                        <div class="space-y-4">
                            <h3 class="text-lg font-semibold text-[#004aad] border-b-2 border-[#004aad] pb-2">
                                DATA PENELITI
                            </h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium mb-1">Nama Lengkap<span class="text-red-500">*</span></label>
                                    <input type="text" name="nama_lengkap" class="w-full p-2 border rounded-md" required value="{{ $nonMahasiswa->nama_lengkap ?? old('nama_lengkap') }}">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium mb-1">Jabatan<span class="text-red-500">*</span></label>
                                    <input type="text" name="jabatan" class="w-full p-2 border rounded-md" required value="{{ $nonMahasiswa->jabatan ?? old('jabatan') }}">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium mb-1">Email<span class="text-red-500">*</span></label>
                                    <input type="email" name="email" class="w-full p-2 border rounded-md" required value="{{ $nonMahasiswa->email ?? old('email') }}">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium mb-1">No. HP<span class="text-red-500">*</span></label>
                                    <input type="tel" name="no_hp" class="w-full p-2 border rounded-md" required value="{{ $nonMahasiswa->no_hp ?? old('no_hp') }}">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium mb-1">Alamat Peneliti<span class="text-red-500">*</span></label>
                                    <textarea name="alamat_peneliti" class="w-full p-2 border rounded-md" rows="3" required>{{ $nonMahasiswa->alamat_peneliti ?? old('alamat_peneliti') }}</textarea>
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
                                    <input type="text" name="nama_instansi" class="w-full p-2 border rounded-md" required value="{{ $nonMahasiswa->nama_instansi ?? old('nama_instansi') }}">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium mb-1">Alamat Instansi<span class="text-red-500">*</span></label>
                                    <textarea name="alamat_instansi" class="w-full p-2 border rounded-md" rows="3" required>{{ $nonMahasiswa->alamat_instansi ?? old('alamat_instansi') }}</textarea>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium mb-1">Bidang<span class="text-red-500">*</span></label>
                                    <input type="text" name="bidang" class="w-full p-2 border rounded-md" required value="{{ $nonMahasiswa->bidang ?? old('bidang') }}">
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
                                    <textarea name="judul_penelitian" class="w-full p-2 border rounded-md" rows="3" required>{{ $nonMahasiswa->judul_penelitian ?? old('judul_penelitian') }}</textarea>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium mb-1">Lama Penelitian<span class="text-red-500">*</span></label>
                                    <input type="text" name="lama_penelitian" class="w-full p-2 border rounded-md" required value="{{ $nonMahasiswa->lama_penelitian ?? old('lama_penelitian') }}">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium mb-1">Tanggal Mulai<span class="text-red-500">*</span></label>
                                    <input type="date" name="tanggal_mulai" class="w-full p-2 border rounded-md" required value="{{ $nonMahasiswa->tanggal_mulai ?? old('tanggal_mulai') }}">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium mb-1">Tanggal Selesai<span class="text-red-500">*</span></label>
                                    <input type="date" name="tanggal_selesai" class="w-full p-2 border rounded-md" required value="{{ $nonMahasiswa->tanggal_selesai ?? old('tanggal_selesai') }}">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium mb-1">Lokasi Penelitian<span class="text-red-500">*</span></label>
                                    <textarea name="lokasi_penelitian" class="w-full p-2 border rounded-md" rows="3" required>{{ $nonMahasiswa->lokasi_penelitian ?? old('lokasi_penelitian') }}</textarea>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium mb-1">Tujuan Penelitian<span class="text-red-500">*</span></label>
                                    <input type="text" name="tujuan_penelitian" class="w-full p-2 border rounded-md" required value="{{ $nonMahasiswa->tujuan_penelitian ?? old('tujuan_penelitian') }}">
                                </div>
                                <div class="w-full">
                                    <label class="block text-sm font-medium mb-1">Anggota peneliti<span class="text-red-500">*</span></label>
                                    <textarea name="anggota_peneliti" class="p-2 border rounded-md w-full sm:min-w-[400px] md:min-w-[600px] lg:min-w-[760px]" rows="5" required>{{ $nonMahasiswa->anggota_peneliti ?? old('anggota_peneliti') }}</textarea>
                                </div>
                            </div>
                        </div>

                        <!-- Berkas Administrasi -->
                        <div class="space-y-4">
                            <h3 class="text-lg font-semibold text-[#004aad] border-b-2 border-[#004aad] pb-2">
                                DOKUMEN REQUISIT
                            </h3>
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-sm font-medium mb-1">Surat Pengantar Instansi<span class="text-red-500">*</span></label>
                                    <input type="file" name="surat_pengantar_instansi" class="w-full p-2 border rounded-md" required>
                                    @if(isset($nonMahasiswa) && $nonMahasiswa->surat_pengantar_instansi)
                                        <div class="flex items-center mt-2">
                                            <p class="text-xs text-gray-500">File sebelumnya: </p>
                                            <a href="{{ Storage::url($nonMahasiswa->surat_pengantar_instansi) }}" target="_blank" class="ml-2 text-xs text-blue-600 hover:text-blue-800 hover:underline flex items-center">
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                                </svg>
                                                Lihat dokumen sebelumnya
                                            </a>
                                        </div>
                                    @endif
                                </div>
                                <div>
                                    <label class="block text-sm font-medium mb-1">Akta Notaris Lembaga<span class="text-red-500">*</span></label>
                                    <input type="file" name="akta_notaris_lembaga" class="w-full p-2 border rounded-md" required>
                                    @if(isset($nonMahasiswa) && $nonMahasiswa->akta_notaris_lembaga)
                                        <div class="flex items-center mt-2">
                                            <p class="text-xs text-gray-500">File sebelumnya: </p>
                                            <a href="{{ Storage::url($nonMahasiswa->akta_notaris_lembaga) }}" target="_blank" class="ml-2 text-xs text-blue-600 hover:text-blue-800 hover:underline flex items-center">
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                                </svg>
                                                Lihat dokumen sebelumnya
                                            </a>
                                        </div>
                                    @endif
                                </div>
                                <div>
                                    <label class="block text-sm font-medium mb-1">Surat Terdaftar Kemenkumham<span class="text-red-500">*</span></label>
                                    <input type="file" name="surat_terdaftar_kemenkumham" class="w-full p-2 border rounded-md" required>
                                    @if(isset($nonMahasiswa) && $nonMahasiswa->surat_terdaftar_kemenkumham)
                                        <div class="flex items-center mt-2">
                                            <p class="text-xs text-gray-500">File sebelumnya: </p>
                                            <a href="{{ Storage::url($nonMahasiswa->surat_terdaftar_kemenkumham) }}" target="_blank" class="ml-2 text-xs text-blue-600 hover:text-blue-800 hover:underline flex items-center">
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                                </svg>
                                                Lihat dokumen sebelumnya
                                            </a>
                                        </div>
                                    @endif
                                </div>
                                <div>
                                    <label class="block text-sm font-medium mb-1">KTP Ketua Peneliti<span class="text-red-500">*</span></label>
                                    <input type="file" name="ktp" class="w-full p-2 border rounded-md" required>
                                    @if(isset($nonMahasiswa) && $nonMahasiswa->ktp)
                                        <div class="flex items-center mt-2">
                                            <p class="text-xs text-gray-500">File sebelumnya: </p>
                                            <a href="{{ Storage::url($nonMahasiswa->ktp) }}" target="_blank" class="ml-2 text-xs text-blue-600 hover:text-blue-800 hover:underline flex items-center">
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                                </svg>
                                                Lihat dokumen sebelumnya
                                            </a>
                                        </div>
                                    @endif
                                </div>
                                <div>
                                    <label class="block text-sm font-medium mb-1">Proposal Penelitian<span class="text-red-500">*</span></label>
                                    <input type="file" name="proposal_penelitian" class="w-full p-2 border rounded-md" required>
                                    @if(isset($nonMahasiswa) && $nonMahasiswa->proposal_penelitian)
                                        <div class="flex items-center mt-2">
                                            <p class="text-xs text-gray-500">File sebelumnya: </p>
                                            <a href="{{ Storage::url($nonMahasiswa->proposal_penelitian) }}" target="_blank" class="ml-2 text-xs text-blue-600 hover:text-blue-800 hover:underline flex items-center">
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                                </svg>
                                                Lihat dokumen sebelumnya
                                            </a>
                                        </div>
                                    @endif
                                </div>
                                <div>
                                    <label class="block text-sm font-medium mb-1">Surat pernyataan bersedia memberikan hasil survei<span class="text-red-500">*</span></label>
                                    <input type="file" name="surat_pernyataan" class="w-full p-2 border rounded-md" required>
                                    @if(isset($nonMahasiswa) && $nonMahasiswa->surat_pernyataan)
                                        <div class="flex items-center mt-2">
                                            <p class="text-xs text-gray-500">File sebelumnya: </p>
                                            <a href="{{ Storage::url($nonMahasiswa->surat_pernyataan) }}" target="_blank" class="ml-2 text-xs text-blue-600 hover:text-blue-800 hover:underline flex items-center">
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                                </svg>
                                                Lihat dokumen sebelumnya
                                            </a>
                                        </div>
                                    @endif
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
                        <div class="flex items-start space-x-2">
                            <svg class="w-5 h-5 text-[#004aad] flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <p class="text-sm text-gray-600">Proposal Penelitian maks. 10 halaman jadi tidak perlu di sertakan semuanya</p>
                        </div>
                        <div class="flex items-start space-x-2 mt-4">
                            <svg class="w-5 h-5 text-[#004aad] flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <p class="text-sm text-gray-600">
                                Jika pengajuan sebelumnya ditolak, Anda bisa <a href="{{ route('pantau') }}" class="text-blue-600 hover:underline">cek status</a> untuk mengajukan ulang dengan perbaikan.
                            </p>
                        </div>
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
