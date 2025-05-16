@include('Admin.Layout.App.Header')
<body class="bg-gradient-to-r from-green-100 to-blue-100">
    @include('Admin.Layout.App.Sidebar')
    
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
                    Selamat Datang Admin, <span class="font-semibold text-blue-600">{{ auth()->user()->username }}</span>
                </div>
            </div>

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
                            Daftar Data Surat
                        </div>
                        
                        <!-- Status Filter Tabs -->
                        <div class="flex items-center space-x-2 ml-4 bg-gray-100 rounded-lg p-1">
                            <a href="{{ route('admin.datasurat', ['status' => 'all', 'search' => $search, 'per_page' => $perPage, 'sort_by' => $sortBy]) }}" 
                            class="px-3 py-1.5 rounded-md text-sm font-medium {{ $statusFilter === 'all' ? 'bg-blue-600 text-white' : 'text-gray-700 hover:bg-gray-200' }}">
                                Semua
                                <span class="inline-flex items-center justify-center ml-1 px-2 py-0.5 text-xs font-medium rounded-full {{ $statusFilter === 'all' ? 'bg-blue-500 text-white' : 'bg-gray-200 text-gray-800' }}">
                                    {{ \App\Models\PenerbitanSurat::count() }}
                                </span>
                            </a>
                            <a href="{{ route('admin.datasurat', ['status' => 'draft', 'search' => $search, 'per_page' => $perPage, 'sort_by' => $sortBy]) }}" 
                            class="px-3 py-1.5 rounded-md text-sm font-medium {{ $statusFilter === 'draft' ? 'bg-yellow-500 text-white' : 'text-gray-700 hover:bg-gray-200' }}">
                                Draft
                                <span class="inline-flex items-center justify-center ml-1 px-2 py-0.5 text-xs font-medium rounded-full {{ $statusFilter === 'draft' ? 'bg-yellow-400 text-white' : 'bg-gray-200 text-gray-800' }}">
                                    {{ \App\Models\PenerbitanSurat::where('status_surat', 'draft')->count() }}
                                </span>
                            </a>
                            <a href="{{ route('admin.datasurat', ['status' => 'diterbitkan', 'search' => $search, 'per_page' => $perPage, 'sort_by' => $sortBy]) }}" 
                            class="px-3 py-1.5 rounded-md text-sm font-medium {{ $statusFilter === 'diterbitkan' ? 'bg-green-600 text-white' : 'text-gray-700 hover:bg-gray-200' }}">
                                Diterbitkan
                                <span class="inline-flex items-center justify-center ml-1 px-2 py-0.5 text-xs font-medium rounded-full {{ $statusFilter === 'diterbitkan' ? 'bg-green-500 text-white' : 'bg-gray-200 text-gray-800' }}">
                                    {{ \App\Models\PenerbitanSurat::where('status_surat', 'diterbitkan')->count() }}
                                </span>
                            </a>
                        </div>
                    </div>

                    <div class="flex items-center space-x-2">
                        <form id="filter-form" action="{{ route('admin.datasurat') }}" method="GET" class="flex items-center space-x-2">
                            <!-- Sort By Dropdown -->
                            <div class="relative">
                                <select id="sort_by" name="sort_by" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                                    <option value="latest" {{ ($sortBy ?? 'latest') == 'latest' ? 'selected' : '' }}>Terbaru</option>
                                    <option value="oldest" {{ ($sortBy ?? 'latest') == 'oldest' ? 'selected' : '' }}>Terlama</option>
                                </select>
                            </div>
                            
                            <!-- Entries Per Page Dropdown -->
                            <div class="relative">
                                <select id="entries-select" name="per_page" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                                    <option value="10" {{ $perPage == 10 ? 'selected' : '' }}>10</option>
                                    <option value="25" {{ $perPage == 25 ? 'selected' : '' }}>25</option>
                                    <option value="50" {{ $perPage == 50 ? 'selected' : '' }}>50</option>
                                    <option value="100" {{ $perPage == 100 ? 'selected' : '' }}>100</option>
                                </select>
                            </div>

                            <!-- Search Input -->
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                    <svg class="w-4 h-4 text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                                    </svg>
                                </div>
                                <input type="hidden" name="status" value="{{ $statusFilter }}">
                                <input type="text" name="search" id="search-input" class="block w-60 p-2.5 pl-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500" placeholder="Cari Data Surat" value="{{ $search }}">
                                <button type="submit" class="absolute inset-y-0 right-0 flex items-center px-4 text-sm font-medium text-white bg-blue-600 rounded-r-lg hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300">
                                    Cari
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
                
                <div class="overflow-x-auto rounded-lg border border-gray-200">
                    <table class="w-full text-sm text-left border-collapse">
                        <thead class="text-gray-700 bg-gray-100">
                            <tr class="bg-[#004aad] text-white">
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
                                <th class="px-4 py-3 border border-gray-300 w-32">Tembusan</th>

                                <th class="px-4 py-3 border border-gray-300 min-w-[120px]">Status surat</th>
                                <th class="px-4 py-3 border border-gray-300 min-w-[120px]">Tanggal</th>
                                <th class="px-4 py-3 border border-gray-300 w-40">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($penerbitanSurats as $index => $surat)
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
                                            {{ $surat->mahasiswa->tanggal_mulai }} - {{ $surat->mahasiswa->tanggal_selesai }}
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
                                            {{ $surat->nonMahasiswa->tanggal_mulai }} - {{ $surat->nonMahasiswa->tanggal_selesai }}
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
                                @if($surat->tembusan)
                                    <button type="button" class="text-blue-500 hover:text-blue-700" 
                                            data-tembusan="{!! $surat->tembusan !!}" 
                                            data-nomor-surat="{{ $surat->nomor_surat }}" 
                                            onclick="showTembusanModal(this)">
                                        Lihat Tembusan
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
                                    {{ $surat->updated_at->format('d/m/Y') }}
                                </td>
                                <td class="px-4 py-3 border border-gray-200">
                                    <div class="flex space-x-2 justify-center">
                                        <!-- Modified PDF download button - only show if no file is uploaded -->
                                        @if(!isset($surat->file_path) || empty($surat->file_path))
                                        <a href="{{ route('admin.penerbitan.download', $surat->id) }}" class="text-green-500 hover:text-green-700 p-1" title="Unduh Pdf">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                            </svg>
                                        </a>
                                        @endif
                                        
                                        <!-- Tombol Download File yang Diupload (hanya muncul jika ada file) -->
                                        @if(isset($surat->file_path) && !empty($surat->file_path))
                                        <a href="{{ route('admin.penerbitan.downloadFile', $surat->id) }}" class="text-green-500 hover:text-green-700 p-1" title="Unduh File Surat Terupload">
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
                                    @if($statusFilter == 'all')
                                        Belum ada data surat
                                    @elseif($statusFilter == 'draft')
                                        Belum ada data surat draft
                                    @elseif($statusFilter == 'diterbitkan')
                                        Belum ada data surat yang diterbitkan
                                    @endif
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="flex justify-between items-center mt-6">
                    <div class="text-sm text-gray-600">
                        Menampilkan {{ $penerbitanSurats->firstItem() ?? 0 }} sampai {{ $penerbitanSurats->lastItem() ?? 0 }} dari {{ $penerbitanSurats->total() }} Total Data
                    </div>
                    <div class="flex">
                        {{ $penerbitanSurats->appends([
                            'search' => $search,
                            'status' => $statusFilter, 
                            'per_page' => $perPage,
                            'sort_by' => $sortBy
                        ])->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Modal for Menimbang Details -->
    <div id="menimbangModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 flex justify-center items-center hidden">
        <div class="bg-white rounded-lg shadow-lg w-11/12 max-w-lg p-6">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-semibold text-gray-900">Pertimbangan Penerbitan Surat</h3>
                <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5" onclick="closeMenimbangModal()">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            <div class="mb-4">
                <p class="text-sm text-gray-500">Nomor Surat: <span id="menimbang_nomor_surat" class="font-medium text-gray-700"></span></p>
            </div>
            <div class="bg-gray-50 p-4 rounded border border-gray-200 mb-4">
                <div id="menimbangContent" class="text-gray-700 whitespace-pre-line"></div>
            </div>
            <div class="flex justify-end">
                <button type="button" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700" onclick="closeMenimbangModal()">
                    Tutup
                </button>
            </div>
        </div>
    </div>

    <!-- Modal for Anggota Penelitian -->
    <div id="anggotaModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 flex justify-center items-center hidden">
        <div class="bg-white rounded-lg shadow-lg w-11/12 max-w-md p-6">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-semibold text-gray-900" id="modalTitle">Daftar Anggota Penelitian</h3>
                <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5" onclick="closeAnggotaModal()">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            <div id="anggotaList" class="mt-2 max-h-60 overflow-y-auto">
                <!-- Anggota will be loaded here -->
            </div>
            <div class="mt-4 flex justify-end">
                <button type="button" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700" onclick="closeAnggotaModal()">
                    Tutup
                </button>
            </div>
        </div>
    </div>

    <div id="tembusanModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden">
    <div class="flex items-center justify-center h-full">
        <div class="bg-white rounded-lg shadow-xl w-full max-w-md max-h-[90vh] overflow-y-auto">
            <div class="flex justify-between items-center border-b p-4">
                <h3 class="text-xl font-semibold text-gray-800">Daftar Tembusan</h3>
                <button type="button" class="text-gray-400 hover:text-gray-600" onclick="closeTembusanModal()">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            
            <div class="p-6">
                <div class="mb-4">
                    <p class="text-sm text-gray-700 mb-2">Nomor Surat: <span id="tembusan_nomor_surat" class="font-medium text-gray-900"></span></p>
                </div>
                <div class="mb-6">
                    <h4 class="text-lg font-medium text-gray-700 mb-3">Tembusan</h4>
                    <textarea id="tembusanTextarea" class="w-full h-64 p-3 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 text-sm" readonly></textarea>
                </div>
            </div>
            
            <div class="border-t p-4 flex justify-end">
                <button type="button" class="px-4 py-2 bg-blue-600 text-white rounded-lg font-medium hover:bg-blue-700" onclick="closeTembusanModal()">
                    Tutup
                </button>
            </div>
        </div>
    </div>
</div>

<script>
// Add these functions with your other JavaScript code
function showTembusanModal(button) {
    const tembusanText = button.dataset.tembusan?.trim();
    const nomorSurat = button.dataset.nomorSurat;

    const tembusanModal = document.getElementById('tembusanModal');
    const tembusanTextarea = document.getElementById('tembusanTextarea');
    const modalNomorSurat = document.getElementById('tembusan_nomor_surat');
    
    // Set the nomor surat in the modal
    modalNomorSurat.textContent = nomorSurat;
    
    // Set the tembusan text in the textarea
    tembusanTextarea.value = tembusanText || 'Tidak ada tembusan';
    
    // Show the modal
    tembusanModal.classList.remove('hidden');
    document.body.style.overflow = 'hidden'; // Prevent scrolling behind modal
}

function closeTembusanModal() {
    document.getElementById('tembusanModal').classList.add('hidden');
    document.body.style.overflow = 'auto'; // Re-enable scrolling
}

// Add to the list of modals in your existing modal close event handlers
document.addEventListener('keydown', function(event) {
    if (event.key === 'Escape') {
        // ...existing modal close handlers...
        if (!document.getElementById('tembusanModal').classList.contains('hidden')) {
            closeTembusanModal();
        }
    }
});
</script>

    <script>
        // Handle sort_by dropdown change
        const sortBySelect = document.getElementById('sort_by');
        if (sortBySelect) {
            sortBySelect.addEventListener('change', function() {
                document.getElementById('filter-form').submit();
            });
        }
        
        // Handle entries per page selector
        const entriesSelect = document.getElementById('entries-select');
        if (entriesSelect) {
            entriesSelect.addEventListener('change', function() {
                document.getElementById('filter-form').submit();
            });
        }
    </script>

    <script>
        // Function to show anggota penelitian modal
        function showAnggotaModal(anggotaData, namaLengkap) {
            const anggotaModal = document.getElementById('anggotaModal');
            const anggotaList = document.getElementById('anggotaList');
            const modalTitle = document.getElementById('modalTitle');
            
            modalTitle.textContent = `Daftar Anggota Penelitian - ${namaLengkap}`;
            anggotaList.innerHTML = '';
            
            try {
                // Try to parse the data as JSON
                let anggotaArray;
                
                if (typeof anggotaData === 'string') {
                    // If it's already a string, try to parse it
                    anggotaArray = JSON.parse(anggotaData);
                } else {
                    // If it's already an object, use it directly
                    anggotaArray = anggotaData;
                }
                
                // Check if it's an array
                if (Array.isArray(anggotaArray)) {
                    if (anggotaArray.length === 0) {
                        anggotaList.innerHTML = '<p class="text-gray-500">Tidak ada anggota penelitian.</p>';
                    } else {
                        const ul = document.createElement('ul');
                        ul.className = 'list-disc list-inside';
                        
                        anggotaArray.forEach((anggota, index) => {
                            const li = document.createElement('li');
                            li.className = 'py-1';
                            li.textContent = typeof anggota === 'object' ? anggota.nama || JSON.stringify(anggota) : anggota;
                            ul.appendChild(li);
                        });
                        
                        anggotaList.appendChild(ul);
                    }
                } else if (typeof anggotaArray === 'string') {
                    // If it's a string (not JSON), display it as is
                    const p = document.createElement('p');
                    p.textContent = anggotaArray;
                    anggotaList.appendChild(p);
                } else {
                    // If it's another type of object, convert to string
                    anggotaList.innerHTML = '<p>' + JSON.stringify(anggotaArray, null, 2).replace(/\\n/g, '<br>') + '</p>';
                }
            } catch (e) {
                // If JSON parsing fails, treat it as a plain string
                const p = document.createElement('p');
                if (anggotaData.includes('\n')) {
                    // If it contains newlines, split by newlines
                    const lines = anggotaData.split('\n');
                    const ul = document.createElement('ul');
                    ul.className = 'list-disc list-inside';
                    
                    lines.forEach(line => {
                        if (line.trim()) {
                            const li = document.createElement('li');
                            li.className = 'py-1';
                            li.textContent = line.trim();
                            ul.appendChild(li);
                        }
                    });
                    
                    anggotaList.appendChild(ul);
                } else {
                    // Otherwise show as is
                    p.textContent = anggotaData;
                    anggotaList.appendChild(p);
                }
            }
            
            // Show the modal
            anggotaModal.classList.remove('hidden');
        }
        
        // Function to close anggota modal
        function closeAnggotaModal() {
            document.getElementById('anggotaModal').classList.add('hidden');
        }

        // Function to show menimbang modal
        function showMenimbangModal(menimbangText, nomorSurat) {
            const menimbangModal = document.getElementById('menimbangModal');
            const menimbangContent = document.getElementById('menimbangContent');
            const modalNomorSurat = document.getElementById('menimbang_nomor_surat');
            
            modalNomorSurat.textContent = nomorSurat;
            menimbangContent.textContent = menimbangText;
            
            // Show the modal
            menimbangModal.classList.remove('hidden');
        }

        // Function to close menimbang modal
        function closeMenimbangModal() {
            document.getElementById('menimbangModal').classList.add('hidden');
        }

        document.addEventListener('DOMContentLoaded', function() {
            // Initialize alert auto-dismiss (only for success alerts)
            initializeAlerts();
            
            // Handle entries per page selector - Modified to preserve status filter
            const entriesSelect = document.getElementById('entries-select');
            if (entriesSelect) {
                entriesSelect.addEventListener('change', function() {
                    const currentUrl = new URL(window.location.href);
                    const params = new URLSearchParams(currentUrl.search);
                    
                    // Update the per_page parameter
                    params.set('per_page', this.value);
                    
                    // Keep the status filter if it exists
                    if (!params.has('status')) {
                        params.set('status', '{{ $statusFilter }}');
                    }
                    
                    // Redirect to the updated URL
                    currentUrl.search = params.toString();
                    window.location.href = currentUrl.toString();
                });
            }
            
            // Close modals when clicking outside of them
            const modals = [
                { id: 'anggotaModal', closeFn: closeAnggotaModal },
                { id: 'menimbangModal', closeFn: closeMenimbangModal }
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
        });

        // Function to initialize alert dismiss functionality
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
@include('Admin.Layout.App.Footer')