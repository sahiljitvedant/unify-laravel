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
    <div id="noInternetOverlay" style="display:none;">
        <div class="offline-box">
            <h1>😞 No Internet Connection</h1>
            <p>Please check your connection and try again.</p>
        </div>
    </div>
    <div class="container-fluid">
        <div class="row">
        <!-- Left Section -->
        {{-- 
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
                    <p class="text-white small mt-3">&copy; 2025 Sachii. All rights reserved.</p>
                </div>
            </div>--}}
            <div class="col-md-6 left-panel d-none d-md-flex position-relative">
                <!-- Overlay -->
                <div class="overlay"></div>
            
                <!-- Bottom Footer -->
                <div class="bottom-footer d-flex justify-content-between align-items-center">
                    <a href="{{ route('home') }}" target="_blank" class="website-link oval-btn">
                        Corporate Website <i class="bi bi-arrow-right ms-2"></i>
                    </a>
                    <p class="text-white small">&copy;2025 Sachii. All rights reserved</p>
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