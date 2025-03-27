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
                    Selamat Datang Staff, <span class="font-semibold text-blue-600">Harist</span>
                </div>
            </div>

            <div class="bg-white p-6 rounded-lg shadow-md mb-8">
                <div class="flex justify-between items-center mb-6">
                    <div class="flex items-center space-x-2">
                        <div class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg font-medium">
                            List Pengajuan Mahasiswa
                        </div>
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
                            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                <svg class="w-4 h-4 text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                                </svg>
                            </div>
                            <form action="{{ route('datapengajuanmahasiswa') }}" method="GET" class="relative">
                                <input type="hidden" name="per_page" id="per-page-input" value="{{ $perPage }}">
                                <input type="text" name="search" id="search-input" class="block w-60 p-2.5 pl-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500" placeholder="Cari Mahasiswa" value="{{ request('search') }}">
                                <button type="submit" class="absolute inset-y-0 right-0 flex items-center px-4 text-sm font-medium text-white bg-blue-600 rounded-r-lg hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300">
                                    Cari
                                </button>
                            </form>
                        </div>
                        
                        
                    </div>
                </div>
                @if(session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                            <span class="block sm:inline">{{ session('success') }}</span>
                        </div>
                @endif
                <div class="overflow-x-auto rounded-lg border border-gray-200">
                    <table class="w-full text-sm text-left border-collapse">
                        <thead class="text-gray-700 bg-gray-100">
                            <tr class="border-b border-gray-300">
                                <th colspan="7" class="px-4 py-3 text-center font-medium border-r border-gray-300">Data Pemohon</th>
                                <th colspan="3" class="px-4 py-3 text-center font-medium border-r border-gray-300">Data Instansi</th>
                                <th colspan="8" class="px-4 py-3 text-center font-medium border-r border-gray-300">Data Penelitian</th>
                                <th colspan="3" class="px-4 py-3 text-center font-medium">Berkas Pendukung</th>
                                <th class="px-4 py-3 border-l border-gray-300">Aksi</th>
                            </tr>
                            <tr class="bg-gray-200">
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
                                    <td class="px-4 py-3 border border-gray-200">{{ $mahasiswa->tanggal_mulai }}</td>
                                    <td class="px-4 py-3 border border-gray-200">{{ $mahasiswa->tanggal_selesai }}</td>
                                    <td class="px-4 py-3 border border-gray-200">{{ $mahasiswa->lokasi_penelitian }}</td>
                                    <td class="px-4 py-3 border border-gray-200">{{ $mahasiswa->tujuan_penelitian }}</td>
                                    <!-- In the Data Penelitian section, replace the anggota_peneliti cell with this: -->
                                    <td class="px-4 py-3 border border-gray-200">
                                        <button type="button" 
                                                onclick="openAnggotaModal('{{ $mahasiswa->anggota_peneliti }}')" 
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
                                                <form action="{{ route('mahasiswa.proses', $mahasiswa->id) }}" method="POST">
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
                                                <button type="button" onclick="openTolakModal('{{ $mahasiswa->id }}')" class="text-red-500 hover:text-red-700 p-1" title="Tolak Pengajuan">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                    </svg>
                                                </button>
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


                  <!-- Pagination -->
                <div class="flex justify-between items-center mt-6">
                    <div class="text-sm text-gray-600">
                        Menampilkan {{ $mahasiswas->firstItem() ?? 0 }} sampai {{ $mahasiswas->lastItem() ?? 0 }} dari {{ $mahasiswas->total() }} Total Data
                    </div>
                    <div class="flex">
                        {{ $mahasiswas->appends(['search' => request('search'), 'per_page' => $perPage])->links('vendor.pagination.tailwind') }}
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
                    </div>
                    
                    <div class="overflow-x-auto rounded-lg border border-gray-200">
                        <table class="w-full text-sm text-left border-collapse">
                            <thead class="text-gray-700 bg-gray-100">
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
                                        <td class="px-4 py-3 border border-gray-200">{{ $mahasiswa->updated_at->format('d-m-Y') }}</td>
                                        <td class="px-4 py-3 border border-gray-200">
                                            <div class="flex space-x-2 justify-center">
                                                <!-- Proses kembali button -->
                                                <form action="{{ route('mahasiswa.proses', $mahasiswa->id) }}" method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <button type="submit" class="text-green-500 hover:text-green-700 p-1" title="Proses Kembali">
                                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                                                        </svg>
                                                    </button>
                                                </form>

                                                 <button type="button" class="text-blue-500 hover:text-blue-700 p-1" 
                                                    onclick="openNotificationModal('{{ $mahasiswa->id }}', '{{ $mahasiswa->nama_lengkap }}', '{{ $mahasiswa->no_hp }}', '{{ $mahasiswa->judul_penelitian }}', '{{ $notifikasi ? $notifikasi->alasan_penolakan : 'Tidak ada alasan yang dicatat' }}')" 
                                                    title="Kirim Notifikasi WhatsApp">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
                </div>
            </div>
        </div>
    </div>

    <div id="notificationModal" class="fixed inset-0 flex items-center justify-center z-50 hidden">
        <div class="bg-white rounded-lg shadow-lg p-6">
            <h2 class="text-lg font-semibold mb-4">Kirim Notifikasi WhatsApp</h2>
            <form id="notificationForm" method="POST" action="{{ route('send.whatsapp.notification') }}">
                @csrf
                <input type="hidden" name="mahasiswa_id" id="mahasiswa_id">
                <div class="mb-4">
                    <label for="nomor" class="block text-sm font-medium text-gray-700">Nomor Telepon</label>
                    <input type="text" id="nomor" name="nomor" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-opacity-50" readonly>
                </div>
                <div class="mb-4">
                    <label for="pesan" class="block text-sm font-medium text-gray-700">Pesan</label>
                    <textarea id="pesan" name="pesan" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-opacity-50" rows="4" required></textarea>
                </div>
                <div class="flex justify-end">
                    <button type="button" class="mr-2 px-4 py-2 bg-gray-300 text-gray-700 rounded-md" onclick="closeNotificationModal()">Batal</button>
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md">Kirim</button>
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
    <div id="anggotaPenelitianModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden flex items-center justify-center">
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
                    <ul id="anggotaList" class="space-y-2 mb-4">
                        <!-- List items will be populated dynamically -->
                    </ul>
                </div>
            </div>
            
            <div class="border-t p-4 flex justify-end">
                <button type="button" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg font-medium hover:bg-gray-300" onclick="closeAnggotaModal()">
                    Tutup
                </button>
            </div>
        </div>
    </div>

    <script>
        function openNotificationModal(id, nama, no_hp, judul_penelitian, alasan_penolakan) {
            document.getElementById('mahasiswa_id').value = id;
            document.getElementById('nomor').value = no_hp;
            document.getElementById('pesan').value = 'Notifikasi: Pengajuan "' + judul_penelitian + '" ditolak. Alasan: ' + alasan_penolakan;
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
        // Auto-hide alerts after 5 seconds
        setTimeout(function() {
            document.querySelectorAll('.alert').forEach(function(alert) {
                alert.style.display = 'none';
            });
        }, 5000);

        // Event listener for entries-select
        document.getElementById('entries-select').addEventListener('change', function() {
            const perPage = this.value;
            const searchInput = document.getElementById('search-input').value;
            const perPageInput = document.getElementById('per-page-input');
            perPageInput.value = perPage;

            // Submit the form
            const form = document.querySelector('form');
            form.submit();
        });
    </script>

     <!-- JavaScript untuk Modal -->
    <script>
        // Function to open the modal and populate with anggota data
        function openAnggotaModal(anggotaData) {
            // Get the modal and list elements
            const modal = document.getElementById('anggotaPenelitianModal');
            const anggotaList = document.getElementById('anggotaList');
            
            // Clear previous list
            anggotaList.innerHTML = '';
            
            // Parse the anggota data - assuming it's comma-separated
            const anggotaArray = anggotaData.split(',').map(item => item.trim()).filter(item => item);
            
            // Create list items for each anggota
            if (anggotaArray.length > 0) {
                anggotaArray.forEach(anggota => {
                    const listItem = document.createElement('li');
                    listItem.className = 'anggota-item p-3 bg-gray-50 border border-gray-200 rounded-lg';
                    listItem.innerHTML = `<span class="font-medium">${anggota}</span>`;
                    anggotaList.appendChild(listItem);
                });
            } else {
                // If no anggota, show a message
                const listItem = document.createElement('li');
                listItem.className = 'p-3 bg-gray-50 border border-gray-200 rounded-lg text-gray-500';
                listItem.textContent = 'Tidak ada anggota peneliti';
                anggotaList.appendChild(listItem);
            }
            
            // Show the modal
            modal.classList.remove('hidden');
            document.body.style.overflow = 'hidden'; // Prevent scrolling behind modal
        }
        
        // Function to close the modal
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