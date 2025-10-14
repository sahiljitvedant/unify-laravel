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
    <link rel="stylesheet" href="{{ asset('css/custom_member.css') }}">
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
            <!-- Left: Logo -->
            <div class="d-flex align-items-center gap-3">
                <a href="{{ route('member_dashboard') }}" class="d-flex align-items-center text-decoration-none">
                    <img src="{{ asset('assets/img/logo.png') }}" alt="Logo"
                        class="topbar-logo">
                </a>
            </div>

            <!-- Right: Time, Notifications, Profile -->
            <div class="d-flex align-items-center gap-3 topbar-right">
                <!-- Home link -->
                <a href="{{ route('home') }}" class="oval-link d-flex align-items-center">
                    <i class="bi bi-globe2 me-2"></i>
                    <span class="d-none d-sm-inline">Sachii</span>
                </a>

                <!-- Notifications -->
                <!-- <a href="#" class="text-dark position-relative">
                    <i class="bi bi-bell fs-5"></i>
                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill ntf_count">3</span>
                </a> -->

                <!-- Profile Dropdown -->
                @php
                    $member = DB::table('tbl_gym_members')->where('id', Auth::id())->first();
                    $profileImage = $member && $member->profile_image ? asset($member->profile_image) : null;
                @endphp

                <div class="dropdown">
                    <a class="dropdown-toggle text-dark text-decoration-none d-flex align-items-center" 
                        href="#" id="profileDropdown" data-bs-toggle="dropdown" aria-expanded="false">

                        @if($profileImage)
                            <img src="{{ $profileImage }}" alt="Profile"
                                class="rounded-circle me-2 profile-img">
                        @else
                            <i class="bi bi-person-circle fs-3 me-2"></i>
                        @endif

                        <span class="username d-none d-md-inline">{{ Auth::user()->name }}</span>
                    </a>

                    <ul class="dropdown-menu dropdown-menu-end shadow" aria-labelledby="profileDropdown">
                        <li>
                            <a class="dropdown-item d-flex align-items-center" 
                            href="{{ route('edit_member', auth()->user()->id) }}">
                                <i class="bi bi-person me-2"></i> Profile
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item d-flex align-items-center" href="#">
                                <i class="bi bi-gear me-2"></i> Settings
                            </a>
                        </li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <a class="dropdown-item d-flex align-items-center" href="{{ route('logout') }}">
                                <i class="bi bi-box-arrow-right me-2"></i> Logout
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="sidebar" id="member_sidebar">
            <ul>
                <li>
                   <a href="{{ route('member_dashboard') }}" 
                       class="{{ request()->routeIs('member_dashboard') ? 'active' : '' }}">
                       <i class="bi bi-grid"></i><span>Dashboard</span>
                   </a>
               </li>
                
                
                <li>
                    <a href="{{ route('member_subscription') }}" 
                        class="{{ request()->routeIs('member_subscription') ? 'active' : '' }}">
                        <i class="bi bi-card-checklist"></i><span>Subsription</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('member_blogs') }}" 
                        class="{{ request()->routeIs('member_blogs','member_blogs_details') ? 'active' : '' }}">
                        <i class="bi bi-journal-text"></i><span>Blogs</span>
                    </a>
                </li>
               
               
                <li>
                    <a href="{{ route('member_my_team') }}" 
                         class="nav-link {{ request()->routeIs('member_my_team', 'my_profile') ? 'active' : '' }}">
                        <i class="bi bi-people"></i><span>My Team</span>
                    </a>

                </li>
                <li>
                    <a href="{{ route('member_gallary') }}" 
                        class="{{ request()->routeIs('member_gallary','member_gallary_namewise') ? 'active' : '' }}">
                        <i class="bi bi-images"></i><span>Gallary</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('member_payments') }}" 
                        class="{{ request()->routeIs('member_payments','view_invoice') ? 'active' : '' }}">
                        <i class="bi bi-credit-card"></i><span>My Payments</span>
                    </a>
                </li>
                
            </ul>
        </div>
        <div class="mobile-toggle-btn">
            <i class="bi bi-list"></i>
        </div>
    @endif
    <!-- Main Content -->
    <div id="mainContent"  class="{{ in_array(Route::currentRouteName(), $hideSidebarRoutes) ? 'no-sidebar' : '' }}">
        @yield('content')
    </div>

    <!-- Bootstrap Bundle JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>
<!-- jQuery CDN -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <!-- Toggle Sidebar -->
    <script>
        const searchMembershipbyId = "{{ route('get_membership_name') }}";
        const editMembershipUrl = "{{ url('/edit_membership') }}";
    </script>
    <script>
        const menuToggle = document.getElementById('menuToggle');
        const sidebar = document.getElementById('sidebar');

        let toggleState = 0; 
        $(document).ready(function() 
        {
            $('.mobile-toggle-btn').click(function() 
            {
                const icon  = $(this).find('i');

                if(toggleState === 0)
                {
                    // alert(1);
                    icon.removeClass().addClass('bi bi-x-circle'); 
                    $('#member_sidebar').attr('style', 'display: block !important;');
                    $('#mainContent').css('padding', '60px 5px 80px 5px'); 
                    $('.mobile-toggle-btn').css
                    ({
                        'bottom': '60px',
                        'right': '20px'
                    });   
                    // Yes icon
                    toggleState = 1;
                } else if(toggleState === 1){
                    icon.removeClass().addClass('bi bi-list'); // No icon
                    $('#member_sidebar').attr('style', 'display: none !important;');
                    $('#mainContent').css('padding', '60px 5px 20px 5px'); 
                    $('.mobile-toggle-btn').css
                    ({
                        'bottom': '10px',
                        'right': '10px'
                    });    
                    toggleState = 0;
                 
                }
            });
        });

    </script>


<script>
    
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
    /* Profile Dropdown Container */
    .dropdown .profile-img {
        width: 32px;
        height: 32px;
        object-fit: cover;
        border-radius: 50%;
    }

    /* Username Text */
    .dropdown .username {
        font-size: 14px;
        font-weight: 500;
        max-width: 100px; /* prevent overflowing */
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    /* Dropdown Toggle */
    .dropdown-toggle {
        padding: 4px 8px;
        font-size: 14px;
    }

    /* Dropdown Menu */
    .dropdown-menu {
        min-width: 180px;
        font-size: 13px;
        padding: 0.25rem 0;
        border-radius: 8px;
        background: #f2f2f2;
    }

    /* Dropdown Items */
    .dropdown-menu .dropdown-item {
        padding: 6px 12px;
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 13px;
    }

    /* Dropdown Icons */
    .dropdown-menu .dropdown-item i {
        font-size: 16px;
    }

    /* Divider */
    .dropdown-menu .dropdown-divider {
        margin: 0.25rem 0;
    }

    /* Hover effect */
    .dropdown-menu .dropdown-item:hover {
        background-color: var(--sidebar_color) !important;
    }

    /* Responsive adjustments */
    @media (max-width: 768px) {
        .dropdown .username {
            display: none; /* hide username on small screens */
        }

        .dropdown-menu {
            min-width: 140px;
            font-size: 12px;
        }

        .dropdown-menu .dropdown-item i {
            font-size: 14px;
        }

        .dropdown-menu .dropdown-item {
            padding: 5px 10px;
        }

        .dropdown-toggle {
            padding: 3px 6px;
        }
    }

</style>