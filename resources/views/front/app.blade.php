<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Gym Website</title>
<link rel="stylesheet" href="style.css">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

<link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>
    <!-- HEADER -->
    <header class="header">
    <nav class="navbar">
        <div class="logo">
            <a href="{{ route('home') }}" class="d-flex align-items-center text-decoration-none">
                <img src="{{ asset('assets/img/logo.png') }}" alt="Logo" 
                    style="height:60px; width:180px; object-fit:cover; border-radius:10px; border:1px solid #0B1061">
            </a>
        </div>
        <ul class="nav-links">
    <li><a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active' : '' }}">Home</a></li>
    <li><a href="{{ route('about_us') }}" class="{{ request()->routeIs('about_us') ? 'active' : '' }}">About</a></li>
    <li><a href="{{ route('blogs') }}" class="{{ request()->routeIs('blogs') ? 'active' : '' }}">Blogs</a></li>
    <li><a href="#contact" class="{{ request()->is('#contact') ? 'active' : '' }}">Contact</a></li>
    <li><a href="{{ route('gallary') }}" class="{{ request()->is('#gallary') ? 'active' : '' }}">Gallary</a></li>
    <li><a target="_blank" href="{{ route('login_get') }}" class="{{ request()->routeIs('login_get') ? 'active' : '' }}">Login</a></li>
</ul>

        <div class="hamburger">&#9776;</div>
    </nav>
    </header>

    <!-- MOBILE MENU -->
    <div class="mobile-menu" id="mobileMenu">
        <a href="{{ route('home') }}">Home</a>
        <a href="{{ route('about_us') }}" >About</a>
        <a href="{{ route('blogs') }}">Blog</a>
        <a href="#contact">Contact</a>
        <li><a href="{{ route('login_get') }}">Login</a></li>
    </div>

    <!-- ABOUT US INFO SECTION -->
    <main>
        @yield('content')
    </main>
    <!-- FOOTER -->
    <footer class="footer fixed-footer">
    <p>&copy;2025 Sachi. All rights reserved.</p>
    </footer>
</body>
    <style>
      .btn-read {
            display: inline-flex;
            justify-content: center; 
            align-items: center;
            gap: 5px; 
            transition: transform 0.3s ease;
        }
        .btn-read:hover {
            transform: translateX(5px);
        }

        .back-btn 
        {
            display: inline-flex;       
            align-items: center;     
            gap: 8px;                   
            font-size: 18px;           
            font-weight: bold;
            text-decoration: none;     
            color: #0B1061;           
        }

        .thick-arrow {
            font-size: 18px;   
            color: #0B1061;        
        }
        .back-btn 
        {
            display: inline-flex;      
            align-items: center;       
            gap: 8px;                
            font-size: 18px;           
            font-weight: bold;
            text-decoration: none;    
            color: #0B1061;             
            transition: transform 0.2s ease, color 0.2s ease;
        }
      
        .fixed-footer 
        {
       
        bottom: 0;
        left: 0;
        width: 100%;
    
        text-align: center;
        /* padding: 10px 0; */
        z-index: 1000;
        }
        .nav-links a.active 
        {
            color: #0B1061; /* green highlight */
            font-weight: bold;
            border-bottom: 2px solid #0B1061;
        }
        .contact-card
        {
            background: #f2f2f2 !important;
        }

        .about-contact {
        min-height: calc(100vh - 60px); /* full height minus footer */
        padding: 40px 20px;
        background: #f9f9f9;
        display: flex;
        align-items: center; /* vertically center */
        }

        .about-container {
        display: flex;
        flex-wrap: wrap;
        gap: 30px;
        max-width: 1100px;
        margin: auto;
        width: 100%;
        }

        .about-info {
        flex: 1 1 45%;
        }

        .contact-card {
        background: #fff;
        border-radius: 12px;
        padding: 25px 20px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        border-left: 5px solid #0B1061; /* accent bar */
        }

        .contact-card h2 {
        margin-bottom: 20px;
        font-size: 22px;
        color: #0B1061;
        }

        .contact-card p {
        margin: 10px 0;
        font-size: 16px;
        line-height: 1.6;
        color: #333;
        }

        .contact-card strong {
        color: #0B1061;
        }

        /* Right side map */
        .about-map {
        flex: 1 1 45%;
        min-height: 400px;
        }

        .about-map iframe {
        width: 100%;
        height: 100%;
        border-radius: 10px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        /* Mobile responsive */
        @media (max-width: 768px) {
        .about-container {
            flex-direction: column;
        }
        .about-map {
            min-height: 300px;
        }
        }
        .blog-image {
            width: 100%;
            height: 350px; /* adjust height as needed */
            object-fit: cover; /* keeps aspect ratio and fills space */
            display: block;
            border-radius: 15px;
        }
        .blog-description 
        {
            font-size: 16px;
            line-height: 1.8;
            color: #444;
            text-align: justify; /* ✅ makes text justified */
        }

    </style>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        const hamburger = document.querySelector('.hamburger');
        const mobileMenu = document.getElementById('mobileMenu');

        hamburger.addEventListener('click', () => {
            mobileMenu.classList.toggle('active');
        });

        // Close menu when clicking a link
        document.querySelectorAll('.mobile-menu a').forEach(link => {
            link.addEventListener('click', () => {
            mobileMenu.classList.remove('active');
            });
        });
    </script>
    <script>
        $(document).ready(function () {
            $("#enquiryForm").on("submit", function () {
                var btn = $("#submitBtn");
                btn.prop("disabled", true).text("Please wait...");
            });
        });
        $(document).ready(function () {
            $(".nav-links a").on("click", function () {
                $(".nav-links a").removeClass("active"); // remove from all
                $(this).addClass("active"); // add to clicked
            });
        });

    </script>
</html>
