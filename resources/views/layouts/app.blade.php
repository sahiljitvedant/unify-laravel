<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Panel')</title>
    <link rel="icon" type="image/png" href="{{ asset('assets/img/logo.png') }}">
    <!-- Bootstrap CSS -->
    <link  href="{{ asset('css/bootstrap.min.css') }}"   rel="stylesheet">
    <!-- Font Awesome -->
    <link  href="{{ asset('css/all.min.css') }}"   rel="stylesheet">
    <!-- Google Fonts: Inter -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link href="{{ asset('css/css2.css') }}" rel="stylesheet">
    <!-- Swal Js -->
    <script src="{{ asset('css/sweetalert2@11.js') }}"></script>
 
    <!-- Custom Admin CSS -->
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
    <link  href="{{ asset('css/cropper.min.css') }}"   rel="stylesheet">
    <script src="{{ asset('css/cropper.min.js') }}"></script>
      
    <style>
        :root {
            --theme-color: {{ config('app.theme_color') }};
            --sidebar_color: {{ config('app.sidebar_color') }};
            --other_color_fff: {{ config('app.other_color_fff') }};
            --font_size: {{ config('app.font_size') }};
            --font_size_10px: {{ config('app.font_size_10px') }};
            --black_color:{{config('app.black_color')}};
            --sidebar_light:{{config('app.sidebar_light')}};
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
    <div id="noInternetOverlay" style="display:none;">
        <div class="offline-box">
            <h1>😞 No Internet Connection</h1>
            <p>Please check your connection and try again.</p>
        </div>
    </div>

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
                <!-- <form id="membershipSearchForm" class="d-none d-md-flex flex-grow-1" style="max-width: 400px;">
                    <input type="text" id="membershipSearchInput" class="form-control" placeholder="Search Member">
                    <button type="submit" class="btn btn_bg_color ms-2">
                        <i class="bi bi-search"></i>
                    </button>
                </form> -->
                <!-- Welcome Text -->
                
            </div>

            <!-- Right: Time, Notifications, Profile -->
            <div class="d-flex align-items-center gap-4">
            <div class="welcome-text d-none d-md-block">
                    <span class="admin_text">
                        Welcome back, Brainstar
                    </span>
                   
                </div>
                <!-- Static Time & Day -->
                <div class="text-end d-none d-md-block">
                    <span id="day" class="day_time"></span>
                    <span id="time" class="day_time"></span>
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
                           
                        </li>

                        <!-- <li>
                            <a class="dropdown-item d-flex align-items-center" href="#">
                                <i class="bi bi-gear me-2"></i> 
                                <span class="dropdown-text">Settings</span>
                            </a>
                        </li> -->
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <a class="dropdown-item d-flex align-items-center" href="{{ route('logout') }}">
                                <i class="bi bi-box-arrow-right me-2"></i> 
                                <span class="dropdown-text">Logout</span>
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
            <a href="{{ route('list_member') }}" 
            class="{{ request()->routeIs('list_member','list_deleted_member','list_payment','add_member','change_member_password') ? 'active' : '' }}">
                <i class="bi bi-people me-2"></i>Members
            </a>
            <a href="{{ route('list_headers') }}" 
            class="{{ request()->routeIs('list_headers','add_header','edit_header','list_deleted_headers') ? 'active' : '' }}">
                <i class="bi bi-list me-2"></i>Headers
            </a>
            <a href="{{ route('list_subheaders') }}" 
            class="{{ request()->routeIs('list_subheaders','add_subheader','edit_subheader','list_deleted_headers') ? 'active' : '' }}">
                <i class="bi bi-diagram-2 me-2"></i>Sub-Headers
            </a>
            
            <a href="{{ route('home_banner') }}" 
            class="{{ request()->routeIs('home_banner','home_banner_add','home_banner_edit','list_deleted_banner') ? 'active' : '' }}">
                <i class="bi bi-image me-2"></i>Home Banner
            </a>
            
            <a href="{{ route('about_page') }}" 
            class="{{ request()->routeIs('about_page','list_deleted_about_page','about_page_add','about_page_edit') ? 'active' : '' }}">
                <i class="bi bi-chat-left-text me-2"></i>About Page
            </a>
            
            <!-- <a href="{{ route('list_payment') }}" 
            class="{{ request()->routeIs('list_payment','add_member_payment','view_admin_invoice') ? 'active' : '' }}">
                <i class="bi bi-credit-card me-2"></i>Payments
            </a> -->
            <a href="{{ route('list_gallery') }}" 
            class="{{ request()->routeIs('list_gallery','add_gallery','edit_gallery','list_deleted_gallery') ? 'active' : '' }}">
                <i class="bi bi-camera me-2"></i>Gallary
            </a>

            <a href="{{ route('admin.contactus') }}" 
            class="{{ request()->routeIs('admin.contactus') ? 'active' : '' }}">
                <i class="bi bi-telephone me-2"></i>Contact US
            </a>
           

            <!-- <a class="d-flex justify-content-start align-items-center" 
                data-bs-toggle="collapse" 
                href="#modulesDropdown" 
                role="button" 
                aria-expanded="{{ request()->routeIs('list_membership','list_trainer') ? 'true' : 'false' }}" 
                aria-controls="modulesDropdown">
            <span><i class="bi bi-briefcase me-2"></i>Modules</span>
            <i class="bi bi-chevron-down small ms-2 mt-0"></i>

            </a>
            <div class="collapse ps-4 {{ request()->routeIs('list_membership','add_membership','edit_membership','list_deleted_membership','list_trainer','add_trainer','edit_trainer','list_deleted_trainer') ? 'show' : '' }}" 
                id="modulesDropdown">
                <a href="{{ route('list_membership') }}" 
                class="d-block py-1 {{ request()->routeIs('list_membership','add_membership','edit_membership','list_deleted_membership') ? 'active' : '' }}">
                    <i class="bi bi-book me-2"></i>Membership
                </a>
                <a href="{{ route('list_trainer') }}" 
                class="d-block py-1 {{ request()->routeIs('list_trainer','add_trainer','edit_trainer','list_deleted_trainer') ? 'active' : '' }}">
                    <i class="bi bi-person-plus me-2"></i>Trainer
                </a>
            </div> -->
            <a href="{{ route('list_blogs') }}" 
            class="{{ request()->routeIs('list_blogs','add_blogs','edit_blogs','list_deleted_blogs') ? 'active' : '' }}">
                <i class="bi bi-journal me-2"></i>Blogs
            </a>
            <a href="{{ route('list_faqs') }}" 
            class="{{ request()->routeIs('list_faqs','add_faq','edit_faq','list_deleted_faqs') ? 'active' : '' }}">
                <i class="bi bi-question-circle me-2"></i>FAQs
            </a>
            <a href="{{ route('add_policy') }}" 
            class="{{ request()->routeIs('add_policy') ? 'active' : '' }}">
                <i class="bi bi-shield-lock me-2"></i>Privacy Policy
            </a>
            <a href="{{ route('add_terms_conditions') }}" 
            class="{{ request()->routeIs('add_terms_conditions') ? 'active' : '' }}">
                <i class="bi bi-file-earmark-check me-2"></i>Terms & Condition
            </a>
            <a href="{{ route('list_careers') }}" 
            class="{{ request()->routeIs('list_careers','add_career','edit_career','list_deleted_careers') ? 'active' : '' }}">
                <i class="bi bi-briefcase me-2"></i>Careers
            </a>
            <a href="{{ route('list_enquiry') }}" 
            class="{{ request()->routeIs('list_enquiry','list_replied_enquiry') ? 'active' : '' }}">
                <i class="bi bi-chat-left-text me-2"></i>Enquiry
            </a>
            <a href="{{ route('themes') }}" 
                class="{{ request()->routeIs('themes') ? 'active' : '' }}">
                    <i class="bi bi-palette me-2"></i>
                    Themes
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
        <!-- Desktop Sidebar Toggle Button (floating) -->
        <div class="desktop-sidebar-toggle d-none d-lg-block">
            <button id="desktopSidebarToggle" class="btn btn-outline-primary">
                <i class="bi bi-chevron-right" id="desktopSidebarIcon"></i>
            </button>
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
    <script>
        document.addEventListener('DOMContentLoaded', function() 
        {
            const desktopToggle = document.getElementById('desktopSidebarToggle');
            const sidebar = document.getElementById('sidebar');
            const mainContent = document.getElementById('mainContent');
            const icon = document.getElementById('desktopSidebarIcon');

            desktopToggle.addEventListener('click', function() {
                sidebar.classList.toggle('collapsed');
                mainContent.classList.toggle('expanded');

                // Change icon
                if(sidebar.classList.contains('collapsed')) {
                    icon.classList.remove('bi-chevron-left');
                    icon.classList.add('bi-x-lg'); // X icon
                } else {
                    icon.classList.remove('bi-x-lg');
                    icon.classList.add('bi-chevron-left'); // back to chevron
                }

                // optional alert for testing
                // alert('Sidebar toggled!');
            });
        });
    </script>
   

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const overlay = document.getElementById('noInternetOverlay');

            function showOfflineMessage() {
                overlay.style.display = 'flex';
            }

            function hideOfflineMessage() {
                overlay.style.display = 'none';
            }

            // Attach listeners
            window.addEventListener('offline', showOfflineMessage);
            window.addEventListener('online', hideOfflineMessage);

            // Check immediately on page load
            if (!navigator.onLine) {
                showOfflineMessage();
            }
        });
    </script>

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
    /* Sidebar collapsed state */
    #sidebar.collapsed {
        width: 0;
        min-width: 0;
        overflow: hidden;
        transition: width 0.3s ease;
    }

   
    #mainContent.expanded {
        margin-left: 0 !important;
        transition: margin-left 0.3s ease;
    }

    /* Desktop toggle button - always visible */
    .desktop-sidebar-toggle {
        position: fixed; 
        top: 95%;        
        left: 150px;    
        transform: translateY(-50%);
        z-index: 1050;   
    }

    #sidebar.collapsed + .desktop-sidebar-toggle {
        left: 10px; 
    }

    .desktop-sidebar-toggle button {
        border-radius: 50%;
        width: 40px;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 2px 6px rgba(0,0,0,0.15);
    }
</style>
<style>
    #noInternetOverlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(248,249,250,0.95);
        display: flex;
        justify-content: center;
        align-items: center;
        z-index: 9999;
        font-family: sans-serif;
    }
    .offline-box {
        background: #f2f2f2;
        padding: 40px 50px;
        border-radius: 12px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.1);
        text-align: center;
    }
    .offline-box h1 {
        font-size: 32px;
        color: #0B1061;
        margin-bottom: 10px;
    }
    .offline-box p {
        font-size: 18px;
        color: #555;
    }
</style>
