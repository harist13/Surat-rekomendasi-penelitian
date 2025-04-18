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
                <h1 class="text-2xl font-bold text-gray-800">Pembuatan Surat</h1>
                <div class="text-gray-600">
                    Selamat Datang Staff, <span class="font-semibold text-blue-600">{{ Auth::user()->username }}</span>
                </div>
            </div>

            <div class="bg-white p-6 rounded-lg shadow-md mb-8">
                <div class="flex justify-between items-center mb-6">
                    <div class="flex items-center space-x-2">
                        <div class="px-4 py-2 bg-blue-600 text-white rounded-lg font-medium">
                            Form Pembuatan Surat
                        </div>
                    </div>

                    <div class="flex items-center space-x-2">
                        <button type="button" class="flex items-center text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                            </svg>
                            Daftar Surat
                        </button>
                    </div>
                </div>
                
                 <form class="space-y-6" id="penerbitanForm" action="{{ route('penerbitan.store') }}" method="POST">
                    @csrf
                    <!-- Add this right after opening the <div class="p-8"> in penerbitan.blade.php -->
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

                        @if ($errors->any())
                        <div id="validation-alert" class="flex items-center p-4 mb-4 text-red-800 border-t-4 border-red-500 bg-red-50" role="alert">
                            <svg class="flex-shrink-0 w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zm-1 9a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd"></path>
                            </svg>
                            <div class="ml-3 text-sm font-medium">
                                <strong>Validasi gagal!</strong> Ada beberapa masalah dengan formulir ini:
                                <ul class="mt-1.5 ml-4 list-disc list-inside">
                                    @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                            <button type="button" class="ml-auto -mx-1.5 -my-1.5 bg-red-50 text-red-500 rounded-lg focus:ring-2 focus:ring-red-400 p-1.5 hover:bg-red-200 inline-flex h-8 w-8" data-dismiss-target="#validation-alert" aria-label="Close">
                                <span class="sr-only">Tutup</span>
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                </svg>
                            </button>
                        </div>
                        @endif
                    </div>
                    <input type="hidden" name="status_surat" value="draft">
                    <!-- Jenis Surat -->
                    <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                        <div>
                            <label for="jenis_surat" class="block mb-2 text-sm font-medium text-gray-700">Jenis</label>
                            <select id="jenis_surat" name="jenis_surat" class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required>
                                <option value="" selected disabled>Pilih Jenis</option>
                                <option value="mahasiswa">Mahasiswa</option>
                                <option value="non_mahasiswa">Non-Mahasiswa</option>
                            </select>
                        </div>
                        
                        <!-- Pemohon selection, hidden initially -->
                        <div id="pemohon_container" class="mt-4 hidden">
                            <label for="pemohon_id" class="block mb-2 text-sm font-medium text-gray-700">Pilih Pemohon (Berkas Yang telah Diterima) </label>
                            <select id="pemohon_id" name="pemohon_id" class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                                <option value="" selected disabled>Pilih Pemohon</option>
                            </select>
                        </div>


                        <!-- Add the hidden no_pengajuan field -->
                        <div id="no_pengajuan_container" class="mt-4 hidden">
                            <label for="no_pengajuan" class="block mb-2 text-sm font-medium text-gray-700">Nomor Pengajuan</label>
                            <input type="text" id="no_pengajuan" name="no_pengajuan" class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" readonly>
                        </div>
                        
                        <div class="mt-4">
                            <label for="nomor_surat" class="block mb-2 text-sm font-medium text-gray-700">Nomor surat</label>
                            <input type="text" id="nomor_surat" name="nomor_surat" class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" placeholder="Masukkan nomor surat" required>
                        </div>

                        <br>

                        <!-- Status Penelitian -->
                                <div>
                                    <label for="status_penelitian" class="block mb-2 text-sm font-medium text-gray-700">Status Penelitian</label>
                                    <select id="status_penelitian" name="status_penelitian" class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                                        <option selected disabled>Pilih Status</option>
                                        <option value="baru">Baru</option>
                                        <option value="lama">Lama</option>
                                        <option value="perpanjangan">Perpanjangan</option>
                                    </select>
                                </div>

                  
                        <br>
                        <div>
                            <label for="menimbang" class="block mb-2 text-sm font-medium text-gray-700">menimbang</label>
                            <textarea id="menimbang" name="menimbang" rows="4" class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" placeholder="Masukkan pertimbangan untuk penerbitan surat ini"></textarea>
                        </div>
                        

                    </div>
                    
                    <!-- Identitas Pemohon (merged with Informasi Tambahan) -->
                    <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                        <h2 class="text-lg font-semibold text-gray-700 mb-4">Identitas Pemohon</h2>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-x-4 gap-y-4">
                            <!-- Left Column -->
                            <div class="space-y-4">
                                <!-- Nama -->
                                <div>
                                    <label for="nama_lengkap" class="block mb-2 text-sm font-medium text-gray-700">Nama Lengkap</label>
                                    <input type="text" id="nama_lengkap" name="nama_lengkap" class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" placeholder="Masukkan nama lengkap" readonly>
                                </div>
                                
                                <!-- Jabatan -->
                                <div>
                                    <label for="jabatan" class="block mb-2 text-sm font-medium text-gray-700">Jabatan</label>
                                    <input type="text" id="jabatan" name="jabatan" class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" placeholder="Masukkan jabatan" readonly>
                                </div>
                                
                                <!-- Mahasiswa specific fields (hidden by default) -->
                                <div id="mahasiswa_fields" class="space-y-4 hidden">
                                    <div>
                                        <label for="nim" class="block mb-2 text-sm font-medium text-gray-700">NIM</label>
                                        <input type="text" id="nim" name="nim" class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" placeholder="Masukkan NIM" readonly>
                                    </div>
                                    <div>
                                        <label for="jurusan" class="block mb-2 text-sm font-medium text-gray-700">Jurusan</label>
                                        <input type="text" id="jurusan" name="jurusan" class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" placeholder="Jurusan" readonly>
                                    </div>
                                </div>
                                
                                <!-- Non-Mahasiswa specific fields (hidden by default) -->
                                <div id="non_mahasiswa_fields" class="space-y-4 hidden">
                                    <div>
                                        <label for="bidang" class="block mb-2 text-sm font-medium text-gray-700">Bidang</label>
                                        <input type="text" id="bidang" name="bidang" class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" placeholder="Bidang" readonly>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Right Column -->
                            <div class="space-y-4">
                                <!-- Contact Information -->
                                <div>
                                    <label for="no_hp" class="block mb-2 text-sm font-medium text-gray-700">Nomor HP</label>
                                    <input type="text" id="no_hp" name="no_hp" class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" placeholder="Masukkan nomor HP" readonly>
                                </div>
                                
                                <!-- Hidden inputs for specific types -->
                                <input type="hidden" id="no_hp_mahasiswa" name="no_hp_mahasiswa">
                                <input type="hidden" id="no_hp_non_mahasiswa" name="no_hp_non_mahasiswa">
                                
                                <!-- Nama Lembaga -->
                                <div>
                                    <label for="instansi" class="block mb-2 text-sm font-medium text-gray-700">Nama Lembaga</label>
                                    <input type="text" id="instansi" name="instansi" class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" placeholder="Masukkan nama lembaga" readonly>
                                </div>
                            </div>
                            
                            <!-- Full Width Fields (Address Information) -->
                            <div class="md:col-span-2 grid grid-cols-1 md:grid-cols-2 gap-4">
                                <!-- Tempat Tinggal -->
                                <div>
                                    <label for="tempat_tinggal" class="block mb-2 text-sm font-medium text-gray-700">Tempat Tinggal</label>
                                    <textarea id="tempat_tinggal" name="tempat_tinggal" rows="3" class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" placeholder="Masukkan alamat lengkap tempat tinggal" readonly></textarea>
                                </div>
                                
                                <!-- Alamat Lembaga -->
                                <div>
                                    <label for="alamat_instansi" class="block mb-2 text-sm font-medium text-gray-700">Alamat Lembaga</label>
                                    <textarea id="alamat_instansi" name="alamat_instansi" rows="3" class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" placeholder="Masukkan alamat lembaga" readonly></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Detail Penelitian -->
                    <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                        <h2 class="text-lg font-semibold text-gray-700 mb-4">Detail Penelitian</h2>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <!-- Left Column -->
                            <div class="space-y-4">
                                
                                <!-- Lokasi Penelitian -->
                                <div>
                                    <label for="lokasi_penelitian" class="block mb-2 text-sm font-medium text-gray-700">Lokasi Penelitian</label>
                                    <input type="text" id="lokasi_penelitian" name="lokasi_penelitian" class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" placeholder="Masukkan lokasi penelitian" readonly>
                                </div>
                            </div>
                            
                            <!-- Right Column -->
                            <div class="space-y-4">
                                <!-- Waktu Penelitian (combined field) -->
                                <div>
                                    <label for="waktu_penelitian" class="block mb-2 text-sm font-medium text-gray-700">Waktu Penelitian</label>
                                    <input type="text" id="waktu_penelitian" name="waktu_penelitian" class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" placeholder="Contoh: 1 Jan 2025 - 30 Jun 2025" readonly>
                                </div>
                            </div>
                            
                            <!-- Full Width Fields -->
                            <div class="md:col-span-2 space-y-4">
                                <!-- Judul Proposal -->
                                <div>
                                    <label for="judul_proposal" class="block mb-2 text-sm font-medium text-gray-700">Judul Proposal</label>
                                    <input type="text" id="judul_proposal" name="judul_proposal" class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" placeholder="Masukkan judul proposal" readonly>
                                </div>
                                
                                <!-- Tujuan Penelitian -->
                                <div>
                                    <label for="tujuan_penelitian" class="block mb-2 text-sm font-medium text-gray-700">Tujuan Penelitian</label>
                                    <textarea id="tujuan_penelitian" name="tujuan_penelitian" rows="4" class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" placeholder="Jelaskan tujuan penelitian secara detail" readonly></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Anggota Penelitian (changed to textarea) -->
                    <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                        <h2 class="text-lg font-semibold text-gray-700 mb-4">Anggota Penelitian</h2>
                        
                        <div>
                            <label for="anggota_penelitian" class="block mb-2 text-sm font-medium text-gray-700">Daftar Anggota Penelitian</label>
                            <textarea id="anggota_penelitian" name="anggota_penelitian" rows="4" class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" placeholder="Masukkan daftar anggota penelitian (pisahkan dengan koma atau baris baru)" readonly></textarea>
                        </div>
                    </div>
                    
                    <!-- Form Actions -->
                    <div class="flex justify-end space-x-3">
                        <button type="button" class="px-5 py-2.5 bg-gray-200 text-gray-700 rounded-lg font-medium hover:bg-gray-300 focus:ring-4 focus:ring-gray-200">
                            Batal
                        </button>
                        <button type="submit" class="px-5 py-2.5 bg-blue-600 text-white rounded-lg font-medium hover:bg-blue-700 focus:ring-4 focus:ring-blue-300">
                            Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize data from backend
        const mahasiswaData = @json($approvedMahasiswa);
        const nonMahasiswaData = @json($approvedNonMahasiswa);
        
        // Get DOM elements
        const jenisSuratSelect = document.getElementById('jenis_surat');
        const pemohonContainer = document.getElementById('pemohon_container');
        const pemohonSelect = document.getElementById('pemohon_id');
        const mahasiswaFields = document.getElementById('mahasiswa_fields');
        const nonMahasiswaFields = document.getElementById('non_mahasiswa_fields');
        const penerbitanForm = document.getElementById('penerbitanForm');
        
        // Initialize form validation
        if (penerbitanForm) {
            penerbitanForm.addEventListener('submit', function(event) {
                const { isValid, errorMessages } = validateForm();
                
                // If validation fails, prevent form submission and show custom alert
                if (!isValid) {
                    event.preventDefault();
                    showErrorAlert('Formulir Tidak Valid!', errorMessages);
                } else {
                    // If valid, show loading state
                    showLoadingState();
                }
            });
        }
        
        // Initialize alerts - only auto-dismiss success alerts
        initializeAlerts();
        
        // Add click event to all close buttons
        const closeButtons = document.querySelectorAll('[data-dismiss-target]');
        closeButtons.forEach(button => {
            button.addEventListener('click', function() {
                const targetId = this.getAttribute('data-dismiss-target');
                const alert = document.querySelector(targetId);
                if (alert) {
                    alert.style.display = 'none';
                }
            });
        });
        
        // Update pemohon dropdown options based on selected jenis
        jenisSuratSelect.addEventListener('change', function() {
            const selectedJenis = this.value;
            pemohonSelect.innerHTML = '<option value="" selected disabled>Pilih Pemohon</option>';
            
            // Reset and hide all specific fields first
            mahasiswaFields.classList.add('hidden');
            nonMahasiswaFields.classList.add('hidden');
            document.getElementById('no_pengajuan_container').classList.add('hidden');
            
            if (selectedJenis === 'mahasiswa') {
                mahasiswaData.forEach(mahasiswa => {
                    const option = document.createElement('option');
                    option.value = mahasiswa.id;
                    option.textContent = `${mahasiswa.nama_lengkap} - ${mahasiswa.nim}`;
                    pemohonSelect.appendChild(option);
                });
                pemohonContainer.classList.remove('hidden');
                mahasiswaFields.classList.remove('hidden');
                
            } else if (selectedJenis === 'non_mahasiswa') {
                nonMahasiswaData.forEach(nonMahasiswa => {
                    const option = document.createElement('option');
                    option.value = nonMahasiswa.id;
                    option.textContent = `${nonMahasiswa.nama_lengkap} - ${nonMahasiswa.nama_instansi}`;
                    pemohonSelect.appendChild(option);
                });
                pemohonContainer.classList.remove('hidden');
                nonMahasiswaFields.classList.remove('hidden');
                
            } else {
                pemohonContainer.classList.add('hidden');
            }
            
            resetForm();
        });
        
        // Load data when pemohon is selected
        pemohonSelect.addEventListener('change', function() {
            const selectedJenis = jenisSuratSelect.value;
            const selectedId = this.value;
            
            if (!selectedId) return;
            
            // Fetch data based on jenis and id
            let url = '';
            if (selectedJenis === 'mahasiswa') {
                url = `{{ route('penerbitan.getMahasiswa') }}?id=${selectedId}`;
            } else {
                url = `{{ route('penerbitan.getNonMahasiswa') }}?id=${selectedId}`;
            }
            
            fetch(url)
                .then(response => response.json())
                .then(data => {
                    // Show the no_pengajuan field
                    document.getElementById('no_pengajuan_container').classList.remove('hidden');
                    document.getElementById('no_pengajuan').value = data.no_pengajuan || '';
                    
                    // Populate form fields with data
                    document.getElementById('nama_lengkap').value = data.nama_lengkap || '';
                    document.getElementById('tempat_tinggal').value = data.alamat_peneliti || '';
                    document.getElementById('instansi').value = data.nama_instansi || '';
                    document.getElementById('alamat_instansi').value = data.alamat_instansi || '';
                    document.getElementById('judul_proposal').value = data.judul_penelitian || '';
                    document.getElementById('lokasi_penelitian').value = data.lokasi_penelitian || '';
                    
                    // Format dates for the combined waktu_penelitian field
                    if (data.tanggal_mulai && data.tanggal_selesai) {
                        document.getElementById('waktu_penelitian').value = 
                            `${data.tanggal_mulai} - ${data.tanggal_selesai}`;
                    }
                    
                    document.getElementById('tujuan_penelitian').value = data.tujuan_penelitian || '';
                    
                    // Populate different fields based on jenis
                    if (selectedJenis === 'mahasiswa') {
                        // Populate mahasiswa-specific fields
                        document.getElementById('nim').value = data.nim || '';
                        document.getElementById('no_hp_mahasiswa').value = data.no_hp || '';
                        document.getElementById('no_hp').value = data.no_hp || '';
                        document.getElementById('jurusan').value = data.jurusan || '';
                        document.getElementById('jabatan').value = 'Mahasiswa';
                    } else {
                        // Populate non-mahasiswa-specific fields
                        document.getElementById('no_hp_non_mahasiswa').value = data.no_hp || '';
                        document.getElementById('no_hp').value = data.no_hp || '';
                        document.getElementById('bidang').value = data.bidang || '';
                        document.getElementById('jabatan').value = data.jabatan || '';
                    }
                    
                    // Handle anggota penelitian as a simple string
                    if (data.anggota_peneliti) {
                        let anggotaText = '';
                        
                        try {
                            // Try to parse as JSON
                            const anggotaList = JSON.parse(data.anggota_peneliti);
                            if (Array.isArray(anggotaList)) {
                                anggotaText = anggotaList.join('\n');
                            } else {
                                anggotaText = data.anggota_peneliti;
                            }
                        } catch (e) {
                            // If not valid JSON, use as is
                            anggotaText = data.anggota_peneliti;
                        }
                        
                        document.getElementById('anggota_penelitian').value = anggotaText;
                    }
                })
                .catch(error => {
                    console.error('Error fetching data:', error);
                    alert('Terjadi kesalahan saat mengambil data pemohon.');
                });
        });
    });

    // Function to toggle sidebar on mobile
    document.addEventListener('DOMContentLoaded', function() {
        const menuToggle = document.getElementById('menu-toggle');
        const mainContent = document.getElementById('main-content');
        
        if (menuToggle) {
            menuToggle.addEventListener('click', function() {
                mainContent.classList.toggle('md:ml-0');
                mainContent.classList.toggle('md:ml-64');
            });
        }
        
        // Handle adding new anggota (team member)
        const tambahAnggotaBtn = document.getElementById('tambah-anggota');
        const anggotaContainer = document.getElementById('anggota-container');
        
        if (tambahAnggotaBtn && anggotaContainer) {
            tambahAnggotaBtn.addEventListener('click', function() {
                const newAnggota = document.createElement('div');
                newAnggota.className = 'anggota-item mb-3 p-3 bg-white border border-gray-200 rounded-lg';
                newAnggota.innerHTML = `
                    <div class="flex flex-col md:flex-row md:space-x-4">
                        <div class="flex-grow mb-3 md:mb-0">
                            <input type="text" class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" placeholder="Nama Anggota">
                        </div>
                        <div class="flex-shrink-0">
                            <button type="button" class="text-red-500 hover:text-red-700 p-2 rounded-lg border border-gray-200 hover:bg-gray-100 delete-anggota">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                </svg>
                            </button>
                        </div>
                    </div>
                `;
                anggotaContainer.appendChild(newAnggota);
                
                // Add event listener to the new delete button
                const deleteBtn = newAnggota.querySelector('.delete-anggota');
                if (deleteBtn) {
                    deleteBtn.addEventListener('click', function() {
                        newAnggota.remove();
                    });
                }
            });
        }
        
        // Add event listeners to initial delete buttons
        const initialDeleteBtns = document.querySelectorAll('.anggota-item button');
        initialDeleteBtns.forEach(btn => {
            btn.addEventListener('click', function() {
                this.closest('.anggota-item').remove();
            });
        });
    });

    // Form validation function with detailed Indonesian messages
    function validateForm() {
        const jenisSurat = document.getElementById('jenis_surat').value;
        const pemohonId = document.getElementById('pemohon_id').value;
        const nomorSurat = document.getElementById('nomor_surat').value;
        const statusPenelitian = document.getElementById('status_penelitian').value;
        const namaLengkap = document.getElementById('nama_lengkap').value;
        const instansi = document.getElementById('instansi').value;
        const tempatTinggal = document.getElementById('tempat_tinggal').value;
        const alamatInstansi = document.getElementById('alamat_instansi').value;
        const judulProposal = document.getElementById('judul_proposal').value;
        const lokasiPenelitian = document.getElementById('lokasi_penelitian').value;
        const waktuPenelitian = document.getElementById('waktu_penelitian').value;
        const tujuanPenelitian = document.getElementById('tujuan_penelitian').value;
        const menimbang = document.getElementById('menimbang').value;
        
        let isValid = true;
        let errorMessages = [];
        
        // Validate required fields with Indonesian messages
        if (!jenisSurat) {
            errorMessages.push('Jenis surat wajib dipilih');
            isValid = false;
            highlightErrorField('jenis_surat');
        }
        
        if (!pemohonId) {
            errorMessages.push('Pemohon wajib dipilih');
            isValid = false;
            highlightErrorField('pemohon_id');
        }
        
        if (!nomorSurat) {
            errorMessages.push('Nomor surat wajib diisi');
            isValid = false;
            highlightErrorField('nomor_surat');
        } else if (!/^[A-Za-z0-9\-\/.]+$/.test(nomorSurat)) {
            errorMessages.push('Nomor surat hanya boleh berisi huruf, angka, dan karakter - / .');
            isValid = false;
            highlightErrorField('nomor_surat');
        }
        
        if (!statusPenelitian) {
            errorMessages.push('Status penelitian wajib dipilih');
            isValid = false;
            highlightErrorField('status_penelitian');
        }
        
        if (!namaLengkap) {
            errorMessages.push('Nama lengkap wajib diisi');
            isValid = false;
            highlightErrorField('nama_lengkap');
        }
        
        if (!instansi) {
            errorMessages.push('Nama lembaga wajib diisi');
            isValid = false;
            highlightErrorField('instansi');
        }
        
        if (!tempatTinggal) {
            errorMessages.push('Tempat tinggal wajib diisi');
            isValid = false;
            highlightErrorField('tempat_tinggal');
        }
        
        if (!alamatInstansi) {
            errorMessages.push('Alamat lembaga wajib diisi');
            isValid = false;
            highlightErrorField('alamat_instansi');
        }
        
        if (!judulProposal) {
            errorMessages.push('Judul proposal wajib diisi');
            isValid = false;
            highlightErrorField('judul_proposal');
        }
        
        if (!lokasiPenelitian) {
            errorMessages.push('Lokasi penelitian wajib diisi');
            isValid = false;
            highlightErrorField('lokasi_penelitian');
        }
        
        if (!waktuPenelitian) {
            errorMessages.push('Waktu penelitian wajib diisi');
            isValid = false;
            highlightErrorField('waktu_penelitian');
        }
        
        if (!tujuanPenelitian) {
            errorMessages.push('Tujuan penelitian wajib diisi');
            isValid = false;
            highlightErrorField('tujuan_penelitian');
        }
        
        return { isValid, errorMessages };
    }

    // Highlight error field with red border
    function highlightErrorField(id) {
        const field = document.getElementById(id);
        if (field) {
            field.classList.add('border-red-500');
            field.classList.add('bg-red-50');
            
            // Add event listener to remove highlight when user starts typing
            field.addEventListener('input', function() {
                field.classList.remove('border-red-500');
                field.classList.remove('bg-red-50');
            }, { once: true });
        }
    }

    // Initialize empty fields
    function resetForm() {
        document.getElementById('nama_lengkap').value = '';
        document.getElementById('jabatan').value = '';
        document.getElementById('tempat_tinggal').value = '';
        document.getElementById('instansi').value = '';
        document.getElementById('alamat_instansi').value = '';
        document.getElementById('judul_proposal').value = '';
        document.getElementById('lokasi_penelitian').value = '';
        document.getElementById('waktu_penelitian').value = '';
        document.getElementById('tujuan_penelitian').value = '';
        document.getElementById('anggota_penelitian').value = '';
        document.getElementById('no_hp').value = '';
        document.getElementById('no_pengajuan').value = '';
        document.getElementById('menimbang').value = '';
        
        // Reset the additional fields
        document.getElementById('nim').value = '';
        document.getElementById('no_hp_mahasiswa').value = '';
        document.getElementById('jurusan').value = '';
        document.getElementById('no_hp_non_mahasiswa').value = '';
        document.getElementById('bidang').value = '';
        
        // Hide the no_pengajuan container
        document.getElementById('no_pengajuan_container').classList.add('hidden');
        
        // Reset any error highlighting
        const errorFields = document.querySelectorAll('.border-red-500');
        errorFields.forEach(field => {
            field.classList.remove('border-red-500');
            field.classList.remove('bg-red-50');
        });
    }

    // Function to show custom error alert with enhanced styling
    function showErrorAlert(title, messages) {
        // Create alert container
        const alertDiv = document.createElement('div');
        alertDiv.className = 'fixed inset-0 flex items-center justify-center z-50';
        alertDiv.innerHTML = `
            <div class="fixed inset-0 bg-black opacity-50"></div>
            <div class="bg-white rounded-lg overflow-hidden shadow-xl transform transition-all max-w-lg w-full z-10">
                <div class="bg-red-500 px-4 py-3 text-white flex items-center">
                    <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                    </svg>
                    <h3 class="text-lg font-medium">${title}</h3>
                </div>
                <div class="p-6">
                    <p class="mb-4 text-gray-600">Silakan perbaiki kesalahan berikut:</p>
                    <div class="bg-red-50 p-4 rounded-lg border border-red-200 mb-4">
                        <ul class="list-disc ml-6">
                            ${messages.map(msg => `<li class="text-sm text-red-700 py-1">${msg}</li>`).join('')}
                        </ul>
                    </div>
                    <div class="flex justify-end">
                        <button type="button" class="px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-400" onclick="closeCustomAlert(this)">
                            Tutup
                        </button>
                    </div>
                </div>
            </div>
        `;
        
        document.body.appendChild(alertDiv);
        
        // Add event listener to close on Escape key
        const escListener = function(e) {
            if (e.key === 'Escape') {
                closeCustomAlert(alertDiv.querySelector('button'));
                document.removeEventListener('keydown', escListener);
            }
        };
        document.addEventListener('keydown', escListener);
        
        // Add event listener to close on background click
        alertDiv.querySelector('.fixed.inset-0.bg-black').addEventListener('click', function() {
            closeCustomAlert(alertDiv.querySelector('button'));
        });
    }

    // Function to close custom alert with animation
    function closeCustomAlert(button) {
        const alertDiv = button.closest('.fixed.inset-0');
        
        // Add closing animation
        const modalContent = alertDiv.querySelector('.bg-white');
        modalContent.classList.add('scale-95', 'opacity-0');
        modalContent.style.transition = 'all 0.2s ease-out';
        
        setTimeout(() => {
            alertDiv.remove();
        }, 200);
    }

    // Function to show loading state on submission
    function showLoadingState() {
        const submitBtn = document.querySelector('button[type="submit"]');
        submitBtn.disabled = true;
        submitBtn.innerHTML = `
            <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            Menyimpan...
        `;
    }

    // Function to initialize alert dismiss functionality (auto-dismiss only success alerts)
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

    // Function to fade out element with animation
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