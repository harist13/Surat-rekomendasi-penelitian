@include('Admin.Layout.App.Header')
<body class="bg-gradient-to-r from-green-100 to-blue-100">
    @include('Admin.Layout.App.Sidebar')
    
    <!-- Chart.js CDN -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
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
                <h1 class="text-2xl font-bold text-gray-800">Kelola Data Responden</h1>
                <a href="{{ route('admin.dataresponden.export-pdf') }}" class="flex items-center text-white bg-red-600 hover:bg-red-700 px-4 py-2 rounded-lg text-sm">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    Export PDF
                </a>
            </div>

            <!-- Alert Message -->
            @if(session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4 rounded">
                <p>{{ session('success') }}</p>
            </div>
            @endif

            @if(session('error'))
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4 rounded">
                <p>{{ session('error') }}</p>
            </div>
            @endif
            
            <!-- Statistic Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <!-- Pie Chart Card -->
                <div class="bg-white p-6 rounded-lg shadow-sm">
                    <h2 class="text-lg font-semibold mb-4">Distribusi Rating</h2>
                    <div class="h-64">
                        <canvas id="ratingPieChart"></canvas>
                    </div>
                </div>
                
                <!-- Total Responden Card -->
                <div class="bg-white p-6 rounded-lg shadow-sm">
                    <h2 class="text-lg font-semibold mb-4">Statistik Responden</h2>
                    <div class="grid grid-cols-2 gap-4">
                        <div class="bg-blue-50 p-4 rounded-lg">
                            <p class="text-gray-600 text-sm">Total Responden</p>
                            <p class="text-3xl font-bold text-blue-600">{{ $uniqueEmails }}</p>
                        </div>
                        <div class="bg-green-50 p-4 rounded-lg">
                            <p class="text-gray-600 text-sm">Rating Terendah</p>
                            <p class="text-3xl font-bold text-green-600" id="lowestRating">-</p>
                        </div>
                        <div class="bg-purple-50 p-4 rounded-lg">
                            <p class="text-gray-600 text-sm">Rating Tertinggi</p>
                            <p class="text-3xl font-bold text-purple-600" id="highestRating">-</p>
                        </div>
                        <div class="bg-yellow-50 p-4 rounded-lg">
                            <p class="text-gray-600 text-sm">Rata-rata Rating</p>
                            <p class="text-3xl font-bold text-yellow-600" id="averageRating">-</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Data Panel -->
            <div class="bg-white p-6 rounded-lg shadow-sm mb-8">
                <div class="flex justify-between items-center mb-6">
                    <div class="flex items-center space-x-4">
                        <!-- Search Form -->
                        <form action="{{ route('admin.dataresponden') }}" method="GET" class="relative">
                            <div class="absolute inset-y-0 left-0 flex items-center pl-3">
                                <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                </svg>
                            </div>
                            <input type="text" name="search" class="pl-10 pr-4 py-2 border rounded-lg w-64" placeholder="Cari responden..." value="{{ request('search') }}">
                            <button type="submit" class="absolute inset-y-0 right-0 flex items-center px-4 text-sm font-medium text-white bg-blue-600 rounded-r-lg hover:bg-blue-700">
                                Cari
                            </button>
                        </form>

                        <!-- Filter -->
                        <select id="filter-layanan" class="bg-gray-50 border rounded-lg px-4 py-2">
                            <option value="">Semua Layanan</option>
                            <option value="mahasiswa" {{ request('jenis_layanan') == 'Mahasiswa' ? 'selected' : '' }}>Mahasiswa</option>
                            <option value="non-mahasiswa" {{ request('jenis_layanan') == 'Non-Mahasiswa' ? 'selected' : '' }}>Non-Mahasiswa</option>
                        </select>
                    </div>

                    <!-- Export Button -->
                    <button id="export-btn" class="flex items-center text-white bg-green-600 hover:bg-green-700 px-4 py-2 rounded-lg">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                        </svg>
                        Export Excel
                    </button>
                </div>

                <!-- Table -->
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left">
                        <thead class="text-white bg-[#004aad]">
                            <tr>
                                <th class="px-4 py-3">No</th>
                                <th class="px-4 py-3">Nama</th>
                                <th class="px-4 py-3">Email</th>
                                <th class="px-4 py-3">No HP</th>
                                <th class="px-4 py-3">Jenis Kelamin</th>
                                <th class="px-4 py-3">Usia</th>
                                <th class="px-4 py-3">Layanan</th>
                                <th class="px-4 py-3">Tanggal</th>
                                <th class="px-4 py-3">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $groupedResponses = $responses->groupBy('email');
                                $count = ($responses->currentPage() - 1) * $responses->perPage();
                            @endphp
                            
                            @foreach($groupedResponses as $email => $userResponses)
                                @php
                                    // Get the first response for this user to display personal info
                                    $firstResponse = $userResponses->first();
                                    $count++;
                                @endphp
                                <tr class="bg-white border-b hover:bg-gray-50" data-user-email="{{ $email }}">
                                    <td class="px-4 py-3">{{ $count }}</td>
                                    <td class="px-4 py-3">{{ $firstResponse->nama }}</td>
                                    <td class="px-4 py-3">{{ $email }}</td>
                                    <td class="px-4 py-3">{{ $firstResponse->no_hp }}</td>
                                    <td class="px-4 py-3">{{ $firstResponse->jenis_kelamin }}</td>
                                    <td class="px-4 py-3">{{ $firstResponse->usia }}</td>
                                    <td class="px-4 py-3">{{ $firstResponse->jenis_layanan }}</td>
                                    <td class="px-4 py-3">{{ $firstResponse->created_at->format('d/m/Y') }}</td>
                                    <td class="px-4 py-3 flex space-x-3">
                                        <button class="text-blue-500 hover:text-blue-700 view-detail" data-responses="{{ json_encode($userResponses) }}">
                                            <!-- View Icon -->
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                            </svg>
                                        </button>
                                        <button class="text-red-500 hover:text-red-700 delete-responses" data-email="{{ $email }}">
                                            <!-- Delete Icon -->
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                            </svg>
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                            
                            @if($groupedResponses->count() == 0)
                                <tr class="bg-white border-b">
                                    <td colspan="9" class="px-4 py-3 text-center text-gray-500">Tidak ada data responden yang ditemukan</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>

                <!-- Pagination Info -->
                <div class="flex justify-between items-center mt-6">
                    <div class="text-sm text-gray-600">
                        Menampilkan {{ $groupedResponses->keys()->first() ? ($responses->firstItem() ?? 0) : 0 }} - {{ $groupedResponses->count() + ($responses->currentPage() - 1) * $responses->perPage() }} dari {{ $uniqueEmails }} responden
                    </div>
                    <div>
                        {{ $responses->appends(['search' => request('search'), 'per_page' => request('per_page')])->links('vendor.pagination.tailwind') }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Detail Modal -->
    <div id="detail-modal" class="fixed inset-0 bg-black bg-opacity-50 hidden flex items-center justify-center p-4 z-50">
        <div class="bg-white rounded-lg w-full max-w-4xl p-6 max-h-[90vh] overflow-y-auto">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-xl font-semibold">Detail Responden</h3>
                <button onclick="hideDetailModal()" class="text-gray-500 hover:text-gray-700">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                <div class="space-y-2">
                    <p><span class="font-semibold">Nama:</span> <span id="detail-nama">-</span></p>
                    <p><span class="font-semibold">Email:</span> <span id="detail-email">-</span></p>
                    <p><span class="font-semibold">No HP:</span> <span id="detail-nohp">-</span></p>
                </div>
                <div class="space-y-2">
                    <p><span class="font-semibold">Jenis Kelamin:</span> <span id="detail-jk">-</span></p>
                    <p><span class="font-semibold">Usia:</span> <span id="detail-usia">-</span></p>
                    <p><span class="font-semibold">Jenis Layanan:</span> <span id="detail-layanan">-</span></p>
                </div>
            </div>
            
            <div class="border-t pt-4">
                <h4 class="font-semibold text-lg mb-4">Jawaban Survei:</h4>
                <div id="detail-answers" class="divide-y"></div>
            </div>
            
            <div class="mt-6 border-t pt-4">
                <h4 class="font-semibold mb-2">Kritik & Saran:</h4>
                <p id="detail-komentar" class="text-gray-600">-</p>
            </div>
            
            <div class="mt-6 flex justify-end">
                <button onclick="hideDetailModal()" class="px-4 py-2 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300">
                    Tutup
                </button>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div id="delete-modal" class="fixed inset-0 bg-black bg-opacity-50 hidden flex items-center justify-center p-4 z-50">
        <div class="bg-white rounded-lg w-full max-w-md p-6">
            <h3 class="text-lg font-semibold mb-4">Konfirmasi Hapus</h3>
            <p class="mb-6">Apakah Anda yakin ingin menghapus semua data survei dari responden ini? Tindakan ini tidak dapat dibatalkan.</p>
            <div class="flex justify-end space-x-2">
                <button onclick="hideDeleteModal()" class="px-4 py-2 border rounded-lg hover:bg-gray-50">
                    Batal
                </button>
                <form id="delete-responses-form" method="POST">
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
            document.querySelectorAll('.bg-green-100, .bg-red-100').forEach(function(alert) {
                alert.style.display = 'none';
            });
        }, 5000);
        
        // Calculate rating statistics from all responses
        function calculateRatingStats() {
            // Collect all responses
            const allResponses = [];
            document.querySelectorAll('.view-detail').forEach(button => {
                try {
                    const responses = JSON.parse(button.getAttribute('data-responses'));
                    if (Array.isArray(responses)) {
                        responses.forEach(response => {
                            if (response.rating) {
                                allResponses.push(response);
                            }
                        });
                    }
                } catch (e) {
                    console.error("Error parsing responses data:", e);
                }
            });
            
            // Count ratings
            const ratingCounts = {
                1: 0,
                2: 0,
                3: 0,
                4: 0,
                5: 0
            };
            
            // Calculate totals and counts
            let totalRating = 0;
            let totalResponses = 0;
            let highestRating = 0;
            let lowestRating = 6; // Start higher than any possible rating
            
            allResponses.forEach(response => {
                const rating = parseInt(response.rating);
                if (rating >= 1 && rating <= 5) {
                    ratingCounts[rating]++;
                    totalRating += rating;
                    totalResponses++;
                    
                    // Update highest and lowest ratings
                    if (rating > highestRating) {
                        highestRating = rating;
                    }
                    if (rating < lowestRating) {
                        lowestRating = rating;
                    }
                }
            });
            
            // If no responses, reset lowestRating
            if (totalResponses === 0) {
                lowestRating = 0;
            }
            
            // Calculate average
            const averageRating = totalResponses > 0 ? (totalRating / totalResponses).toFixed(1) : '-';
            
            // Update stats in the UI
            document.getElementById('highestRating').textContent = highestRating || '-';
            document.getElementById('lowestRating').textContent = lowestRating === 6 ? '-' : lowestRating;
            document.getElementById('averageRating').textContent = averageRating;
            
            return {
                counts: ratingCounts,
                highest: highestRating,
                lowest: lowestRating === 6 ? 0 : lowestRating,
                average: averageRating,
                total: totalResponses
            };
        }
        
        // Create the pie chart
        function createRatingChart(stats) {
            const ctx = document.getElementById('ratingPieChart').getContext('2d');
            
            // Define custom colors for each rating
            const colors = [
                '#FF6384', // Rating 1 - Red
                '#FFCE56', // Rating 2 - Yellow
                '#36A2EB', // Rating 3 - Blue
                '#4BC0C0', // Rating 4 - Teal
                '#9966FF'  // Rating 5 - Purple
            ];
            
            // Create chart data
            const data = {
                labels: ['1 - Sangat Tidak Setuju', '2 - Tidak Setuju', '3 - Kurang Setuju', '4 - Setuju', '5 - Sangat Setuju'],
                datasets: [{
                    data: [
                        stats.counts[1], 
                        stats.counts[2], 
                        stats.counts[3], 
                        stats.counts[4], 
                        stats.counts[5]
                    ],
                    backgroundColor: colors,
                    hoverBackgroundColor: colors,
                    borderWidth: 1
                }]
            };
            
            // Create chart options
            const options = {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'right',
                        labels: {
                            boxWidth: 15,
                            padding: 15
                        }
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                const label = context.label || '';
                                const value = context.raw || 0;
                                const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                const percentage = total > 0 ? Math.round((value / total) * 100) : 0;
                                return `${label}: ${value} (${percentage}%)`;
                            }
                        }
                    }
                }
            };
            
            // Create the chart
            new Chart(ctx, {
                type: 'pie',
                data: data,
                options: options
            });
        }
        
        // Show Detail Modal
        function showDetailModal(responses) {
            if (!responses || responses.length === 0) {
                return;
            }
            
            // Get first response for profile details
            const firstResponse = responses[0];
            
            // Fill profile details
            document.getElementById('detail-nama').textContent = firstResponse.nama || '-';
            document.getElementById('detail-email').textContent = firstResponse.email || '-';
            document.getElementById('detail-nohp').textContent = firstResponse.no_hp || '-';
            document.getElementById('detail-jk').textContent = firstResponse.jenis_kelamin || '-';
            document.getElementById('detail-usia').textContent = firstResponse.usia || '-';
            document.getElementById('detail-layanan').textContent = firstResponse.jenis_layanan || '-';
            document.getElementById('detail-komentar').textContent = firstResponse.kritik_saran || 'Tidak ada kritik atau saran';
            
            // Fill answers
            const answersContainer = document.getElementById('detail-answers');
            answersContainer.innerHTML = '';
            
            responses.forEach((response, index) => {
                if (!response.question) return;
                
                const answerDiv = document.createElement('div');
                answerDiv.className = 'py-3';
                
                // Array dari label untuk setiap rating
                const ratingLabels = [
                    'Sangat Tidak Setuju',
                    'Tidak Setuju',
                    'Kurang Setuju',
                    'Setuju',
                    'Sangat Setuju'
                ];
                
                // Buat heading pertanyaan
                let innerHtml = `<p class="font-medium mb-3">${index + 1}. ${response.question.pertanyaan}</p>`;
                
                // Tambahkan container responsif
                innerHtml += `<div class="flex flex-col sm:grid sm:grid-cols-5 gap-1 mt-2">`;
                
                // Buat radio buttons untuk setiap rating 1-5
                for (let i = 1; i <= 5; i++) {
                    const isChecked = parseInt(response.rating) === i;
                    const bgColor = isChecked ? 'bg-blue-100' : '';
                    const textColor = isChecked ? 'text-blue-700' : 'text-gray-600';
                    
                    innerHtml += `
                        <div class="flex sm:flex-col items-center justify-between sm:justify-center ${bgColor} p-2 rounded mb-1 sm:mb-0">
                            <div class="flex items-center">
                                <input type="radio" 
                                    id="rating-${index}-${i}" 
                                    name="rating-${index}" 
                                    value="${i}" 
                                    ${isChecked ? 'checked' : ''} 
                                    disabled 
                                    class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500">
                                <label for="rating-${index}-${i}" class="ml-1 text-sm font-medium ${isChecked ? 'text-blue-700' : 'text-gray-700'}">${i}</label>
                            </div>
                            <label class="text-xs sm:text-sm ${textColor}">${ratingLabels[i-1]}</label>
                        </div>
                    `;
                }
                
                innerHtml += `</div>`;
                answerDiv.innerHTML = innerHtml;
                answersContainer.appendChild(answerDiv);
            });
            
            // Show modal
            document.getElementById('detail-modal').classList.remove('hidden');
            document.body.classList.add('overflow-hidden');
        }

        // Hide Detail Modal
        function hideDetailModal() {
            document.getElementById('detail-modal').classList.add('hidden');
            document.body.classList.remove('overflow-hidden');
        }
        
        // Show Delete Modal
        function showDeleteModal(email) {
            document.getElementById('delete-responses-form').action = `/admin/dataresponden/${encodeURIComponent(email)}`;
            document.getElementById('delete-modal').classList.remove('hidden');
            document.body.classList.add('overflow-hidden');
        }
        
        // Hide Delete Modal
        function hideDeleteModal() {
            document.getElementById('delete-modal').classList.add('hidden');
            document.body.classList.remove('overflow-hidden');
        }

        document.addEventListener('DOMContentLoaded', function() {
            // Initialize charts and statistics
            const stats = calculateRatingStats();
            createRatingChart(stats);
            
            // View detail buttons
            document.querySelectorAll('.view-detail').forEach(button => {
                button.addEventListener('click', function() {
                    try {
                        const responses = JSON.parse(this.getAttribute('data-responses'));
                        showDetailModal(responses);
                    } catch (e) {
                        console.error("Error parsing responses data:", e);
                    }
                });
            });
            
            // Delete buttons
            document.querySelectorAll('.delete-responses').forEach(button => {
                button.addEventListener('click', function() {
                    const email = this.getAttribute('data-email');
                    showDeleteModal(email);
                });
            });

            // Filter by layanan
            document.getElementById('filter-layanan').addEventListener('change', function () {
                const filterValue = this.value.toLowerCase();
                const rows = document.querySelectorAll('tbody tr');

                rows.forEach(row => {
                    if (!row.dataset.userEmail) return; // Skip rows without data attribute
                    
                    const layanan = row.querySelector('td:nth-child(7)').textContent.toLowerCase();
                    row.style.display = filterValue === '' || layanan.includes(filterValue)
                        ? ''
                        : 'none';
                });
            });

            // Export button
            document.querySelector('#export-btn').addEventListener('click', () => {
                window.location.href = "{{ route('admin.dataresponden.export') }}";
            });
        });
    </script>

</body>
@include('Admin.Layout.App.Footer')