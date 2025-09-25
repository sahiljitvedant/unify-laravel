<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Panel')</title>
    <link rel="icon" type="image/png" href="{{ asset('assets/img/logo.png') }}">
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
    <!-- Custom Admin CSS -->
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.js"></script>

      
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
       
        <!-- Topbar -->
        <div class="topbar d-flex justify-content-between align-items-center px-3 py-2 shadow-sm flex-wrap">
            <!-- Left: Mobile Menu & Logo -->
            <div class="d-flex align-items-center gap-3">
                <!-- Mobile Menu Button -->
                <button id="menuToggle" class="btn btn-outline-secondary d-lg-none">
                    <i class="fas fa-bars"></i>
                </button>

                <!-- Logo -->
                <a href="{{ route('list_dashboard') }}" class="d-flex align-items-center text-decoration-none">
                    <img src="{{ asset('assets/img/logo.png') }}" alt="Logo"
                        style="height:50px; width:150px; object-fit:cover; border-radius:8px; border:1px solid var(--sidebar_color)">
                </a>
            </div>

            <!-- Center: Search Bar + Welcome -->
            <div class="d-flex align-items-center flex-grow-1 justify-content-center mx-3 gap-3">
                <form id="membershipSearchForm" class="d-none d-md-flex flex-grow-1" style="max-width: 400px;">
                    <input type="text" id="membershipSearchInput" class="form-control" placeholder="Search Member">
                    <button type="submit" class="btn btn_bg_color ms-2">
                        <i class="bi bi-search"></i>
                    </button>
                </form>
                <!-- Welcome Text -->
                <div class="welcome-text d-none d-md-block">
                    <span style="font-size:12px; color:#000;">
                        Welcome back, Admin
                    </span>
                </div>
            </div>

            <!-- Right: Time, Notifications, Profile -->
            <div class="d-flex align-items-center gap-4">
                <!-- Static Time & Day -->
                <div class="text-end d-none d-md-block">
                    <span id="day" class="d-block fw-semibold"></span>
                    <span id="time" class="small text-muted"></span>
                </div>

                <!-- Notifications -->
                <!-- <a href="#" class="text-dark position-relative">
                    <i class="bi bi-bell fs-5"></i>
                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                        3
                    </span>
                </a> -->

                <!-- Profile Dropdown -->
                <div class="dropdown">
                    <a class="dropdown-toggle text-dark text-decoration-none d-flex align-items-center" 
                    href="#" role="button" id="profileDropdown" data-bs-toggle="dropdown">
                        <i class="bi bi-person-circle fs-5 me-2"></i> 
                        <span class="fw-medium" style="font-size:14px;">Admin</span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end shadow" aria-labelledby="profileDropdown">
                        <li>
                            <a class="dropdown-item d-flex align-items-center" href="#">
                                <i class="bi bi-person me-2"></i> 
                                <span style="font-size:14px;">Profile</span>
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item d-flex align-items-center" href="#">
                                <i class="bi bi-gear me-2"></i> 
                                <span style="font-size:14px;">Settings</span>
                            </a>
                        </li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <a class="dropdown-item d-flex align-items-center" href="{{ route('logout') }}">
                                <i class="bi bi-box-arrow-right me-2"></i> 
                                <span style="font-size:14px;">Logout</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- Sidebar -->
        <div id="sidebar" class="sidebar d-lg-block">
          
            <a href="{{ route('list_dashboard') }}" 
                class="{{ request()->routeIs('list_dashboard') ? 'active' : '' }}">
                    <i class="bi bi-speedometer2 me-2"></i>
                    Dashboard
            </a>
            <a href="{{ route('member_login') }}" 
            class="{{ request()->routeIs('member_login') ? 'active' : '' }}">
                <i class="bi bi-people me-2"></i>Login
            </a>
            <!-- <a class="d-flex justify-content-start align-items-center" 
            data-bs-toggle="collapse" 
            href="#modulesDropdown" 
            role="button" 
            aria-expanded="{{ request()->routeIs('list_membership','list_trainer') ? 'true' : 'false' }}" 
            aria-controls="modulesDropdown">
            <span><i class="bi bi-briefcase me-2"></i>Members</span>
            <i class="fas fa-chevron-down small ms-2 mt-0"></i>
            </a>
            <div class="collapse ps-4 {{ request()->routeIs('list_membership','list_trainer') ? 'show' : '' }}" 
                id="modulesDropdown">
                <a href="{{ route('list_membership') }}" 
                class="d-block py-1 {{ request()->routeIs('list_membership') ? 'active' : '' }}">
                    <i class="bi bi-book me-2"></i>Membership
                </a>
                <a href="{{ route('list_trainer') }}" 
                class="d-block py-1 {{ request()->routeIs('list_trainer') ? 'active' : '' }}">
                    <i class="bi bi-person-plus me-2"></i>Trainer
                </a>
            </div>
            <a href="{{ route('list_blogs') }}" 
            class="{{ request()->routeIs('list_blogs') ? 'active' : '' }}">
                <i class="bi bi-journal me-2"></i>Blogs
            </a> -->
            <a href="#" 
            class="{{ request()->routeIs('member_team') ? '' : '' }}">
                <i class="bi bi-camera me-2"></i>My Team
            </a>
            <a href="#" 
            class="{{ request()->routeIs('list_member') ? '' : '' }}">
                <i class="bi bi-chat-left-text me-2"></i>Enquiry
            </a>
            <a href="{{ route('member_team') }}" 
            class="{{ request()->routeIs('member_team') ? 'active' : '' }}">
                <i class="bi bi-question-circle me-2"></i>Working History
            </a>
            <a href="{{ route('add_policy') }}" 
            class="{{ request()->routeIs('add_policy') ? 'active' : '' }}">
                <i class="bi bi-shield-lock me-2"></i>Privacy Policy
            </a>
            <a  target="_blank" href="{{ route('home') }}" 
            class="{{ request()->routeIs('list_member') ? '' : '' }}">
                <i class="bi bi-globe me-2"></i>Go Live
            </a>
           
           
            <a href="{{ route('logout') }}" 
            class="{{ request()->routeIs('logout') ? 'active' : '' }}">
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
        const searchMembershipbyId = "{{ route('get_membership_name') }}";
        const editMembershipUrl = "{{ url('/edit_membership') }}";
    </script>
    <script>
        const menuToggle = document.getElementById('menuToggle');
        const sidebar = document.getElementById('sidebar');

        menuToggle.addEventListener('click', () => {
            sidebar.classList.toggle('active');
        });
  
        function updateTime() {
            const now = new Date();
            const optionsDay = { weekday: 'long' };
            const optionsTime = { hour: '2-digit', minute: '2-digit' };

            document.getElementById('day').textContent = now.toLocaleDateString('en-US', optionsDay);
            document.getElementById('time').textContent = now.toLocaleTimeString('en-US', optionsTime);
        }
        setInterval(updateTime, 1000);
        updateTime();
    </script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="{{ asset('assets/js/gym_membership/app.js') }}"></script>
    @stack('scripts')
</body>
</html>
<style>
    .topbar {
    height: 70px;
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    z-index: 1000;
    }

    .topbar .form-control {
        max-width: 100%;
        border-radius: 8px;
        font-size: 14px;
        color: var(--theme-color);
    }

    .topbar form {
        min-width: 200px; /* prevents shrinking too much */
    }

    /* Add spacing between logo and search */
    @media (max-width: 1200px) {
        .topbar .flex-grow-1 {
            margin-left: 20px;
        }
    }

    /* Mobile responsiveness */
    @media (max-width: 768px) {
        .topbar form {
            display: none !important; /* hide search bar on small screens */
        }
        .welcome-text {
            display: none !important;
        }
        .topbar {
            flex-wrap: wrap;
            height: auto;
            padding: 10px;
        }
    }
    .dropdown-menu 
    {
        --bs-dropdown-link-hover-bg: var(--sidebar_color) !important;
        --bs-dropdown-link-active-bg: var(--sidebar_color) !important;
        --bs-dropdown-link-hover-color: var(--theme-color) !important;
        --bs-dropdown-link-active-color: var(--theme-color) !important;
    }
</style>