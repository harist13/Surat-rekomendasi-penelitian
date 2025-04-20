@include('Admin.Layout.App.Header')
<body class="bg-gradient-to-r from-green-100 to-blue-100">
    <!-- Top Navbar -->
    @include('Admin.Layout.App.Sidebar')
    
    <!-- Main Content -->
    <div class="md:ml-64 pt-16 min-h-screen transition-all duration-300" id="main-content">
        <!-- Mobile Menu Button -->
        <button id="menu-toggle" class="md:hidden fixed top-4 left-4 z-50 p-2 bg-white rounded-lg shadow">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
            </svg>
        </button>

        <!-- Content -->
        <div class="p-8">
            <!-- Header -->
            <div class="flex justify-between items-center mb-8">
                <h1 class="text-2xl font-bold text-gray-800">Data Survei Kepuasan</h1>
                <div class="text-gray-600">
                    Selamat Datang Admin, <span class="font-semibold text-blue-600">{{ Auth::user()->username }}</span>
                </div>
            </div>

            <!-- Alert Messages -->
            @if(session('success'))
            <div id="success-alert" class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4 rounded" role="alert">
                <p>{{ session('success') }}</p>
            </div>
            @endif

            @if($errors->any())
            <div id="error-alert" class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4 rounded" role="alert">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <!-- Survey Management Panel -->
            <div class="bg-white p-6 rounded-lg shadow-sm mb-8">
                <div class="flex justify-between items-center mb-6">
                    <!-- Tabs -->
                    <div class="flex items-center space-x-2">
                        <div class="px-4 py-2 bg-blue-600 text-white rounded-lg font-medium">
                            DATA PERTANYAAN SURVEI
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="flex items-center space-x-2">
                        <div class="relative">
                            <select id="entries-select" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                                <option selected value="10">10</option>
                                <option value="25">25</option>
                                <option value="50">50</option>
                                <option value="100">100</option>
                            </select>
                        </div>
                        
                        <div class="relative">
                            <!-- Search Form -->
                            <form action="{{ route('admin.datasurvei') }}" method="GET" class="relative">
                                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                    <svg class="w-4 h-4 text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                                    </svg>
                                </div>
                                <input type="text" name="search" id="search-input" class="block w-60 p-2.5 pl-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500" placeholder="Cari pertanyaan" value="{{ request('search') }}">
                                <button type="submit" class="absolute inset-y-0 right-0 flex items-center px-4 text-sm font-medium text-white bg-blue-600 rounded-r-lg hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300">
                                    Cari
                                </button>
                            </form>
                        </div>
                        
                        <button type="button" id="btn-tambah-survei" class="flex items-center text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                            </svg>
                            Tambah Pertanyaan
                        </button>
                    </div>
                </div>
                
                <!-- Survey Table -->
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left" id="survei-table">
                        <thead class="text-white bg-[#004aad]">
                            <tr>
                                <th class="px-4 py-3">No</th>
                                <th class="px-4 py-3">Pertanyaan</th>
                                <th class="px-4 py-3">Status</th>
                                <th class="px-4 py-3">Tanggal Dibuat</th>
                                <th class="px-4 py-3">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($surveiQuestions as $index => $question)
                            <tr class="bg-white border-b hover:bg-gray-50">
                                <td class="px-4 py-3">{{ $index + 1 }}</td>
                                <td class="px-4 py-3 max-w-xs truncate">{{ $question->pertanyaan }}</td>
                                <td class="px-4 py-3">
                                    @if($question->is_active)
                                        <span class="px-2 py-1 bg-green-100 text-green-800 rounded-full text-xs">Aktif</span>
                                    @else
                                        <span class="px-2 py-1 bg-red-100 text-red-800 rounded-full text-xs">Tidak Aktif</span>
                                    @endif
                                </td>
                                <td class="px-4 py-3">{{ $question->created_at->format('d/m/Y') }}</td>
                                <td class="px-4 py-3 flex space-x-2">
                                    <button data-survei-id="{{ $question->id }}" class="btn-edit-survei text-blue-500 hover:text-blue-700">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path>
                                        </svg>
                                    </button>
                                    <button data-survei-id="{{ $question->id }}" class="btn-delete-survei text-red-500 hover:text-red-700">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                        </svg>
                                    </button>
                                    <button data-survei-id="{{ $question->id }}" class="btn-toggle-status text-yellow-500 hover:text-yellow-700" title="{{ $question->is_active ? 'Nonaktifkan' : 'Aktifkan' }}">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" {{ $question->is_active ? '' : 'stroke-dasharray="4 4"' }}></path>
                                        </svg>
                                    </button>
                                    <button data-survei-id="{{ $question->id }}" class="btn-view-survei text-green-500 hover:text-green-700">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                        </svg>
                                    </button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                <!-- Pagination -->
                <div class="flex justify-between items-center mt-6">
                    <div class="text-sm text-gray-600">
                        Menampilkan {{ $surveiQuestions->firstItem() ?? 0 }} sampai {{ $surveiQuestions->lastItem() ?? 0 }} dari {{ $surveiQuestions->total() }} Total Data
                    </div>
                    <div class="flex">
                        {{ $surveiQuestions->appends(['search' => request('search'), 'per_page' => request('per_page')])->links('vendor.pagination.tailwind') }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tambah Survei Modal -->
    <div id="tambah-survei-modal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden flex items-center justify-center p-4">
        <div class="bg-white rounded-lg w-full max-w-2xl">
            <!-- Modal Header -->
            <div class="flex justify-between items-center p-4 border-b">
                <h3 class="text-lg font-semibold">Tambah Pertanyaan Survei</h3>
                <button onclick="hideTambahSurveiModal()" class="text-gray-500 hover:text-gray-700">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
            
            <!-- Modal Body -->
            <form id="add-survei-form" action="{{ route('admin.datasurvei.store') }}" method="POST" class="p-4 space-y-4">
                @csrf
                <div>
                    <label class="block text-sm font-medium mb-1">Pertanyaan Survei</label>
                    <input type="text" name="pertanyaan" class="w-full p-2 border rounded-lg" required>
                </div>
                
                <div>
                    <label class="block text-sm font-medium mb-1">Status</label>
                    <select name="is_active" class="w-full p-2 border rounded-lg">
                        <option value="1" selected>Aktif</option>
                        <option value="0">Tidak Aktif</option>
                    </select>
                </div>
                
                
                    <input type="hidden" name="kepuasan_pelayanan" class="w-full p-2 border rounded-lg bg-gray-100" value="1 2 3 4 5" readonly>
                    
                
                <!-- Modal Footer -->
                <div class="flex justify-end space-x-2 pt-4">
                    <button type="button" onclick="hideTambahSurveiModal()" class="px-4 py-2 border rounded-lg hover:bg-gray-50">
                        Batal
                    </button>
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Edit Survei Modal -->
    <div id="edit-survei-modal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden flex items-center justify-center p-4">
        <div class="bg-white rounded-lg w-full max-w-2xl">
            <!-- Modal Header -->
            <div class="flex justify-between items-center p-4 border-b">
                <h3 class="text-lg font-semibold">Edit Pertanyaan Survei</h3>
                <button onclick="hideEditSurveiModal()" class="text-gray-500 hover:text-gray-700">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
            
            <!-- Modal Body -->
            <form id="edit-survei-form" method="POST" class="p-4 space-y-4">
                @csrf
                @method('PUT')
                <input type="hidden" id="edit-survei-id" name="survei_id">
                
                <div>
                    <label class="block text-sm font-medium mb-1">Pertanyaan Survei</label>
                    <input type="text" id="edit-pertanyaan" name="pertanyaan" class="w-full p-2 border rounded-lg" required>
                </div>
                
                <div>
                    <label class="block text-sm font-medium mb-1">Status</label>
                    <select id="edit-is-active" name="is_active" class="w-full p-2 border rounded-lg">
                        <option value="1">Aktif</option>
                        <option value="0">Tidak Aktif</option>
                    </select>
                </div>
                
                
                    <input type="hidden" id="edit-kepuasan" name="kepuasan_pelayanan" class="w-full p-2 border rounded-lg bg-gray-100" value="1 2 3 4 5" readonly>
                
                
                <!-- Modal Footer -->
                <div class="flex justify-end space-x-2 pt-4">
                    <button type="button" onclick="hideEditSurveiModal()" class="px-4 py-2 border rounded-lg hover:bg-gray-50">
                        Batal
                    </button>
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
    
    <!-- View Survei Modal -->
    <div id="view-survei-modal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden flex items-center justify-center p-4">
        <div class="bg-white rounded-lg w-full max-w-2xl">
            <!-- Modal Header -->
            <div class="flex justify-between items-center p-4 border-b">
                <h3 class="text-lg font-semibold">Detail Pertanyaan Survei</h3>
                <button onclick="hideViewSurveiModal()" class="text-gray-500 hover:text-gray-700">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
            
            <!-- Modal Body -->
            <div class="p-4 space-y-4">
                <div>
                    <p class="text-sm font-medium text-gray-500">Pertanyaan</p>
                    <p id="view-pertanyaan" class="text-lg">-</p>
                </div>
                
                <div>
                    <p class="text-sm font-medium text-gray-500">Status</p>
                    <p id="view-status" class="text-lg">-</p>
                </div>
                
                <div>
                    <p class="text-sm font-medium text-gray-500">Skala Kepuasan</p>
                    <p id="view-kepuasan" class="text-lg">-</p>
                </div>

                 <div>
                    <p class="text-sm font-medium text-gray-500">Skala Kepuasan</p>
                    <div class="mt-2 text-sm text-gray-600">
                        <p>1 = Sangat Tidak Setuju</p>
                        <p>2 = Tidak Setuju</p>
                        <p>3 = Kurang Setuju</p>
                        <p>4 = Setuju</p>
                        <p>5 = Sangat Setuju</p>
                    </div>
                </div>
                
                <div>
                    <p class="text-sm font-medium text-gray-500">Tanggal Dibuat</p>
                    <p id="view-created-at" class="text-lg">-</p>
                </div>
                
                <div>
                    <p class="text-sm font-medium text-gray-500">Tanggal Diperbarui</p>
                    <p id="view-updated-at" class="text-lg">-</p>
                </div>
                
                <!-- Modal Footer -->
                <div class="flex justify-end space-x-2 pt-4">
                    <button type="button" onclick="hideViewSurveiModal()" class="px-4 py-2 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300">
                        Tutup
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div id="delete-modal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden flex items-center justify-center p-4">
        <div class="bg-white rounded-lg w-full max-w-md p-6">
            <h3 class="text-lg font-semibold mb-4">Konfirmasi Hapus</h3>
            <p class="mb-6">Apakah Anda yakin ingin menghapus pertanyaan survei ini? Tindakan ini akan menghapus semua jawaban terkait dan tidak dapat dibatalkan.</p>
            <div class="flex justify-end space-x-2">
                <button onclick="hideDeleteModal()" class="px-4 py-2 border rounded-lg hover:bg-gray-50">
                    Batal
                </button>
                <form id="delete-survei-form" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700">
                        Hapus
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Toggle Status Modal -->
    <div id="toggle-status-modal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden flex items-center justify-center p-4">
        <div class="bg-white rounded-lg w-full max-w-md p-6">
            <h3 class="text-lg font-semibold mb-4">Konfirmasi Perubahan Status</h3>
            <p id="toggle-status-text" class="mb-6">Apakah Anda yakin ingin mengubah status pertanyaan survei ini?</p>
            <div class="flex justify-end space-x-2">
                <button onclick="hideToggleStatusModal()" class="px-4 py-2 border rounded-lg hover:bg-gray-50">
                    Batal
                </button>
                <form id="toggle-status-form" method="POST">
                    @csrf
                    @method('PUT')
                    <input type="hidden" id="toggle-status-value" name="is_active" value="">
                    <button type="submit" class="px-4 py-2 bg-yellow-600 text-white rounded-lg hover:bg-yellow-700">
                        Ubah Status
                    </button>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Auto-hide alerts after 5 seconds
        setTimeout(function() {
            document.querySelectorAll('.alert').forEach(function(alert) {
                alert.style.display = 'none';
            });
        }, 5000);

        // Show Tambah Survei Modal
        function showTambahSurveiModal() {
            document.getElementById('tambah-survei-modal').classList.remove('hidden');
            document.body.classList.add('overflow-hidden');
        }

        // Hide Tambah Survei Modal
        function hideTambahSurveiModal() {
            document.getElementById('tambah-survei-modal').classList.add('hidden');
            document.body.classList.remove('overflow-hidden');
        }

        // Show Edit Survei Modal
        function showEditSurveiModal(surveiId) {
            // Reset form first to clear previous values
            document.getElementById('edit-survei-form').reset();
            
            // Set the form action URL
            document.getElementById('edit-survei-form').action = `/admin/datasurvei/${surveiId}`;
            
            // Fetch survei data
            fetch(`/admin/datasurvei/${surveiId}`)
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    // Populate form fields with survei data
                    document.getElementById('edit-survei-id').value = data.id;
                    document.getElementById('edit-pertanyaan').value = data.pertanyaan || '';
                    
                    // Set status dropdown
                    const statusSelect = document.getElementById('edit-is-active');
                    statusSelect.value = data.is_active ? '1' : '0';
                    
                    // Show the modal
                    document.getElementById('edit-survei-modal').classList.remove('hidden');
                    document.body.classList.add('overflow-hidden');
                })
                .catch(error => {
                    console.error('Error fetching survei data:', error);
                    alert('Gagal mengambil data survei. Silakan coba lagi.');
                });
        }

        // Hide Edit Survei Modal
        function hideEditSurveiModal() {
            document.getElementById('edit-survei-modal').classList.add('hidden');
            document.body.classList.remove('overflow-hidden');
        }
        
        // Show View Survei Modal
        function showViewSurveiModal(surveiId) {
            // Fetch survei data
            fetch(`/admin/datasurvei/${surveiId}`)
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    // Populate view fields with survei data
                    document.getElementById('view-pertanyaan').textContent = data.pertanyaan || '-';
                    document.getElementById('view-status').textContent = data.is_active ? 'Aktif' : 'Tidak Aktif';
                    document.getElementById('view-kepuasan').textContent = data.kepuasan_pelayanan || '1 2 3 4 5';
                    
                    // Format the date
                    const createdDate = new Date(data.created_at);
                    document.getElementById('view-created-at').textContent = createdDate.toLocaleString('id-ID', {
                        day: '2-digit',
                        month: '2-digit',
                        year: 'numeric',
                        hour: '2-digit',
                        minute: '2-digit'
                    });
                    
                    const updatedDate = new Date(data.updated_at);
                    document.getElementById('view-updated-at').textContent = updatedDate.toLocaleString('id-ID', {
                        day: '2-digit',
                        month: '2-digit',
                        year: 'numeric',
                        hour: '2-digit',
                        minute: '2-digit'
                    });
                    
                    // Show the modal
                    document.getElementById('view-survei-modal').classList.remove('hidden');
                    document.body.classList.add('overflow-hidden');
                })
                .catch(error => {
                    console.error('Error fetching survei data:', error);
                    alert('Gagal mengambil data survei. Silakan coba lagi.');
                });
        }

        // Hide View Survei Modal
        function hideViewSurveiModal() {
            document.getElementById('view-survei-modal').classList.add('hidden');
            document.body.classList.remove('overflow-hidden');
        }

        // Show Delete Confirmation Modal
        function showDeleteModal(surveiId) {
            document.getElementById('delete-survei-form').action = `/admin/datasurvei/${surveiId}`;
            document.getElementById('delete-modal').classList.remove('hidden');
            document.body.classList.add('overflow-hidden');
        }

        // Hide Delete Confirmation Modal
        function hideDeleteModal() {
            document.getElementById('delete-modal').classList.add('hidden');
            document.body.classList.remove('overflow-hidden');
        }
        
        // Show Toggle Status Modal
        function showToggleStatusModal(surveiId, isActive) {
            const newStatus = isActive ? '0' : '1';
            const statusText = isActive ? 'menonaktifkan' : 'mengaktifkan';
            
            document.getElementById('toggle-status-form').action = `/admin/datasurvei/${surveiId}/toggle-status`;
            document.getElementById('toggle-status-value').value = newStatus;
            document.getElementById('toggle-status-text').textContent = `Apakah Anda yakin ingin ${statusText} pertanyaan survei ini?`;
            
            document.getElementById('toggle-status-modal').classList.remove('hidden');
            document.body.classList.add('overflow-hidden');
        }
        
        // Hide Toggle Status Modal
        function hideToggleStatusModal() {
            document.getElementById('toggle-status-modal').classList.add('hidden');
            document.body.classList.remove('overflow-hidden');
        }

        // Add event listeners when the DOM is loaded
        document.addEventListener('DOMContentLoaded', function() {
            // Add Survei button
            document.getElementById('btn-tambah-survei').addEventListener('click', showTambahSurveiModal);
            
            // Edit buttons
            document.querySelectorAll('.btn-edit-survei').forEach(button => {
                button.addEventListener('click', function() {
                    const surveiId = this.getAttribute('data-survei-id');
                    showEditSurveiModal(surveiId);
                });
            });
            
            // View buttons
            document.querySelectorAll('.btn-view-survei').forEach(button => {
                button.addEventListener('click', function() {
                    const surveiId = this.getAttribute('data-survei-id');
                    showViewSurveiModal(surveiId);
                });
            });
            
            // Delete buttons
            document.querySelectorAll('.btn-delete-survei').forEach(button => {
                button.addEventListener('click', function() {
                    const surveiId = this.getAttribute('data-survei-id');
                    showDeleteModal(surveiId);
                });
            });
            
            // Toggle Status buttons
            document.querySelectorAll('.btn-toggle-status').forEach(button => {
                button.addEventListener('click', function() {
                    const surveiId = this.getAttribute('data-survei-id');
                    const row = this.closest('tr');
                    const statusCell = row.querySelector('td:nth-child(3)');
                    const isActive = statusCell.textContent.trim().includes('Aktif');
                    
                    showToggleStatusModal(surveiId, isActive);
                });
            });

            // Add event listeners for search input
            document.getElementById('search-input').addEventListener('keyup', function(event) {
                if (event.key === 'Enter') {
                    document.querySelector('form[action="{{ route("admin.datasurvei") }}"]').submit();
                }
            });

            // Add event listener for per_page select
            document.getElementById('entries-select').addEventListener('change', function() {
                const perPage = this.value;
                const search = document.getElementById('search-input').value;
                const url = new URL(window.location.href);
                url.searchParams.set('per_page', perPage);
                url.searchParams.set('search', search);
                window.location.href = url.toString();
            });
            
            // Set the initial value of the entries select
            const urlParams = new URLSearchParams(window.location.search);
            const perPage = urlParams.get('per_page');
            if (perPage) {
                document.getElementById('entries-select').value = perPage;
            }
        });
    </script>

</body>
@include('Admin.Layout.App.Footer')