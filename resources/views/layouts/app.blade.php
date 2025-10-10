<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>@yield('title', config('app.name', 'Laravel'))</title>

        <!-- Bootstrap CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

        <!-- Custom CSS -->
        @vite(['resources/css/app.css'])
    </head>
    <body class="bg-light">
        <!-- Sticky Top Header -->
        <header class="navbar navbar-expand-lg navbar-light bg-white border-bottom px-4 py-3 header-navbar sticky-top">
            <div class="container-fluid">
                <div class="d-flex align-items-center gap-3">
                    <button class="btn btn-link text-dark p-1 sidebar-toggle" id="sidebarToggle" type="button">
                        <svg class="w-5 h-5" width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                    </button>
                    <img src="{{ asset('images/logo.png') }}" alt="Logo" class="navbar-brand h1 mb-0 fw-bold text-dark !w-[10%]" style="object-fit: contain; width: 15%;">
                </div>
                <div class="navbar-nav ms-auto">
                    <span class="navbar-text text-dark">{{ date('M d, Y') }}</span>
                </div>
            </div>
        </header>

        <div class="d-flex vh-100">
            <!-- Collapsible Sidebar -->
            <aside class="sidebar main-sidebar border-end sidebar-collapsible" id="sidebar">


                <!-- Sidebar Navigation -->
                <nav class="nav flex-column p-3">
                    <!-- <a href="{{ route('home') }}" class="nav-link d-flex align-items-center gap-3 px-3 py-2 text-white text-decoration-none rounded sidebar-link" data-section="home">
                        <svg class="w-5 h-5" width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                        </svg>
                        <span class="sidebar-text">Home</span>
                    </a> -->
                    <a href="{{ route('projects.index') }}" class="nav-link d-flex align-items-center gap-3 px-3 py-2 text-white text-decoration-none rounded sidebar-link" data-section="projects">
                        <svg class="w-5 h-5" width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                        </svg>
                        <span class="sidebar-text">Projects</span>
                    </a>
                    <a href="{{ route('towers.index') }}" class="nav-link d-flex align-items-center gap-3 px-3 py-2 text-white text-decoration-none rounded sidebar-link" data-section="towers">
                        <svg class="w-5 h-5" width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                        </svg>
                        <span class="sidebar-text">Towers</span>
                    </a>
                </nav>
            </aside>

            <!-- Main Content Area -->
            <main class="flex-grow-1 overflow-auto p-4">
                @if (session('success'))
                    <div class="alert alert-dismissible fade show alert-card alert-card--success d-flex align-items-start justify-content-between gap-3 mb-3" role="alert">
                        <div class="d-flex align-items-start">
                            <svg class="alert-icon" viewBox="0 0 24 24" fill="none" stroke="#16a34a" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                <path d="M9 12l2 2 4-4" />
                                <circle cx="12" cy="12" r="9" stroke="#16a34a"/>
                            </svg>
                            <div>
                                <p class="alert-title mb-1">Success</p>
                                <p class="alert-text">{{ session('success') }}</p>
                            </div>
                        </div>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if (session('error'))
                    <div class="alert alert-dismissible fade show alert-card alert-card--error d-flex align-items-start justify-content-between gap-3 mb-3" role="alert">
                        <div class="d-flex align-items-start">
                            <svg class="alert-icon" viewBox="0 0 24 24" fill="none" stroke="#dc2626" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                <path d="M12 8v4m0 4h.01" />
                                <circle cx="12" cy="12" r="9" stroke="#dc2626"/>
                            </svg>
                            <div>
                                <p class="alert-title mb-1">Error</p>
                                <p class="alert-text">{{ session('error') }}</p>
                            </div>
                        </div>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @yield('content')
            </main>
        </div>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const sidebarLinks = document.querySelectorAll('.sidebar-link');
                const mainContent = document.querySelector('main');
                const sidebar = document.getElementById('sidebar');
                const sidebarToggle = document.getElementById('sidebarToggle');
                const sidebarTexts = document.querySelectorAll('.sidebar-text');

                // Set active state for current page
                const currentPath = window.location.pathname;
                if (currentPath === '/' || currentPath === '/projects') {
                    document.querySelector('[data-section="projects"]').classList.add('active');
                } else if (currentPath === '/home') {
                    document.querySelector('[data-section="home"]').classList.add('active');
                } else if (currentPath.startsWith('/towers')) {
                    document.querySelector('[data-section="towers"]').classList.add('active');
                }

                // Handle sidebar navigation
                sidebarLinks.forEach(link => {
                    link.addEventListener('click', function(e) {
                        // Remove active state from all links
                        sidebarLinks.forEach(l => l.classList.remove('active'));

                        // Add active state to clicked link
                        this.classList.add('active');
                    });
                });

                // Handle sidebar toggle
                sidebarToggle.addEventListener('click', function() {
                    sidebar.classList.toggle('collapsed');

                    // Toggle text visibility
                    sidebarTexts.forEach(text => {
                        text.style.display = sidebar.classList.contains('collapsed') ? 'none' : 'inline';
                    });

                    // Rotate toggle icon
                    const icon = this.querySelector('svg');
                    icon.style.transform = sidebar.classList.contains('collapsed') ? 'rotate(180deg)' : 'rotate(0deg)';
                });

                // Check if sidebar should be collapsed on page load (from localStorage)
                const isCollapsed = localStorage.getItem('sidebarCollapsed') === 'true';
                if (isCollapsed) {
                    sidebar.classList.add('collapsed');
                    sidebarTexts.forEach(text => {
                        text.style.display = 'none';
                    });
                    const icon = sidebarToggle.querySelector('svg');
                    icon.style.transform = 'rotate(180deg)';
                }

                // Save sidebar state to localStorage
                sidebarToggle.addEventListener('click', function() {
                    const isCollapsed = sidebar.classList.contains('collapsed');
                    localStorage.setItem('sidebarCollapsed', isCollapsed);
                });
            });
        </script>

        <!-- Bootstrap JavaScript -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>

        <!-- Custom JavaScript -->
        @vite(['resources/js/app.js'])

        <!-- Page-specific scripts -->
        @stack('scripts')
    </body>
</html>
