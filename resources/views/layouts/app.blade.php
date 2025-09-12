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
        <link href="{{ asset('app.css') }}" rel="stylesheet">
    </head>
    <body class="bg-light">
        <!-- Top Header -->
        <header class="navbar navbar-expand-lg navbar-light bg-white border-bottom px-4 py-3 header-navbar">
            <div class="container-fluid">
                <h1 class="navbar-brand h1 mb-0 fw-bold text-dark">Progress Monitoring</h1>
                <div class="navbar-nav ms-auto">
                    <span class="navbar-text text-dark">{{ date('M d, Y') }}</span>
                </div>
            </div>
        </header>

        <div class="d-flex vh-100">
            <!-- Fixed Sidebar -->
            <aside class="sidebar main-sidebar w-25 border-end p-4">
                <nav class="nav flex-column">
                    <a href="{{ route('home') }}" class="nav-link d-flex align-items-center gap-3 px-3 py-2 text-white text-decoration-none rounded sidebar-link" data-section="home">
                        <svg class="w-5 h-5" width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                        </svg>
                        <span>Home</span>
                    </a>
                    <a href="{{ route('projects.index') }}" class="nav-link d-flex align-items-center gap-3 px-3 py-2 text-white text-decoration-none rounded sidebar-link" data-section="projects">
                        <svg class="w-5 h-5" width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                        </svg>
                        <span>Projects</span>
                    </a>
                    <a href="{{ route('towers.index') }}" class="nav-link d-flex align-items-center gap-3 px-3 py-2 text-white text-decoration-none rounded sidebar-link" data-section="towers">
                        <svg class="w-5 h-5" width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                        </svg>
                        <span>Towers</span>
                    </a>
                </nav>
            </aside>

            <!-- Main Content Area -->
            <main class="flex-grow-1 overflow-auto p-4">
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
                        {{ session('success') }}
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
