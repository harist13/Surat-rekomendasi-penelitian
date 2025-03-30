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
                <h1 class="text-2xl font-bold text-gray-800">Manage template</h1>
                <div class="text-gray-600">
                    Selamat Datang Admin, <span class="font-semibold text-blue-600">{{ Auth::template()->templatename }}</span>
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

            <!-- template Management Panel -->
            <div class="bg-white p-6 rounded-lg shadow-sm mb-8">
                <div class="flex justify-between items-center mb-6">
                    <!-- Tabs -->
                    <div class="flex items-center space-x-2">
                        <button class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg font-medium">
                            LIST template
                        </button>
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
                            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                <svg class="w-4 h-4 text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                                </svg>
                            </div>
                            <!-- Search Form -->
                            <form action="{{ route('akun') }}" method="GET" class="relative">
                                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                    <svg class="w-4 h-4 text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                                    </svg>
                                </div>
                                <input type="text" name="search" id="search-input" class="block w-60 p-2.5 pl-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500" placeholder="Cari template" value="{{ request('search') }}">
                                <button type="submit" class="absolute inset-y-0 right-0 flex items-center px-4 text-sm font-medium text-white bg-blue-600 rounded-r-lg hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300">
                                    Cari
                                </button>
                            </form>

                        </div>
                        
                        <button type="button" id="btn-tambah-template" class="flex items-center text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                            </svg>
                            Tambah template
                        </button>
                    </div>
                </div>
                
                <!-- templates Table -->
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left" id="templates-table">
                        <thead class="text-gray-700 bg-gray-300">
                            <tr>
                                <th class="px-4 py-3">No</th>
                                <th class="px-4 py-3">NIP</th>
                                <th class="px-4 py-3">templatename</th>
                                <th class="px-4 py-3">No Telp</th>
                                <th class="px-4 py-3">Email</th>
                                <th class="px-4 py-3">Role</th>
                                <th class="px-4 py-3">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($templates as $index => $template)
                            <tr class="bg-white border-b hover:bg-gray-50">
                                <td class="px-4 py-3">{{ $index + 1 }}</td>
                                <td class="px-4 py-3">{{ $template->nip }}</td>
                                <td class="px-4 py-3">{{ $template->templatename }}</td>
                                <td class="px-4 py-3">{{ $template->no_telp }}</td>
                                <td class="px-4 py-3">{{ $template->email }}</td>
                                <td class="px-4 py-3">{{ $template->getRoleNames()->first() }}</td>
                                <td class="px-4 py-3 flex space-x-2">
                                    <button data-template-id="{{ $template->id }}" class="btn-edit-template text-blue-500 hover:text-blue-700">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path>
                                        </svg>
                                    </button>
                                    <button data-template-id="{{ $template->id }}" class="btn-delete-template text-red-500 hover:text-red-700">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
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
                        Menampilkan {{ $templates->firstItem() ?? 0 }} sampai {{ $templates->lastItem() ?? 0 }} dari {{ $templates->total() }} Total Data
                    </div>
                    <div class="flex">
                        {{ $templates->appends(['search' => request('search'), 'per_page' => request('per_page')])->links('vendor.pagination.tailwind') }}
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- Tambah template Modal -->
    <div id="tambah-template-modal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden flex items-center justify-center p-4">
        <div class="bg-white rounded-lg w-full max-w-2xl">
            <!-- Modal Header -->
            <div class="flex justify-between items-center p-4 border-b">
                <h3 class="text-lg font-semibold">Tambah template Baru</h3>
                <button onclick="hideTambahtemplateModal()" class="text-gray-500 hover:text-gray-700">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
            
            <!-- Modal Body -->
            <form id="add-template-form" action="{{ route('akun.store') }}" method="POST" class="p-4 space-y-4">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium mb-1">NIP</label>
                        <input type="text" name="nip" class="w-full p-2 border rounded-lg" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-1">templatename</label>
                        <input type="text" name="templatename" class="w-full p-2 border rounded-lg" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-1">Password</label>
                        <input type="password" name="password" class="w-full p-2 border rounded-lg" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-1">No Telp</label>
                        <input type="tel" name="no_telp" class="w-full p-2 border rounded-lg" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-1">Email</label>
                        <input type="email" name="email" class="w-full p-2 border rounded-lg" required>
                    </div>
                  
                    <div>
                        <label class="block text-sm font-medium mb-1">Role</label>
                        <select name="role" class="w-full p-2 border rounded-lg">
                            @foreach($roles as $role)
                            <option value="{{ $role->name }}">{{ $role->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                
                <!-- Modal Footer -->
                <div class="flex justify-end space-x-2 pt-4">
                    <button type="button" onclick="hideTambahtemplateModal()" class="px-4 py-2 border rounded-lg hover:bg-gray-50">
                        Batal
                    </button>
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Edit template Modal -->
    <div id="edit-template-modal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden flex items-center justify-center p-4">
        <div class="bg-white rounded-lg w-full max-w-2xl">
            <!-- Modal Header -->
            <div class="flex justify-between items-center p-4 border-b">
                <h3 class="text-lg font-semibold">Edit template</h3>
                <button onclick="hideEdittemplateModal()" class="text-gray-500 hover:text-gray-700">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
            
            <!-- Modal Body -->
            <form id="edit-template-form" method="POST" class="p-4 space-y-4">
                @csrf
                @method('PUT')
                <input type="hidden" id="edit-template-id" name="template_id">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium mb-1">NIP</label>
                        <input type="text" id="edit-nip" name="nip" class="w-full p-2 border rounded-lg" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-1">templatename</label>
                        <input type="text" id="edit-templatename" name="templatename" class="w-full p-2 border rounded-lg" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-1">Password</label>
                        <input type="password" id="edit-password" name="password" class="w-full p-2 border rounded-lg" placeholder="Leave blank to keep current password">
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-1">No Telp</label>
                        <input type="tel" id="edit-no-telp" name="no_telp" class="w-full p-2 border rounded-lg" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-1">Email</label>
                        <input type="email" id="edit-email" name="email" class="w-full p-2 border rounded-lg" required>
                    </div>
                
                    <div>
                        <label class="block text-sm font-medium mb-1">Role</label>
                        <select id="edit-role" name="role" class="w-full p-2 border rounded-lg">
                            @foreach($roles as $role)
                            <option value="{{ $role->name }}">{{ $role->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                
                <!-- Modal Footer -->
                <div class="flex justify-end space-x-2 pt-4">
                    <button type="button" onclick="hideEdittemplateModal()" class="px-4 py-2 border rounded-lg hover:bg-gray-50">
                        Batal
                    </button>
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div id="delete-modal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden flex items-center justify-center p-4">
        <div class="bg-white rounded-lg w-full max-w-md p-6">
            <h3 class="text-lg font-semibold mb-4">Konfirmasi Hapus</h3>
            <p class="mb-6">Apakah Anda yakin ingin menghapus template ini? Tindakan ini tidak dapat dibatalkan.</p>
            <div class="flex justify-end space-x-2">
                <button onclick="hideDeleteModal()" class="px-4 py-2 border rounded-lg hover:bg-gray-50">
                    Batal
                </button>
                <form id="delete-template-form" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700">
                        Hapus
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

        // Show Tambah template Modal
        function showTambahtemplateModal() {
            document.getElementById('tambah-template-modal').classList.remove('hidden');
            document.body.classList.add('overflow-hidden');
        }

        // Hide Tambah template Modal
        function hideTambahtemplateModal() {
            document.getElementById('tambah-template-modal').classList.add('hidden');
            document.body.classList.remove('overflow-hidden');
        }

        function showEdittemplateModal(templateId) {
            // Reset form first to clear previous values
            document.getElementById('edit-template-form').reset();
            
            // Set the form action URL
            document.getElementById('edit-template-form').action = `/admin/akun/${templateId}`;
            
            // Fetch template data
            fetch(`/admin/akun/${templateId}`)
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    // Populate form fields with template data
                    document.getElementById('edit-template-id').value = data.id;
                    document.getElementById('edit-nip').value = data.nip;
                    document.getElementById('edit-templatename').value = data.templatename;
                    // Password field is left empty intentionally
                    document.getElementById('edit-no-telp').value = data.no_telp;
                    document.getElementById('edit-email').value = data.email;
                    
                    // Select the correct role option
                    const roleSelect = document.getElementById('edit-role');
                    for (let i = 0; i < roleSelect.options.length; i++) {
                        if (roleSelect.options[i].value === data.role) {
                            roleSelect.selectedIndex = i;
                            break;
                        }
                    }
                    
                    // Show the modal
                    document.getElementById('edit-template-modal').classList.remove('hidden');
                    document.body.classList.add('overflow-hidden');
                })
                .catch(error => {
                    console.error('Error fetching template data:', error);
                    alert('Gagal mengambil data template. Silakan coba lagi.');
                });
        }

        // Hide Edit template Modal
        function hideEdittemplateModal() {
            document.getElementById('edit-template-modal').classList.add('hidden');
            document.body.classList.remove('overflow-hidden');
        }

        // Show Delete Confirmation Modal
        function showDeleteModal(templateId) {
            document.getElementById('delete-template-form').action = `/admin/akun/${templateId}`;
            document.getElementById('delete-modal').classList.remove('hidden');
            document.body.classList.add('overflow-hidden');
        }

        // Hide Delete Confirmation Modal
        function hideDeleteModal() {
            document.getElementById('delete-modal').classList.add('hidden');
            document.body.classList.remove('overflow-hidden');
        }

        // Add event listeners when the DOM is loaded
        document.addEventListener('DOMContentLoaded', function() {
            // Add template button
            document.getElementById('btn-tambah-template').addEventListener('click', showTambahtemplateModal);
            
            // Edit buttons
            document.querySelectorAll('.btn-edit-template').forEach(button => {
                button.addEventListener('click', function() {
                    const templateId = this.getAttribute('data-template-id');
                    showEdittemplateModal(templateId);
                });
            });
            
            // Delete buttons
            document.querySelectorAll('.btn-delete-template').forEach(button => {
                button.addEventListener('click', function() {
                    const templateId = this.getAttribute('data-template-id');
                    showDeleteModal(templateId);
                });
            });

            // Add event listeners for search input
            document.getElementById('search-input').addEventListener('keyup', function() {
                let searchTerm = this.value.toLowerCase();
                let tableRows = document.querySelectorAll('#templates-table tbody tr');
                
                tableRows.forEach(row => {
                    let text = row.textContent.toLowerCase();
                    row.style.display = text.includes(searchTerm) ? '' : 'none';
                });
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
        });
    </script>

</body>
@include('Admin.Layout.App.Footer')