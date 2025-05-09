 @include('Layout.App.Header')
    <div class="max-w-7xl mx-auto px-4 py-12 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h1 class="text-4xl font-bold text-gray-800 mb-4">Hubungi Kami</h1>
            <p class="text-gray-600 max-w-2xl mx-auto">Jika Anda membutuhkan informasi lebih lanjut, jangan ragu untuk menghubungi kami melalui form berikut atau informasi kontak dibawah ini.</p>
        </div>

        <!-- Grid Kontak dan Form -->
        <div class="grid md:grid-cols-2 gap-12">
            <!-- Informasi Kontak -->
            <div class="space-y-8">
                <!-- Card Alamat -->
                <div class="bg-white p-8 rounded-xl shadow-lg">
                    <div class="flex items-start gap-4 mb-6">
                        <div class="bg-[#004aad] p-3 rounded-lg">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-xl font-semibold mb-2">Kantor Gubernur Kalimantan Timur</h3>
                            <p class="text-gray-600">
                                Jl. Gajah Mada No.1, Samarinda Ulu<br>
                                Kota Samarinda, Kalimantan Timur<br>
                                75123
                            </p>
                        </div>
                    </div>

                    <!-- Google Maps Embed -->
                    <div class="aspect-w-16 aspect-h-9">
                        <iframe 
                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3989.6801464345756!2d117.14844431475333!3d-0.502599599686785!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2df67f95a6a1f0fd%3A0x9b10b8e25b61d3a8!2sKantor%20Gubernur%20Kalimantan%20Timur!5e0!3m2!1sid!2sid!4v1659422180896!5m2!1sid!2sid" 
                            class="w-full h-96 rounded-lg border-0" 
                            allowfullscreen="" 
                            loading="lazy">
                        </iframe>
                    </div>
                </div>

                <!-- Kontak Detail -->
                <div class="grid gap-6 sm:grid-cols-2">
                    <!-- Email -->
                    <div class="bg-white p-6 rounded-xl shadow-lg">
                        <div class="flex items-center gap-3">
                            <div class="bg-[#004aad] p-2 rounded-lg">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                </svg>
                            </div>
                            <div>
                                <h4 class="font-semibold">Email</h4>
                                <p class="text-gray-600">info@kaltimprov.go.id</p>
                            </div>
                        </div>
                    </div>

                    <!-- Telepon -->
                    <div class="bg-white p-6 rounded-xl shadow-lg">
                        <div class="flex items-center gap-3">
                            <div class="bg-[#004aad] p-2 rounded-lg">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                </svg>
                            </div>
                            <div>
                                <h4 class="font-semibold">Telepon</h4>
                                <p class="text-gray-600">+62 541 733 333</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Form Kontak -->
            <div class="bg-white p-8 rounded-xl shadow-lg h-fit sticky top-24">
                <form class="space-y-6">
                    <div>
                        <label class="block text-gray-700 mb-2">Nama Lengkap</label>
                        <input type="text" 
                            class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-[#004aad] focus:border-[#004aad] outline-none transition">
                    </div>

                    <div>
                        <label class="block text-gray-700 mb-2">Alamat Email</label>
                        <input type="email" 
                            class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-[#004aad] focus:border-[#004aad] outline-none transition">
                    </div>

                    <div>
                        <label class="block text-gray-700 mb-2">Subjek</label>
                        <input type="text" 
                            class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-[#004aad] focus:border-[#004aad] outline-none transition">
                    </div>

                    <div>
                        <label class="block text-gray-700 mb-2">Pesan</label>
                        <textarea 
                            rows="5"
                            class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-[#004aad] focus:border-[#004aad] outline-none transition"></textarea>
                    </div>

                    <button type="submit" 
                            class="w-full bg-[#004aad] text-white py-3 px-6 rounded-lg font-semibold hover:bg-blue-700 transition-colors">
                        Kirim Pesan
                    </button>
                </form>
            </div>
        </div>
    </div>
    @include('Layout.App.footer')