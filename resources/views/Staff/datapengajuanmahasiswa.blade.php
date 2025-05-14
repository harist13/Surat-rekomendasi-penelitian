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
                <h1 class="text-2xl font-bold text-gray-800">Manajemen Pengajuan</h1>
                <div class="text-gray-600">
                    Selamat Datang Staff, <span class="font-semibold text-blue-600">{{ Auth::user()->username }}</span>
                </div>
            </div>

            <div class="bg-white p-6 rounded-lg shadow-md mb-8">
                <div class="flex justify-between items-center mb-6">
                    <div class="flex items-center space-x-2">
                        <div class="px-4 py-2 bg-blue-600 text-white rounded-lg font-medium">
                            List Pengajuan Mahasiswa
                        </div>
                    </div>

                     <div class="flex items-center space-x-2">
                        <form id="main-filter-form" action="{{ route('datapengajuanmahasiswa') }}" method="GET" class="flex items-center space-x-2">
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
                                <input type="text" name="search" id="main-search-input" class="block w-60 p-2.5 pl-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500" placeholder="Cari Mahasiswa" value="{{ request('search') }}">
                                <button type="submit" class="absolute inset-y-0 right-0 flex items-center px-4 text-sm font-medium text-white bg-blue-600 rounded-r-lg hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300">
                                    Cari
                                </button>
                            </div>
                            
                            <!-- Keep rejected table parameters when submitting main form -->
                            <input type="hidden" name="search_rejected" value="{{ request('search_rejected') }}">
                            <input type="hidden" name="per_page_rejected" value="{{ $perPageRejected ?? 10 }}">
                        </form>
                    </div>
                </div>
                @if(session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                            <span class="block sm:inline">{{ session('success') }}</span>
                        </div>
                @endif

                @if(session('error'))
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                        <span class="block sm:inline">{{ session('error') }}</span>
                    </div>
                @endif

                @if ($errors->any())
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                        <ul class="list-disc pl-5">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <div class="overflow-x-auto rounded-lg border border-gray-200">
                    <table class="w-full text-sm text-left border-collapse">
                        <thead class="text-white bg-[#004aad]">
                            <tr class="border-b border-gray-300">
                                <th colspan="7" class="px-4 py-3 text-center font-medium border-r border-gray-300">Data Pemohon</th>
                                <th colspan="3" class="px-4 py-3 text-center font-medium border-r border-gray-300">Data Instansi</th>
                                <th colspan="8" class="px-4 py-3 text-center font-medium border-r border-gray-300">Data Penelitian</th>
                                <th colspan="3" class="px-4 py-3 text-center font-medium">Berkas Pendukung</th>
                                <th class="px-4 py-3 border-l border-gray-300">Aksi</th>
                            </tr>
                            <tr class="bg-[#004aad]">
                                <!-- Data Pemohon Sub Columns -->
                                <th class="px-4 py-3 border border-gray-300 w-12">No</th>
                                <th class="px-4 py-3 border border-gray-300 min-w-[150px]">Nomor Pengajuan</th>
                                <th class="px-4 py-3 border border-gray-300 min-w-[150px]">Nama Lengkap</th>
                                <th class="px-4 py-3 border border-gray-300 w-32">NIM</th>
                                <th class="px-4 py-3 border border-gray-300 min-w-[180px]">Email</th>
                                <th class="px-4 py-3 border border-gray-300 w-36">No HP</th>
                                <th class="px-4 py-3 border border-gray-300 min-w-[250px] whitespace-normal">Alamat Peneliti</th>
                                
                                <!-- Data Instansi Sub Columns -->
                                <th class="px-4 py-3 border border-gray-300 min-w-[150px]">Nama Instansi</th>
                                <th class="px-4 py-3 border border-gray-300 min-w-[250px] whitespace-normal">Alamat Instansi</th>
                                <th class="px-4 py-3 border border-gray-300 min-w-[150px]">Jurusan/Fakultas</th>
                                
                                <!-- Data Penelitian Sub Columns -->
                                <th class="px-4 py-3 border border-gray-300 min-w-[200px]">Judul Penelitian</th>
                                <th class="px-4 py-3 border border-gray-300 w-32">Lama Penelitian</th>
                                <th class="px-4 py-3 border border-gray-300 w-36">Tanggal Mulai</th>
                                <th class="px-4 py-3 border border-gray-300 w-36">Tanggal Selesai</th>
                                <th class="px-4 py-3 border border-gray-300 min-w-[150px]">Lokasi Penelitian</th>
                                <th class="px-4 py-3 border border-gray-300 min-w-[200px]">Tujuan Penelitian</th>
                                <th class="px-4 py-3 border border-gray-300 min-w-[200px]">Anggota Peneliti</th>
                                <th class="px-4 py-3 border border-gray-300 w-24">Status</th>
                                
                                <!-- Berkas Pendukung Sub Columns -->
                                <th class="px-4 py-3 border border-gray-300 w-40">Surat Pengantar</th>
                                <th class="px-4 py-3 border border-gray-300 w-32">Proposal</th>
                                <th class="px-4 py-3 border border-gray-300 w-28">KTP</th>
                                
                                <th class="px-4 py-3 border border-gray-300 w-28">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($mahasiswas as $index => $mahasiswa)
                                <tr class="bg-white hover:bg-gray-50">
                                    <!-- Data Pemohon -->
                                    <td class="px-4 py-3 border border-gray-200">{{ $index + 1 }}</td>
                                    <td class="px-4 py-3 border border-gray-200">{{ $mahasiswa->no_pengajuan }}</td>
                                    <td class="px-4 py-3 border border-gray-200">{{ $mahasiswa->nama_lengkap }}</td>
                                    <td class="px-4 py-3 border border-gray-200">{{ $mahasiswa->nim }}</td>
                                    <td class="px-4 py-3 border border-gray-200">{{ $mahasiswa->email }}</td>
                                    <td class="px-4 py-3 border border-gray-200">{{ $mahasiswa->no_hp }}</td>
                                    <td class="px-4 py-3 border border-gray-200 whitespace-normal">{{ $mahasiswa->alamat_peneliti }}</td>
                                    
                                    <!-- Data Instansi -->
                                    <td class="px-4 py-3 border border-gray-200">{{ $mahasiswa->nama_instansi }}</td>
                                    <td class="px-4 py-3 border border-gray-200 whitespace-normal">{{ $mahasiswa->alamat_instansi }}</td>
                                    <td class="px-4 py-3 border border-gray-200">{{ $mahasiswa->jurusan }}</td>
                                    
                                    <!-- Data Penelitian -->
                                    <td class="px-4 py-3 border border-gray-200">{{ $mahasiswa->judul_penelitian }}</td>
                                    <td class="px-4 py-3 border border-gray-200">{{ $mahasiswa->lama_penelitian }}</td>
                                    <td class="px-4 py-3 border border-gray-200">
                                        {{ Carbon::parse($mahasiswa->tanggal_mulai)->locale('id')->translatedFormat('d-M-Y') }}
                                    </td>
                                    <td class="px-4 py-3 border border-gray-200">
                                        {{ Carbon::parse($mahasiswa->tanggal_selesai)->locale('id')->translatedFormat('d-M-Y') }}
                                    </td>

                                    <td class="px-4 py-3 border border-gray-200">{{ $mahasiswa->lokasi_penelitian }}</td>
                                    <td class="px-4 py-3 border border-gray-200">{{ $mahasiswa->tujuan_penelitian }}</td>
                                    <!-- In the Data Penelitian section, replace the anggota_peneliti cell with this: -->
                                    <td class="px-4 py-3 border border-gray-200">
                                        <button type="button" 
                                            onclick="openAnggotaModal({{ json_encode($mahasiswa->anggota_peneliti) }})" 
                                            class="px-2 py-1 text-sm text-blue-600 hover:text-blue-800 font-medium">
                                        Lihat Anggota
                                        </button>
                                    </td>
                                    <td class="px-4 py-3 border border-gray-200">
                                        @if($mahasiswa->status == 'diproses')
                                            <span class="px-2 py-1 text-xs rounded-full bg-yellow-100 text-yellow-800">{{ $mahasiswa->status }}</span>
                                        @elseif($mahasiswa->status == 'ditolak')
                                            <span class="px-2 py-1 text-xs rounded-full bg-red-100 text-red-800">{{ $mahasiswa->status }}</span>
                                        @elseif($mahasiswa->status == 'diterima')
                                            <span class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-800">{{ $mahasiswa->status }}</span>
                                        @else
                                            <span class="px-2 py-1 text-xs rounded-full bg-gray-100 text-gray-800">{{ $mahasiswa->status }}</span>
                                        @endif
                                    </td>
                                    
                                    <!-- Berkas Pendukung -->
                                    <td class="px-4 py-3 border border-gray-200">
                                        <a href="{{ Storage::url($mahasiswa->surat_pengantar_instansi) }}" class="text-blue-500 hover:text-blue-700">Download</a>
                                    </td>
                                    <td class="px-4 py-3 border border-gray-200">
                                        <a href="{{ Storage::url($mahasiswa->proposal_penelitian) }}" class="text-blue-500 hover:text-blue-700">Download</a>
                                    </td>
                                    <td class="px-4 py-3 border border-gray-200">
                                        <a href="{{ Storage::url($mahasiswa->ktp) }}" class="text-blue-500 hover:text-blue-700">Download</a>
                                    </td>
                                    
                                    <td class="px-4 py-3 border border-gray-200">
                                        <div class="flex space-x-2 justify-center">
                                            
                                            <!-- Checkmark icon (Terima) -->
                                           @if($mahasiswa->status != 'diterima')
                                                <form action="{{ route('mahasiswa.proses', $mahasiswa->id) }}" method="POST" onsubmit="return confirm('Apakah anda ingin menyetujui berkas ini?');">
                                                    @csrf
                                                    @method('PUT')
                                                    <button type="submit" class="text-green-500 hover:text-green-700 p-1" title="Terima Pengajuan">
                                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                                        </svg>
                                                    </button>
                                                </form>
                                            @else
                                                <!-- Disabled checkmark when already accepted -->
                                                <button disabled class="text-gray-300 cursor-not-allowed p-1" title="Sudah Diterima">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                                    </svg>
                                                </button>
                                            @endif
                                            
                                           <!-- Replace the existing X icon (Tolak) button with this one -->
                                            @if($mahasiswa->status != 'ditolak')
                                                @if($mahasiswa->has_letter ?? false)
                                                    <!-- Disabled X when a letter already exists -->
                                                    <button disabled class="text-gray-300 cursor-not-allowed p-1" title="Tidak dapat ditolak karena surat sudah dibuat">
                                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                        </svg>
                                                    </button>
                                                @else
                                                    <button type="button" onclick="openTolakModal('{{ $mahasiswa->id }}')" class="text-red-500 hover:text-red-700 p-1" title="Tolak Pengajuan">
                                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                        </svg>
                                                    </button>
                                                @endif
                                            @else
                                                <!-- Disabled X when already rejected -->
                                                <button disabled class="text-gray-300 cursor-not-allowed p-1" title="Sudah Ditolak">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                    </svg>
                                                </button>
                                            @endif
                                            
                                            <!-- Delete button -->
                                            <form action="{{ route('mahasiswa.hapus', $mahasiswa->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-500 hover:text-red-700 p-1" title="Hapus">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                    </svg>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>


                  <!-- Pagination for main table -->
                <div class="flex justify-between items-center mt-6">
                    <div class="text-sm text-gray-600">
                        Menampilkan {{ $mahasiswas->firstItem() ?? 0 }} sampai {{ $mahasiswas->lastItem() ?? 0 }} dari {{ $mahasiswas->total() }} Total Data
                    </div>
                    <div class="flex">
                        {{ $mahasiswas->appends([
                            'search' => request('search'), 
                            'per_page' => $perPage,
                            'search_rejected' => request('search_rejected'),
                            'per_page_rejected' => $perPageRejected ?? 10
                        ])->links('vendor.pagination.tailwind') }}
                    </div>
                </div>
                <!-- Add this new table after the existing table and pagination -->
                <div class="mt-12 mb-8">
                    <div class="flex justify-between items-center mb-6">
                        <div class="flex items-center space-x-2">
                            <div class="px-4 py-2 bg-red-100 text-red-700 rounded-lg font-medium">
                                Pengajuan Mahasiswa yang Ditolak
                            </div>
                        </div>
                        <!-- Add search and per-page for rejected table -->
                        <div class="flex items-center space-x-2">
                            <form id="rejected-filter-form" action="{{ route('datapengajuanmahasiswa') }}" method="GET" class="flex items-center space-x-2">
                                <div class="relative">
                                    <select id="rejected-entries-select" name="per_page_rejected" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-red-500 focus:border-red-500 block w-full p-2.5">
                                        <option value="10" {{ ($perPageRejected ?? 10) == 10 ? 'selected' : '' }}>10</option>
                                        <option value="25" {{ ($perPageRejected ?? 10) == 25 ? 'selected' : '' }}>25</option>
                                        <option value="50" {{ ($perPageRejected ?? 10) == 50 ? 'selected' : '' }}>50</option>
                                        <option value="100" {{ ($perPageRejected ?? 10) == 100 ? 'selected' : '' }}>100</option>
                                    </select>
                                </div>
                                
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                        <svg class="w-4 h-4 text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                                        </svg>
                                    </div>
                                    <input type="text" name="search_rejected" id="rejected-search-input" class="block w-60 p-2.5 pl-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-red-500 focus:border-red-500" placeholder="Cari Pengajuan Ditolak" value="{{ request('search_rejected') }}">
                                    <button type="submit" class="absolute inset-y-0 right-0 flex items-center px-4 text-sm font-medium text-white bg-red-600 rounded-r-lg hover:bg-red-700 focus:ring-4 focus:outline-none focus:ring-red-300">
                                        Cari
                                    </button>
                                </div>
                                
                                <!-- Keep main table parameters when submitting rejected form -->
                                <input type="hidden" name="search" value="{{ request('search') }}">
                                <input type="hidden" name="per_page" value="{{ $perPage }}">
                            </form>
                        </div>
                    </div>
                    
                    <div class="overflow-x-auto rounded-lg border border-gray-200">
                        <table class="w-full text-sm text-left border-collapse">
                            <thead class="text-white bg-[#004aad]">
                                <tr>
                                    <th class="px-4 py-3 border border-gray-300 w-12">No</th>
                                    <th class="px-4 py-3 border border-gray-300 min-w-[150px]">Nomor Pengajuan</th>
                                    <th class="px-4 py-3 border border-gray-300 min-w-[150px]">Nama Lengkap</th>
                                    <th class="px-4 py-3 border border-gray-300 w-32">NIM</th>
                                    <th class="px-4 py-3 border border-gray-300 min-w-[200px]">Judul Penelitian</th>
                                    <th class="px-4 py-3 border border-gray-300 min-w-[180px]">Email</th>
                                    <th class="px-4 py-3 border border-gray-300 w-36">No HP</th>
                                    <th class="px-4 py-3 border border-gray-300 min-w-[250px]">Alasan Penolakan</th>
                                    <th class="px-4 py-3 border border-gray-300 w-36">Tanggal Ditolak</th>
                                    <th class="px-4 py-3 border border-gray-300 w-28">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($ditolakMahasiswas as $index => $mahasiswa)
                                    <tr class="bg-white hover:bg-gray-50">
                                        <td class="px-4 py-3 border border-gray-200">{{ $index + 1 }}</td>
                                        <td class="px-4 py-3 border border-gray-200">{{ $mahasiswa->no_pengajuan }}</td>
                                        <td class="px-4 py-3 border border-gray-200">{{ $mahasiswa->nama_lengkap }}</td>
                                        <td class="px-4 py-3 border border-gray-200">{{ $mahasiswa->nim }}</td>
                                        <td class="px-4 py-3 border border-gray-200">{{ $mahasiswa->judul_penelitian }}</td>
                                        <td class="px-4 py-3 border border-gray-200">{{ $mahasiswa->email }}</td>
                                        <td class="px-4 py-3 border border-gray-200">{{ $mahasiswa->no_hp }}</td>
                                        <td class="px-4 py-3 border border-gray-200">
                                            @php
                                                $notifikasi = $mahasiswa->notifikasis()->where('tipe', 'danger')->latest()->first();
                                            @endphp
                                            {{ $notifikasi ? $notifikasi->alasan_penolakan : 'Tidak ada alasan yang dicatat' }}
                                        </td>
                                        <td class="px-4 py-3 border border-gray-200">{{ $mahasiswa->updated_at->locale('id')->translatedFormat('d-M-Y') }}
                                        </td>
                                        <td class="px-4 py-3 border border-gray-200">
                                            <div class="flex space-x-2 justify-center">

                                                 <button type="button" 
                                                    onclick="openNotificationModal('{{ $mahasiswa->id }}', '{{ $mahasiswa->nama_lengkap }}', '{{ $mahasiswa->no_hp }}', '{{ $mahasiswa->judul_penelitian }}', '{{ $notifikasi ? $notifikasi->alasan_penolakan : 'Tidak ada alasan yang dicatat' }}', '{{ $mahasiswa->no_pengajuan }}')" 
                                                    class="text-green-600 hover:text-green-800 p-1 flex items-center justify-center" 
                                                    title="Kirim Notifikasi WhatsApp">
                                                    <svg class="w-5 h-5" viewBox="0 0 24 24" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                                                    </svg>
                                                </button>

                                                <button type="button" 
                                                    onclick="openEmailModalMahasiswa('{{ $mahasiswa->id }}', '{{ $mahasiswa->nama_lengkap }}', '{{ $mahasiswa->email }}', '{{ $mahasiswa->judul_penelitian }}', '{{ $notifikasi ? $notifikasi->alasan_penolakan : 'Tidak ada alasan yang dicatat' }}', '{{ $mahasiswa->no_pengajuan }}')" 
                                                    class="text-blue-600 hover:text-blue-800 p-1 flex items-center justify-center" 
                                                    title="Kirim Notifikasi Email">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                                    </svg>
                                                </button>
                                                
                                                <!-- Delete button -->
                                                <form action="{{ route('mahasiswa.hapus', $mahasiswa->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-500 hover:text-red-700 p-1" title="Hapus">
                                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                        </svg>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr class="bg-white">
                                        <td colspan="9" class="px-4 py-6 text-center text-gray-500 border border-gray-200">
                                            Tidak ada pengajuan mahasiswa yang ditolak
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <!-- Pagination for rejected table -->
                    @if($ditolakMahasiswas->count() > 0)
                    <div class="flex justify-between items-center mt-6">
                        <div class="text-sm text-gray-600">
                            Menampilkan {{ $ditolakMahasiswas->firstItem() ?? 0 }} sampai {{ $ditolakMahasiswas->lastItem() ?? 0 }} dari {{ $ditolakMahasiswas->total() }} Total Data
                        </div>
                        <div class="flex">
                            {{ $ditolakMahasiswas->appends([
                                'search' => request('search'),
                                'per_page' => $perPage,
                                'search_rejected' => request('search_rejected'),
                                'per_page_rejected' => $perPageRejected ?? 10
                            ])->links('vendor.pagination.tailwind') }}
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Email Notification Modal for Mahasiswa -->
    <div id="emailModalMahasiswa" class="fixed inset-0 flex items-center justify-center z-50 hidden">
        <div class="absolute inset-0 bg-black bg-opacity-50" onclick="closeEmailModalMahasiswa()"></div>
        <div class="bg-white rounded-lg shadow-xl w-full max-w-md mx-4 relative max-h-[90vh] flex flex-col">
            <div class="flex justify-between items-center bg-blue-600 text-white p-4 rounded-t-lg">
                <h2 class="text-lg font-semibold flex items-center">
                    <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                    </svg>
                    Kirim Notifikasi Email
                </h2>
                <button type="button" class="text-white hover:text-gray-200 focus:outline-none" onclick="closeEmailModalMahasiswa()">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            <div class="overflow-y-auto flex-grow">
                <form id="emailFormMahasiswa" method="POST" action="{{ route('send.email.notification') }}">
                    @csrf
                    <input type="hidden" name="mahasiswa_id" id="email_mahasiswa_id">
                    <input type="hidden" name="nama" id="email_nama_mahasiswa">
                    <input type="hidden" name="no_pengajuan" id="email_no_pengajuan_mahasiswa">
                    <input type="hidden" name="judul_penelitian" id="email_judul_penelitian_mahasiswa">
                    <input type="hidden" name="alasan_penolakan" id="email_alasan_penolakan_mahasiswa">
                    
                    <div class="p-6">
                        <div class="mb-4">
                            <label for="email_mahasiswa" class="block text-sm font-medium text-gray-700 mb-1">Alamat Email</label>
                            <input type="email" id="email_mahasiswa" name="email" class="block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:ring-blue-500 focus:border-blue-500 text-sm" readonly>
                        </div>
                        
                        <div class="mb-4">
                            <p class="text-sm text-gray-600 mb-2">Informasi Pengajuan:</p>
                            <div class="p-3 bg-gray-50 rounded-md text-sm mb-4">
                                <p class="mb-1"><span class="font-medium">Nama:</span> <span id="display_nama_mahasiswa"></span></p>
                                <p class="mb-1"><span class="font-medium">No. Pengajuan:</span> <span id="display_no_pengajuan_mahasiswa"></span></p>
                                <p class="mb-1"><span class="font-medium">Judul Penelitian:</span> <span id="display_judul_penelitian_mahasiswa"></span></p>
                                <p class="mb-1"><span class="font-medium">Alasan Penolakan:</span> <span id="display_alasan_penolakan_mahasiswa"></span></p>
                            </div>
                            
                            <label for="pesan_email_mahasiswa" class="block text-sm font-medium text-gray-700 mb-1">Pesan Email</label>
                            <textarea id="pesan_email_mahasiswa" name="pesan_email" class="block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:ring-blue-500 focus:border-blue-500 text-sm" rows="12" required></textarea>
                            <p class="mt-1 text-xs text-gray-500">Pesan akan dikirim melalui email ke alamat yang tercantum.</p>
                        </div>
                        
                        <div class="flex justify-end space-x-3 mt-6">
                            <button type="button" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2" onclick="closeEmailModalMahasiswa()">
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

    <div id="notificationModal" class="fixed inset-0 flex items-center justify-center z-50 hidden">
        <div class="absolute inset-0 bg-black bg-opacity-50" onclick="closeNotificationModal()"></div>
        <div class="bg-white rounded-lg shadow-xl w-full max-w-md mx-4 relative">
            <div class="flex justify-between items-center bg-green-600 text-white p-4 rounded-t-lg">
                <h2 class="text-lg font-semibold flex items-center">
                    <svg class="w-6 h-6 mr-2" viewBox="0 0 24 24" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                        <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                    </svg>
                    Kirim Notifikasi WhatsApp
                </h2>
                <button type="button" class="text-white hover:text-gray-200 focus:outline-none" onclick="closeNotificationModal()">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            <form id="notificationForm" method="POST" action="{{ route('send.whatsapp.notification') }}">
                @csrf
                <input type="hidden" name="mahasiswa_id" id="mahasiswa_id">
                <div class="p-6">
                    <div class="mb-4">
                        <label for="nomor" class="block text-sm font-medium text-gray-700 mb-1">Nomor Telepon</label>
                        <div class="flex items-center border border-gray-300 rounded-md overflow-hidden">
                            <span class="bg-gray-100 px-3 py-2 text-gray-600 text-sm">+62</span>
                            <input type="text" id="nomor" name="nomor" class="block w-full p-2 text-gray-900 focus:ring-green-500 focus:border-green-500 border-0 focus:outline-none" readonly>
                        </div>
                    </div>
                    <div class="mb-4">
                        <label for="pesan" class="block text-sm font-medium text-gray-700 mb-1">Pesan</label>
                        <textarea id="pesan" name="pesan" class="block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:ring-green-500 focus:border-green-500 text-sm" rows="12" required></textarea>
                        <p class="mt-1 text-xs text-gray-500">Pesan akan dikirim melalui WhatsApp ke nomor yang tercantum.</p>
                    </div>
                    <div class="flex justify-end space-x-3 mt-6">
                        <button type="button" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2" onclick="closeNotificationModal()">
                            Batal
                        </button>
                        <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 flex items-center">
                            <svg class="w-4 h-4 mr-2" viewBox="0 0 24 24" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                            </svg>
                            Kirim Pesan
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Add this modal at the end of the view file, before the closing body tag -->
    <div id="tolakModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden flex items-center justify-center">
        <div class="bg-white rounded-lg shadow-xl w-full max-w-md">
            <div class="flex justify-between items-center border-b p-4">
                <h3 class="text-xl font-semibold text-gray-800">Alasan Penolakan</h3>
                <button type="button" class="text-gray-400 hover:text-gray-600" onclick="closeTolakModal()">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            
            <form id="tolakForm" method="POST">
                @csrf
                @method('PUT')
                <div class="p-6">
                    <div class="mb-4">
                        <label for="alasan_penolakan" class="block text-sm font-medium text-gray-700 mb-2">Alasan Penolakan:</label>
                        <textarea id="alasan_penolakan" name="alasan_penolakan" rows="4" class="w-full border border-gray-300 rounded-lg p-2 text-sm" required></textarea>
                    </div>
                </div>
                
                <div class="border-t p-4 flex justify-end space-x-3">
                    <button type="button" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg font-medium hover:bg-gray-300" onclick="closeTolakModal()">
                        Batal
                    </button>
                    <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-lg font-medium hover:bg-red-700">
                        Tolak Pengajuan
                    </button>
                </div>
            </form>
        </div>
    </div>
     <!-- Modal Anggota Penelitian -->
    <!-- Modal Anggota Penelitian -->
    <div id="anggotaPenelitianModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden">
        <div class="flex items-center justify-center h-full">
            <div class="bg-white rounded-lg shadow-xl w-full max-w-md max-h-[90vh] overflow-y-auto">
                <div class="flex justify-between items-center border-b p-4">
                    <h3 class="text-xl font-semibold text-gray-800">Daftar Anggota Penelitian</h3>
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

    <script>
        // JavaScript functions for Email Modal with message in datapengajuanmahasiswa.blade.php
        function openEmailModalMahasiswa(id, nama, email, judul_penelitian, alasan_penolakan, no_pengajuan) {
            // Set form values
            document.getElementById('email_mahasiswa_id').value = id;
            document.getElementById('email_nama_mahasiswa').value = nama;
            document.getElementById('email_mahasiswa').value = email;
            document.getElementById('email_judul_penelitian_mahasiswa').value = judul_penelitian;
            document.getElementById('email_alasan_penolakan_mahasiswa').value = alasan_penolakan;
            document.getElementById('email_no_pengajuan_mahasiswa').value = no_pengajuan;
            
            // Display values in the modal
            document.getElementById('display_nama_mahasiswa').textContent = nama;
            document.getElementById('display_no_pengajuan_mahasiswa').textContent = no_pengajuan;
            document.getElementById('display_judul_penelitian_mahasiswa').textContent = judul_penelitian;
            document.getElementById('display_alasan_penolakan_mahasiswa').textContent = alasan_penolakan;
            
            // Create a default message template
            const defaultMessage = `Halo ${nama},

        Dengan hormat kami informasikan bahwa pengajuan penelitian Anda dengan nomor pengajuan "${no_pengajuan}" dan judul "${judul_penelitian}" belum dapat kami setujui.

        Alasan: ${alasan_penolakan}

        Anda dapat mengajukan kembali permohonan dengan memperbaiki persyaratan sesuai dengan alasan penolakan di atas. Jika ada pertanyaan, silakan hubungi kantor kami pada jam kerja (Senin-Jumat, 08.00-16.00).

        Terima kasih atas pengertian Anda.

        Hormat kami,
        Tim Badan Kesatuan Bangsa dan Politik
        Pemerintah Provinsi Kalimantan Timur`;
            
            document.getElementById('pesan_email_mahasiswa').value = defaultMessage;
            
            // Show modal
            document.getElementById('emailModalMahasiswa').classList.remove('hidden');
            document.body.style.overflow = 'hidden'; // Prevent scrolling behind modal
        }

        function closeEmailModalMahasiswa() {
            document.getElementById('emailModalMahasiswa').classList.add('hidden');
            document.body.style.overflow = 'auto'; // Re-enable scrolling
        }
    </script>

    <script>
        function openNotificationModal(id, nama, no_hp, judul_penelitian, alasan_penolakan, no_pengajuan) {
            // Set the appropriate ID based on which view we're in
            // For mahasiswa.blade.php:
            if (document.getElementById('mahasiswa_id')) {
                document.getElementById('mahasiswa_id').value = id;
            }
            // For non-mahasiswa.blade.php:
            if (document.getElementById('non_mahasiswa_id')) {
                document.getElementById('non_mahasiswa_id').value = id;
            }
            
            document.getElementById('nomor').value = no_hp;
            
            // Create a more formal and polite template message
            const pesan = `Halo ${nama},

        Dengan hormat kami informasikan bahwa pengajuan penelitian Anda dengan nomor pengajuan "${no_pengajuan}" dan judul "${judul_penelitian}" belum dapat kami setujui.

        Alasan: ${alasan_penolakan}

        Anda dapat mengajukan kembali permohonan dengan memperbaiki persyaratan sesuai dengan alasan penolakan di atas. Jika ada pertanyaan, silakan hubungi kantor kami pada jam kerja (Senin-Jumat, 08.00-16.00).

        Terima kasih atas pengertian Anda.

        Hormat kami,
        Tim Badan Kesatuan Bangsa dan Politik
        Pemerintah Provinsi Kalimantan Timur`;
            
            document.getElementById('pesan').value = pesan;
            document.getElementById('notificationModal').classList.remove('hidden');
        }

        function closeNotificationModal() {
            document.getElementById('notificationModal').classList.add('hidden');
        }
    </script>

    <!-- Add this to your JavaScript section -->
    <script>
        // Function to open tolak modal

       function openTolakModal(id) {
            // Check if the button is disabled
            const button = event.currentTarget;
            if (button.hasAttribute('disabled')) {
                return false; // Do nothing if button is disabled
            }
            
            const modal = document.getElementById('tolakModal');
            const form = document.getElementById('tolakForm');
            
            // Make sure we're using the absolute path
            form.action = `/staff/datapengajuanmahasiswa/${id}/tolak`;
            
            modal.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }
        
        // Function to close tolak modal
        function closeTolakModal() {
            document.getElementById('tolakModal').classList.add('hidden');
            document.body.style.overflow = 'auto'; // Re-enable scrolling
        }
    </script>

     <script>
            document.addEventListener('DOMContentLoaded', function() {
            // Auto-hide alerts after 5 seconds
            setTimeout(function() {
                document.querySelectorAll('.alert').forEach(function(alert) {
                    alert.style.display = 'none';
                });
            }, 5000);

            // Event listeners for select boxes to change items per page
            // Main table entries select
            document.getElementById('main-entries-select').addEventListener('change', function() {
                document.getElementById('main-filter-form').submit();
            });
            
            // Rejected table entries select
            document.getElementById('rejected-entries-select').addEventListener('change', function() {
                document.getElementById('rejected-filter-form').submit();
            });

            // Mobile menu toggle
            const menuToggle = document.getElementById('menu-toggle');
            const sidebar = document.querySelector('[id^="sidebar"]'); // Get sidebar element
            
            if (menuToggle && sidebar) {
                menuToggle.addEventListener('click', function() {
                    sidebar.classList.toggle('-translate-x-full');
                });
            }
        });
     </script>

     <!-- JavaScript untuk Modal -->
    <script>
        // Function to open the modal and populate with anggota data
        // Function to open the modal and populate with anggota data
        function openAnggotaModal(anggotaData) {
            // Get the modal and textarea element
            const modal = document.getElementById('anggotaPenelitianModal');
            const anggotaTextarea = document.getElementById('anggotaTextarea');
            
            // Clear previous content
            anggotaTextarea.value = '';
            
            // Parse the anggota data properly - handle different formats
            let anggotaArray = [];
            
            if (typeof anggotaData === 'string') {
                // Try to parse if it's a JSON string
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
                    // If parsing fails, assume it's comma-separated
                    anggotaArray = anggotaData.split(',').map(item => item.trim()).filter(item => item);
                }
            } else if (Array.isArray(anggotaData)) {
                anggotaArray = anggotaData;
            }
            
            // Add data to textarea
            if (anggotaArray && anggotaArray.length > 0) {
                anggotaTextarea.value = anggotaArray.join('\n');
            } else {
                anggotaTextarea.value = 'Tidak ada anggota peneliti';
            }
            
            // Show the modal
            modal.classList.remove('hidden');
            document.body.style.overflow = 'hidden'; // Prevent scrolling behind modal
        }

        // Function to close the modal remains the same
        function closeAnggotaModal() {
            document.getElementById('anggotaPenelitianModal').classList.add('hidden');
            document.body.style.overflow = 'auto'; // Re-enable scrolling
        }
        
        // Add event listener for mobile menu toggle
        document.addEventListener('DOMContentLoaded', function() {
            const menuToggle = document.getElementById('menu-toggle');
            const sidebar = document.querySelector('[id^="sidebar"]'); // Get sidebar element
            
            if (menuToggle && sidebar) {
                menuToggle.addEventListener('click', function() {
                    sidebar.classList.toggle('-translate-x-full');
                });
            }
        });
    </script>
    
</body>
@include('Staff.Layout.App.Footer')