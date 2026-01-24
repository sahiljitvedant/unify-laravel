<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Gym Website</title>
  <link rel="icon" type="image/png" href="{{ asset('assets/img/logo.png') }}">
  <link rel="stylesheet" href="style.css">
 
  <link rel="stylesheet" href="{{ asset('css/style.css') }}">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
  <style>
    :root 
    {
        --theme_color: {{ config('app.theme_color') }};
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
                <li><a href="#hero">Home</a></li>
                <li><a href="#about">About</a></li>
                <li><a href="#classes">Blogs</a></li>
                <li><a href="#contact">Contact</a></li>
                <li><a target="_blank" href="{{ route('login_get') }}">Login</a></li>
            </ul>
            </div>
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
        <!-- <div class="slides">
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
        </div> -->

        <!-- dots -->
        <!-- <div class="slider-dots" role="tablist" aria-label="Slides">
            <button class="dot active" aria-label="Slide 1" data-index="0"></button>
            <button class="dot" aria-label="Slide 2" data-index="1"></button>
            <button class="dot" aria-label="Slide 3" data-index="2"></button>
        </div> -->
        <div class="slides">
            @foreach($banners as $key => $banner)
                <div class="slide {{ $key == 0 ? 'active' : '' }}"
                    style="background-image: url('{{ asset($banner->banner_image) }}');">

                    <div class="slide-content">
                        <h1>{{ $banner->title }}</h1>
                        <p>{{ $banner->sub_title }}</p>
                        <a class="btn-see-more btn-read" href="#about">Get Started</a>
                    </div>

                </div>
            @endforeach
        </div>
        <div class="slider-dots">
            @foreach($banners as $key => $banner)
                <button class="dot {{ $key == 0 ? 'active' : '' }}" data-index="{{ $key }}"></button>
            @endforeach
        </div>


    </section>
    <!-- ABOUT -->
    
    <section id="about" class="about">
        <div class="container">
            <div class="row align-items-stretch"> <!-- key: stretch columns to same height -->

            <!-- Left Column: Text (fills height, pushes button to bottom) -->
            <div class="col-md-6 d-flex">
                <div class="about-text w-100 d-flex flex-column">
                <div class="about-text-inner">  <!-- this inner element will stretch -->
                    <h2>About Us</h2>
                    <p>
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam vitae orci sed libero consequat tincidunt.
                    Vivamus vel urna eget arcu ultricies sagittis. Integer euismod, sapien nec pretium pharetra, magna justo 
                    volutpat magna, et bibendum justo libero eget risus. Lorem ipsum dolor sit amet, consectetur adipiscing elit. 
                    Nullam vitae orci sed libero consequat tincidunt. Vivamus vel urna eget arcu ultricies sagittis.
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam vitae orci sed libero consequat tincidunt.
                    Vivamus vel urna eget arcu ultricies sagittis. Integer euismod, sapien nec pretium pharetra, magna justo 
                    volutpat magna, et bibendum justo libero eget risus. Lorem ipsum dolor sit amet, consectetur adipiscing elit. 
                    Nullam vitae orci sed libero consequat tincidunt. Vivamus vel urna eget arcu ultricies sagittis.
                    
                    </p>

                    <div class="about-cta"> <!-- keeps CTA at bottom -->
                    <a href="{{ route('about_us') }}" class="btn-see-more mt-2 btn-read">Get Started</a>
                    </div>
                </div>
                </div>
            </div>

            <!-- Right Column: Image (will match the height of the left column) -->
            <div class="col-md-6 d-flex">
                <div class="contact-image w-100">
                <img src="https://images.unsplash.com/photo-1558611848-73f7eb4001a1?w=1200" alt="Gym">
                </div>
            </div>

            </div>
        </div>
    </section>
    <!-- Industry Section -->
    <section class="industries-section">
        <div class="container">

            <div class="section-head text-center mb-5">
                <span class="section-badge">INDUSTRIES</span>
                <h2 class="section-title">Industries We Are Into</h2>
            </div>

            <div class="row g-4">

                <!-- Card 1 -->
                <div class="col-md-4">
                    <div class="industry-card">
                        <div class="icon-box">
                            <i class="bi bi-building"></i>
                        </div>
                        <h5>Steel & Metal</h5>
                        <p>
                            Delivering robust solutions for steel and metal industries with precision and reliability.
                        </p>
                    </div>
                </div>

                <!-- Card 2 -->
                <div class="col-md-4">
                    <div class="industry-card">
                        <div class="icon-box">
                            <i class="bi bi-fuel-pump"></i>
                        </div>
                        <h5>Oil & Gas</h5>
                        <p>
                            Trusted automation and monitoring systems tailored for Oil & Gas operations.
                        </p>
                    </div>
                </div>

                <!-- Card 3 -->
                <div class="col-md-4">
                    <div class="industry-card">
                        <div class="icon-box">
                            <i class="bi bi-bricks"></i>
                        </div>
                        <h5>Cement</h5>
                        <p>
                            Enabling high-performance cement plants with scalable industrial solutions.
                        </p>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- Our Clients -->
    <section class="trusted-section">
        <div class="container">
            <h2 class="trusted-title">Trusted by Industry Leaders</h2>

            <div class="logo-slider">
                <div class="logo-track">
                    <!-- Logos (repeat once for smooth infinite scroll) -->
                    <img src="{{ asset('assets/img/logos/aware.png') }}" alt="Aware">
                    <img src="{{ asset('assets/img/logos/est.png') }}" alt="EST">
                    <img src="{{ asset('assets/img/logos/esser.png') }}" alt="Esser">
                    <img src="{{ asset('assets/img/logos/honeywell.png') }}" alt="Honeywell">
                    <img src="{{ asset('assets/img/logos/fipron.png') }}" alt="Fipron">

                    <!-- Duplicate -->
                    <img src="{{ asset('assets/img/logos/aware.png') }}" alt="Aware">
                    <img src="{{ asset('assets/img/logos/est.png') }}" alt="EST">
                    <img src="{{ asset('assets/img/logos/esser.png') }}" alt="Esser">
                    <img src="{{ asset('assets/img/logos/honeywell.png') }}" alt="Honeywell">
                    <img src="{{ asset('assets/img/logos/fipron.png') }}" alt="Fipron">
                </div>
            </div>
        </div>
    </section>
    <!-- Testimonial -->
    <section class="testimonial-section">
        <div class="container">
            <h2 class="section-title">What Our Clients Say</h2>
            <p class="section-subtitle">Trusted by professionals across industries</p>

            <div class="row g-4 mt-4">

                <!-- Card 1 -->
                <div class="col-md-4">
                    <div class="testimonial-card">
                        <img src="{{ asset('assets/img/testimonials/user1.jpg') }}" class="testimonial-img" alt="User">

                        <p class="testimonial-text">
                            “Excellent service and quick support. Their solutions helped our business grow significantly.”
                        </p>

                        <h5 class="testimonial-name">Rahul Mehta</h5>
                        <span class="testimonial-role">Operations Manager</span>

                        <div class="testimonial-socials">
                            <a href="https://instagram.com" target="_blank">
                                <i class="bi bi-instagram"></i>
                            </a>
                            <a href="https://facebook.com" target="_blank">
                                <i class="bi bi-facebook"></i>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Card 2 -->
                <div class="col-md-4">
                    <div class="testimonial-card">
                        <img src="{{ asset('assets/img/testimonials/user2.jpg') }}" class="testimonial-img" alt="User">

                        <p class="testimonial-text">
                            “Very professional team. Implementation was smooth and the support is outstanding.”
                        </p>

                        <h5 class="testimonial-name">Anita Sharma</h5>
                        <span class="testimonial-role">Founder</span>

                        <div class="testimonial-socials">
                            <a href="https://instagram.com" target="_blank">
                                <i class="bi bi-instagram"></i>
                            </a>
                            <a href="https://facebook.com" target="_blank">
                                <i class="bi bi-facebook"></i>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Card 3 -->
                <div class="col-md-4">
                    <div class="testimonial-card">
                        <img src="{{ asset('assets/img/testimonials/user3.jpg') }}" class="testimonial-img" alt="User">

                        <p class="testimonial-text">
                            “Reliable, scalable, and easy to use. Highly recommended for growing companies.”
                        </p>

                        <h5 class="testimonial-name">Vikram Patel</h5>
                        <span class="testimonial-role">Tech Lead</span>

                        <div class="testimonial-socials">
                            <a href="https://instagram.com" target="_blank">
                                <i class="bi bi-instagram"></i>
                            </a>
                            <a href="https://facebook.com" target="_blank">
                                <i class="bi bi-facebook"></i>
                            </a>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- CLASSES -->
    <section id="classes" class="classes">
        <div class="container">
        <h2>Blogs</h2>
        <div class="class-grid">
            @foreach($latest_blogs as $blog)
            <div class="blog-card">
                <img src="{{ $blog->blog_image ?? 'https://images.unsplash.com/photo-1605296867424-35fc25c9212a?w=600' }}" alt="{{ $blog->blog_title }}">
                <div class="blog-content">
                    <span class="blog-date">{{ \Carbon\Carbon::parse($blog->publish_date)->format('d M') }}</span>
                    <h3 class="blog-title">{{ \Illuminate\Support\Str::limit($blog->blog_title, 50, '...') }}</h3>
                    <p>{{ \Illuminate\Support\Str::limit($blog->description, 120, '...') }}</p>
                    <div class="text-end mt-auto">
                        <a href="{{ route('blogs_read_more', ['id' => encrypt($blog->id)]) }}" class="btn-read">
                            Read More
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <div class="see-more-container">
            <a href="{{ route('blogs') }}" class="btn-see-more btn-read">See More</a>
        </div></div>
    </section>
    <!-- CONTACT -->
  
    {{-- <section id="contact" class="contact">
        <div class="container">
            <div class="row align-items-center">
            
                <!-- Left Column: Cartoon Image -->
                <div class="col-md-6 contact-image">
                    <img src="https://images.unsplash.com/photo-1605296867424-35fc25c9212a?w=600" 
                        alt="Contact Us Illustration" class="img-fluid">
                        <!-- <img src="{{ asset('assets/img/gym_04.jpg') }}" 
                        alt="Contact Us Illustration" class="img-fluid"> -->
                </div>
                

                <!-- Right Column: Contact Form -->
                <div class="col-md-6">
                    <div class="contact-card">
                    <h2>Contact Us</h2>
                    <form method="POST" action="{{ route('enquiry.store') }}" id="enquiryForm">
                        @csrf
                        <input type="text" class="form-control" name="name" placeholder="Your Name" required>
                        <input type="email" class="form-control" name="email" placeholder="Your Email" required>
                        <textarea rows="5" class="form-control" name="message" placeholder="Your Message" required maxlength="150"></textarea>
                        <button type="submit" id="submitBtn" class="btn-see-more btn-read">Send Message</button>
                    </form>
                    </div>
                </div>

            </div>
        </div>
    </section>--}}
    <section class="contact-info-section">
        <div class="container">

            <div class="section-head text-center mb-5">
                <span class="section-badge">QUICK CONTACT INFO</span>
                <h2 class="section-title">Contact Information</h2>
            </div>

            <div class="row g-4">

                <!-- Location -->
                <div class="col-md-3">
                    <div class="contact-card">
                        <div class="contact-icon">
                            <i class="bi bi-geo-alt"></i>
                        </div>
                        <h5>Our Location</h5>
                        <p>
                            1363 Naskarhat Madhya Para,<br>
                            Kolkata – 700039
                        </p>
                    </div>
                </div>

                <!-- Email -->
                <div class="col-md-3">
                    <div class="contact-card">
                        <div class="contact-icon">
                            <i class="bi bi-envelope"></i>
                        </div>
                        <h5>Email Us</h5>
                        <p>
                            support@yourdomain.com<br>
                            info@yourdomain.com
                        </p>
                    </div>
                </div>

                <!-- Phone -->
                <div class="col-md-3">
                    <div class="contact-card">
                        <div class="contact-icon">
                            <i class="bi bi-telephone"></i>
                        </div>
                        <h5>Phone Number</h5>
                        <p>
                            +91 98765 43210<br>
                            +91 91234 56789
                        </p>
                    </div>
                </div>

                <!-- Business Hours -->
                <div class="col-md-3">
                    <div class="contact-card">
                        <div class="contact-icon">
                            <i class="bi bi-clock"></i>
                        </div>
                        <h5>Business Hours</h5>
                        <p>
                            Mon – Fri: 10 AM – 6 PM<br>
                            Sat: 10 AM – 5 PM
                        </p>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- FOOTER -->
    <footer class="footer">
        <div class="container">
            <div class="footer-grid">
            
            <!-- Column 1 -->
            <div class="footer-col">
                <h3>We at Brainstari</h3>
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
                    <li><a href="blogs">Blogs</a></li>
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
                &copy; <script>document.write(new Date().getFullYear())</script> Brainstar|2026 All Rights Reserved.
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
            color: var(--theme-color);
            font-weight: bold;
            border-bottom: 2px solid var(--theme-color);;
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
