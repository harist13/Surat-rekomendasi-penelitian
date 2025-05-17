<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Staff Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Heroicons -->
    <script src="https://unpkg.com/@heroicons/v2.0.18/24/outline/index.js"></script>
</head>

<header>
    <!-- Top Navbar -->
    <div class="fixed top-0 left-0 right-0 bg-white shadow-sm h-16 z-30 flex items-center px-4">
        <div class="container mx-auto flex justify-between items-center">
            <!-- Left side - Logo and text -->
            <div class="flex items-center md:ml-64 transition-all duration-300" id="navbar-content">
               
            </div>
            
            <!-- Right side - User profile -->
            <div class="flex items-center">
    <!-- Notification Icon -->
    <div class="relative mr-4 cursor-pointer" id="notificationButton">
        <svg class="w-6 h-6 text-gray-600 hover:text-blue-600 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
        </svg>
        @if(isset($unreadNotifications) && $unreadNotifications->count() > 0)
            <span class="absolute -top-1 -right-1 bg-red-500 text-white text-xs px-1.5 rounded-full">{{ $unreadNotifications->count() }}</span>
        @endif
    </div>
            <div class="flex items-center cursor-pointer" id="userProfileButton">
                <div class="text-sm text-right mr-2">
                    <div class="font-medium">{{ Auth::user()->username }}</div>
                    <div class="text-xs text-gray-500">{{ Auth::user()->getRoleNames()->first() }}</div>
                </div>
                <div class="bg-gray-200 rounded-full h-8 w-8 flex items-center justify-center">
                    <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                </div>
            </div>
        </div>
    </div>
    <!-- Profile Modal -->
    <div id="profileModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center hidden">
        <div class="bg-white rounded-lg shadow-xl w-80 overflow-hidden">
            <!-- Modal Header -->
            <div class="bg-gradient-to-r from-green-500 to-blue-500 px-4 py-5 flex flex-col items-center">
                <div class="bg-white rounded-full h-16 w-16 flex items-center justify-center mb-2">
                    <svg class="w-10 h-10 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                </div>
                <h3 class="text-white text-lg font-semibold">{{ Auth::user()->username }}</h3>
                <p class="text-white text-sm opacity-90">{{ Auth::user()->getRoleNames()->first() }}</p>
            </div>
        
            <!-- Modal Body -->
            <div class="p-4">
                <!-- Profile Options -->
                <div class="space-y-2">
                    <a href="javascript:void(0);" id="editProfileBtn" class="flex items-center p-2 hover:bg-gray-100 rounded-lg transition">
                        <svg class="w-5 h-5 mr-3 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        <span>Edit Profile</span>
                    </a>
                    <a href="#" id="logoutBtn" class="flex items-center p-2 text-red-500 hover:bg-red-50 rounded-lg transition">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                        </svg>
                        <span>Keluar</span>
                    </a>
                </div>
            </div>
            
            <!-- Modal Footer -->
            <div class="px-4 py-3 bg-gray-50 text-right">
                <button id="closeProfileModal" class="px-4 py-2 bg-gray-200 hover:bg-gray-300 rounded-lg transition">Tutup</button>
            </div>
        </div>
    </div>
    </div>


 <!-- Logout confirmation modal -->
    <div id="logoutModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center hidden">
        <div class="bg-white rounded-lg shadow-xl w-80 overflow-hidden">
            <div class="p-4">
                <h3 class="text-lg font-semibold mb-2">Konfirmasi Keluar</h3>
                <p class="text-gray-600">Apakah Anda yakin ingin keluar dari aplikasi?</p>
            </div>
            <div class="px-4 py-3 bg-gray-50 flex justify-end space-x-2">
                <button id="cancelLogout" class="px-4 py-2 bg-gray-200 hover:bg-gray-300 rounded-lg transition">Batal</button>
                <button id="confirmLogout" class="px-4 py-2 bg-red-500 text-white hover:bg-red-600 rounded-lg transition">Keluar</button>
            </div>
        </div>
    </div>

    <!-- Hidden Logout Form -->
    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
        @csrf
    </form>

    <div id="editProfileModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center hidden">
    <div class="bg-white rounded-lg shadow-xl w-96 max-w-full overflow-hidden">
        <!-- Modal Header -->
        <div class="bg-gradient-to-r from-green-500 to-blue-500 px-4 py-3">
            <h3 class="text-white text-lg font-semibold">Edit Profile</h3>
        </div>
        
        <!-- Modal Body -->
        <div class="p-4">
            <form id="editProfileForm" action="{{ route('profile.update') }}" method="POST">
                @csrf
                @method('PUT')
                
                <!-- NIP -->
                <div class="mb-4">
                    <label for="edit_nip" class="block text-sm font-medium text-gray-700 mb-1">NIP</label>
                    <input type="text" id="edit_nip" name="nip" value="{{ Auth::user()->nip }}" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-blue-500">
                </div>
                
                <!-- Username -->
                <div class="mb-4">
                    <label for="edit_username" class="block text-sm font-medium text-gray-700 mb-1">Username</label>
                    <input type="text" id="edit_username" name="username" value="{{ Auth::user()->username }}" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-blue-500">
                </div>
                
                <!-- Password -->
                <div class="mb-4">
                    <label for="edit_password" class="block text-sm font-medium text-gray-700 mb-1">Password (Kosongkan jika tidak ingin mengubah)</label>
                    <input type="password" id="edit_password" name="password" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-blue-500">
                </div>
                
                <!-- Password Confirmation -->
                <div class="mb-4">
                    <label for="edit_password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Konfirmasi Password</label>
                    <input type="password" id="edit_password_confirmation" name="password_confirmation" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-blue-500">
                </div>
                
                <!-- No Telp -->
                <div class="mb-4">
                    <label for="edit_no_telp" class="block text-sm font-medium text-gray-700 mb-1">No. Telepon</label>
                    <input type="text" id="edit_no_telp" name="no_telp" value="{{ Auth::user()->no_telp }}" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-blue-500">
                </div>
                
                <!-- Email -->
                <div class="mb-4">
                    <label for="edit_email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                    <input type="email" id="edit_email" name="email" value="{{ Auth::user()->email }}" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-blue-500">
                </div>
            </form>
        </div>
        
        <!-- Modal Footer -->
        <div class="px-4 py-3 bg-gray-50 flex justify-end space-x-2">
            <button id="closeEditProfileModal" class="px-4 py-2 bg-gray-200 hover:bg-gray-300 rounded-lg transition">Batal</button>
            <button id="saveProfileBtn" class="px-4 py-2 bg-blue-500 text-white hover:bg-blue-600 rounded-lg transition">Simpan</button>
        </div>
    </div>
