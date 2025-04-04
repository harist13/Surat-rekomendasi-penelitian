<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - SIRPENA KALTIM</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Heroicons -->
    <script src="https://unpkg.com/@heroicons/v2.0.18/24/outline/index.js"></script>
</head>
<body class="bg-gradient-to-r from-blue-100 to-indigo-100 min-h-screen flex items-center">
    <div class="max-w-md w-full mx-auto p-6">
        <div class="bg-white rounded-xl shadow-2xl p-8">
            <!-- Logo -->
            <div class="text-center mb-8">
                <img src="{{ asset('assets/kaltim.png')}}" alt="Logo" class="h-20 w-20 mx-auto mb-4">
                <h2 class="text-3xl font-bold text-[#004aad]">SIRPENA KALTIM</h2>
                <p class="text-gray-600 mt-2">Silakan masuk ke akun Anda</p>
            </div>

            <!-- Form Login -->
            <form class="space-y-6" method="POST" action="{{ route('login.authenticate') }}">
                @csrf
                
                @if($errors->has('login'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                    {{ $errors->first('login') }}
                </div>
                @endif
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Username</label>
                    <div class="relative">
                        <input type="text" 
                               name="username"
                               class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-[#004aad] focus:border-[#004aad] transition"
                               placeholder="Masukkan username"
                               value="{{ old('username') }}">
                        <svg class="w-5 h-5 absolute right-3 top-3.5 text-gray-400" 
                             fill="none" 
                             stroke="currentColor" 
                             viewBox="0 0 24 24">
                            <path stroke-linecap="round" 
                                  stroke-linejoin="round" 
                                  stroke-width="2" 
                                  d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Password</label>
                    <div class="relative">
                        <input type="password" 
                               id="password"
                               name="password"
                               class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-[#004aad] focus:border-[#004aad] transition"
                               placeholder="Masukkan password">
                        <button type="button" 
                                onclick="togglePassword()"
                                class="absolute right-3 top-3.5 text-gray-400 hover:text-[#004aad]">
                            <svg id="eye-icon" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" 
                                      stroke-linejoin="round" 
                                      stroke-width="2" 
                                      d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                <path stroke-linecap="round" 
                                      stroke-linejoin="round" 
                                      stroke-width="2" 
                                      d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                            </svg>
                        </button>
                    </div>
                </div>

               
                <button type="submit" 
                        class="w-full bg-[#004aad] text-white py-3 rounded-lg hover:bg-[#003b8a] transition flex items-center justify-center font-semibold">
                    MASUK
                </button>

               

                <p class="text-center text-sm text-gray-600 mt-6">
                    <a href="{{ route('home')}}" class="text-[#004aad] hover:underline font-medium">Kembali</a>
                </p>
            </form>
        </div>
    </div>

    <script>
        function togglePassword() {
            const passwordField = document.getElementById('password');
            const eyeIcon = document.getElementById('eye-icon');
            
            if (passwordField.type === 'password') {
                passwordField.type = 'text';
                eyeIcon.innerHTML = `
                    <path stroke-linecap="round" 
                          stroke-linejoin="round" 
                          stroke-width="2" 
                          d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-7a9 9 0 11-18 0 9 9 0 0118 0z"/>
                `;
            } else {
                passwordField.type = 'password';
                eyeIcon.innerHTML = `
                    <path stroke-linecap="round" 
                          stroke-linejoin="round" 
                          stroke-width="2" 
                          d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                    <path stroke-linecap="round" 
                          stroke-linejoin="round" 
                          stroke-width="2" 
                          d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                `;
            }
        }
    </script>
</body>
</html>