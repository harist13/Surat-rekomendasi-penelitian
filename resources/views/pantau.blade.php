@include('Layout.App.Header')
<body class="bg-gray-50">
    <!-- Main Content -->
    <div class="max-w-7xl mx-auto px-4 py-8">
        <!-- Breadcrumbs -->
        <div class="text-sm text-gray-600 mb-4 flex items-center space-x-2">
            <a href="{{ route('home') }}" class="text-blue-600 hover:underline">Beranda</a>
            <span class="text-gray-400">/</span>
            <span class="text-gray-500">Pantau Status Pengajuan</span>
        </div>

        <!-- Form Pencarian -->
        <div class="mt-8 bg-[#add8e6] p-8 rounded-lg flex flex-col items-center">
            <h3 class="text-2xl font-bold mb-4">Cek Status Permohonan</h3>
            <form method="POST" action="{{ route('pantau.cek') }}" class="flex items-center w-full max-w-md">
                @csrf
                <input type="text" name="no_pengajuan" placeholder="Nomor Permohonan" 
                       class="bg-white shadow-md px-4 py-2 rounded-lg mr-2 w-full" 
                       value="{{ $data->no_pengajuan ?? '' }}" required />
                <button type="submit" class="bg-[#004aad] text-white px-8 py-3 rounded-lg font-semibold hover:bg-blue-500 transition">
                    Cek
                </button>
            </form>
            @if(session('error'))
                <div class="mt-4 text-red-500">{{ session('error') }}</div>
            @endif
        </div>

        @if(isset($data))
        <!-- Tampilkan Data -->
        <div class="flex flex-col lg:flex-row gap-8 mt-8">
            <!-- Detail Pengajuan -->
            <div class="lg:w-2/3">
                <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                    <h1 class="text-2xl font-bold text-[#004aad] mb-6">
                        STATUS PENGAJUAN PENELITIAN 
                        <span class="text-lg">({{ strtoupper($tipe) }})</span>
                    </h1>
                    
                    <!-- Alert Status -->
                    <div class="bg-blue-50 border-l-4 border-blue-400 p-4 mb-6">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-blue-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm text-blue-700">
                                    No. Permohonan: <strong>{{ $data->no_pengajuan }}</strong>
                                    @if($penerbitan)
                                        • No. Surat: <strong>{{ $penerbitan->nomor_surat }}</strong>
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Detail Pemohon -->
                    <div class="space-y-6">
                        <div class="space-y-4">
                            <h3 class="text-lg font-semibold text-[#004aad] border-b-2 border-[#004aad] pb-2">
                                DATA PEMOHON
                            </h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-500">Nama Lengkap</label>
                                    <p class="mt-1 text-sm text-gray-900">{{ $data->nama_lengkap }}</p>
                                </div>
                                
                                @if($tipe === 'mahasiswa')
                                <div>
                                    <label class="block text-sm font-medium text-gray-500">NIM</label>
                                    <p class="mt-1 text-sm text-gray-900">{{ $data->nim }}</p>
                                </div>
                                @else
                                <div>
                                    <label class="block text-sm font-medium text-gray-500">Jabatan</label>
                                    <p class="mt-1 text-sm text-gray-900">{{ $data->jabatan }}</p>
                                </div>
                                @endif
                                
                                <div>
                                    <label class="block text-sm font-medium text-gray-500">Email</label>
                                    <p class="mt-1 text-sm text-gray-900">{{ $data->email }}</p>
                                </div>
                                
                                <div>
                                    <label class="block text-sm font-medium text-gray-500">No. HP</label>
                                    <p class="mt-1 text-sm text-gray-900">{{ $data->no_hp }}</p>
                                </div>
                                
                                <div class="md:col-span-2">
                                    <label class="block text-sm font-medium text-gray-500">Alamat Peneliti</label>
                                    <p class="mt-1 text-sm text-gray-900 whitespace-pre-line">{{ $data->alamat_peneliti }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Data Instansi -->
                        <div class="space-y-4">
                            <h3 class="text-lg font-semibold text-[#004aad] border-b-2 border-[#004aad] pb-2">
                                DATA INSTANSI
                            </h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-500">Nama Instansi</label>
                                    <p class="mt-1 text-sm text-gray-900">{{ $data->nama_instansi }}</p>
                                </div>
                                
                                <div class="md:col-span-2">
                                    <label class="block text-sm font-medium text-gray-500">Alamat Instansi</label>
                                    <p class="mt-1 text-sm text-gray-900 whitespace-pre-line">{{ $data->alamat_instansi }}</p>
                                </div>
                                
                                <div>
                                    <label class="block text-sm font-medium text-gray-500">
                                        @if($tipe === 'mahasiswa')
                                            Jurusan/Fakultas
                                        @else
                                            Bidang
                                        @endif
                                    </label>
                                    <p class="mt-1 text-sm text-gray-900">
                                        {{ $tipe === 'mahasiswa' ? $data->jurusan : $data->bidang }}
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Detail Penelitian -->
                        <div class="space-y-4">
                            <h3 class="text-lg font-semibold text-[#004aad] border-b-2 border-[#004aad] pb-2">
                                DETAIL PENELITIAN
                            </h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div class="md:col-span-2">
                                    <label class="block text-sm font-medium text-gray-500">Judul Penelitian</label>
                                    <p class="mt-1 text-sm text-gray-900">{{ $data->judul_penelitian }}</p>
                                </div>
                                
                                <div>
                                    <label class="block text-sm font-medium text-gray-500">Lama Penelitian</label>
                                    <p class="mt-1 text-sm text-gray-900">{{ $data->lama_penelitian }}</p>
                                </div>
                                
                                <div>
                                    <label class="block text-sm font-medium text-gray-500">Tanggal Mulai</label>
                                    <p class="mt-1 text-sm text-gray-900">{{ $data->tanggal_mulai }}</p>
                                </div>
                                
                                <div>
                                    <label class="block text-sm font-medium text-gray-500">Tanggal Selesai</label>
                                    <p class="mt-1 text-sm text-gray-900">{{ $data->tanggal_selesai }}</p>
                                </div>
                                
                                <div class="md:col-span-2">
                                    <label class="block text-sm font-medium text-gray-500">Lokasi Penelitian</label>
                                    <p class="mt-1 text-sm text-gray-900">{{ $data->lokasi_penelitian }}</p>
                                </div>
                                
                                <div class="md:col-span-2">
                                    <label class="block text-sm font-medium text-gray-500">Tujuan Penelitian</label>
                                    <p class="mt-1 text-sm text-gray-900 whitespace-pre-line">{{ $data->tujuan_penelitian }}</p>
                                </div>
                                
                                <div class="md:col-span-2">
                                    <label class="block text-sm font-medium text-gray-500">Anggota Peneliti</label>
                                    <button type="button" 
                                            onclick="openAnggotaModal('{{ $data->anggota_peneliti }}')" 
                                            class="mt-1 px-3 py-1.5 text-sm bg-blue-50 text-blue-600 hover:bg-blue-100 rounded-md">
                                        <i class="fas fa-users mr-2"></i>Lihat Daftar Anggota
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Timeline Status -->
            <div class="lg:w-1/3">
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h3 class="text-lg font-semibold text-[#004aad] mb-6">PROGRES PENGAJUAN</h3>
                    
                    <div class="relative h-[570px] overflow-y-auto">
                        <div class="absolute left-5 top-2 bottom-2 w-0.5 bg-gray-200"></div>
                        
                        <div class="space-y-8">
                            <!-- Show system status history if available -->
                            @if(isset($statusHistories) && $statusHistories->count() > 0)
                                @foreach($statusHistories as $history)
                                    <div class="relative flex gap-4">
                                        <div class="flex flex-col items-center">
                                            <div class="w-10 h-10 rounded-full flex items-center justify-center shrink-0 
                                                @if($history->status == 'ditolak')
                                                    bg-red-500
                                                @elseif($history->status == 'diterima')
                                                    bg-green-500
                                                @elseif($history->status == 'surat_dibuat')
                                                    bg-orange-500
                                                @elseif($history->status == 'surat_diterbitkan')
                                                    bg-green-500
                                                @elseif($history->status == 'surat_dihapus')
                                                    bg-red-500
                                                @elseif($history->status == 'dihapus')
                                                    bg-red-500
                                                @else
                                                    bg-blue-500
                                                @endif">
                                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    @if($history->status == 'ditolak' || $history->status == 'surat_dihapus' || $history->status == 'dihapus')
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                                    @elseif($history->status == 'diterima' || $history->status == 'surat_diterbitkan')
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                                    @elseif($history->status == 'surat_dibuat')
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                                    @else
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                                                    @endif
                                                </svg>
                                            </div>
                                        </div>
                                        <div class="flex-1 pb-8">
                                            <h4 class="font-medium text-gray-900">
                                                @if($history->status == 'ditolak')
                                                    Berkas Ditolak
                                                @elseif($history->status == 'diterima')
                                                    Berkas Diterima
                                                @elseif($history->status == 'surat_dibuat')
                                                    Surat Dibuat
                                                @elseif($history->status == 'surat_diterbitkan')
                                                    Surat Diterbitkan
                                                @elseif($history->status == 'surat_dihapus')
                                                    Surat Dihapus
                                                @elseif($history->status == 'dihapus')
                                                    Pengajuan Dihapus
                                                @else
                                                    {{ ucfirst(str_replace('_', ' ', $history->status)) }}
                                                @endif
                                            </h4>
                                            <div class="text-sm text-gray-500">
                                                {{ $history->created_at->format('d M Y H:i') }}
                                            </div>
                                            @if($history->notes)
                                                <div class="mt-2 text-xs text-gray-600">
                                                    {{ $history->notes }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <!-- Default Status Display for backward compatibility -->
                                <!-- Status 1: Menunggu Verifikasi (Always Show) -->
                                <div class="relative flex gap-4">
                                    <div class="flex flex-col items-center">
                                        <div class="w-10 h-10 bg-blue-500 rounded-full flex items-center justify-center shrink-0">
                                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                            </svg>
                                        </div>
                                    </div>
                                    <div class="flex-1 pb-8">
                                        <h4 class="font-medium text-gray-900">Pengajuan Diterima Sistem</h4>
                                        <div class="text-sm text-gray-500">
                                            {{ $data->created_at->format('d M Y H:i') }}
                                        </div>
                                    </div>
                                </div>

                                <!-- Status 2: Proses Verifikasi -->
                                <div class="relative flex gap-4">
                                    <div class="flex flex-col items-center">
                                        <div class="w-10 h-10 bg-purple-500 rounded-full flex items-center justify-center shrink-0">
                                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                                            </svg>
                                        </div>
                                    </div>
                                    <div class="flex-1 pb-8">
                                        <h4 class="font-medium text-gray-900">Sedang Diproses</h4>
                                        <div class="text-sm text-gray-500">
                                            {{ $data->created_at->addMinutes(15)->format('d M Y H:i') }}
                                        </div>
                                    </div>
                                </div>

                                <!-- Status 3: Hasil Verifikasi -->
                                @if($data->status == 'diterima' || $data->status == 'ditolak')
                                <div class="relative flex gap-4">
                                    <div class="flex flex-col items-center">
                                        <div class="w-10 h-10 {{ $data->status == 'diterima' ? 'bg-green-500' : 'bg-red-500' }} rounded-full flex items-center justify-center shrink-0">
                                            @if($data->status == 'diterima')
                                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                            </svg>
                                            @else
                                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                            </svg>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="flex-1 pb-8">
                                        <h4 class="font-medium text-gray-900">
                                            @if($data->status == 'diterima')
                                            Berkas Diterima oleh {{ $penerbitan->user->username ?? 'Staff' }}
                                            @else
                                            Berkas Ditolak
                                            @endif
                                        </h4>
                                        <div class="text-sm text-gray-500">
                                            {{ $data->updated_at->format('d M Y H:i') }}
                                        </div>
                                        @if($data->status == 'ditolak' && $notifikasis->isNotEmpty())
                                        <div class="mt-2 text-xs text-red-600">
                                            Alasan: {{ $notifikasis->first()->alasan_penolakan }}
                                        </div>
                                        @endif
                                    </div>
                                </div>
                                @endif

                                <!-- Status 4: Proses Penerbitan Surat -->
                                @if($penerbitan)
                                <div class="relative flex gap-4">
                                    <div class="flex flex-col items-center">
                                        <div class="w-10 h-10 bg-orange-500 rounded-full flex items-center justify-center shrink-0">
                                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                            </svg>
                                        </div>
                                    </div>
                                    <div class="flex-1 pb-8">
                                        <h4 class="font-medium text-gray-900">
                                            @if($penerbitan->status_surat == 'draft')
                                            Surat dalam Proses Penyusunan
                                            @else
                                            Surat dalam Tahap Finalisasi
                                            @endif
                                        </h4>
                                        <div class="text-sm text-gray-500">
                                            {{ $penerbitan->created_at->format('d M Y H:i') }}
                                        </div>
                                    </div>
                                </div>
                                @endif

                                <!-- Status 5: Surat Selesai -->
                                @if($penerbitan && $penerbitan->status_surat == 'diterbitkan')
                                <div class="relative flex gap-4">
                                    <div class="flex flex-col items-center">
                                        <div class="w-10 h-10 bg-green-500 rounded-full flex items-center justify-center shrink-0">
                                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                            </svg>
                                        </div>
                                    </div>
                                    <div class="flex-1">
                                        <h4 class="font-medium text-gray-900">Surat Telah Diterbitkan</h4>
                                        <div class="text-sm text-gray-500">
                                            Nomor: {{ $penerbitan->nomor_surat }}
                                        </div>
                                        <div class="text-xs text-gray-400 mt-1">
                                            {{ $penerbitan->updated_at->format('d M Y H:i') }}
                                        </div>
                                    </div>
                                </div>
                                @endif
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>
    <div id="anggotaModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3 text-center">
            <h3 class="text-lg leading-6 font-medium text-gray-900">Daftar Anggota Peneliti</h3>
            <div class="mt-2 px-4 py-3">
                <p id="anggotaList" class="text-sm text-gray-500 whitespace-pre-line"></p>
            </div>
            <div class="items-center px-4 py-3">
                <button onclick="closeAnggotaModal()" class="px-4 py-2 bg-blue-500 text-white text-base font-medium rounded-md shadow-sm hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-300">
                    Tutup
                </button>
            </div>
        </div>
    </div>
</div>

<script>
function openAnggotaModal(anggota) {
    document.getElementById('anggotaList').textContent = anggota;
    document.getElementById('anggotaModal').classList.remove('hidden');
}

function closeAnggotaModal() {
    document.getElementById('anggotaModal').classList.add('hidden');
}
</script>
</body>
@include('Layout.App.Footer')