</div>


</header>

<!-- Modal Notifikasi -->
<div id="notifmodal" class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center hidden">
    <div class="bg-white rounded-lg shadow-xl w-[600px] max-w-full max-h-[90vh] flex flex-col overflow-hidden">
        
        <!-- Header -->
        <div class="bg-[#A7CDFF] px-6 py-4 flex justify-between items-center">
            <h1 class="text-xl font-bold text-gray-900">Notifikasi</h1>
            <button id="markAllAsRead" class="text-blue-700 text-sm font-medium hover:underline">Tandai Baca Semua</button>
        </div>

        <!-- Tabs -->
        <div class="flex justify-around items-center border-b bg-[#A7CDFF] text-gray-700">
            <button class="tab-btn py-2 px-4 font-semibold text-gray-600" data-tab="masuk">
                Pengajuan Masuk
                @if(isset($newApplicationNotifications) && $newApplicationNotifications->where('telah_dibaca', false)->count() > 0)
                    <span class="ml-1 bg-white text-xs px-2 py-0.5 rounded-full font-semibold">{{ $newApplicationNotifications->where('telah_dibaca', false)->count() }}</span>
                @endif
            </button>
            <button class="tab-btn py-2 px-4 font-semibold text-gray-600" data-tab="verifikasi">
                Verifikasi Pengajuan
                @if(isset($verificationNotifications) && $verificationNotifications->where('telah_dibaca', false)->count() > 0)
                    <span class="ml-1 bg-white text-xs px-2 py-0.5 rounded-full font-semibold">{{ $verificationNotifications->where('telah_dibaca', false)->count() }}</span>
                @endif
            </button>
            <button class="tab-btn py-2 px-4 font-semibold text-gray-600" data-tab="surat">
                Data Surat
                @if(isset($suratNotifications) && $suratNotifications->where('telah_dibaca', false)->count() > 0)
                    <span class="ml-1 bg-white text-xs px-2 py-0.5 rounded-full font-semibold">{{ $suratNotifications->where('telah_dibaca', false)->count() }}</span>
                @endif
            </button>
        </div>

        <!-- Konten Notifikasi -->
        <div class="p-4 space-y-4 overflow-y-auto max-h-[400px]">
            <!-- Pengajuan Masuk Tab -->
            <div id="tab-masuk" class="tab-content hidden">
                @if(isset($newApplicationNotifications) && $newApplicationNotifications->where('telah_dibaca', false)->count() > 0)
                    @foreach($newApplicationNotifications->where('telah_dibaca', false) as $notification)
                        <div class="border-b pb-2">
                            <p class="text-xs text-gray-500">{{ $notification->created_at->format('d M Y H:i A') }}</p>
                            <p class="font-bold">{{ $notification->tipe_peneliti === 'mahasiswa' ? ($notification->mahasiswa ? $notification->mahasiswa->no_pengajuan : 'N/A') : ($notification->nonMahasiswa ? $notification->nonMahasiswa->no_pengajuan : 'N/A') }}</p>
                            <p>{{ $notification->pesan }}</p>
                        </div>
                    @endforeach
                @else
                    <div class="text-center text-gray-500 py-4">
                        Tidak ada pengajuan baru
                    </div>
                @endif
            </div>

            <!-- Verifikasi Pengajuan Tab -->
            <div id="tab-verifikasi" class="tab-content hidden">
                @if(isset($verificationNotifications) && $verificationNotifications->where('telah_dibaca', false)->count() > 0)
                    @foreach($verificationNotifications->where('telah_dibaca', false) as $notification)
                        <div class="border-b pb-2">
                            <p class="text-xs text-gray-500">{{ $notification->created_at->format('d M Y H:i A') }}</p>
                            <p class="font-bold">
                                @if($notification->tipe_peneliti === 'mahasiswa' && $notification->mahasiswa)
                                    {{ $notification->mahasiswa->no_pengajuan }}
                                @elseif($notification->tipe_peneliti === 'non_mahasiswa' && $notification->nonMahasiswa)
                                    {{ $notification->nonMahasiswa->no_pengajuan }}
                                @endif
                            </p>
                            <p>{{ $notification->pesan }}</p>
                            @if($notification->alasan_penolakan)
                                <p class="mt-1 text-sm text-red-600">Alasan: {{ $notification->alasan_penolakan }}</p>
                            @endif
                        </div>
                    @endforeach
                @else
                    <div class="text-center text-gray-500 py-4">
                        Tidak ada notifikasi verifikasi
                    </div>
                @endif
            </div>

            <!-- Data Surat Tab -->
            <div id="tab-surat" class="tab-content hidden">
                @if(isset($suratNotifications) && $suratNotifications->where('telah_dibaca', false)->count() > 0)
                    @foreach($suratNotifications->where('telah_dibaca', false) as $notification)
                        <div class="border-b pb-2">
                            <p class="text-xs text-gray-500">{{ $notification->created_at->format('d M Y H:i A') }}</p>
                            @if($notification->tipe_peneliti === 'mahasiswa' && $notification->mahasiswa)
                                <p class="font-bold">{{ $notification->mahasiswa->no_pengajuan }}</p>
                            @elseif($notification->tipe_peneliti === 'non_mahasiswa' && $notification->nonMahasiswa)
                                <p class="font-bold">{{ $notification->nonMahasiswa->no_pengajuan }}</p>
                            @endif
                            <p>{{ $notification->pesan }}</p>
                            
                            @if($notification->penerbitan_surat_id)
                                <div class="mt-1">
                                    @php
                                        $penerbitanSurat = \App\Models\PenerbitanSurat::find($notification->penerbitan_surat_id);
                                    @endphp
                                    @if($penerbitanSurat)
                                        <span class="text-xs text-blue-600">
                                            Nomor Surat: {{ $penerbitanSurat->nomor_surat }}
                                        </span>
                                    @endif
                                </div>
                            @endif
                        </div>
                    @endforeach
                @else
                    <div class="text-center text-gray-500 py-4">
                        Tidak ada notifikasi terkait surat
                    </div>
                @endif
            </div>
        </div>

        <!-- Footer -->
        <div class="px-6 py-4 border-t bg-gray-50">
            <button id="closenotifmodal" class="w-full px-4 py-2 bg-blue-500 text-white hover:bg-blue-600 rounded-lg transition">
                Tutup
            </button>
        </div>
    </div>
