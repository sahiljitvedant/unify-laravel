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
            --other_color_fff: {{ config('app.other_color_fff') }};
            --font_size: {{ config('app.font_size') }};
        }
        .no-sidebar {
            margin-left: 0 !important;
            padding: 100px 20px 20px 20px !important;
            max-width: 500px;
            margin: 100px auto 0 auto !important;
        }

    </style>
</head>

<body>
    @php
        $hideSidebarRoutes = ['login_get', 'register_get', 'access_denied'];
    @endphp

    @if (!in_array(Route::currentRouteName(), $hideSidebarRoutes))
        <!-- Header -->
       
        <div class="topbar d-flex justify-content-between align-items-center px-3">
            <!-- Mobile Menu Button -->
            <button id="menuToggle" class="btn btn-outline-secondary d-lg-none">
                <i class="fas fa-bars"></i>
            </button>

            <!-- Logo & Brand -->
           
            <a href="{{ route('list_dashboard') }}" class="d-flex align-items-center text-decoration-none">
                <img src="{{ asset('assets/img/logo.png') }}" alt="Logo" 
                    style="height:60px; width:180px; object-fit:cover; border-radius:10px; border:1px solid var(--sidebar_color)">
            </a>
        </div>
        

        <!-- Sidebar -->
        <div id="sidebar" class="sidebar d-lg-block">
          
            <a href="{{ route('list_dashboard') }}">
            
                <i class="bi bi-speedometer2 me-2"></i>
                Dashboard
            </a>
            <a href="{{ route('list_member') }}"><i class="bi bi-people me-2"></i>Members</a>
            <a class="d-flex justify-content-start align-items-center" 
            data-bs-toggle="collapse" 
            href="#modulesDropdown" 
            role="button" 
            aria-expanded="false" 
            aria-controls="modulesDropdown">
            <span><i class="bi bi-briefcase me-2"></i>Modules</span><i class="fas fa-chevron-down small ms-2 mt-0"></i>
            </a>
            <div class="collapse ps-4" id="modulesDropdown">
                <a href="{{ route('list_membership') }}" class="d-block py-1">
                    <i class="bi bi-book me-2"></i>Membership
                </a>
                <a href="#" class="d-block py-1">
                    <i class="bi bi-person-plus me-2"></i>Trainer
                </a>
            </div>

            <a href="#"><i class="bi bi-gear me-2"></i>Settings</a>
            <a href="{{ route('logout') }}">
                <i class="bi bi-box-arrow-right me-2"></i>Logout
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
