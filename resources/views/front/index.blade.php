<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Gym Website</title>
  <link rel="stylesheet" href="style.css">
  <link rel="stylesheet" href="{{ asset('css/style.css') }}">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
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
        <li><a href="#hero">Home</a></li>
        <li><a href="#about">About</a></li>
        <li><a href="#classes">Blogs</a></li>
        <li><a href="#contact">Contact</a></li>
        <li><a target="_blank" href="{{ route('login_get') }}">Login</a></li>
        </ul>
        <div class="hamburger">&#9776;</div>
    </nav>
    </header>
    <!-- MOBILE MENU -->
    <div class="mobile-menu" id="mobileMenu">
    <a href="#hero">Home</a>
    <a href="#about">About</a>
    <a href="#classes">Classes</a>
    <a href="#contact">Contact</a>
    <li><a href="{{ route('login_get') }}">Login</a></li>
    </div>
    <!-- HERO -->
    <section id="hero" class="hero-slider" aria-label="Hero slider">
        <div class="slides">
            <div class="slide active" style="background-image: url('https://images.unsplash.com/photo-1558611848-73f7eb4001a1?w=1200');" aria-hidden="false">
            <div class="slide-content">
                <h1>Transform Your Body</h1>
                <p>Join our gym and start your fitness journey today.</p>
                <a class="btn-see-more btn-read" href="#about">Get Started</a>
            </div>
            </div>

            <div class="slide" style="background-image: url('https://images.unsplash.com/photo-1517836357463-d25dfeac3438?w=1200');" aria-hidden="true">
            <div class="slide-content">
                <h1>Push Your Limits</h1>
                <p>Cardio, strength, yoga & more — all in one place.</p>
                <a class="btn-see-more btn-read" href="#classes">Join Now</a>
            </div>
            </div>

            <div class="slide" style="background-image: url('https://images.unsplash.com/photo-1579758629938-03607ccdbaba?w=1200');" aria-hidden="true">
            <div class="slide-content">
                <h1>Feel the Energy</h1>
                <p>Group classes, personal training, and motivation.</p>
                <a class="btn-see-more btn-read" href="#contact">Start Today</a>
            </div>
            </div>
        </div>

        <!-- dots -->
        <div class="slider-dots" role="tablist" aria-label="Slides">
            <button class="dot active" aria-label="Slide 1" data-index="0"></button>
            <button class="dot" aria-label="Slide 2" data-index="1"></button>
            <button class="dot" aria-label="Slide 3" data-index="2"></button>
        </div>
    </section>
    <!-- ABOUT -->
    <section id="about" class="about">
        <div class="about-text">
        <h2>About Us</h2>
        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam vitae orci sed libero consequat tincidunt. Vivamus vel urna eget arcu ultricies sagittis. Integer euismod, sapien nec pretium pharetra, magna justo volutpat magna, et bibendum justo libero eget risus.Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam vitae orci sed libero consequat tincidunt. Vivamus vel urna eget arcu ultricies sagittis. Integer euismod, sapien nec pretium pharetra, magna justo volutpat magna, et bibendum justo libero eget risus.Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam vitae orci sed libero consequat tincidunt. Vivamus vel urna eget arcu ultricies sagittis. Integer euismod, sapien nec pretium pharetra, magna justo volutpat magna, et bibendum justo libero eget risus.Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam vitae orci sed libero consequat tincidunt. Vivamus vel urna eget arcu ultricies sagittis. Integer euismod, sapien nec pretium pharetra, magna justo volutpat magna, et bibendum justo libero eget risus.

        </p>
        <a href="{{ route('about_us') }}" class="btn-see-more mt-2 btn-read">Get Started</a>
        </div>
        <img src="https://images.unsplash.com/photo-1558611848-73f7eb4001a1?w=600" alt="Gym">
        
    </section>
    <!-- CLASSES -->
    <section id="classes" class="classes">
    <h2>Blogs</h2>
    <div class="class-grid">
        
        <div class="class-item">
            <img src="https://images.unsplash.com/photo-1605296867424-35fc25c9212a?w=600" alt="Crossfit">
            <h3>Yoga</h3>
            <p>Improve flexibility, balance, and mental focus with our yoga sessions.</p>
            <a href="{{ route('blogs_read_more') }}" class="btn-read">
            Read More <i class="bi bi-arrow-right fs-5 ms-1 align-middle"></i>
        </a>
        </div>

        <div class="class-item">
        <img src="https://images.unsplash.com/photo-1605296867424-35fc25c9212a?w=600" alt="Crossfit">
        <h3>Cardio</h3>
        <p>Burn calories and boost your endurance with high-energy cardio workouts.</p>
        <a href="{{ route('blogs_read_more') }}" class="btn-read">
            Read More <i class="bi bi-arrow-right fs-5 ms-1 align-middle"></i>
        </a>
        </div>

        <div class="class-item">
        <img src="https://images.unsplash.com/photo-1605296867424-35fc25c9212a?w=600" alt="Crossfit">
        <h3>Crossfit</h3>
        <p>Challenge your strength and stamina with functional training.</p>
        <a href="{{ route('blogs_read_more') }}" class="btn-read">
            Read More <i class="bi bi-arrow-right fs-5 ms-1 align-middle"></i>
        </a>
        </div>

    </div>
    <!-- See More button -->
    <div class="see-more-container">
        <a href="{{ route('blogs') }}" class="btn-see-more btn-read">See More</a>
    </div>
    </section>
    <!-- CONTACT -->
    <section id="contact" class="contact">
        <h2>Contact Us</h2>
        <div class="contact-card">
        <form method="POST" action="{{ route('enquiry.store') }}" id="enquiryForm">
            @csrf
            <input type="text" name="name" placeholder="Your Name" required>
            <input type="email" name="email" placeholder="Your Email" required>
            <textarea rows="5" name="message" placeholder="Your Message" required maxlength="15"></textarea>

            <button type="submit" id="submitBtn" class="btn-see-more btn-read">Send Message</button>
        </form>
        </div>
    </section>
    <!-- FOOTER -->
    <footer class="footer">
        <p>&copy;2025 Sachi. All rights reserved.</p>
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
        (function () 
        {
            const slides = document.querySelectorAll(".hero-slider .slide");
            const dots   = document.querySelectorAll(".hero-slider .dot");
            let current = 0;

            if (!slides.length || !dots.length) return;

            function showSlide(index) {
            index = (index + slides.length) % slides.length;
            slides.forEach((s, i) => {
                s.classList.toggle("active", i === index);
                s.setAttribute('aria-hidden', i === index ? 'false' : 'true');
            });
            dots.forEach((d, i) => d.classList.toggle('active', i === index));
            current = index;
            }

            // wire dots
            dots.forEach(dot => {
            dot.addEventListener('click', function () {
                const idx = parseInt(this.dataset.index, 10);
                showSlide(idx);
            });
            // keyboard support
            dot.addEventListener('keydown', function (e) {
                if (e.key === 'Enter' || e.key === ' ') {
                e.preventDefault();
                showSlide(parseInt(this.dataset.index, 10));
                }
            });
            });

            // optional: keyboard left/right
            document.addEventListener('keydown', function (e) {
            if (e.key === 'ArrowLeft') showSlide(current - 1);
            if (e.key === 'ArrowRight') showSlide(current + 1);
            });

            // ensure initial state
            showSlide(0);

            // optional autoplay (comment out if you don't want auto-advance)
            let autoplayInterval = 5000; // ms
            let autoplay = setInterval(() => showSlide(current + 1), autoplayInterval);

            // pause autoplay while user interacts (hover / touch)
            const sliderEl = document.querySelector('.hero-slider');
            sliderEl.addEventListener('mouseenter', () => clearInterval(autoplay));
            sliderEl.addEventListener('touchstart', () => clearInterval(autoplay));

            // small safety: re-show current after images load (keeps layout stable)
            window.addEventListener('load', () => showSlide(current));
        })();
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
