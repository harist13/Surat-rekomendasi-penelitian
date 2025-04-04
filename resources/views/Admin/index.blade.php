@include('Admin.Layout.App.Header')
<body class="bg-gradient-to-r from-green-100 to-blue-100">
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
            <div class="flex justify-between items-center mb-8">
                <h1 class="text-2xl font-bold text-gray-800">Admin Dashboard</h1>
                <div class="text-gray-600">
                    Selamat Datang Admin, <span class="font-semibold text-blue-600">{{ Auth::user()->username }}</span>
                </div>
            </div>

            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <!-- Total Users -->
                <div class="bg-white p-6 rounded-lg shadow-sm">
                    <h3 class="text-gray-500 text-sm mb-2">Total Users</h3>
                    <div class="flex justify-between items-center">
                        <span class="text-3xl font-bold text-gray-800">{{ $totalUsers }}</span>
                        <span class="text-green-500 text-sm bg-green-100 px-2 py-1 rounded-full">
                            Registered Users
                        </span>
                    </div>
                </div>

                <!-- Pending Requests -->
                <div class="bg-white p-6 rounded-lg shadow-sm">
                    <h3 class="text-gray-500 text-sm mb-2">Dokumen Diproses</h3>
                    <div class="flex justify-between items-center">
                        <span class="text-3xl font-bold text-gray-800">{{ $totalPending }}</span>
                        <span class="text-yellow-500 text-sm bg-yellow-100 px-2 py-1 rounded-full">
                            Menunggu Verifikasi
                        </span>
                    </div>
                </div>

                <!-- Dokumen Diterima -->
                <div class="bg-white p-6 rounded-lg shadow-sm">
                    <h3 class="text-gray-500 text-sm mb-2">Dokumen diterima</h3>
                    <div class="flex justify-between items-center">
                        <span class="text-3xl font-bold text-gray-800">{{ $approvedDocuments }}</span>
                        <span class="text-green-500 text-sm bg-green-100 px-2 py-1 rounded-full">
                            Diterbitkan
                        </span>
                    </div>
                </div>
            </div>

            <!-- Statistics Section -->
            <div class="bg-white p-6 rounded-lg shadow-sm">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-lg font-semibold text-gray-800">Statistik Data pengajuan</h2>
                    <span class="text-gray-500 text-sm">6 Bulan Terakhir</span>
                </div>
                
                <!-- Chart -->
                <div class="h-64">
                    <canvas id="statsChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Include Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    <script>
        // Data for the chart
        const months = @json($monthlyStats['months']);
        const userData = @json($monthlyStats['userStats']);
        const requestData = @json($monthlyStats['requestStats']);
        const documentData = @json($monthlyStats['documentStats']);
        
        // Create the chart
        const ctx = document.getElementById('statsChart').getContext('2d');
        const statsChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: months,
                datasets: [
                    {
                        label: 'User Baru',
                        data: userData,
                        backgroundColor: 'rgba(59, 130, 246, 0.5)', // Blue
                        borderColor: 'rgb(59, 130, 246)',
                        borderWidth: 1
                    },
                    {
                        label: 'Pengajuan',
                        data: requestData,
                        backgroundColor: 'rgba(245, 158, 11, 0.5)', // Yellow
                        borderColor: 'rgb(245, 158, 11)',
                        borderWidth: 1
                    },
                    {
                        label: 'Dokumen Diterbitkan',
                        data: documentData,
                        backgroundColor: 'rgba(16, 185, 129, 0.5)', // Green
                        borderColor: 'rgb(16, 185, 129)',
                        borderWidth: 1
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            precision: 0
                        }
                    }
                },
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    title: {
                        display: true,
                        text: 'Statistik Data Per Bulan'
                    }
                }
            }
        });

        // Toggle sidebar on mobile
        document.getElementById('menu-toggle').addEventListener('click', function() {
            document.querySelector('.sidebar').classList.toggle('-translate-x-full');
        });
    </script>
</body>
@include('Admin.Layout.App.Footer')