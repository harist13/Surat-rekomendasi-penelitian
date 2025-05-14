@php use Carbon\Carbon; @endphp

@include('Staff.Layout.App.Header')
<body class="bg-gradient-to-r from-green-100 to-blue-100">
    @include('Staff.Layout.App.Sidebar')
    
    <div class="md:ml-64 pt-16 min-h-screen transition-all duration-300" id="main-content">
        <button id="menu-toggle" class="md:hidden fixed top-4 left-4 z-50 p-2 bg-white rounded-lg shadow">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
            </svg>
        </button>

        <div class="p-8">
            <div class="flex justify-between items-center mb-8">
                <h1 class="text-2xl font-bold text-gray-800">Manajemen Data Surat</h1>
                <div class="text-gray-600">
                    Selamat Datang Staff, <span class="font-semibold text-blue-600">{{ auth()->user()->username }}</span>
                </div>
            </div>

            <!-- Document Download Alert -->
            @if(session('document_path'))
            <div id="download-alert" class="flex items-center p-4 mb-4 text-green-800 border-t-4 border-green-500 bg-green-50" role="alert">
                <svg class="flex-shrink-0 w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zm-1 9a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd"></path>
                </svg>
                <div class="ml-3 text-sm font-medium">
                    Surat berhasil dibuat! Anda dapat mengunduh dokumen Word dengan klik tombol berikut:
                    <a href="{{ route('penerbitan.download', ['id' => session('surat_id') ?? $penerbitanSurats->first()->id ?? 0]) }}" class="ml-2 inline-flex items-center px-3 py-1.5 text-white bg-green-700 rounded-md hover:bg-green-800 focus:ring-2 focus:ring-green-500">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        Unduh Dokumen
                    </a>
                </div>
                <button type="button" class="ml-auto -mx-1.5 -my-1.5 bg-green-50 text-green-500 rounded-lg focus:ring-2 focus:ring-green-400 p-1.5 hover:bg-green-200 inline-flex h-8 w-8" data-dismiss-target="#download-alert" aria-label="Close">
                    <span class="sr-only">Tutup</span>
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                    </svg>
                </button>
            </div>
            @endif

            <!-- Alert Messages -->
            <div class="mb-6">
                @if(session('success'))
                <div id="success-alert" class="flex items-center p-4 mb-4 text-green-800 border-t-4 border-green-500 bg-green-50" role="alert">
                    <svg class="flex-shrink-0 w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zm-1 9a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd"></path>
                    </svg>
                    <div class="ml-3 text-sm font-medium">
                        {{ session('success') }}
                    </div>
                    <button type="button" class="ml-auto -mx-1.5 -my-1.5 bg-green-50 text-green-500 rounded-lg focus:ring-2 focus:ring-green-400 p-1.5 hover:bg-green-200 inline-flex h-8 w-8" data-dismiss-target="#success-alert" aria-label="Close">
                        <span class="sr-only">Tutup</span>
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                        </svg>
                    </button>
                </div>
                @endif

                @if(session('error'))
                <div id="error-alert" class="flex items-center p-4 mb-4 text-red-800 border-t-4 border-red-500 bg-red-50" role="alert">
                    <svg class="flex-shrink-0 w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zm-1 9a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd"></path>
                    </svg>
                    <div class="ml-3 text-sm font-medium">
                        {{ session('error') }}
                    </div>
                    <button type="button" class="ml-auto -mx-1.5 -my-1.5 bg-red-50 text-red-500 rounded-lg focus:ring-2 focus:ring-red-400 p-1.5 hover:bg-red-200 inline-flex h-8 w-8" data-dismiss-target="#error-alert" aria-label="Close">
                        <span class="sr-only">Tutup</span>
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                        </svg>
                    </button>
                </div>
                @endif
            </div>

            <div class="bg-white p-6 rounded-lg shadow-md mb-8">
                <div class="flex justify-between items-center mb-6">
                    <div class="flex items-center space-x-2">
                       <div class="px-4 py-2 bg-blue-600 text-white rounded-lg font-medium">
                            List Data Surat
                        </div>
                    </div>

                    <div class="flex items-center space-x-2">
                         <form id="main-filter-form" action="{{ route('datasurat') }}" method="GET" class="flex items-center space-x-2">
                            <div class="relative">
                                <select id="main-entries-select" name="per_page" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                                    <option value="10" {{ $perPage == 10 ? 'selected' : '' }}>10</option>
                                    <option value="25" {{ $perPage == 25 ? 'selected' : '' }}>25</option>
                                    <option value="50" {{ $perPage == 50 ? 'selected' : '' }}>50</option>
                                    <option value="100" {{ $perPage == 100 ? 'selected' : '' }}>100</option>
                                </select>
                            </div>
                            
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                    <svg class="w-4 h-4 text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                                    </svg>
                                </div>
                                <input type="text" name="search" id="main-search-input" class="block w-60 p-2.5 pl-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500" placeholder="Cari Data Surat" value="{{ request('search') }}">
                                <button type="submit" class="absolute inset-y-0 right-0 flex items-center px-4 text-sm font-medium text-white bg-blue-600 rounded-r-lg hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300">
                                    Cari
                                </button>
                            </div>
                            
                            <!-- Keep published table parameters when submitting main form -->
                            <input type="hidden" name="search_published" value="{{ request('search_published') }}">
                            <input type="hidden" name="per_page_published" value="{{ request('per_page_published', 10) }}">
                        
                            
                        </form>
                    </div>
                </div>
                
                <div class="overflow-x-auto rounded-lg border border-gray-200">
                <table class="w-full text-sm text-left border-collapse">
                    <thead class="text-gray-700 bg-gray-100">
                        <tr class="text-white bg-[#004aad]">
                            <th class="px-4 py-3 border border-gray-300 w-12">No</th>
                            <th class="px-4 py-3 border border-gray-300 min-w-[150px]">No Pengajuan</th>
                            <th class="px-4 py-3 border border-gray-300 min-w-[150px]">Nama</th>
                            <th class="px-4 py-3 border border-gray-300 min-w-[150px]">Jabatan</th>
                            <th class="px-4 py-3 border border-gray-300 min-w-[180px]">No telpon</th>
                            <th class="px-4 py-3 border border-gray-300 min-w-[150px]">Nama Lembaga</th>
                            <th class="px-4 py-3 border border-gray-300 min-w-[200px]">Judul Proposal</th>
                            <th class="px-4 py-3 border border-gray-300 min-w-[150px]">Lokasi Penelitian</th>
                            <th class="px-4 py-3 border border-gray-300 min-w-[150px]">Waktu Penelitian</th>
                            <th class="px-4 py-3 border border-gray-300 min-w-[150px]">Bidang Penelitian</th>
                            <th class="px-4 py-3 border border-gray-300 w-40">Anggota Penelitian</th>
                            <th class="px-4 py-3 border border-gray-300 w-32">Status Penelitian</th>
                            <th class="px-4 py-3 border border-gray-300 w-32">Nomor Surat</th>
                            <th class="px-4 py-3 border border-gray-300 w-32">Menimbang</th>
                            <th class="px-4 py-3 border border-gray-300 min-w-[120px]">Status surat</th>
                            <th class="px-4 py-3 border border-gray-300 w-40">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($penerbitanSurats->where('status_surat', '!=', 'diterbitkan') as $index => $surat)
                        <tr class="bg-white hover:bg-gray-50">
                            <td class="px-4 py-3 border border-gray-200">{{ $index + 1 }}</td>
                            <td class="px-4 py-3 border border-gray-200">
                                @if($surat->jenis_surat === 'mahasiswa' && $surat->mahasiswa)
                                    {{ $surat->mahasiswa->no_pengajuan ?? 'Tidak tersedia' }}
                                @elseif($surat->jenis_surat === 'non_mahasiswa' && $surat->nonMahasiswa)
                                    {{ $surat->nonMahasiswa->no_pengajuan ?? 'Tidak tersedia' }}
                                @else
                                    <span class="text-red-500">Data tidak tersedia</span>
                                @endif
                            </td>
                            <td class="px-4 py-3 border border-gray-200">
                                @if($surat->jenis_surat === 'mahasiswa' && $surat->mahasiswa)
                                    {{ $surat->mahasiswa->nama_lengkap }}
                                @elseif($surat->jenis_surat === 'non_mahasiswa' && $surat->nonMahasiswa)
                                    {{ $surat->nonMahasiswa->nama_lengkap }}
                                @else
                                    <span class="text-red-500">Data tidak tersedia</span>
                                @endif
                            </td>
                            <td class="px-4 py-3 border border-gray-200">
                                @if($surat->jenis_surat === 'mahasiswa')
                                    Mahasiswa
                                @elseif($surat->nonMahasiswa)
                                    {{ $surat->nonMahasiswa->jabatan }}
                                @else
                                    <span class="text-red-500">Data tidak tersedia</span>
                                @endif
                            </td>
                            <td class="px-4 py-3 border border-gray-200">
                                @if($surat->jenis_surat === 'mahasiswa' && $surat->mahasiswa)
                                    {{ $surat->mahasiswa->no_hp }}
                                @elseif($surat->jenis_surat === 'non_mahasiswa' && $surat->nonMahasiswa)
                                    {{ $surat->nonMahasiswa->no_hp }}
                                @else
                                    <span class="text-red-500">Data tidak tersedia</span>
                                @endif
                            </td>
                            <td class="px-4 py-3 border border-gray-200">
                                @if($surat->jenis_surat === 'mahasiswa' && $surat->mahasiswa)
                                    {{ $surat->mahasiswa->nama_instansi }}
                                @elseif($surat->jenis_surat === 'non_mahasiswa' && $surat->nonMahasiswa)
                                    {{ $surat->nonMahasiswa->nama_instansi }}
                                @else
                                    <span class="text-red-500">Data tidak tersedia</span>
                                @endif
                            </td>
                            <td class="px-4 py-3 border border-gray-200">
                                @if($surat->jenis_surat === 'mahasiswa' && $surat->mahasiswa)
                                    {{ $surat->mahasiswa->judul_penelitian }}
                                @elseif($surat->jenis_surat === 'non_mahasiswa' && $surat->nonMahasiswa)
                                    {{ $surat->nonMahasiswa->judul_penelitian }}
                                @else
                                    <span class="text-red-500">Data tidak tersedia</span>
                                @endif
                            </td>
                            <td class="px-4 py-3 border border-gray-200">
                                @if($surat->jenis_surat === 'mahasiswa' && $surat->mahasiswa)
                                    {{ $surat->mahasiswa->lokasi_penelitian }}
                                @elseif($surat->jenis_surat === 'non_mahasiswa' && $surat->nonMahasiswa)
                                    {{ $surat->nonMahasiswa->lokasi_penelitian }}
                                @else
                                    <span class="text-red-500">Data tidak tersedia</span>
                                @endif
                            </td>
                            <td class="px-4 py-3 border border-gray-200">
                                @if($surat->jenis_surat === 'mahasiswa' && $surat->mahasiswa)
                                    @if($surat->mahasiswa->tanggal_mulai && $surat->mahasiswa->tanggal_selesai)
                                        {{ Carbon::parse($surat->mahasiswa->tanggal_mulai)->locale('id')->translatedFormat('d-M-Y') }}
                                        s.d
                                        {{ Carbon::parse($surat->mahasiswa->tanggal_selesai)->locale('id')->translatedFormat('d-M-Y') }}
                                        @if($surat->mahasiswa->lama_penelitian)
                                            ({{ $surat->mahasiswa->lama_penelitian }})
                                        @endif
                                    @elseif($surat->mahasiswa->lama_penelitian)
                                        {{ $surat->mahasiswa->lama_penelitian }}
                                    @else
                                        <span class="text-red-500">Data tidak tersedia</span>
                                    @endif
                                @elseif($surat->jenis_surat === 'non_mahasiswa' && $surat->nonMahasiswa)
                                    @if($surat->nonMahasiswa->tanggal_mulai && $surat->nonMahasiswa->tanggal_selesai)
                                        {{ Carbon::parse($surat->nonMahasiswa->tanggal_mulai)->locale('id')->translatedFormat('d-M-Y') }}
                                        s.d
                                        {{ Carbon::parse($surat->nonMahasiswa->tanggal_selesai)->locale('id')->translatedFormat('d-M-Y') }}
                                        @if($surat->nonMahasiswa->lama_penelitian)
                                            ({{ $surat->nonMahasiswa->lama_penelitian }})
                                        @endif
                                    @elseif($surat->nonMahasiswa->lama_penelitian)
                                        {{ $surat->nonMahasiswa->lama_penelitian }}
                                    @else
                                        <span class="text-red-500">Data tidak tersedia</span>
                                    @endif
                                @else
                                    <span class="text-red-500">Data tidak tersedia</span>
                                @endif
                            </td>
                            <td class="px-4 py-3 border border-gray-200">
                                @if($surat->jenis_surat === 'mahasiswa' && $surat->mahasiswa)
                                    {{ $surat->mahasiswa->jurusan ?? 'Data tidak tersedia' }}
                                @elseif($surat->jenis_surat === 'non_mahasiswa' && $surat->nonMahasiswa)
                                    {{ $surat->nonMahasiswa->bidang ?? 'Data tidak tersedia' }}
                                @else
                                    <span class="text-red-500">Data tidak tersedia</span>
                                @endif
                            </td>
                            <td class="px-4 py-3 border border-gray-200">
                                @if($surat->jenis_surat === 'mahasiswa' && $surat->mahasiswa && $surat->mahasiswa->anggota_peneliti)
                                    <button type="button" class="text-blue-500 hover:text-blue-700" 
                                            onclick="showAnggotaModal('{{ addslashes(json_encode($surat->mahasiswa->anggota_peneliti)) }}', 
                                            '{{ addslashes($surat->mahasiswa->nama_lengkap) }}')">
                                        Lihat Anggota
                                    </button>
                                @elseif($surat->jenis_surat === 'non_mahasiswa' && $surat->nonMahasiswa && $surat->nonMahasiswa->anggota_peneliti)
                                    <button type="button" class="text-blue-500 hover:text-blue-700" 
                                            onclick="showAnggotaModal('{{ addslashes(json_encode($surat->nonMahasiswa->anggota_peneliti)) }}', 
                                            '{{ addslashes($surat->nonMahasiswa->nama_lengkap) }}')">
                                        Lihat Anggota
                                    </button>
                                @else
                                    <span class="text-gray-500">Tidak ada anggota</span>
                                @endif
                            </td>
                            <td class="px-4 py-3 border border-gray-200">
                                <span class="px-2 py-1 text-xs font-semibold rounded-full 
                                    {{ $surat->status_penelitian === 'baru' ? 'bg-green-100 text-green-800' : 
                                       ($surat->status_penelitian === 'lanjutan' ? 'bg-blue-100 text-blue-800' : 'bg-purple-100 text-purple-800') }}">
                                    {{ ucfirst($surat->status_penelitian) }}
                                </span>
                            </td>
                            <td class="px-4 py-3 border border-gray-200">
                                {{ $surat->nomor_surat }}
                            </td>
                            <!-- Add this cell in the <tbody> section after the "Nomor Surat" cell in both tables -->
                            <td class="px-4 py-3 border border-gray-200">
                                @if($surat->menimbang)
                                    <button type="button" class="text-blue-500 hover:text-blue-700" 
                                            onclick="showMenimbangModal('{{ addslashes($surat->menimbang) }}', 
                                            '{{ $surat->nomor_surat }}')">
                                        Lihat Pertimbangan
                                    </button>
                                @else
                                    <span class="text-gray-500">Tidak ada</span>
                                @endif
                            </td>
                            <td class="px-4 py-3 border border-gray-200">
                                @if($surat->status_surat == 'draft')
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                        Draft
                                    </span>
                                @elseif($surat->status_surat == 'diterbitkan')
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                        Diterbitkan
                                    </span>
                                @else
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-800">
                                        {{ $surat->status_surat }}
                                    </span>
                                @endif
                            </td>
                            <td class="px-4 py-3 border border-gray-200">
                                <div class="flex space-x-2 justify-center">
                                    @if($surat->status_surat == 'draft')
                                        <button type="button" class="text-green-500 hover:text-green-700 p-1" 
                                                onclick="openConfirmStatusModal('{{ $surat->id }}', 
                                                '{{ $surat->jenis_surat === 'mahasiswa' && $surat->mahasiswa ? $surat->mahasiswa->nama_lengkap : ($surat->jenis_surat === 'non_mahasiswa' && $surat->nonMahasiswa ? $surat->nonMahasiswa->nama_lengkap : 'Tidak tersedia') }}',
                                                '{{ $surat->nomor_surat }}')" 
                                                title="Terbitkan Surat">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                            </svg>
                                        </button>
                                    @endif
                                     <button type="button" class="text-blue-500 hover:text-blue-700 p-1" 
                                        onclick="openEditSuratModal('{{ $surat->id }}', '{{ $surat->nomor_surat }}', '{{ addslashes($surat->menimbang ?? '') }}', {{ isset($surat->file_path) ? 'true' : 'false' }})" 
                                        title="Edit Surat">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path>
                                        </svg>
                                    </button>

                                    <form action="{{ route('penerbitan.destroy', $surat->id) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus surat ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-500 hover:text-red-700 p-1" title="Hapus">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                            </svg>
                                        </button>
                                    </form>
                                   
                                     <!-- Modified PDF download button - only show if no file is uploaded -->
                                    @if(!isset($surat->file_path) || empty($surat->file_path))
                                    <a href="{{ route('penerbitan.download', $surat->id) }}" class="text-green-500 hover:text-green-700 p-1" title="Unduh Pdf">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                        </svg>
                                    </a>
                                    @endif
                                    
                                    <!-- Tombol Download File yang Diupload (hanya muncul jika ada file) -->
                                    @if(isset($surat->file_path) && !empty($surat->file_path))
                                    <a href="{{ route('penerbitan.downloadFile', $surat->id) }}" class="text-green-500 hover:text-green-700 p-1" title="Unduh File Surat Terupload">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                        </svg>
                                    </a>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr class="bg-white">
                            <td colspan="17" class="px-4 py-3 border border-gray-200 text-center text-gray-500">
                                Belum ada data surat yang belum diterbitkan
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

                <!-- Pagination for main table -->
                <div class="flex justify-between items-center mt-6">
                    <div class="text-sm text-gray-600">
                        Menampilkan {{ $penerbitanSurats->where('status_surat', '!=', 'diterbitkan')->count() > 0 ? ($penerbitanSurats->firstItem() ?? 0) : 0 }} sampai {{ $penerbitanSurats->where('status_surat', '!=', 'diterbitkan')->count() > 0 ? ($penerbitanSurats->lastItem() ?? 0) : 0 }} dari {{ $penerbitanSurats->total() }} Total Data
                    </div>
                    <div class="flex">
                        {{ $penerbitanSurats->appends([
                            'search' => request('search'), 
                            'per_page' => $perPage,
                            'search_published' => request('search_published'),
                            'per_page_published' => request('per_page_published', 10)
                        ])->links() }}
                    </div>
                </div>

                <!-- Data Surat Diterbitkan Section -->
                <div class="mt-12 mb-8">
                    <div class="flex justify-between items-center mb-6">
                        <div class="flex items-center space-x-2">
                            <div class="px-4 py-2 bg-green-100 text-green-700 rounded-lg font-medium">
                                Data Surat Diterbitkan
                            </div>
                        </div>
                        
                        <!-- Add search and per-page for published table -->
                        <div class="flex items-center space-x-2">
                            <form id="published-filter-form" action="{{ route('datasurat') }}" method="GET" class="flex items-center space-x-2">
                                <div class="relative">
                                    <select id="published-entries-select" name="per_page_published" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-green-500 focus:border-green-500 block w-full p-2.5">
                                        <option value="10" {{ (request('per_page_published', 10) == 10) ? 'selected' : '' }}>10</option>
                                        <option value="25" {{ (request('per_page_published', 10) == 25) ? 'selected' : '' }}>25</option>
                                        <option value="50" {{ (request('per_page_published', 10) == 50) ? 'selected' : '' }}>50</option>
                                        <option value="100" {{ (request('per_page_published', 10) == 100) ? 'selected' : '' }}>100</option>
                                    </select>
                                </div>
                                
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                        <svg class="w-4 h-4 text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                                        </svg>
                                    </div>
                                    <input type="text" name="search_published" id="published-search-input" class="block w-60 p-2.5 pl-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-green-500 focus:border-green-500" placeholder="Cari Surat Diterbitkan" value="{{ request('search_published') }}">
                                    <button type="submit" class="absolute inset-y-0 right-0 flex items-center px-4 text-sm font-medium text-white bg-green-600 rounded-r-lg hover:bg-green-700 focus:ring-4 focus:outline-none focus:ring-green-300">
                                        Cari
                                    </button>
                                </div>
                                
                                <!-- Keep main table parameters when submitting published form -->
                                <input type="hidden" name="search" value="{{ request('search') }}">
                                <input type="hidden" name="per_page" value="{{ $perPage }}">
                            </form>
                        </div>
                    </div>
                    
                    <div class="overflow-x-auto rounded-lg border border-gray-200">
                        <table class="w-full text-sm text-left border-collapse">
                            <thead class="text-gray-700 bg-gray-100">
                                <tr class="text-white bg-[#004aad]">
                                    <th class="px-4 py-3 border border-gray-300 w-12">No</th>
                                    <th class="px-4 py-3 border border-gray-300 min-w-[150px]">No Pengajuan</th>
                                    <th class="px-4 py-3 border border-gray-300 min-w-[150px]">Nama</th>
                                    <th class="px-4 py-3 border border-gray-300 min-w-[150px]">Jabatan</th>
                                    <th class="px-4 py-3 border border-gray-300 min-w-[180px]">No telpon</th>
                                    <th class="px-4 py-3 border border-gray-300 min-w-[150px]">Nama Lembaga</th>
                                    <th class="px-4 py-3 border border-gray-300 min-w-[200px]">Judul Proposal</th>
                                    <th class="px-4 py-3 border border-gray-300 min-w-[150px]">Lokasi Penelitian</th>
                                    <th class="px-4 py-3 border border-gray-300 min-w-[150px]">Waktu Penelitian</th>
                                    <th class="px-4 py-3 border border-gray-300 min-w-[150px]">Bidang Penelitian</th>
                                    <th class="px-4 py-3 border border-gray-300 w-32">Status Penelitian</th>
                                    <th class="px-4 py-3 border border-gray-300 w-32">Nomor Surat</th>
                                    <th class="px-4 py-3 border border-gray-300 w-32">Menimbang</th>
                                    <th class="px-4 py-3 border border-gray-300 min-w-[120px]">Status surat</th>
                                    <th class="px-4 py-3 border border-gray-300 w-40">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($penerbitanSuratsPublished ?? $penerbitanSurats->where('status_surat', 'diterbitkan') as $index => $surat)
                                <tr class="bg-white hover:bg-gray-50">
                                    <td class="px-4 py-3 border border-gray-200">{{ $index + 1 }}</td>
                                    <td class="px-4 py-3 border border-gray-200">
                                        @if($surat->jenis_surat === 'mahasiswa' && $surat->mahasiswa)
                                            {{ $surat->mahasiswa->no_pengajuan ?? 'Tidak tersedia' }}
                                        @elseif($surat->jenis_surat === 'non_mahasiswa' && $surat->nonMahasiswa)
                                            {{ $surat->nonMahasiswa->no_pengajuan ?? 'Tidak tersedia' }}
                                        @else
                                            <span class="text-red-500">Data tidak tersedia</span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-3 border border-gray-200">
                                        @if($surat->jenis_surat === 'mahasiswa' && $surat->mahasiswa)
                                            {{ $surat->mahasiswa->nama_lengkap }}
                                        @elseif($surat->jenis_surat === 'non_mahasiswa' && $surat->nonMahasiswa)
                                            {{ $surat->nonMahasiswa->nama_lengkap }}
                                        @else
                                            <span class="text-red-500">Data tidak tersedia</span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-3 border border-gray-200">
                                        @if($surat->jenis_surat === 'mahasiswa')
                                            Mahasiswa
                                        @elseif($surat->nonMahasiswa)
                                            {{ $surat->nonMahasiswa->jabatan }}
                                        @else
                                            <span class="text-red-500">Data tidak tersedia</span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-3 border border-gray-200">
                                        @if($surat->jenis_surat === 'mahasiswa' && $surat->mahasiswa)
                                            {{ $surat->mahasiswa->no_hp }}
                                        @elseif($surat->jenis_surat === 'non_mahasiswa' && $surat->nonMahasiswa)
                                            {{ $surat->nonMahasiswa->no_hp }}
                                        @else
                                            <span class="text-red-500">Data tidak tersedia</span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-3 border border-gray-200">
                                        @if($surat->jenis_surat === 'mahasiswa' && $surat->mahasiswa)
                                            {{ $surat->mahasiswa->nama_instansi }}
                                        @elseif($surat->jenis_surat === 'non_mahasiswa' && $surat->nonMahasiswa)
                                            {{ $surat->nonMahasiswa->nama_instansi }}
                                        @else
                                            <span class="text-red-500">Data tidak tersedia</span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-3 border border-gray-200">
                                        @if($surat->jenis_surat === 'mahasiswa' && $surat->mahasiswa)
                                            {{ $surat->mahasiswa->judul_penelitian }}
                                        @elseif($surat->jenis_surat === 'non_mahasiswa' && $surat->nonMahasiswa)
                                            {{ $surat->nonMahasiswa->judul_penelitian }}
                                        @else
                                            <span class="text-red-500">Data tidak tersedia</span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-3 border border-gray-200">
                                        @if($surat->jenis_surat === 'mahasiswa' && $surat->mahasiswa)
                                            {{ $surat->mahasiswa->lokasi_penelitian }}
                                        @elseif($surat->jenis_surat === 'non_mahasiswa' && $surat->nonMahasiswa)
                                            {{ $surat->nonMahasiswa->lokasi_penelitian }}
                                        @else
                                            <span class="text-red-500">Data tidak tersedia</span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-3 border border-gray-200">
                                        @if($surat->jenis_surat === 'mahasiswa' && $surat->mahasiswa)
                                            @if($surat->mahasiswa->tanggal_mulai && $surat->mahasiswa->tanggal_selesai)
                                                {{ Carbon::parse($surat->mahasiswa->tanggal_mulai)->locale('id')->translatedFormat('d-M-Y') }}
                                                s.d
                                                {{ Carbon::parse($surat->mahasiswa->tanggal_selesai)->locale('id')->translatedFormat('d-M-Y') }}
                                                @if($surat->mahasiswa->lama_penelitian)
                                                    ({{ $surat->mahasiswa->lama_penelitian }})
                                                @endif
                                            @elseif($surat->mahasiswa->lama_penelitian)
                                                {{ $surat->mahasiswa->lama_penelitian }}
                                            @else
                                                <span class="text-red-500">Data tidak tersedia</span>
                                            @endif
                                        @elseif($surat->jenis_surat === 'non_mahasiswa' && $surat->nonMahasiswa)
                                            @if($surat->nonMahasiswa->tanggal_mulai && $surat->nonMahasiswa->tanggal_selesai)
                                                {{ Carbon::parse($surat->nonMahasiswa->tanggal_mulai)->locale('id')->translatedFormat('d-M-Y') }}
                                                s.d
                                                {{ Carbon::parse($surat->nonMahasiswa->tanggal_selesai)->locale('id')->translatedFormat('d-M-Y') }}
                                                @if($surat->nonMahasiswa->lama_penelitian)
                                                    ({{ $surat->nonMahasiswa->lama_penelitian }})
                                                @endif
                                            @elseif($surat->nonMahasiswa->lama_penelitian)
                                                {{ $surat->nonMahasiswa->lama_penelitian }}
                                            @else
                                                <span class="text-red-500">Data tidak tersedia</span>
                                            @endif
                                        @else
                                            <span class="text-red-500">Data tidak tersedia</span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-3 border border-gray-200">
                                        @if($surat->jenis_surat === 'mahasiswa' && $surat->mahasiswa)
                                            {{ $surat->mahasiswa->jurusan ?? 'Data tidak tersedia' }}
                                        @elseif($surat->jenis_surat === 'non_mahasiswa' && $surat->nonMahasiswa)
                                            {{ $surat->nonMahasiswa->bidang ?? 'Data tidak tersedia' }}
                                        @else
                                            <span class="text-red-500">Data tidak tersedia</span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-3 border border-gray-200">
                                        <span class="px-2 py-1 text-xs font-semibold rounded-full 
                                            {{ $surat->status_penelitian === 'baru' ? 'bg-green-100 text-green-800' : 
                                               ($surat->status_penelitian === 'lanjutan' ? 'bg-blue-100 text-blue-800' : 'bg-purple-100 text-purple-800') }}">
                                            {{ ucfirst($surat->status_penelitian) }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3 border border-gray-200">
                                        {{ $surat->nomor_surat }}
                                    </td>
                                    <td class="px-4 py-3 border border-gray-200">
                                        @if($surat->menimbang)
                                            <button type="button" class="text-blue-500 hover:text-blue-700" 
                                                    onclick="showMenimbangModal('{{ addslashes($surat->menimbang) }}', 
                                                    '{{ $surat->nomor_surat }}')">
                                                Lihat Pertimbangan
                                            </button>
                                        @else
                                            <span class="text-gray-500">Tidak ada</span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-3 border border-gray-200">
                                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                            Diterbitkan
                                        </span>
                                    </td>
                                    <td class="px-4 py-3 border border-gray-200">
                                        <div class="flex space-x-2 justify-center">
                                            <button type="button" 
                                                    onclick="openWhatsAppModal('{{ $surat->id }}', '{{ $surat->jenis_surat === 'mahasiswa' ? $surat->mahasiswa->nama_lengkap : $surat->nonMahasiswa->nama_lengkap }}', '{{ $surat->jenis_surat === 'mahasiswa' ? $surat->mahasiswa->no_hp : $surat->nonMahasiswa->no_hp }}', '{{ $surat->jenis_surat === 'mahasiswa' ? $surat->mahasiswa->judul_penelitian : $surat->nonMahasiswa->judul_penelitian }}', '{{ $surat->nomor_surat }}', '{{ $surat->jenis_surat === 'mahasiswa' ? $surat->mahasiswa->no_pengajuan : $surat->nonMahasiswa->no_pengajuan }}')" 
                                                    class="text-green-500 hover:text-green-700 p-1" 
                                                    title="Kirim Notifikasi WhatsApp">
                                                 <svg class="w-5 h-5" viewBox="0 0 24 24" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                                                </svg>
                                            </button>

                                            <!-- Email button - Add right after the WhatsApp button -->
                                            <button type="button" class="text-blue-500 hover:text-blue-700 p-1" 
                                                    onclick="openEmailModal('{{ $surat->id }}', 
                                                    '{{ $surat->jenis_surat === 'mahasiswa' && $surat->mahasiswa ? $surat->mahasiswa->nama_lengkap : ($surat->jenis_surat === 'non_mahasiswa' && $surat->nonMahasiswa ? $surat->nonMahasiswa->nama_lengkap : 'Tidak tersedia') }}',
                                                    '{{ $surat->jenis_surat === 'mahasiswa' && $surat->mahasiswa ? $surat->mahasiswa->email : ($surat->jenis_surat === 'non_mahasiswa' && $surat->nonMahasiswa ? $surat->nonMahasiswa->email : '') }}',
                                                    '{{ $surat->jenis_surat === 'mahasiswa' && $surat->mahasiswa ? addslashes($surat->mahasiswa->judul_penelitian) : ($surat->jenis_surat === 'non_mahasiswa' && $surat->nonMahasiswa ? addslashes($surat->nonMahasiswa->judul_penelitian) : '') }}',
                                                    '{{ $surat->nomor_surat }}')"
                                                    title="Kirim Notifikasi Email">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                                </svg>
                                            </button>
                                            
                                            <form action="{{ route('penerbitan.destroy', $surat->id) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus surat ini?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-500 hover:text-red-700 p-1" title="Hapus">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                    </svg>
                                                </button>
                                            </form>
                                            
                                            <!-- Modified PDF download button - only show if no file is uploaded -->
                                            @if(!isset($surat->file_path) || empty($surat->file_path))
                                            <a href="{{ route('penerbitan.download', $surat->id) }}" class="text-green-500 hover:text-green-700 p-1" title="Unduh Pdf">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                                </svg>
                                            </a>
                                            @endif
                                            
                                            <!-- Tombol Download File yang Diupload (hanya muncul jika ada file) -->
                                            @if(isset($surat->file_path) && !empty($surat->file_path))
                                            <a href="{{ route('penerbitan.downloadFile', $surat->id) }}" class="text-green-500 hover:text-green-700 p-1" title="Unduh File Surat Terupload">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                                </svg>
                                            </a>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr class="bg-white">
                                    <td colspan="16" class="px-4 py-3 border border-gray-200 text-center text-gray-500">
                                        Belum ada data surat yang diterbitkan
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    
                    <!-- Pagination for published table -->
                    @if(isset($penerbitanSuratsPublished) && $penerbitanSuratsPublished->count() > 0 || $penerbitanSurats->where('status_surat', 'diterbitkan')->count() > 0)
                    <div class="flex justify-between items-center mt-6">
                        <div class="text-sm text-gray-600">
                            Menampilkan {{ isset($penerbitanSuratsPublished) ? $penerbitanSuratsPublished->firstItem() ?? 0 : 0 }} sampai {{ isset($penerbitanSuratsPublished) ? $penerbitanSuratsPublished->lastItem() ?? 0 : 0 }} dari {{ isset($penerbitanSuratsPublished) ? $penerbitanSuratsPublished->total() : $penerbitanSurats->where('status_surat', 'diterbitkan')->count() }} Total Data
                        </div>
                        <div class="flex">
                            @if(isset($penerbitanSuratsPublished))
                                {{ $penerbitanSuratsPublished->appends([
                                    'search' => request('search'),
                                    'per_page' => $perPage,
                                    'search_published' => request('search_published'),
                                    'per_page_published' => request('per_page_published', 10)
                                ])->links() }}
                            @else
                                <!-- Placeholder for pagination links -->
                                <span class="text-gray-500">Paginasi belum tersedia</span>
                            @endif
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    
    <!-- Email Notification Modal -->
    <div id="emailModal" class="fixed inset-0 flex items-center justify-center z-50 hidden">
        <div class="absolute inset-0 bg-black bg-opacity-50" onclick="closeEmailModal()"></div>
        <div class="bg-white rounded-lg shadow-xl w-full max-w-md mx-4 relative max-h-[90vh] flex flex-col">
            <div class="flex justify-between items-center bg-blue-600 text-white p-4 rounded-t-lg">
                <h2 class="text-lg font-semibold flex items-center">
                    <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                    </svg>
                    Kirim Notifikasi Email
                </h2>
                <button type="button" class="text-white hover:text-gray-200 focus:outline-none" onclick="closeEmailModal()">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            <div class="overflow-y-auto flex-grow">
                <form action="{{ route('send.approval.email.notification') }}" method="POST">
                    @csrf
                    <input type="hidden" name="surat_id" id="email_surat_id">
                    <input type="hidden" name="nama" id="email_nama">
                    <input type="hidden" name="judul_penelitian" id="email_judul_penelitian">
                    <input type="hidden" name="nomor_surat" id="email_nomor_surat">
                    
                    <div class="p-6">
                        <div class="mb-4">
                            <label for="email_alamat" class="block text-sm font-medium text-gray-700 mb-1">Alamat Email</label>
                            <input type="email" id="email_alamat" name="email" class="block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:ring-blue-500 focus:border-blue-500 text-sm" required>
                        </div>
                        
                        <div class="mb-4">
                            <p class="text-sm text-gray-600 mb-2">Informasi Surat Terbit:</p>
                            <div class="p-3 bg-gray-50 rounded-md text-sm mb-4">
                                <p class="mb-1"><span class="font-medium">Nama:</span> <span id="display_email_nama"></span></p>
                                <p class="mb-1"><span class="font-medium">Judul Penelitian:</span> <span id="display_email_judul_penelitian"></span></p>
                                <p class="mb-1"><span class="font-medium">Nomor Surat:</span> <span id="display_email_nomor_surat"></span></p>
                            </div>
                            
                            <label for="email_pesan" class="block text-sm font-medium text-gray-700 mb-1">Pesan Email</label>
                            <textarea id="email_pesan" name="pesan_email" class="block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:ring-blue-500 focus:border-blue-500 text-sm" rows="12" required></textarea>
                            <p class="mt-1 text-xs text-gray-500">Pesan akan dikirim melalui email ke alamat yang tercantum.</p>
                        </div>
                        
                        <div class="flex justify-end space-x-3 mt-6">
                            <button type="button" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2" onclick="closeEmailModal()">
                                Batal
                            </button>
                            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 flex items-center">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                </svg>
                                Kirim Email
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal for Edit Surat -->
    <div id="editSuratModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 flex justify-center items-center hidden">
        <div class="bg-white rounded-lg shadow-lg w-11/12 max-w-md p-6">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-semibold text-gray-900">Edit Data Surat</h3>
                <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5" onclick="closeEditSuratModal()">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            <form id="editSuratForm" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="space-y-4">
                    <!-- Nomor Surat -->
                    <div>
                        <label for="edit_nomor_surat" class="block text-sm font-medium text-gray-700">Nomor Surat</label>
                        <input type="text" id="edit_nomor_surat" name="nomor_surat" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm" required>
                    </div>
                    
                    <!-- Menimbang -->
                    <div>
                        <label for="edit_menimbang" class="block text-sm font-medium text-gray-700">Menimbang</label>
                        <textarea id="edit_menimbang" name="menimbang" rows="4" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm" placeholder="Masukkan pertimbangan untuk penerbitan surat ini"></textarea>
                    </div>
                    
                    <!-- File Upload -->
                    <div>
                        <label for="edit_file_surat" class="block text-sm font-medium text-gray-700">Unggah File Surat</label>
                        <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md">
                            <div class="space-y-1 text-center">
                                <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                                    <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                                <div class="flex text-sm text-gray-600">
                                    <label for="edit_file_surat" class="relative cursor-pointer bg-white rounded-md font-medium text-blue-600 hover:text-blue-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-blue-500">
                                        <span>Unggah file</span>
                                        <input id="edit_file_surat" name="file_surat" type="file" class="sr-only" accept=".doc,.docx,.pdf">
                                    </label>
                                    <p class="pl-1">atau seret dan letakkan</p>
                                </div>
                                <p class="text-xs text-gray-500">
                                    DOC, DOCX, PDF hingga 5MB
                                </p>
                            </div>
                        </div>
                        <div id="edit_file_preview" class="hidden mt-2 p-2 bg-gray-50 rounded-md">
                            <div class="flex items-center">
                                <svg class="w-5 h-5 text-gray-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                                <span id="edit_file_name" class="text-sm text-gray-700"></span>
                                <button type="button" id="edit_remove_file" class="ml-auto text-red-500 hover:text-red-700">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>
                        <p class="mt-1 text-xs text-gray-500">File surat yang sudah ada akan diganti jika Anda mengunggah file baru.</p>
                    </div>
                    
                    <!-- File Status -->
                    <div id="existing_file_info" class="bg-blue-50 p-3 rounded-md hidden">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 text-blue-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <span class="text-sm text-blue-700">File surat sudah ada. Unggah file baru hanya jika ingin mengganti file yang ada.</span>
                        </div>
                    </div>
                </div>
                
                <div class="mt-5 flex justify-end">
                    <button type="button" class="mr-2 py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500" onclick="closeEditSuratModal()">
                        Batal
                    </button>
                    <button type="submit" class="py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal for Menimbang Details -->
    <!-- Modal for Menimbang Details -->
    <div id="menimbangModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden">
        <div class="flex items-center justify-center h-full">
            <div class="bg-white rounded-lg shadow-xl w-full max-w-md max-h-[90vh] overflow-y-auto">
                <div class="flex justify-between items-center border-b p-4">
                    <h3 class="text-xl font-semibold text-gray-800">Pertimbangan Penerbitan Surat</h3>
                    <button type="button" class="text-gray-400 hover:text-gray-600" onclick="closeMenimbangModal()">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
                
                <div class="p-6">
                    <div class="mb-4">
                        <p class="text-sm text-gray-700 mb-2">Nomor Surat: <span id="menimbang_nomor_surat" class="font-medium text-gray-900"></span></p>
                    </div>
                    <!-- Pertimbangan Penerbitan Surat -->
                    <div class="mb-6">
                        <h4 class="text-lg font-medium text-gray-700 mb-3">Pertimbangan</h4>
                        <textarea id="menimbangTextarea" class="w-full h-64 p-3 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 text-sm" readonly></textarea>
                    </div>
                </div>
                
                <div class="border-t p-4 flex justify-end">
                    <button type="button" class="px-4 py-2 bg-blue-600 text-white rounded-lg font-medium hover:bg-blue-700" onclick="closeMenimbangModal()">
                        Tutup
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal for Anggota Penelitian -->
    <!-- Modal for Anggota Penelitian -->
    <div id="anggotaModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden">
        <div class="flex items-center justify-center h-full">
            <div class="bg-white rounded-lg shadow-xl w-full max-w-md max-h-[90vh] overflow-y-auto">
                <div class="flex justify-between items-center border-b p-4">
                    <h3 class="text-xl font-semibold text-gray-800" id="modalTitle">Daftar Anggota Penelitian</h3>
                    <button type="button" class="text-gray-400 hover:text-gray-600" onclick="closeAnggotaModal()">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
                
                <div class="p-6">
                    <!-- Daftar Anggota Penelitian -->
                    <div class="mb-6">
                        <h4 class="text-lg font-medium text-gray-700 mb-3">Anggota Penelitian</h4>
                        <textarea id="anggotaTextarea" class="w-full h-64 p-3 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 text-sm" readonly></textarea>
                    </div>
                </div>
                
                <div class="border-t p-4 flex justify-end">
                    <button type="button" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg font-medium hover:bg-gray-300" onclick="closeAnggotaModal()">
                        Tutup
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- WhatsApp Notification Modal -->
    <div id="whatsappModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden flex items-center justify-center">
        <div class="bg-white rounded-lg shadow-xl w-full max-w-md relative">
            <div class="flex justify-between items-center bg-green-600 text-white p-4 rounded-t-lg">
                <h3 class="text-xl font-semibold flex items-center">
                    <svg class="w-6 h-6 mr-2" viewBox="0 0 24 24" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                        <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z"/>
                    </svg>
                    Kirim Notifikasi WhatsApp
                </h3>
                <button type="button" class="text-white hover:text-gray-200 focus:outline-none" onclick="closeWhatsAppModal()">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            
            <form id="whatsappForm" method="POST" action="{{ route('send.whatsapp.notification') }}">
                @csrf
                <input type="hidden" name="surat_id" id="whatsapp_surat_id">
                <div class="p-6">
                    <div class="mb-4">
                        <label for="whatsapp_nomor" class="block text-sm font-medium text-gray-700 mb-2">Nomor Telepon:</label>
                        <div class="flex items-center border border-gray-300 rounded-lg overflow-hidden">
                            <span class="bg-gray-100 px-3 py-2 text-gray-600 text-sm border-r">+62</span>
                            <input type="text" id="whatsapp_nomor" name="nomor" class="w-full border-0 p-2 text-sm focus:ring-green-500 focus:border-green-500 focus:outline-none" readonly>
                        </div>
                    </div>
                    <div class="mb-2">
                        <label for="whatsapp_pesan" class="block text-sm font-medium text-gray-700 mb-2">Pesan:</label>
                        <textarea id="whatsapp_pesan" name="pesan" rows="12" class="w-full border border-gray-300 rounded-lg p-3 text-sm focus:ring-green-500 focus:border-green-500"></textarea>
                        <p class="mt-2 text-xs text-gray-500">Pesan akan dikirim melalui WhatsApp ke nomor yang tercantum.</p>
                    </div>
                </div>
                
                <div class="border-t p-4 flex justify-end space-x-3">
                    <button type="button" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg font-medium hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-400 focus:ring-offset-2" onclick="closeWhatsAppModal()">
                        Batal
                    </button>
                    <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded-lg font-medium hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 flex items-center">
                        <svg class="w-4 h-4 mr-2" viewBox="0 0 24 24" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                            <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z"/>
                        </svg>
                        Kirim Pesan
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Confirmation Modal for Status Update -->
    <div id="confirmStatusModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 flex justify-center items-center hidden">
        <div class="bg-white rounded-lg shadow-lg w-11/12 max-w-md p-6">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-semibold text-gray-900">Konfirmasi Penerbitan Surat</h3>
                <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5" onclick="closeConfirmStatusModal()">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            <div class="mb-4">
                <p class="text-gray-700">Apakah Anda yakin ingin menerbitkan surat <span id="confirm_nomor_surat" class="font-semibold"></span> atas nama <span id="confirm_nama" class="font-semibold"></span>?</p>
            </div>
            <form id="statusUpdateForm" method="POST">
                @csrf
                @method('PUT')
                <div class="flex justify-end">
                    <button type="button" class="mr-2 px-4 py-2 bg-gray-300 text-gray-700 rounded-md" onclick="closeConfirmStatusModal()">Batal</button>
                    <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded-md">Terbitkan</button>
                </div>
            </form>
        </div>
    </div>
    
    <!-- Modal for File Upload -->
    <div id="fileUploadModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 flex justify-center items-center hidden">
        <div class="bg-white rounded-lg shadow-lg w-11/12 max-w-md p-6">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-semibold text-gray-900">Unggah File Surat</h3>
                <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5" onclick="closeFileUploadModal()">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            <form id="fileUploadForm" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-4">
                    <p class="text-sm text-gray-700 mb-2">Nomor Surat: <span id="upload_nomor_surat" class="font-medium text-gray-900"></span></p>
                    <p class="text-sm text-gray-700 mb-4">Unggah file surat yang telah diproses atau ditandatangani</p>
                    
                    <div class="border-2 border-dashed border-gray-300 rounded-lg p-4 mb-3">
                        <label for="file_surat" class="flex flex-col items-center justify-center cursor-pointer">
                            <svg class="w-8 h-8 text-gray-400 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                            </svg>
                            <span class="text-sm text-gray-500">Klik atau seret file ke sini</span>
                            <input type="file" name="file_surat" id="file_surat" class="hidden" accept=".doc,.docx,.pdf">
                        </label>
                    </div>
                    
                    <div id="file_preview" class="hidden mt-2 p-2 bg-gray-50 rounded-md">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 text-gray-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            <span id="file_name" class="text-sm text-gray-700"></span>
                            <button type="button" id="remove_file" class="ml-auto text-red-500 hover:text-red-700">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </button>
                        </div>
                    </div>
                    
                    <p class="mt-1 text-xs text-gray-500">Format yang diterima: .doc, .docx, .pdf (Maks. 5MB)</p>
                </div>
                <div class="flex justify-end">
                    <button type="button" class="mr-2 px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400" onclick="closeFileUploadModal()">Batal</button>
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">Unggah</button>
                </div>
            </form>
        </div>
    </div>


    <script>
        // Function to open Email notification modal
        function openEmailModal(id, nama, email, judulPenelitian, nomorSurat) {
            document.getElementById('email_surat_id').value = id;
            document.getElementById('email_alamat').value = email;
            document.getElementById('email_nama').value = nama;
            document.getElementById('email_judul_penelitian').value = judulPenelitian;
            document.getElementById('email_nomor_surat').value = nomorSurat;
            
            // Display values in the modal
            document.getElementById('display_email_nama').textContent = nama;
            document.getElementById('display_email_judul_penelitian').textContent = judulPenelitian;
            document.getElementById('display_email_nomor_surat').textContent = nomorSurat;
            
            // Create a template message
            const pesan = `Halo ${nama},

        Dengan ini kami informasikan bahwa surat izin penelitian Anda dengan judul "${judulPenelitian}" telah diterbitkan dengan nomor surat: ${nomorSurat} dan siap untuk diambil.

        Silahkan datang ke kantor kami untuk mengambil surat tersebut pada jam kerja (Senin-Jumat, 08.00-16.00).

        Terima kasih.

        Hormat kami,
        Badan Kesatuan Bangsa dan Politik
        Pemerintah Provinsi Kalimantan Timur`;
            
            document.getElementById('email_pesan').value = pesan;
            document.getElementById('emailModal').classList.remove('hidden');
        }

        // Function to close Email modal
        function closeEmailModal() {
            document.getElementById('emailModal').classList.add('hidden');
        }
    </script>

    <script>
        // Function to open edit surat modal
        function openEditSuratModal(id, nomorSurat, menimbang, hasFile) {
            const form = document.getElementById('editSuratForm');
            form.action = `/staff/penerbitan/${id}/update`;
            
            // Set form values
            document.getElementById('edit_nomor_surat').value = nomorSurat;
            document.getElementById('edit_menimbang').value = menimbang;
            
            // Show file status if a file exists
            const existingFileInfo = document.getElementById('existing_file_info');
            if (hasFile) {
                existingFileInfo.classList.remove('hidden');
            } else {
                existingFileInfo.classList.add('hidden');
            }
            
            // Reset file upload field
            document.getElementById('edit_file_surat').value = '';
            document.getElementById('edit_file_preview').classList.add('hidden');
            
            // Show the modal
            document.getElementById('editSuratModal').classList.remove('hidden');
        }

        // Function to close edit surat modal
        function closeEditSuratModal() {
            document.getElementById('editSuratModal').classList.add('hidden');
        }

        // File preview for edit modal
        document.addEventListener('DOMContentLoaded', function() {
            const editFileInput = document.getElementById('edit_file_surat');
            const editFilePreview = document.getElementById('edit_file_preview');
            const editFileName = document.getElementById('edit_file_name');
            const editRemoveFile = document.getElementById('edit_remove_file');
            
            if (editFileInput && editFilePreview && editFileName && editRemoveFile) {
                editFileInput.addEventListener('change', function(event) {
                    if (this.files && this.files[0]) {
                        const file = this.files[0];
                        editFileName.textContent = file.name;
                        editFilePreview.classList.remove('hidden');
                        
                        // Validate file size
                        if (file.size > 5 * 1024 * 1024) { // 5MB
                            alert('Ukuran file terlalu besar. Maksimal 5MB.');
                            this.value = '';
                            editFilePreview.classList.add('hidden');
                        }
                        
                        // Validate file type
                        const allowedTypes = ['application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'application/pdf'];
                        if (!allowedTypes.includes(file.type)) {
                            alert('Format file tidak didukung. Gunakan .doc, .docx, atau .pdf');
                            this.value = '';
                            editFilePreview.classList.add('hidden');
                        }
                    }
                });
                
                editRemoveFile.addEventListener('click', function() {
                    editFileInput.value = '';
                    editFilePreview.classList.add('hidden');
                });
            }
            
            // Add edit modal to the list of modals that can be closed with ESC key
            const modals = document.querySelectorAll('[id$="Modal"]');
            document.addEventListener('keydown', function(event) {
                if (event.key === 'Escape') {
                    modals.forEach(modal => {
                        if (!modal.classList.contains('hidden')) {
                            if (modal.id === 'editSuratModal') {
                                closeEditSuratModal();
                            } else if (modal.id === 'fileUploadModal') {
                                closeFileUploadModal();
                            } else if (modal.id === 'whatsappModal') {
                                closeWhatsAppModal();
                            } else if (modal.id === 'confirmStatusModal') {
                                closeConfirmStatusModal();
                            } else if (modal.id === 'menimbangModal') {
                                closeMenimbangModal();
                            } else if (modal.id === 'anggotaModal') {
                                closeAnggotaModal();
                            }
                        }
                    });
                }
            });
            
            // Adding drag and drop functionality for edit modal
            const editDropArea = document.querySelector('#editSuratModal .border-dashed');
            
            if (editDropArea) {
                ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
                    editDropArea.addEventListener(eventName, preventDefaults, false);
                });
                
                function preventDefaults(e) {
                    e.preventDefault();
                    e.stopPropagation();
                }
                
                ['dragenter', 'dragover'].forEach(eventName => {
                    editDropArea.addEventListener(eventName, function() {
                        editDropArea.classList.add('border-blue-400', 'bg-blue-50');
                    }, false);
                });
                
                ['dragleave', 'drop'].forEach(eventName => {
                    editDropArea.addEventListener(eventName, function() {
                        editDropArea.classList.remove('border-blue-400', 'bg-blue-50');
                    }, false);
                });
                
                editDropArea.addEventListener('drop', function(e) {
                    const dt = e.dataTransfer;
                    const files = dt.files;
                    editFileInput.files = files;
                    
                    // Trigger change event
                    const event = new Event('change', { bubbles: true });
                    editFileInput.dispatchEvent(event);
                }, false);
            }
            
            // Form validation for edit surat form
            const editSuratForm = document.getElementById('editSuratForm');
            if (editSuratForm) {
                editSuratForm.addEventListener('submit', function(e) {
                    const nomorSurat = document.getElementById('edit_nomor_surat').value;
                    
                    if (!nomorSurat.trim()) {
                        e.preventDefault();
                        alert('Nomor surat tidak boleh kosong');
                        return false;
                    }
                    
                    // Show loading state
                    const submitBtn = this.querySelector('button[type="submit"]');
                    submitBtn.disabled = true;
                    submitBtn.innerHTML = `
                        <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white inline-block" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        Menyimpan...
                    `;
                });
            }
        });
    </script>

    <script>
    // Function to show anggota penelitian modal
    // Function to show anggota penelitian modal
    function showAnggotaModal(anggotaData, namaLengkap) {
        // Get the modal and textarea element
        const anggotaModal = document.getElementById('anggotaModal');
        const anggotaTextarea = document.getElementById('anggotaTextarea');
        const modalTitle = document.getElementById('modalTitle');
        
        // Set the title with the name
        modalTitle.textContent = `Daftar Anggota Penelitian - ${namaLengkap}`;
        
        // Clear previous content
        anggotaTextarea.value = '';
        
        // Parse the anggota data properly - handle different formats
        let anggotaArray = [];
        
        try {
            // Try to parse the data as JSON
            if (typeof anggotaData === 'string') {
                // If it's already a string, try to parse it as JSON
                try {
                    const parsed = JSON.parse(anggotaData);
                    if (Array.isArray(parsed)) {
                        anggotaArray = parsed;
                    } else if (typeof parsed === 'string') {
                        anggotaArray = parsed.split(',').map(item => item.trim()).filter(item => item);
                    } else {
                        anggotaArray = [String(parsed)]; // Just use it as a single item
                    }
                } catch (e) {
                    // If parsing fails, assume it's comma-separated or a plain string
                    if (anggotaData.includes(',')) {
                        anggotaArray = anggotaData.split(',').map(item => item.trim()).filter(item => item);
                    } else {
                        anggotaArray = [anggotaData];
                    }
                }
            } else if (Array.isArray(anggotaData)) {
                anggotaArray = anggotaData;
            } else if (anggotaData) {
                anggotaArray = [String(anggotaData)];
            }
            
            // Add data to textarea
            if (anggotaArray && anggotaArray.length > 0) {
                // Format objects if they exist in the array
                const formattedArray = anggotaArray.map(item => {
                    if (typeof item === 'object' && item !== null) {
                        return item.nama || JSON.stringify(item);
                    }
                    return item;
                });
                anggotaTextarea.value = formattedArray.join('\n');
            } else {
                anggotaTextarea.value = 'Tidak ada anggota peneliti';
            }
        } catch (e) {
            // If all parsing attempts fail, show the error
            anggotaTextarea.value = 'Error: ' + e.message + '\n\nData asli: ' + anggotaData;
        }
        
        // Show the modal
        anggotaModal.classList.remove('hidden');
        document.body.style.overflow = 'hidden'; // Prevent scrolling behind modal
    }

    // Function to close the modal
    function closeAnggotaModal() {
        document.getElementById('anggotaModal').classList.add('hidden');
        document.body.style.overflow = 'auto'; // Re-enable scrolling
    }
    
    // Function to open WhatsApp notification modal
    function openWhatsAppModal(id, nama, nomor, judulPenelitian, nomorSurat, noPengajuan) {
        document.getElementById('whatsapp_surat_id').value = id;
        document.getElementById('whatsapp_nomor').value = nomor;
        
        // Create a template message with nomor pengajuan included
        const pesan = `Halo ${nama},

    Dengan hormat kami informasikan bahwa surat izin penelitian Anda dengan:

    Nomor Pengajuan: ${noPengajuan}
    Judul Penelitian: "${judulPenelitian}"
    Nomor Surat: ${nomorSurat}

    Telah diterbitkan dan siap untuk diambil. Silakan datang ke kantor kami untuk mengambil surat tersebut pada jam kerja (Senin-Jumat, 08.00-16.00 WIB).

    Jika ada pertanyaan, silakan hubungi kami melalui kontak yang tertera di website.

    Terima kasih atas perhatiannya.

    Hormat kami,
    Tim Badan Kesatuan Bangsa dan Politik
    Pemerintah Provinsi Kalimantan Timur`;
        
        document.getElementById('whatsapp_pesan').value = pesan;
        document.getElementById('whatsappModal').classList.remove('hidden');
    }

    // Function to close WhatsApp notification modal
    function closeWhatsAppModal() {
        document.getElementById('whatsappModal').classList.add('hidden');
    }

    // Function to show menimbang modal
    // Function to show menimbang modal
    function showMenimbangModal(menimbangText, nomorSurat) {
        const menimbangModal = document.getElementById('menimbangModal');
        const menimbangTextarea = document.getElementById('menimbangTextarea');
        const modalNomorSurat = document.getElementById('menimbang_nomor_surat');
        
        // Set the nomor surat in the modal
        modalNomorSurat.textContent = nomorSurat;
        
        // Set the menimbang text in the textarea
        menimbangTextarea.value = menimbangText || 'Tidak ada pertimbangan';
        
        // Show the modal
        menimbangModal.classList.remove('hidden');
        document.body.style.overflow = 'hidden'; // Prevent scrolling behind modal
    }

    // Function to close menimbang modal
    function closeMenimbangModal() {
        document.getElementById('menimbangModal').classList.add('hidden');
        document.body.style.overflow = 'auto'; // Re-enable scrolling
    }

    function openConfirmStatusModal(id, nama, nomorSurat) {
        const form = document.getElementById('statusUpdateForm');
        // Use the correct route with parameter
        form.action = "{{ url('staff/penerbitan') }}/" + id + "/update-status";
        
        document.getElementById('confirm_nama').textContent = nama;
        document.getElementById('confirm_nomor_surat').textContent = nomorSurat;
        
        document.getElementById('confirmStatusModal').classList.remove('hidden');
    }

    // Function to close confirmation modal
    function closeConfirmStatusModal() {
        document.getElementById('confirmStatusModal').classList.add('hidden');
    }
    
    function openFileUploadModal(id, nomorSurat) {
        const form = document.getElementById('fileUploadForm');
        form.action = `/staff/penerbitan/${id}/update-file`;
        
        document.getElementById('upload_nomor_surat').textContent = nomorSurat;
        document.getElementById('fileUploadModal').classList.remove('hidden');
    }

    // Function to close file upload modal
    function closeFileUploadModal() {
        document.getElementById('fileUploadModal').classList.add('hidden');
        document.getElementById('file_surat').value = '';
        document.getElementById('file_preview').classList.add('hidden');
    }

    document.addEventListener('DOMContentLoaded', function() {
        // File preview and handling
        const fileInput = document.getElementById('file_surat');
        const filePreview = document.getElementById('file_preview');
        const fileName = document.getElementById('file_name');
        const removeFile = document.getElementById('remove_file');
        
        if (fileInput && filePreview && fileName && removeFile) {
            fileInput.addEventListener('change', function(event) {
                if (this.files && this.files[0]) {
                    const file = this.files[0];
                    fileName.textContent = file.name;
                    filePreview.classList.remove('hidden');
                    
                    // Validasi ukuran file
                    if (file.size > 5 * 1024 * 1024) { // 5MB
                        alert('Ukuran file terlalu besar. Maksimal 5MB.');
                        this.value = '';
                        filePreview.classList.add('hidden');
                    }
                    
                    // Validasi tipe file
                    const allowedTypes = ['application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'application/pdf'];
                    if (!allowedTypes.includes(file.type)) {
                        alert('Format file tidak didukung. Gunakan .doc, .docx, atau .pdf');
                        this.value = '';
                        filePreview.classList.add('hidden');
                    }
                }
            });
            
            removeFile.addEventListener('click', function() {
                fileInput.value = '';
                filePreview.classList.add('hidden');
            });
        }
        
        // Auto-show document download alert if present
        const downloadAlert = document.getElementById('download-alert');
        if (downloadAlert) {
            downloadAlert.scrollIntoView({ behavior: 'smooth', block: 'center' });
            
            // Auto-dismiss after 10 seconds
            setTimeout(() => {
                fadeOut(downloadAlert);
            }, 10000);
        }
        
        // Add event listener to close button
        const closeDownloadAlert = downloadAlert?.querySelector('button[data-dismiss-target="#download-alert"]');
        if (closeDownloadAlert) {
            closeDownloadAlert.addEventListener('click', function() {
                fadeOut(downloadAlert);
            });
        }
        
        // Initialize alert auto-dismiss (only for success alerts)
        initializeAlerts();
        
        // Handle entries per page selectors
        // Main table entries select
        const mainEntriesSelect = document.getElementById('main-entries-select');
        if (mainEntriesSelect) {
            mainEntriesSelect.addEventListener('change', function() {
                document.getElementById('main-filter-form').submit();
            });
        }
        
        // Published table entries select
        const publishedEntriesSelect = document.getElementById('published-entries-select');
        if (publishedEntriesSelect) {
            publishedEntriesSelect.addEventListener('change', function() {
                document.getElementById('published-filter-form').submit();
            });
        }
        
        // Add confirmation for delete actions with Indonesian messages
        const deleteForms = document.querySelectorAll('form[action*="destroy"]');
        deleteForms.forEach(form => {
            form.addEventListener('submit', function(event) {
                event.preventDefault();
                
                // Get letter details for confirmation message
                const row = this.closest('tr');
                const nama = row.querySelector('td:nth-child(3)').textContent.trim();
                const nomorSurat = row.querySelector('td:nth-child(13)').textContent.trim();
                
                if (confirm(`PERHATIAN: Anda akan menghapus surat dengan nomor "${nomorSurat}" atas nama "${nama}" DAN JUGA menghapus data peneliti terkait beserta semua berkas dokumennya dari sistem. Tindakan ini tidak dapat dibatalkan. Apakah Anda yakin ingin melanjutkan?`)) {
                    this.submit();
                }
            });
        });
        
        // Close modals when clicking outside of them
        const modals = [
            { id: 'anggotaModal', closeFn: closeAnggotaModal },
            { id: 'whatsappModal', closeFn: closeWhatsAppModal },
            { id: 'confirmStatusModal', closeFn: closeConfirmStatusModal },
            { id: 'menimbangModal', closeFn: closeMenimbangModal },
            { id: 'fileUploadModal', closeFn: closeFileUploadModal },
            { id: 'emailModal', closeFn: closeEmailModal }
        ];
        
        modals.forEach(modal => {
            const modalElement = document.getElementById(modal.id);
            if (modalElement) {
                modalElement.addEventListener('click', function(event) {
                    if (event.target === this) {
                        modal.closeFn();
                    }
                });
            }
        });
        
        // Add escape key handler for all modals
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                modals.forEach(modal => {
                    const modalElement = document.getElementById(modal.id);
                    if (modalElement && !modalElement.classList.contains('hidden')) {
                        modal.closeFn();
                    }
                });
            }
        });
        
        // Add confirmation for status updates
        const updateForm = document.getElementById('statusUpdateForm');
        if (updateForm) {
            updateForm.addEventListener('submit', function(event) {
                // Show loading on button
                const button = this.querySelector('button[type="submit"]');
                const originalHTML = button.innerHTML;
                button.disabled = true;
                button.innerHTML = `<svg class="animate-spin w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>`;
            });
        }
        
        // Form validation for file upload
        const uploadForm = document.getElementById('fileUploadForm');
        if (uploadForm) {
            uploadForm.addEventListener('submit', function(e) {
                if (!fileInput.files || fileInput.files.length === 0) {
                    e.preventDefault();
                    alert('Silakan pilih file terlebih dahulu');
                    return false;
                }
                
                // Show loading state
                const submitBtn = this.querySelector('button[type="submit"]');
                submitBtn.disabled = true;
                submitBtn.innerHTML = `
                    <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white inline-block" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    Mengunggah...
                `;
            });
        }
        
        // Drag and drop functionality
        const dropArea = document.querySelector('.border-dashed');
        
        if (dropArea) {
            ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
                dropArea.addEventListener(eventName, preventDefaults, false);
            });
            
            function preventDefaults(e) {
                e.preventDefault();
                e.stopPropagation();
            }
            
            ['dragenter', 'dragover'].forEach(eventName => {
                dropArea.addEventListener(eventName, highlight, false);
            });
            
            ['dragleave', 'drop'].forEach(eventName => {
                dropArea.addEventListener(eventName, unhighlight, false);
            });
            
            function highlight() {
                dropArea.classList.add('border-blue-400', 'bg-blue-50');
            }
            
            function unhighlight() {
                dropArea.classList.remove('border-blue-400', 'bg-blue-50');
            }
            
            dropArea.addEventListener('drop', handleDrop, false);
            
            function handleDrop(e) {
                const dt = e.dataTransfer;
                const files = dt.files;
                fileInput.files = files;
                
                // Trigger change event
                const event = new Event('change', { bubbles: true });
                fileInput.dispatchEvent(event);
            }
        }
    });

    // Function to initialize alert dismiss functionality - only auto-dismiss success alerts
    function initializeAlerts() {
        // Auto-dismiss only success alerts after 5 seconds
        setTimeout(() => {
            const successAlerts = document.querySelectorAll('#success-alert');
            successAlerts.forEach(alert => {
                if (alert) {
                    fadeOut(alert);
                }
            });
        }, 5000);
        
        // Add click event to all close buttons
        const closeButtons = document.querySelectorAll('[data-dismiss-target]');
        closeButtons.forEach(button => {
            button.addEventListener('click', function() {
                const targetId = this.getAttribute('data-dismiss-target');
                const alert = document.querySelector(targetId);
                if (alert) {
                    fadeOut(alert);
                }
            });
        });
    }

    // Function to fade out element
    function fadeOut(element) {
        let opacity = 1;
        const timer = setInterval(() => {
            if (opacity <= 0.1) {
                clearInterval(timer);
                element.style.display = 'none';
            }
            element.style.opacity = opacity;
            opacity -= 0.1;
        }, 50);
    }
</script>
</body>
@include('Staff.Layout.App.Footer')