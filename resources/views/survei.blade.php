<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Survei Kepuasan Pengguna - Kesbangpol Kaltim</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Heroicons -->
    <script src="https://unpkg.com/@heroicons/v2.0.18/24/outline/index.js"></script>
</head>
<body class="bg-gray-50">
    <!-- Header -->
    @include('Layout.App.Header')

    <!-- Main Content -->
    <div class="max-w-4xl mx-auto px-4 py-8">
        <!-- Breadcrumbs -->
        <div class="text-sm text-gray-600 mb-8 flex items-center space-x-2">
            <a href="{{ route('home') }}" class="text-blue-600 hover:underline">Beranda</a>
            <span class="text-gray-400">/</span>
            <span class="text-gray-500">Survei Kepuasan Pengguna</span>
        </div>
        
        <!-- Alert Messages -->
        @if(session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4 rounded" role="alert">
            <p class="font-medium">{{ session('success') }}</p>
        </div>
        @endif

        @if(session('error'))
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4 rounded" role="alert">
            <p class="font-medium">{{ session('error') }}</p>
        </div>
        @endif

        @if($errors->any())
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4 rounded" role="alert">
            <p class="font-medium">Ada kesalahan pada form:</p>
            <ul class="mt-2 list-disc list-inside">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <!-- Survey Card -->
        <div class="bg-white rounded-xl shadow-lg overflow-hidden p-8 mb-8">
            <div class="text-center mb-10">
                <h1 class="text-3xl font-bold text-[#004aad] mb-4">Survei Kepuasan Layanan</h1>
                <p class="text-gray-600">Bantu kami meningkatkan kualitas layanan dengan mengisi survei ini</p>
            </div>

            <form class="space-y-8" action="{{ route('survei.submit') }}" method="POST">
                @csrf
                <!-- Informasi Pengguna -->
                <div class="space-y-6">
                    <h3 class="text-xl font-semibold text-[#004aad] border-b-2 border-blue-100 pb-2">
                        <span class="bg-[#004aad] text-white px-4 py-1 rounded-t">1</span>
                        Data Responden
                    </h3>
                    
                    <div class="grid gap-6 md:grid-cols-2">
                        <!-- Kolom Kiri -->
                        <div class="space-y-6">
                            <div>
                                <label class="block text-gray-700 mb-2">Nama Lengkap<span class="text-red-500">*</span></label>
                                <input type="text" name="nama" value="{{ old('nama') }}"
                                    class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" 
                                    required>
                            </div>
                            
                            <div>
                                <label class="block text-gray-700 mb-2">Email<span class="text-red-500">*</span></label>
                                <input type="email" name="email" value="{{ old('email') }}"
                                    class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" 
                                    required>
                            </div>
                            
                            <div>
                                <label class="block text-gray-700 mb-2">Jenis Kelamin<span class="text-red-500">*</span></label>
                                <div class="flex space-x-6 mt-2">
                                    <label class="flex items-center">
                                        <input type="radio" name="jenis_kelamin" value="Laki-laki" class="h-4 w-4 text-blue-600" {{ old('jenis_kelamin') == 'Laki-laki' ? 'checked' : '' }} required>
                                        <span class="ml-2">Laki-laki</span>
                                    </label>
                                    <label class="flex items-center">
                                        <input type="radio" name="jenis_kelamin" value="Perempuan" class="h-4 w-4 text-blue-600" {{ old('jenis_kelamin') == 'Perempuan' ? 'checked' : '' }}>
                                        <span class="ml-2">Perempuan</span>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <!-- Kolom Kanan -->
                        <div class="space-y-6">
                            <div>
                                <label class="block text-gray-700 mb-2">No. HP/WhatsApp<span class="text-red-500">*</span></label>
                                <input type="text" name="no_hp" value="{{ old('no_hp') }}"
                                    class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                
                                    required>
                            </div>
                            
                            <div>
                                <label class="block text-gray-700 mb-2">Usia<span class="text-red-500">*</span></label>
                                <input type="text" name="usia" value="{{ old('usia') }}"
             
                                    class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                    required>
                            </div>
                            
                            <div>
                                <label class="block text-gray-700 mb-2">Jenis Layanan<span class="text-red-500">*</span></label>
                                <select name="jenis_layanan" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" required>
                                    <option value="">Pilih Jenis Layanan</option>
                                    <option value="Mahasiswa" {{ old('jenis_layanan') == 'Mahasiswa' ? 'selected' : '' }}>Mahasiswa</option>
                                    <option value="Non-Mahasiswa" {{ old('jenis_layanan') == 'Non-Mahasiswa' ? 'selected' : '' }}>Non-Mahasiswa</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                

                <!-- Penilaian Layanan -->
                <div class="space-y-6">
                    <h3 class="text-xl font-semibold text-[#004aad] border-b-2 border-blue-100 pb-2">
                        <span class="bg-[#004aad] text-white px-4 py-1 rounded-t">2</span>
                        Penilaian Layanan
                    </h3>

                    <!-- Skala Penilaian -->
                    <div class="bg-blue-50 p-4 rounded-lg mb-6">
                        <div class="flex justify-between text-sm font-medium text-[#004aad]">
                            <span>1. Sangat Tidak Setuju</span>
                            <span>2. Tidak Setuju</span>
                            <span>3. Kurang Setuju</span>
                            <span>4. Setuju</span>
                            <span>5. Sangat Setuju</span>
                        </div>
                    </div>

                    @if(isset($surveiQuestions) && $surveiQuestions->count() > 0)
                        @foreach($surveiQuestions as $index => $question)
                            @if($question->is_active)
                            <!-- Question {{ $index + 1 }} -->
                            <div class="space-y-4">
                                <label class="block text-gray-700">{{ $index + 1 }}. {{ $question->pertanyaan }}</label>
                                <div class="flex justify-between space-x-4">
                                    @for($i = 1; $i <= 5; $i++)
                                    <label class="flex flex-col items-center">
                                        <input type="radio" name="question_{{ $question->id }}" value="{{ $i }}" class="mt-1" {{ old('question_'.$question->id) == $i ? 'checked' : '' }} {{ $i == 1 ? 'required' : '' }}>
                                        <span class="text-sm text-gray-600 mt-1">{{ $i }}</span>
                                    </label>
                                    @endfor
                                </div>
                            </div>
                            @endif
                        @endforeach
                    @else
                        <div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4 mb-4" role="alert">
                            <p>Belum ada pertanyaan survei yang tersedia.</p>
                        </div>
                    @endif
                </div>

                <!-- Komentar -->
                <div class="space-y-6">
                    <h3 class="text-xl font-semibold text-[#004aad] border-b-2 border-blue-100 pb-2">
                        <span class="bg-[#004aad] text-white px-4 py-1 rounded-t">3</span>
                        Kritik & Saran
                    </h3>
                    <div>
                        <label class="block text-gray-700 mb-2">Komentar/Kritik/Saran</label>
                        <textarea 
                            name="kritik_saran"
                            rows="4"
                            class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                            placeholder="Tuliskan saran atau kritik Anda untuk perbaikan layanan kami">{{ old('kritik_saran') }}</textarea>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="text-center pt-8">
                    <button 
                        type="submit"
                        class="bg-[#004aad] text-white px-12 py-3 rounded-lg font-semibold hover:bg-blue-600 transition transform hover:scale-105"
                    >
                        Kirim Survei
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Footer -->
    @include('Layout.App.Footer')
    
    <script>
        // Auto-hide alerts after 8 seconds
        setTimeout(function() {
            document.querySelectorAll('[role="alert"]').forEach(function(alert) {
                alert.style.display = 'none';
            });
        }, 8000);
    </script>
</body>
</html>