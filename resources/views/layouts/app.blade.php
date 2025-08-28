<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Panel')</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

    <!-- DataTables Bootstrap 5 -->
    <link href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" rel="stylesheet" />
    <link href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap5.min.css" rel="stylesheet" />
    <link href="https://cdn.datatables.net/searchpanes/2.2.0/css/searchPanes.bootstrap5.min.css" rel="stylesheet" />

    <!-- Font librry -->
    <!-- Google Fonts: Inter -->

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <!-- Swal Js -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- Custom CSS -->
      <!-- Custom Admin CSS -->
      <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
    <style>
        :root {
            --theme-color: {{ config('app.theme_color') }};
            --sidebar_color: {{ config('app.sidebar_color') }};
        }

    </style>
</head>

<body>
    @php
        $hideSidebarRoutes = ['login_get', 'register_get', 'access_denied'];
    @endphp

    @if (!in_array(Route::currentRouteName(), $hideSidebarRoutes))
        <!-- Header -->
        <div class="topbar">
            <button id="menuToggle" class="btn btn-outline-secondary d-lg-none">
                <i class="fas fa-bars"></i>
            </button>
            <span class="fw-bold">Admin Dashboard</span>
        </div>

        <!-- Sidebar -->
        <div id="sidebar" class="sidebar d-lg-block">
            <a href="{{ route('list_dashboard') }}">
            
                <i class="fas fa-home me-2"></i>
                Dashboard
            </a>
            <a href="{{ route('list_member') }}"><i class="fas fa-users me-2"></i>Members</a>
            <a class="d-flex justify-content-between align-items-center" 
            data-bs-toggle="collapse" 
            href="#modulesDropdown" 
            role="button" 
            aria-expanded="false" 
            aria-controls="modulesDropdown">
            <span><i class="fas fa-layer-group me-2"></i>Modules</span><i class="fas fa-chevron-down small"></i>
            </a>
            <div class="collapse ps-4" id="modulesDropdown">
                <a href="{{ route('list_membership') }}" class="d-block py-1">
                    <i class="fas fa-id-card me-2"></i>Membership
                </a>
                <a href="#" class="d-block py-1">
                    <i class="fas fa-user-tie me-2"></i>Trainer
                </a>
            </div>

            <a href="#"><i class="fas fa-cogs me-2"></i>Settings</a>
            <a href="{{ route('logout') }}">
                <i class="fas fa-sign-out-alt me-2"></i>Logout
            </a>
        </div>
    @endif
    <!-- Main Content -->
    <div id="mainContent"  class="{{ in_array(Route::currentRouteName(), $hideSidebarRoutes) ? 'no-sidebar' : '' }}">
        @yield('content')
    </div>

    <!-- Bootstrap Bundle JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Toggle Sidebar -->
    <script>
        const menuToggle = document.getElementById('menuToggle');
        const sidebar = document.getElementById('sidebar');

        menuToggle.addEventListener('click', () => {
            sidebar.classList.toggle('active');
        });
    </script>
    @stack('scripts')
</body>
</html>
<style>
    .no-sidebar {
    margin-left: 0 !important;
    padding: 100px 20px 20px 20px !important;
    max-width: 500px;
    margin: 100px auto 0 auto !important;
}

</style>