</div>

<!-- Add this in the head section of staff/layout/header.blade.php -->
<!-- SweetAlert2 CDN -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener('DOMContentLoaded', () => {
    const tabs = document.querySelectorAll('.tab-btn');
    const contents = document.querySelectorAll('.tab-content');

    // Set default tab
    const defaultTab = document.querySelector('[data-tab="masuk"]');
    const defaultContent = document.getElementById('tab-masuk');
    if (defaultTab && defaultContent) {
        defaultTab.classList.add('text-black', 'border-b-2', 'border-blue-600');
        defaultContent.classList.remove('hidden');
    }

    tabs.forEach(tab => {
        tab.addEventListener('click', () => {
            // Remove active state
            tabs.forEach(t => t.classList.remove('text-black', 'border-b-2', 'border-blue-600'));
            contents.forEach(c => c.classList.add('hidden'));

            // Add active state
            tab.classList.add('text-black', 'border-b-2', 'border-blue-600');
            const target = tab.getAttribute('data-tab');
            document.getElementById(`tab-${target}`).classList.remove('hidden');
        });
    });
});
</script>

<script>
    // Notification Modal Logic
    document.addEventListener('DOMContentLoaded', () => {
        const notificationButton = document.getElementById('notificationButton');
        const notifmodal = document.getElementById('notifmodal');
        const closenotifmodal = document.getElementById('closenotifmodal');
        const markAllAsRead = document.getElementById('markAllAsRead');

        // Toggle Notification Modal
        if (notificationButton) {
            notificationButton.addEventListener('click', () => {
                notifmodal.classList.toggle('hidden');
            });
        }

        // Close Modal
        if (closenotifmodal) {
            closenotifmodal.addEventListener('click', () => {
                notifmodal.classList.add('hidden');
            });
        }

        // Close when clicking outside
        window.addEventListener('click', (e) => {
            if (e.target === notifmodal) {
                notifmodal.classList.add('hidden');
            }
        });

        // Handle mark all as read
        if (markAllAsRead) {
            markAllAsRead.addEventListener('click', () => {
                fetch('{{ route("notification.markAllRead") }}', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Update UI to reflect all notifications are read
                        document.querySelectorAll('.tab-content .border-b').forEach(el => {
                            el.remove();
                        });
                        
                        // Add "no notifications" message to each tab
                        document.querySelectorAll('.tab-content').forEach(tab => {
                            tab.innerHTML = `
                                <div class="text-center text-gray-500 py-4">
                                    Tidak ada notifikasi baru
                                </div>
                            `;
                        });
                        
                        // Update notification counter badge in main notification icon
                        const notifBadge = document.querySelector('#notificationButton .bg-red-500');
                        if (notifBadge) {
                            notifBadge.remove();
                        }

                        // Update tab counters - remove all counter badges in tabs
                        document.querySelectorAll('.tab-btn span').forEach(counter => {
                            counter.remove();
                        });

                        // Show success message
                        Swal.fire({
                            title: 'Berhasil!',
                            text: 'Semua notifikasi telah ditandai sebagai dibaca',
                            icon: 'success',
                            confirmButtonText: 'OK'
                        });
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    Swal.fire({
                        title: 'Error!',
                        text: 'Gagal menandai notifikasi sebagai dibaca',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                });
            });
        }
    });
</script>
<!-- Add this at the end of the staff header.blade.php file, after the existing script section -->
<script>
    // Make sure DOM is fully loaded before accessing elements
    document.addEventListener('DOMContentLoaded', function() {
        // Profile Edit Modal Elements
        const editProfileBtn = document.getElementById('editProfileBtn');
        const profileModal = document.getElementById('profileModal');
        const editProfileModal = document.getElementById('editProfileModal');
        const closeEditProfileModal = document.getElementById('closeEditProfileModal');
        const saveProfileBtn = document.getElementById('saveProfileBtn');
        const editProfileForm = document.getElementById('editProfileForm');
        
        // Show Edit Profile Modal
        if (editProfileBtn) {
            editProfileBtn.addEventListener('click', function(e) {
                e.preventDefault();
                console.log('Edit profile button clicked'); // Debugging
                if (profileModal) profileModal.classList.add('hidden'); // Hide the profile modal
                if (editProfileModal) editProfileModal.classList.remove('hidden'); // Show the edit profile modal
            });
        } else {
            console.error('Edit profile button not found in DOM');
        }
        
        // Close Edit Profile Modal
        if (closeEditProfileModal) {
            closeEditProfileModal.addEventListener('click', function() {
                editProfileModal.classList.add('hidden');
            });
        }
        
        // Close Edit Profile Modal when clicking outside
        window.addEventListener('click', function(e) {
            if (e.target === editProfileModal) {
                editProfileModal.classList.add('hidden');
            }
        });
        
        // Handle profile form submission
        if (saveProfileBtn) {
            saveProfileBtn.addEventListener('click', function(e) {
                e.preventDefault();
                
                // Show loading state
                saveProfileBtn.disabled = true;
                saveProfileBtn.innerHTML = 'Menyimpan...';
                
                // Get form data
                const formData = new FormData(editProfileForm);
                
                // Send AJAX request
                fetch(editProfileForm.action, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    // Reset button state
                    saveProfileBtn.disabled = false;
                    saveProfileBtn.innerHTML = 'Simpan';
                    
                    if (data.success) {
                        // Show success message
                        Swal.fire({
                            title: 'Berhasil!',
                            text: data.message,
                            icon: 'success',
                            confirmButtonText: 'OK'
                        }).then((result) => {
                            // Close the modal
                            editProfileModal.classList.add('hidden');
                            
                            // Reload the page to reflect updates
                            window.location.reload();
                        });
                    } else {
                        // Show error message
                        Swal.fire({
                            title: 'Gagal!',
                            text: data.message,
                            icon: 'error',
                            confirmButtonText: 'OK'
                        });
                        
                        // Display validation errors if any
                        if (data.errors) {
                            let errorMessage = '';
                            for (const field in data.errors) {
                                errorMessage += `${data.errors[field].join('\n')}\n`;
                            }
                            
                            if (errorMessage) {
                                Swal.fire({
                                    title: 'Validasi Gagal',
                                    text: errorMessage,
                                    icon: 'error',
                                    confirmButtonText: 'OK'
                                });
                            }
                        }
                    }
                })
                .catch(error => {
                    // Reset button state
                    saveProfileBtn.disabled = false;
                    saveProfileBtn.innerHTML = 'Simpan';
                    
                    // Show error message
                    Swal.fire({
                        title: 'Error!',
                        text: 'Terjadi kesalahan saat memproses permintaan',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                    console.error('Error:', error);
                });
            });
        }
    });
</script>
            <!-- Surat Notifications Tab -->
            <div id="tab-Data surat" class="tab-content hidden">
                @if(isset($suratNotifications) && $suratNotifications->count() > 0)
                    @foreach($suratNotifications as $notification)
                        <div class="border-b pb-2">
                            <p class="text-xs text-gray-500">{{ $notification->created_at->format('d M Y H:i A') }}</p>
                            @if($notification->tipe_peneliti === 'mahasiswa' && $notification->mahasiswa)
                                <p class="font-bold">{{ $notification->mahasiswa->no_pengajuan }}</p>
                            @elseif($notification->tipe_peneliti === 'non_mahasiswa' && $notification->nonMahasiswa)
                                <p class="font-bold">{{ $notification->nonMahasiswa->no_pengajuan }}</p>
                            @endif
                            <p>{{ $notification->pesan }}</p>
                            
                            @if($notification->penerbitan_surat_id)
                                <div class="mt-1">
                                    @php
                                        $penerbitanSurat = \App\Models\PenerbitanSurat::find($notification->penerbitan_surat_id);
                                    @endphp
                                    @if($penerbitanSurat)
                                        <span class="text-xs text-blue-600">
                                            Nomor Surat: {{ $penerbitanSurat->nomor_surat }}
                                        </span>
                                    @endif
                                </div>
                            @endif
                        </div>
                    @endforeach
                @else
                    <div class="text-center text-gray-500 py-4">
                        Tidak ada notifikasi terkait surat
                    </div>
                @endif
            </div>
