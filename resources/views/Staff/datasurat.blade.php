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
                        <button class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg font-medium">
                            LIST Data Surat
                        </button>
                    </div>

                    <div class="flex items-center space-x-2">
                         <div class="relative">
                            <select id="entries-select" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                                <option value="10" {{ $perPage == 10 ? 'selected' : '' }}>10</option>
                                <option value="25" {{ $perPage == 25 ? 'selected' : '' }}>25</option>
                                <option value="50" {{ $perPage == 50 ? 'selected' : '' }}>50</option>
                                <option value="100" {{ $perPage == 100 ? 'selected' : '' }}>100</option>
                            </select>
                        </div>
                        
                        <div class="relative">
                            <form action="{{ route('datasurat') }}" method="GET" class="flex items-center">
                                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                    <svg class="w-4 h-4 text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                                    </svg>
                                </div>
                                <input type="hidden" name="per_page" id="per-page-input" value="{{ $perPage }}">
                                <input type="text" name="search" id="search-input" class="block w-60 p-2.5 pl-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500" placeholder="Cari Data Surat" value="{{ $search }}">
                                <button type="submit" class="absolute inset-y-0 right-0 flex items-center px-4 text-sm font-medium text-white bg-blue-600 rounded-r-lg hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300">
                                    Cari
                                </button>
                            </form>
                        </div>
                        
                        <a href="{{ route('penerbitan') }}" class="flex items-center text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                            Tambah Surat
                        </a>
                    </div>
                </div>
                
                <div class="overflow-x-auto rounded-lg border border-gray-200">
                <table class="w-full text-sm text-left border-collapse">
                    <thead class="text-gray-700 bg-gray-100">
                        <tr class="bg-gray-200">
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
                            <th class="px-4 py-3 border border-gray-300 min-w-[120px]">Status surat</th>
                            <th class="px-4 py-3 border border-gray-300 min-w-[120px]">Posisi surat</th>
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
                                <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                    {{ $surat->posisi_surat }}
                                </span>
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
                                    <a href="#" class="text-blue-500 hover:text-blue-700 p-1" title="Edit">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path>
                                        </svg>
                                    </a>

                                    <form action="{{ route('penerbitan.destroy', $surat->id) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus surat ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-500 hover:text-red-700 p-1" title="Hapus">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                            </svg>
                                        </button>
                                    </form>
                                   
                                    <a href="#" class="text-green-500 hover:text-green-700 p-1" title="Lihat PDF">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                        </svg>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr class="bg-white">
                            <td colspan="16" class="px-4 py-3 border border-gray-200 text-center text-gray-500">
                                Belum ada data surat yang belum diterbitkan
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
                        {{ $penerbitanSurats->appends(['search' => $search, 'per_page' => $perPage])->links() }}
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
            </div>
            
            <div class="overflow-x-auto rounded-lg border border-gray-200">
                <table class="w-full text-sm text-left border-collapse">
                    <thead class="text-gray-700 bg-gray-100">
                        <tr class="bg-gray-200">
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
                            <th class="px-4 py-3 border border-gray-300 min-w-[120px]">Status surat</th>
                            <th class="px-4 py-3 border border-gray-300 min-w-[120px]">Posisi surat</th>
                            <th class="px-4 py-3 border border-gray-300 w-40">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($penerbitanSurats->where('status_surat', 'diterbitkan') as $index => $surat)
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
                                <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                    Diterbitkan
                                </span>
                            </td>
                            <td class="px-4 py-3 border border-gray-200">
                                <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                    {{ $surat->posisi_surat }}
                                </span>
                            </td>
                            <td class="px-4 py-3 border border-gray-200">
                                <div class="flex space-x-2 justify-center">
                                    <button type="button" class="text-blue-500 hover:text-blue-700 p-1" 
                                            onclick="openWhatsAppModal('{{ $surat->id }}', 
                                            '{{ $surat->jenis_surat === 'mahasiswa' && $surat->mahasiswa ? $surat->mahasiswa->nama_lengkap : ($surat->jenis_surat === 'non_mahasiswa' && $surat->nonMahasiswa ? $surat->nonMahasiswa->nama_lengkap : 'Tidak tersedia') }}',
                                            '{{ $surat->jenis_surat === 'mahasiswa' && $surat->mahasiswa ? $surat->mahasiswa->no_hp : ($surat->jenis_surat === 'non_mahasiswa' && $surat->nonMahasiswa ? $surat->nonMahasiswa->no_hp : '') }}',
                                            '{{ $surat->jenis_surat === 'mahasiswa' && $surat->mahasiswa ? addslashes($surat->mahasiswa->judul_penelitian) : ($surat->jenis_surat === 'non_mahasiswa' && $surat->nonMahasiswa ? addslashes($surat->nonMahasiswa->judul_penelitian) : '') }}',
                                            '{{ $surat->nomor_surat }}')"
                                            title="Kirim Notifikasi WhatsApp">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                                        </svg>
                                    </button>
                                    
                                    <a href="#" class="text-blue-500 hover:text-blue-700 p-1" title="Edit">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path>
                                        </svg>
                                    </a>
                                    
                                    <form action="{{ route('penerbitan.destroy', $surat->id) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus surat ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-500 hover:text-red-700 p-1" title="Hapus">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                            </svg>
                                        </button>
                                    </form>
                                    
                                    <a href="#" class="text-green-500 hover:text-green-700 p-1" title="Lihat PDF">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                        </svg>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr class="bg-white">
                            <td colspan="14" class="px-4 py-3 border border-gray-200 text-center text-gray-500">
                                Belum ada data surat yang diterbitkan
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
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

        <!-- Modal for WhatsApp Notification -->
    <div id="whatsappModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 flex justify-center items-center hidden">
        <div class="bg-white rounded-lg shadow-lg w-11/12 max-w-md p-6">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-semibold text-gray-900">Kirim Notifikasi WhatsApp</h3>
                <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5" onclick="closeWhatsAppModal()">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            <form action="{{ route('send.whatsapp.notification') }}" method="POST">
                @csrf
                <input type="hidden" name="surat_id" id="whatsapp_surat_id">
                <div class="mb-4">
                    <label for="whatsapp_nomor" class="block text-sm font-medium text-gray-700">Nomor Telepon</label>
                    <input type="text" id="whatsapp_nomor" name="nomor" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-opacity-50" readonly>
                </div>
                <div class="mb-4">
                    <label for="whatsapp_pesan" class="block text-sm font-medium text-gray-700">Pesan</label>
                    <textarea id="whatsapp_pesan" name="pesan" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-opacity-50" rows="4" required></textarea>
                </div>
                <div class="flex justify-end">
                    <button type="button" class="mr-2 px-4 py-2 bg-gray-300 text-gray-700 rounded-md" onclick="closeWhatsAppModal()">Batal</button>
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md">Kirim</button>
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
        
        // Function to open WhatsApp notification modal
        function openWhatsAppModal(id, nama, nomor, judulPenelitian, nomorSurat) {
            document.getElementById('whatsapp_surat_id').value = id;
            document.getElementById('whatsapp_nomor').value = nomor;
            
            // Create a template message
            const pesan = `Halo ${nama},\n\nDengan ini kami informasikan bahwa surat izin penelitian Anda dengan judul "${judulPenelitian}" telah diterbitkan dengan nomor surat: ${nomorSurat}.\n\nSilahkan datang ke kantor kami untuk mengambil surat tersebut pada jam kerja (Senin-Jumat, 08.00-16.00).\n\nTerima kasih.`;
            
            document.getElementById('whatsapp_pesan').value = pesan;
            document.getElementById('whatsappModal').classList.remove('hidden');
        }

        // Function to close WhatsApp modal
        function closeWhatsAppModal() {
            document.getElementById('whatsappModal').classList.add('hidden');
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

        document.addEventListener('DOMContentLoaded', function() {
            // Initialize alert auto-dismiss (only for success alerts)
            initializeAlerts();
            
            // Handle entries per page selector
            const entriesSelect = document.getElementById('entries-select');
            if (entriesSelect) {
                entriesSelect.addEventListener('change', function() {
                    document.getElementById('per-page-input').value = this.value;
                    document.querySelector('form').submit();
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
                    
                    if (confirm(`Anda yakin ingin menghapus surat dengan nomor "${nomorSurat}" atas nama "${nama}"? Data yang sudah dihapus tidak dapat dikembalikan.`)) {
                        this.submit();
                    }
                });
            });
            
            // Close modals when clicking outside of them
            const modals = [
                { id: 'anggotaModal', closeFn: closeAnggotaModal },
                { id: 'whatsappModal', closeFn: closeWhatsAppModal },
                { id: 'confirmStatusModal', closeFn: closeConfirmStatusModal }
            ];
            
            modals.forEach(modal => {
                document.getElementById(modal.id).addEventListener('click', function(event) {
                    if (event.target === this) {
                        modal.closeFn();
                    }
                });
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