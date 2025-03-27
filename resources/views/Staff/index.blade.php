@include('Staff.Layout.App.Header')
<body class="bg-gradient-to-r from-green-100 to-blue-100">
    @include('Staff.Layout.App.Sidebar')
    
   

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
                <h1 class="text-2xl font-bold text-gray-800">Staff Dashboard</h1>
                <div class="text-gray-600">
                    Selamat Datang Staff, <span class="font-semibold text-blue-600">Harist</span>
                </div>
            </div>

            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <!-- Total Users -->
                <div class="bg-white p-6 rounded-lg shadow-sm">
                    <h3 class="text-gray-500 text-sm mb-2">Total Users</h3>
                    <div class="flex justify-between items-center">
                        <span class="text-3xl font-bold text-gray-800">200</span>
                        <span class="text-green-500 text-sm bg-green-100 px-2 py-1 rounded-full">
                            +10 users
                        </span>
                    </div>
                </div>

                <!-- Pending Requests -->
                <div class="bg-white p-6 rounded-lg shadow-sm">
                    <h3 class="text-gray-500 text-sm mb-2">Pending Requests</h3>
                    <div class="flex justify-between items-center">
                        <span class="text-3xl font-bold text-gray-800">5</span>
                        <span class="text-red-500 text-sm bg-red-100 px-2 py-1 rounded-full">
                            -2 request
                        </span>
                    </div>
                </div>

                <!-- Dokumen Diterima -->
                <div class="bg-white p-6 rounded-lg shadow-sm">
                    <h3 class="text-gray-500 text-sm mb-2">Dokumen diterima</h3>
                    <div class="flex justify-between items-center">
                        <span class="text-3xl font-bold text-gray-800">50</span>
                        <span class="text-green-500 text-sm bg-green-100 px-2 py-1 rounded-full">
                            +5 document
                        </span>
                    </div>
                </div>
            </div>

            <!-- Statistics Section -->
            <div class="bg-white p-6 rounded-lg shadow-sm">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-lg font-semibold text-gray-800">Statistik Data pengajuan</h2>
                    <span class="text-gray-500 text-sm">Time</span>
                </div>
                
                <!-- Chart Placeholder -->
                <div class="h-64 bg-gray-50 rounded-lg flex items-center justify-center">
                    <p class="text-gray-400">Chart akan ditampilkan di sini</p>
                </div>
            </div>
        </div>
    </div>

</body>
@include('Staff.Layout.App.Footer')

