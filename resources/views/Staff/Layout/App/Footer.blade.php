<script>
        // Get elements
        const sidebar = document.getElementById('sidebar');
        const menuToggle = document.getElementById('menu-toggle');
        const mainContent = document.getElementById('main-content');
        const navbarContent = document.getElementById('navbar-content');
        const sidebarToggleClose = document.getElementById('sidebar-toggle-close');
        const sidebarToggleOpen = document.getElementById('sidebar-toggle-open');
        
        // Function to toggle sidebar visibility
        function toggleSidebar() {
            const isSidebarVisible = !sidebar.classList.contains('-translate-x-full');
            
            if (isSidebarVisible) {
                // Hide sidebar
                sidebar.classList.add('-translate-x-full');
                
                // Show the open button
                sidebarToggleOpen.classList.remove('opacity-0', 'hidden');
                sidebarToggleOpen.classList.add('opacity-100');
                
                // Adjust main content
                if (window.innerWidth >= 768) {
                    mainContent.classList.remove('md:ml-64');
                    mainContent.classList.add('md:ml-0');
                    navbarContent.classList.remove('md:ml-64');
                    navbarContent.classList.add('md:ml-0');
                }
            } else {
                // Show sidebar
                sidebar.classList.remove('-translate-x-full');
                
                // Hide the open button
                sidebarToggleOpen.classList.add('opacity-0');
                setTimeout(() => {
                    sidebarToggleOpen.classList.add('hidden');
                }, 300);
                
                // Adjust main content
                if (window.innerWidth >= 768) {
                    mainContent.classList.add('md:ml-64');
                    mainContent.classList.remove('md:ml-0');
                    navbarContent.classList.add('md:ml-64');
                    navbarContent.classList.remove('md:ml-0');
                }
            }
        }
        
        // Set initial state (sidebar visible on desktop by default)
        function setInitialState() {
            if (window.innerWidth >= 768) {
                sidebar.classList.remove('-translate-x-full');
                sidebarToggleOpen.classList.add('opacity-0', 'hidden');
                mainContent.classList.add('md:ml-64');
                mainContent.classList.remove('md:ml-0');
                navbarContent.classList.add('md:ml-64');
                navbarContent.classList.remove('md:ml-0');
            } else {
                sidebar.classList.add('-translate-x-full');
                sidebarToggleOpen.classList.remove('opacity-0', 'hidden');
                sidebarToggleOpen.classList.add('opacity-100');
            }
        }
        
        // Initialize
        setInitialState();
        
        // Mobile menu toggle
        menuToggle.addEventListener('click', toggleSidebar);
        
        // Close sidebar button
        sidebarToggleClose.addEventListener('click', toggleSidebar);
        
        // Open sidebar button
        sidebarToggleOpen.addEventListener('click', toggleSidebar);

        // Close sidebar when clicking outside on mobile
        document.addEventListener('click', (event) => {
            if (window.innerWidth < 768 && 
                !sidebar.contains(event.target) && 
                !menuToggle.contains(event.target) &&
                !sidebarToggleOpen.contains(event.target)) {
                
                if (!sidebar.classList.contains('-translate-x-full')) {
                    toggleSidebar();
                }
            }
        });
        
        // Handle window resize
        window.addEventListener('resize', () => {
            if (window.innerWidth >= 768) {
                // On desktop, adjust main content based on sidebar visibility
                if (sidebar.classList.contains('-translate-x-full')) {
                    mainContent.classList.remove('md:ml-64');
                    mainContent.classList.add('md:ml-0');
                    navbarContent.classList.remove('md:ml-64');
                    navbarContent.classList.add('md:ml-0');
                    sidebarToggleOpen.classList.remove('opacity-0', 'hidden');
                    sidebarToggleOpen.classList.add('opacity-100');
                } else {
                    mainContent.classList.add('md:ml-64');
                    mainContent.classList.remove('md:ml-0');
                    navbarContent.classList.add('md:ml-64');
                    navbarContent.classList.remove('md:ml-0');
                    sidebarToggleOpen.classList.add('opacity-0', 'hidden');
                }
            } else {
                // On mobile, always hide sidebar when resizing to mobile
                sidebar.classList.add('-translate-x-full');
                sidebarToggleOpen.classList.remove('opacity-0', 'hidden');
                sidebarToggleOpen.classList.add('opacity-100');
            }
        });

        // Profile Modal
        const userProfileButton = document.getElementById('userProfileButton');
        const profileModal = document.getElementById('profileModal');
        const closeProfileModal = document.getElementById('closeProfileModal');
        
        // Logout Modal
        const logoutBtn = document.getElementById('logoutBtn');
        const logoutModal = document.getElementById('logoutModal');
        const cancelLogout = document.getElementById('cancelLogout');
        const confirmLogout = document.getElementById('confirmLogout');
        
        // Toggle profile modal
        userProfileButton.addEventListener('click', () => {
            profileModal.classList.remove('hidden');
        });
        
        closeProfileModal.addEventListener('click', () => {
            profileModal.classList.add('hidden');
        });
        
        // Handle logout
        logoutBtn.addEventListener('click', (e) => {
            e.preventDefault();
            profileModal.classList.add('hidden');
            logoutModal.classList.remove('hidden');
        });
        
        cancelLogout.addEventListener('click', () => {
            logoutModal.classList.add('hidden');
        });
        
         // Updated Logout Handling
        confirmLogout.addEventListener('click', function() {
            // Buat form logout
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = '{{ route('logout') }}';
            
            // Tambahkan CSRF token
            const csrfInput = document.createElement('input');
            csrfInput.type = 'hidden';
            csrfInput.name = '_token';
            csrfInput.value = '{{ csrf_token() }}';
            form.appendChild(csrfInput);

            document.body.appendChild(form);
            form.submit();
        });
        
        // Close modals when clicking outside
        window.addEventListener('click', (e) => {
            if (e.target === profileModal) {
                profileModal.classList.add('hidden');
            }
            if (e.target === logoutModal) {
                logoutModal.classList.add('hidden');
            }
        });
    </script>
</body>
</html>