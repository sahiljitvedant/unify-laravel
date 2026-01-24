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
    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/front.css') }}">
    <style>
         :root {
            --theme-color: {{ config('app.theme_color') }};
            --sidebar_color: {{ config('app.sidebar_color') }};
            --other_color_fff: {{ config('app.other_color_fff') }};
            --font_size: {{ config('app.font_size') }};
        }
    </style>
    
</head>
<body>
<div class="container-fluid">
    <div class="row">
       <!-- Left Section -->
        <div class="col-md-6 left-section d-none d-md-flex p-0 flex-column justify-content-center align-items-center text-center position-relative">
            <!-- Top Feature Icons -->
            <div class="top-feature-icons d-flex justify-content-center gap-4 flex-wrap">
                <div class="icon-box">
                    <i class="bi bi-bicycle fa-2x mb-2"></i>
                    <p>Cardio</p>
                </div>
                <div class="icon-box">
                <i class="bi bi-heart-pulse fa-2x mb-2"></i>
                    <p>Yoga</p>
                </div>
                <div class="icon-box">
                <i class="bi bi-person fa-2x mb-2"></i>
                    <p>Bodybuilding</p>
                </div>
                <div class="icon-box">
                <i class="bi bi-activity fa-2x mb-2"></i>
                    <p>Crossfit</p>
                </div>
                <div class="icon-box">
                <i class="bi bi-emoji-smile fa-2x mb-2"></i>
                    <p>Mindfulness</p>
                </div>
            </div>
            <!-- Background Shapes -->
            <div class="shape-circle shape-circle-1"></div>
            <div class="shape-circle shape-circle-2"></div>
            <div class="shape-circle shape-circle-3"></div>
            <div class="shape-circle shape-circle-4"></div>
            <div class="logo-center d-flex flex-column align-items-center justify-content-center position-absolute top-50 start-50 translate-middle">
            <!-- Logo & Tagline -->
            <img src="{{ asset('assets/img/logo.png') }}" alt="Logo" 
                style="height: 65px; width:200px; object-fit:cover; border-radius:10px; border:1px solid #0B1061" class="mt-2">
            <h6 class="mt-3">Crafting Digital Solutions</h6>
            </div>
          
            <!-- Social Icons (Vertically Centered) -->
            <div class="social-links d-flex flex-column position-absolute" style="top: 50%; left: 50px; transform: translateY(-50%);">
                <a href="#" class="text-white mb-3 fs-5"><i class="fab fa-facebook-f"></i></a>
                <a href="#" class="text-white mb-3 fs-5"><i class="fab fa-twitter"></i></a>
                <a href="#" class="text-white mb-3 fs-5"><i class="fab fa-linkedin-in"></i></a>
                <a href="#" class="text-white mb-3 fs-5"><i class="fab fa-instagram"></i></a>
            </div>

            <!-- Bottom Footer: Corporate Website (left) & Copyright (right) -->

            <div class="d-flex justify-content-between w-100 position-absolute bottom-0 px-4 py-2">
                <!-- Left: Corporate Website -->
                <a href="{{ route('home') }}" target="_blank" class="bubble-link text-white text-decoration-none d-inline-flex align-items-center px-3 py-2">
                    Corporate Website
                    <i class="bi bi-arrow-right ms-2"></i>
                </a>

                <!-- Right: Copyright -->
                <p class="text-white small mt-3">&copy; 2026 Brainstar. All rights reserved.</p>
            </div>
        </div>

        <!-- Right section -->
        <div class="col-md-6 d-flex align-items-center justify-content-center ">
            @yield('right-section')
        </div>
    </div>
</div>

</body>
</html>