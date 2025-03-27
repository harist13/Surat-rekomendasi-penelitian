<!-- Sidebar -->
<div class="fixed left-0 top-0 h-full w-64 bg-white shadow-lg transition-transform duration-300 z-40" id="sidebar">
    <div class="p-4 pt-6">
        <!-- Organization logo and name -->
        <div class="flex items-center mb-8 pb-4 border-b border-gray-200">
            <img src="{{ asset('assets/kaltim.png') }}" alt="Logo Kesbangpol" class="h-8 w-8 mr-2" />
            <div class="text-lg">
                <div class="font-semibold text-black-700">SRIKOP</div>
            </div>
            <!-- Added sidebar toggle button on the right -->
            <button id="sidebar-toggle-close" class="ml-auto p-1 hover:bg-gray-100 rounded-lg">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                </svg>
            </button>
        </div>
        
        <h2 class="text-xl font-bold text-gray-800 mb-6">Staff Panel</h2>
        
        <nav>
            <ul class="space-y-2">
                <li>
                    <a href="{{ route('staff') }}" class="flex items-center p-3 text-gray-700 hover:bg-blue-50 rounded-lg transition">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                        </svg>
                        Dashboard
                    </a>
                </li>
                
                <li class="group relative">
                    <a href="" class="flex items-center justify-between p-3 text-gray-700 hover:bg-blue-50 rounded-lg transition">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                            </svg>
                            Data Pengajuan
                        </div>
                        <svg class="w-4 h-4 transform transition-transform duration-300 group-hover:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </a>
                    
                    <!-- Dropdown Menu -->
                    <ul class="hidden group-hover:block ml-4 pl-2 space-y-2">
                        <li>
                            <a href="{{ route('datapengajuanmahasiswa') }}" class="flex items-center p-3 text-gray-700 hover:bg-blue-50 rounded-lg transition">
                                <span class="ml-6">Mahasiswa</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('datapengajuannonmahasiswa') }}" class="flex items-center p-3 text-gray-700 hover:bg-blue-50 rounded-lg transition">
                                <span class="ml-6">Non Mahasiswa</span>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="group relative">
                    <a href="#" class="flex items-center justify-between p-3 text-gray-700 hover:bg-blue-50 rounded-lg transition">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                            </svg>
                            Data surat
                        </div>
                        <svg class="w-4 h-4 transform transition-transform duration-300 group-hover:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </a>
                    
                    <!-- Dropdown Menu -->
                    <ul class="hidden group-hover:block ml-4 pl-2 space-y-2">
                        <li>
                            <a href="{{ route('penerbitan') }}" class="flex items-center p-3 text-gray-700 hover:bg-blue-50 rounded-lg transition">
                                <span class="ml-6">Penerbitan surat</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('datasurat') }}" class="flex items-center p-3 text-gray-700 hover:bg-blue-50 rounded-lg transition">
                                <span class="ml-6">Data surat</span>
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </nav>
    </div>
</div>

<!-- Sidebar Toggle Button (visible when sidebar is closed) -->
<div id="sidebar-toggle-open" class="fixed left-0 top-4 p-2 bg-white rounded-lg shadow z-50 transition-opacity duration-300 opacity-0 hidden">
    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
    </svg>
</div>