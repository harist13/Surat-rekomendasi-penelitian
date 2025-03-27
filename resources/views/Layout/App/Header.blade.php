<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulir Penelitian - PTSP MAN IC Lombok Timur</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Heroicons -->
    <script src="https://unpkg.com/@heroicons/v2.0.18/24/outline/index.js"></script>
</head>
<style>
    /* Smooth transition for mobile menu */
#mobile-menu {
    transition: all 0.3s ease-out;
}

/* Mobile dropdown animation */
.mobile-dropdown-content {
    max-height: 0;
    overflow: hidden;
    transition: max-height 0.3s ease-out;
}
</style>
    <header class="bg-[#004aad] text-white shadow-md sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex justify-between items-center h-16">
                <div class="flex items-center space-x-2">
                    <img src="{{ asset('assets/kaltim.png')}}" alt="Logo" class="h-10 w-9">
                    <span class="text-xl font-bold">PERIKOMNAS KALTIM</span>
                </div>
                <div class="hidden md:flex space-x-6">
                    <a href="{{ route('home') }}" class="hover:text-blue-200 transition">BERANDA</a>
                    <a href="{{ route('tentang') }}" class="hover:text-blue-200 transition">TENTANG KAMI</a>
                    <!-- Dropdown Layanan -->
                <div class="relative" id="dropdown-container">
                    <button id="dropdown-button" class="hover:text-blue-200 transition flex items-center">
                        LAYANAN
                        <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>

                    <div id="dropdown-menu" class="absolute hidden bg-white shadow-lg rounded-md mt-2 min-w-[200px]">
                        <div class="py-2">
                            <a href="{{ route('pengajuanmahasiswa') }}" class="block px-4 py-2 text-gray-800 hover:bg-blue-50">
                                Mahasiswa
                            </a>
                            <a href="{{ route('pengajuannonmahasiswa') }}" class="block px-4 py-2 text-gray-800 hover:bg-blue-50">
                                Non-Mahasiswa
                            </a>
                        </div>
                    </div>
                </div>
                    <a href="{{ route('kontak') }}" class="hover:text-blue-200 transition">KONTAK</a>
                    <a href="{{ route('login') }}" class="hover:text-blue-200 transition">LOGIN</a>

                </div>
                <!-- Mobile Menu Button -->
                <button id="mobile-menu-button" class="md:hidden p-2">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
            </div>
        </div>

        <!-- Mobile Menu -->
        <div id="mobile-menu" class="hidden md:hidden absolute w-full bg-[#004aad] px-4 pb-4">
            <div class="flex flex-col space-y-4">
                <a href="{{ route('home') }}" class="hover:text-blue-200">HOME</a>
                <a href="{{ route('tentang') }}" class="hover:text-blue-200">TENTANG KAMI</a>
                
                <!-- Dropdown Layanan Mobile -->
                <div class="flex flex-col">
                    <div class="flex items-center justify-between hover:text-blue-200">
                        <span>LAYANAN</span>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </div>
                    <div class="ml-4 mt-2 space-y-2">
                        <a href="{{ route('pengajuanmahasiswa') }}" class="block hover:text-blue-200">Mahasiswa</a>
                        <a href="{{ route('pengajuannonmahasiswa') }}" class="block hover:text-blue-200">Non-Mahasiswa</a>
                    </div>
                </div>

                <a href="{{ route('kontak') }}" class="hover:text-blue-200">KONTAK</a>
                <a href="{{ route('login') }}" class="hover:text-blue-200">LOGIN</a>
            </div>
        </div>
    </header>