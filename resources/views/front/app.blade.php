<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>@yield('title', 'Sachii-Front')</title>
  <link rel="icon" type="image/png" href="{{ asset('assets/img/logo.png') }}">
  <link rel="stylesheet" href="style.css">
 
  <link rel="stylesheet" href="{{ asset('css/style.css') }}">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
  <style>
    :root 
    {
        --theme-color: {{ config('app.theme_color') }};
        --sidebar_color: {{ config('app.sidebar_color') }};
        --other_color_fff: {{ config('app.other_color_fff') }};
        --front_font_size: {{ config('app.front_font_size') }};
    }
  </style>
</head>
<body>
    <!-- HEADER -->
    <header class="header">
        <nav class="navbar">
            <div class="container">
            <div class="logo">
                <a href="{{ route('home') }}" class="d-flex align-items-center text-decoration-none">
                    <img src="{{ asset('assets/img/logo.png') }}" alt="Logo" 
                        style="height:50px; width:160px; object-fit:cover; border-radius:10px; border:1px solid #0B1061">
                </a>
            </div>
            <ul class="nav-links">
                <li><a href="/">Home</a></li>
                <li><a href="/about_us">About</a></li>
                <li><a href="/blogs">Blogs</a></li>
                <li><a href="#contact">Contact</a></li>
                <li><a target="_blank" href="{{ route('login_get') }}">Login</a></li>
            </ul>
            </div>
            <div class="hamburger">&#9776;</div>
        </nav>
    </header>
    <!-- MOBILE MENU -->
    <div class="mobile-menu" id="mobileMenu">
        <a href="/">Home</a>
        <a href="/about_us">About</a>
        <a href="#classes">Classes</a>
        <a href="#contact">Contact</a>
        <li><a href="{{ route('login_get') }}">Login</a></li>
    </div>
    <!-- ABOUT US INFO SECTION -->
    <main>
        @yield('content')
    </main>
   
    <!-- FOOTER -->
    <footer class="footer">
        <div class="container">
            <div class="footer-grid">
            
            <!-- Column 1 -->
            <div class="footer-col">
                <h3>We at Sachiii</h3>
                <p>
                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam vitae orci sed libero consequat tincidunt. Vivamus vel urna eget arcu ultricies sagittis. Integer euismod, sapien nec pretium pharetra, magna justo volutpat magna, et bibendum justo libero eget risus.Lorem ipsum dolor sit ame
                </p>
                <div class="social-links">
                    <a href="#" class="btn-read"><i class="bi bi-facebook"></i></a>
                    <a href="#"  class="btn-read"><i class="bi bi-instagram"></i></a>
                    <a href="#"  class="btn-read"><i class="bi bi-linkedin"></i></a>
                    <a href="#"  class="btn-read"><i class="bi bi-youtube"></i></a>
                </div>
            </div>

            <!-- Column 2 -->
            <div class="footer-col">
                <h3>Navigation</h3>
                <ul class="footer-links">
                    <li><a href="/about_us">About Us</a></li>
                    <li><a href="#">Gallary</a></li>
                    <li><a href="/blogs">Blogs</a></li>
                    <li><a href="/privacy_policy">Privacy Policy</a></li>
                    <li><a href="#">Terms & Conditions</a></li>
                    <li><a href="/faqs">FAQ's</a></li>
                </ul>
            </div>

            <!-- Column 3 -->
            <div class="footer-col">
                <h3>Contact</h3>
                <p> Fitness Club, FC Road, Pune, Maharashtra, India</p>
                <p>support@fitnessclub.com</p>
                <p>+91 98765 43210</p>

                <form class="newsletter">
                <input type="email" class="form-control" placeholder="Subscribe email" required>
                <button type="submit" class="btn-read">Subscribe</button>
                </form>
            </div>
            </div>

            <div class="footer-bottom">
            <p>
                &copy; <script>document.write(new Date().getFullYear())</script> Sachi|2025 All Rights Reserved.
                <a href="/privacy_policy">Privacy Policy</a> |
                <a href="#">Terms & Conditions</a>
            </p>
            </div>
        </div>
    </footer>

    <style>
        .nav-links a,
        .mobile-menu a {
            text-decoration: none;
            color: inherit;    
        }
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
        .nav-links a.active 
        {
            color: #0B1061; 
            font-weight: bold;
            border-bottom: 2px solid #0B1061;
        }
        .contact-card
        {
            background: #f2f2f2 !important;
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
        document.addEventListener('DOMContentLoaded', function () {
        const slider = document.querySelector('.hero-slider');
        if (!slider) return;

        const slides = slider.querySelectorAll('.slide');
        const dots   = slider.querySelectorAll('.dot');

        if (!slides.length || !dots.length) return;

        let current = 0;
        const autoplayInterval = 130000; // 3s (change to 5000 if you want 5s)
        let autoplayTimer = null;

        function showSlide(index) {
            index = (index + slides.length) % slides.length; // always wrap around
            slides.forEach((s, i) => {
            s.classList.toggle('active', i === index);
            s.setAttribute('aria-hidden', i === index ? 'false' : 'true');
            });
            dots.forEach((d, i) => d.classList.toggle('active', i === index));
            current = index;
        }

        function startAutoplay() {
            stopAutoplay();
            autoplayTimer = setInterval(() => showSlide(current + 1), autoplayInterval);
        }
        function stopAutoplay() {
            if (autoplayTimer) clearInterval(autoplayTimer);
            autoplayTimer = null;
        }

        // dot controls
        dots.forEach(dot => {
            dot.addEventListener('click', () => {
            showSlide(parseInt(dot.dataset.index, 10));
            startAutoplay(); // 🔥 restart autoplay after clicking
            });
        });

        // keyboard arrows
        document.addEventListener('keydown', (e) => {
            if (e.key === 'ArrowLeft') { showSlide(current - 1); startAutoplay(); }
            if (e.key === 'ArrowRight') { showSlide(current + 1); startAutoplay(); }
        });

        // pause on hover/touch
        slider.addEventListener('mouseenter', stopAutoplay);
        slider.addEventListener('mouseleave', startAutoplay);
        slider.addEventListener('touchstart', stopAutoplay);
        slider.addEventListener('touchend', startAutoplay);

        // init
        showSlide(0);
        startAutoplay();
        });
    </script>

    <script>
        $(document).ready(function () {
            $("#enquiryForm").on("submit", function () {
                var btn = $("#submitBtn");
                btn.prop("disabled", true).text("Please wait...");
            });
        });
        // $(document).ready(function () {
        //     $(".nav-links a").on("click", function () {
        //         $(".nav-links a").removeClass("active"); // remove from all
        //         $(this).addClass("active"); // add to clicked
        //     });
        // });
        $(document).ready(function () {
            const sections = $("section"); // all sections
            const navLinks = $(".nav-links a");

            function setActiveLink() {
                let scrollPos = $(window).scrollTop();

                sections.each(function () {
                    let top = $(this).offset().top - 100; // offset for navbar height
                    let bottom = top + $(this).outerHeight();
                    let id = $(this).attr("id");

                    if (scrollPos >= top && scrollPos < bottom) {
                        navLinks.removeClass("active");
                        $(".nav-links a[href='#" + id + "']").addClass("active");
                    }
                });
            }

            // run on page load + scroll
            setActiveLink();
            $(window).on("scroll", setActiveLink);
        });

    </script>

</body>


</html>
