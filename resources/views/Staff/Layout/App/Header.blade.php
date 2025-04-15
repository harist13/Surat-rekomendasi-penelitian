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
                    <a href="#" class="flex items-center p-2 hover:bg-gray-100 rounded-lg transition">
                        <svg class="w-5 h-5 mr-3 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        <span>Edit Profile</span>
                    </a>
                    <a href="#" class="flex items-center p-2 hover:bg-gray-100 rounded-lg transition">
                        <svg class="w-5 h-5 mr-3 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                        <span>Pengaturan</span>
                    </a>
                    <hr class="my-2">
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

</header>

