<!-- Footer -->
    <footer class="bg-gray-800 text-white py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid md:grid-cols-4 gap-8">
                <div>
                    <h3 class="text-xl font-bold mb-4">Kontak Kami</h3>
                    <p class="mb-2">Jl. Gajah Mada No.2, RW.01, Jawa, Kec. Samarinda Ulu, Kota Samarinda, Kalimantan Timur 75242</p>
                    <p class="mb-2">Kalimantan Timur</p>
                    <p class="mb-2">Email: info@SIRPENA-kaltim.sch.id</p>
                    <p>Telp: 0541-733333</p>
                </div>
                
                <div>
                    <h3 class="text-xl font-bold mb-4">Tautan Cepat</h3>
                    <ul class="space-y-2">
                        <li><a href="{{ route('tentang') }}" class="hover:text-blue-200 transition">Tentang Kami</a></li>
                        <li><a href="{{ route('layanan') }}" class="hover:text-blue-200 transition">Layanan</a></li>
                    </ul>
                </div>

                <div>
                    <h3 class="text-xl font-bold mb-4">Layanan</h3>
                    <ul class="space-y-2">
                        <li><a href="{{ route('pengajuanmahasiswa') }}" class="hover:text-blue-200 transition">Permohonan Izin Mahasiswa</a></li>
                        <li><a href="{{ route('pengajuannonmahasiswa') }}" class="hover:text-blue-200 transition">Permohonan Izin Non Mahasiswa</a></li>
                        <li><a href="{{ route('pantau') }}" class="hover:text-blue-200 transition">Status Pengajuan</a></li>
                    </ul>
                </div>

                <div>
                    <h3 class="text-xl font-bold mb-4">Sosial Media</h3>
                    <div class="flex space-x-4">
                        <a href="https://www.instagram.com/pemprov_kaltim/?hl=id" class="hover:text-blue-200 transition">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
            
            <div class="border-t border-gray-700 mt-8 pt-8 text-center">
                <p>&copy; 2025 SIRPENA KALTIM. All rights reserved.</p>
            </div>
        </div>
    </footer>
    </body>
<script>
    // Toggle mobile menu
    const mobileMenuButton = document.getElementById('mobile-menu-button');
    const mobileMenu = document.getElementById('mobile-menu');

    mobileMenuButton.addEventListener('click', () => {
        mobileMenu.classList.toggle('hidden');
    });

    // Close menu when clicking outside
    document.addEventListener('click', (event) => {
        if (!mobileMenu.contains(event.target) && !mobileMenuButton.contains(event.target)) {
            mobileMenu.classList.add('hidden');
        }
    });
</script>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const dropdownButton = document.getElementById("dropdown-button");
        const dropdownMenu = document.getElementById("dropdown-menu");
        const dropdownContainer = document.getElementById("dropdown-container");

        let isDropdownOpen = false;

        // Tampilkan dropdown saat hover
        dropdownContainer.addEventListener("mouseenter", () => {
            dropdownMenu.classList.remove("hidden");
        });

        // Biarkan dropdown tetap muncul meskipun mouse keluar dari tombol "LAYANAN"
        dropdownContainer.addEventListener("mouseleave", () => {
            // Tidak melakukan apa-apa (supaya dropdown tetap muncul)
        });

        // Toggle dropdown saat tombol diklik
        dropdownButton.addEventListener("click", (event) => {
            event.stopPropagation(); // Mencegah event bubble ke document
            isDropdownOpen = !isDropdownOpen;
            dropdownMenu.classList.toggle("hidden", !isDropdownOpen);
        });

        // Sembunyikan dropdown jika klik di luar
        document.addEventListener("click", (event) => {
            if (!dropdownContainer.contains(event.target)) {
                isDropdownOpen = false;
                dropdownMenu.classList.add("hidden");
            }
        });
    });
</script>

</html>