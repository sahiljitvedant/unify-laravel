<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>@yield('title', 'Brainstar-Front')</title>
  <link rel="icon" type="image/png" href="{{ asset('assets/img/logo.png') }}">

  <meta name="csrf-token" content="{{ csrf_token() }}">
  <link rel="stylesheet" href="{{ asset('css/style.css') }}">
  <link rel="stylesheet" href="{{ asset('css/responsive.css') }}">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
  <style>
    :root 
    {
        --theme-color: {{ config('app.theme_color') }};
        --sidebar_color: {{ config('app.sidebar_color') }};
        --sidebar_light:{{ config('app.sidebar_light') }};
        --other_color_fff: {{ config('app.other_color_fff') }};
        --front_font_size: {{ config('app.front_font_size') }};
    }
    html, body {
        margin: 0;
        padding: 0;
        overflow-x: hidden;
    }

    .footer
    {
        background: #333333;
        box-shadow: 0 -18px 40px rgba(0, 0, 0, 0.25);
    }
    /* Quick Inquiry Button */
    .quick-inquiry-btn {
        position: fixed;
        right: -48px;
        top: 30%;
        transform: translateY(-50%) rotate(-90deg);
        background: var(--sidebar_color);
        color: #fff;
        padding: 12px 30px;
        font-weight: 600;
        border-radius: 6px 6px 0 0;
        cursor: pointer;
        z-index: 999;
        box-shadow: -4px 0 12px rgba(0,0,0,0.25);
    }

    /* Drawer Panel */
    .inquiry-drawer {
        position: fixed;
        top: 0;
        right: -360px;
        width: 360px;
        height: 100vh;
        background: #fff;
        box-shadow: -10px 0 30px rgba(0,0,0,0.25);
        transition: 0.4s ease;
        z-index: 1000;
        padding: 22px 20px; /* improved spacing */
    }

    /* Active Drawer */
    .inquiry-drawer.active {
        right: 0;
    }

    /* Header */
    .inquiry-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        border-bottom: 1px solid #ddd;
        padding-bottom: 10px;
        margin-bottom: 15px; /* spacing before form */
    }

    .inquiry-header h4 {
        margin: 0;
        font-weight: 600;
        color: var(--sidebar_color);
    }

    .close-btn {
        font-size: 28px;
        cursor: pointer;
    }

    /* Form */
    #enquiry_form {
        margin-top: 5px;
    }

    #enquiry_form .form-control {
        margin-bottom: 10px; /* consistent spacing */
        padding: 10px;
        font-size: 14px;
    }

    /* Error messages */
    .error-message {
        margin-top: -6px;
        margin-bottom: 8px;
        font-size: 12px;
    }

    /* Textarea */
    #enquiry_form textarea.form-control {
        margin-bottom: 12px;
    }

    /* Submit button */
    .btn-submit {
        width: 100%;
        padding: 12px;
        margin-top: 6px; /* spacing above button */
        background: var(--sidebar_color);
        color: #fff;
        border: none;
        font-weight: 600;
        border-radius: 6px;
    }

    .brochure-btn {
        position: fixed;
        right: 0;               /* visible */
        top: 55%;               /* below enquiry */
        background: var(--sidebar_color);
        color: #fff;
        padding: 12px 16px;
        border-radius: 8px 0 0 8px;
        cursor: pointer;
        z-index: 9999;          /* above everything */
        display: flex;
        align-items: center;
        gap: 8px;
        text-decoration: none;
        transition: 0.3s ease;
    }

    .brochure-btn i {
        font-size: 20px;
    }

    /* hide text */
    .brochure-btn .tooltip-text {
        max-width: 0;
        overflow: hidden;
        white-space: nowrap;
        transition: 0.3s ease;
    }

    /* expand */
    .brochure-btn:hover .tooltip-text {
        max-width: 180px;
    }


  </style>
</head>
    @php
        $adminContact = DB::table('tbl_admin_contact')->first();

        $facebook  = $adminContact->facebook_url ?? '#';
        $instagram = $adminContact->instagram_url ?? '#';
        $linkedin  = $adminContact->linkedin_url ?? 'https://www.linkedin.com/company/brainstar-technologies-private-limited/?viewAsMember=true';
        $youtube   = $adminContact->youtube_url ?? '#';

        $email  = $adminContact->email_address1 ?? 'support@brainstar.com';
        $mobile = $adminContact->mobile_number1 ?? '+91 98765 43210';
    @endphp
    <body>
        <!-- HEADER -->
        <header class="header">
            <nav class="navbar">
                <div class="container nav-container">

                    <!-- Logo -->
                    <a href="{{ route('home') }}" class="logo">
                        <img src="{{ asset('assets/img/logo.png') }}" alt="Logo">
                    </a>

                    <!-- Desktop Menu -->
                    <ul class="nav-links">
                        <li><a href="/">Home</a></li>
                        <li><a href="/about_us">About</a></li>
                      
                        @foreach($menus as $menu)
                            <li class="has-dropdown">
                                <a href="javascript:void(0)">
                                    {{ $menu['title'] }}
                                    <i class="bi-caret-down-fill menu-icon"></i>
                                </a>

                                <ul class="menu-dropdown">

                                    {{-- With subheaders --}}
                                    @if(!empty($menu['with_subheader']))
                                        @foreach($menu['with_subheader'] as $sub)
                                            <li class="has-dropdown-sub">
                                                <a href="javascript:void(0)">
                                                    {{ $sub['name'] }}
                                                    <i class="bi bi-caret-right-fill menu-icon"></i>
                                                </a>

                                                <ul class="menu-dropdown-sub">
                                                    @foreach($sub['pages'] as $page)
                                                        <li>
                                                            <a href="{{ url($page->slug) }}">
                                                                {{ $page->title }}
                                                            </a>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            </li>
                                        @endforeach
                                    @endif

                                    {{-- Without subheader --}}
                                    @if(!empty($menu['without_subheader']))
                                        @foreach($menu['without_subheader'] as $page)
                                            <li>
                                                <a href="{{ url($page->slug) }}">
                                                    {{ $page->title }}
                                                </a>
                                            </li>
                                        @endforeach
                                    @endif

                                </ul>
                            </li>
                        @endforeach

                        <li><a href="/contact_us">Contact Us</a></li>
                        <li><a href="/careers">Careers</a></li>
                        <!-- <li><a target="_blank" href="{{ route('login_get') }}">Login</a></li> -->
                    </ul>

                    <!-- Hamburger (Mobile Only) -->
                    <div class="hamburger" id="hamburger">
                    <i class="bi bi-list"></i>
                    </div>


                </div>

            </nav>
            <!-- Mobile Slide Menu -->
            <div class="mobile-menu" id="mobileMenu">
                <div class="mobile-menu-header">
                    <span class="close-menu" id="closeMenu">&times;</span>
                </div>

                <ul class="mobile-nav-links">
                    <li><a href="/">Home</a></li>
                    <li><a href="/about_us">About</a></li>

                    @foreach($menus as $menu)
                    <li class="mobile-has-dropdown">
                        <div class="mobile-dropdown-toggle">
                        {{ $menu['title'] }}
                        <i class="bi bi-caret-down-fill"></i>
                        </div>

                        <ul class="mobile-dropdown">
                        @if(!empty($menu['with_subheader']))
                            @foreach($menu['with_subheader'] as $sub)
                            <li class="mobile-sub-toggle">
                                <div class="mobile-sub-title">
                                {{ $sub['name'] }}
                                <i class="bi bi-caret-right-fill"></i>
                                </div>
                                <ul class="mobile-sub-dropdown">
                                @foreach($sub['pages'] as $page)
                                    <li><a href="{{ url($page->slug) }}">{{ $page->title }}</a></li>
                                @endforeach
                                </ul>
                            </li>
                            @endforeach
                        @endif

                        @if(!empty($menu['without_subheader']))
                            @foreach($menu['without_subheader'] as $page)
                            <li><a href="{{ url($page->slug) }}">{{ $page->title }}</a></li>
                            @endforeach
                        @endif
                        </ul>
                    </li>
                    @endforeach

                    <li><a href="/contact_us">Contact Us</a></li>
                    <li><a href="/careers">Careers</a></li>
                    <!-- <li><a href="{{ route('login_get') }}">Login</a></li> -->
                </ul>
            </div>
  
        </header>

        <!-- Quick Inquiry Button -->
        <div class="quick-inquiry-btn" id="openInquiry">
            Quick Enquiry
        </div>

        <!-- Enquiry Drawer -->
        <div class="inquiry-drawer" id="inquiryDrawer">

            <div class="inquiry-header">
                <h4>Quick Enquiry</h4>
                <span class="close-btn" id="closeInquiry">&times;</span>
            </div>

            <form id="enquiry_form">

                <input type="text" name="name" class="form-control" placeholder="Name*">
                <div class="text-danger error-message" data-error-for="name"></div>

                <input type="email" name="email" class="form-control" placeholder="Email*">
                <div class="text-danger error-message" data-error-for="email"></div>

                <input type="tel" name="mobile" class="form-control" placeholder="Mobile Number*">
                <div class="text-danger error-message" data-error-for="mobile"></div>

                <!-- HEADER DROPDOWN -->
                <select name="header_id" id="enquiry_header_id" class="form-control">
                    <option value="">Select Category</option>
                    @foreach($headers as $header)
                        <option value="{{ $header->id }}">{{ $header->title }}</option>
                    @endforeach
                </select>
                <div class="text-danger error-message" data-error-for="header_id"></div>

                <!-- SUBHEADER DROPDOWN -->
                <select name="subheader_id" id="enquiry_subheader_id" class="form-control">
                    <option value="">Select Sub Category</option>
                </select>
                <div class="text-danger error-message" data-error-for="subheader_id"></div>

                <textarea name="message" class="form-control" rows="4" placeholder="Message*" ></textarea>
                <div class="text-danger error-message" data-error-for="message"></div>

                <button type="submit" class="btn-submit" id="submitEnquiryBtn">Submit Inquiry</button>
            </form>

        </div>
        @php
            $brochure = \App\Models\CompanyBrochure::first();
        @endphp

        @if($brochure && $brochure->file_path)
        <a href="{{ asset($brochure->file_path) }}"
            id="brochureBtn"
            class="brochure-btn"
            download="brainstar_company_brochure.pdf">
            <i class="bi bi-file-earmark-pdf"></i>
            <span class="tooltip-text">Company Brochure</span>
        </a>
        @endif


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
                        <h3>BRAINSTAR,</h3>
                        <p class="footer_p">
                        We as a system integrator are serving satisfied customers
                        across PAN India from last 5 years.
                        We provide Maintenance services (AMC) Safety and security system, low
                        voltage systems, such as CCTV, Fire Alarm system, Fire detection system, Gas
                        suppression system, Access Control system, Public addressing system, BMS,
                        IBMS, Intrusion alarm system etc.
                        We have successfully provided solutions to diversified market segments such
                        as Manufacturing industry, Logistics and Warehouse,IT Sectors, Ports ,
                        Pharma Industries and Other system Integrators
                        </p>
                        <div class="social-links">
                            <a href="{{ $facebook ?: '#' }}" class="btn-read" target="_blank"><i class="bi bi-facebook"></i></a>
                            <a href="{{ $instagram ?: '#' }}" class="btn-read" target="_blank"><i class="bi bi-instagram"></i></a>
                            <a href="{{ $linkedin ?: '#' }}" class="btn-read" target="_blank"><i class="bi bi-linkedin"></i></a>
                            <a href="{{ $youtube ?: '#' }}" class="btn-read" target="_blank"><i class="bi bi-youtube"></i></a>
                        </div>

                    </div>

                    <!-- Column 2 -->
                    <div class="footer-col">
                        <h3>Navigation</h3>
                        <ul class="footer-links">
                            <li><a href="/about_us">About Us</a></li>
                            <li><a href="/contact_us">Contact Us</a></li>
                            <li><a href="/careers">Careers</a></li>
                            <li><a href="/privacy_policy">Privacy Policy</a></li>
                            <li><a href="/terms_and_conditions">Terms & Conditions</a></li>
                            <li><a href="/faqs">FAQ's</a></li>
                        </ul>
                    </div>

                    <!-- Column 3 -->
                    <div class="footer-col">
                        <h3>Contact Info</h3>

                        <p><i class="bi bi-building"></i> Brainstar Technologies Pvt. Ltd.</p>
                        <p><i class="bi bi-envelope"></i> {{ $email ?: 'support@brainstar.com' }}</p>
                        <p><i class="bi bi-telephone"></i> {{ $mobile ?: '+91 98765 43210' }}</p>

                        <p><i class="bi bi-geo-alt"></i> Pune, Maharashtra, India</p>
                    </div>
                </div>

                <div class="footer-bottom">
                <p>
                    &copy; <script>document.write(new Date().getFullYear())</script> Brainstar|2026 All Rights Reserved.
                    <a href="/privacy_policy"><b>Privacy Policy</b></a> |
                    <a href="/terms_and_conditions"> <b>Terms & Conditions</b></a>
                </p>
                </div>
            </div>
        </footer>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

        <!-- Slider code -->
        <!-- <script>
            document.addEventListener('DOMContentLoaded', function () 
            {

                const slider = document.querySelector('#hero');
                if (!slider) return;

                const slides = slider.querySelectorAll('.slide');
                const dots = slider.querySelectorAll('.dot');
                const prevBtn = slider.querySelector('.prev-btn');
                const nextBtn = slider.querySelector('.next-btn');

                if (!slides.length) return;

                let current = 0;
                const intervalTime = 2000; // 2 seconds
                let sliderInterval;

                function updateSlider(index) {
                    current = (index + slides.length) % slides.length;

                    slides.forEach((slide, i) => {
                        slide.classList.toggle('active', i === current);
                    });

                    dots.forEach((dot, i) => {
                        dot.classList.toggle('active', i === current);
                    });

                    console.log("Slide:", current); // test log
                }

                function nextSlide() {
                    updateSlider(current + 1);
                }

                function prevSlide() {
                    updateSlider(current - 1);
                }

                function startAutoplay() {
                    clearInterval(sliderInterval);
                    sliderInterval = setInterval(nextSlide, intervalTime);
                    console.log("Autoplay started");
                }

                // Button Events
                nextBtn.addEventListener('click', () => {
                    nextSlide();
                    startAutoplay();
                });

                prevBtn.addEventListener('click', () => {
                    prevSlide();
                    startAutoplay();
                });

                // Dot Click
                dots.forEach(dot => {
                    dot.addEventListener('click', function () {
                        const index = parseInt(this.getAttribute('data-index'));
                        updateSlider(index);
                        startAutoplay();
                    });
                });

                // Init
                updateSlider(0);
                startAutoplay();

            });
        </script> -->
        
        <script>
            document.addEventListener('DOMContentLoaded', function () 
            {

                const slider = document.querySelector('#hero');
                if (!slider) return;

                const slides = slider.querySelectorAll('.slide');
                const dots = slider.querySelectorAll('.dot');

                if (!slides.length) return;

                let current = 0;
                const intervalTime = 2000; // 2 seconds
                let sliderInterval;

                function updateSlider(index) {
                    current = (index + slides.length) % slides.length;

                    slides.forEach((slide, i) => {
                        slide.classList.toggle('active', i === current);
                    });

                    dots.forEach((dot, i) => {
                        dot.classList.toggle('active', i === current);
                    });

                    console.log("Slide:", current);
                }

                function nextSlide() {
                    updateSlider(current + 1);
                }

                function startAutoplay() {
                    clearInterval(sliderInterval);
                    sliderInterval = setInterval(nextSlide, intervalTime);
                }

                // Dot Click
                dots.forEach(dot => {
                    dot.addEventListener('click', function () {
                        const index = parseInt(this.dataset.index);
                        updateSlider(index);
                        startAutoplay();
                    });
                });

                // Init
                updateSlider(0);
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
        <!-- Enquiry Model -->
        <script>
            const openInquiry = document.getElementById("openInquiry");
            const closeInquiry = document.getElementById("closeInquiry");
            const inquiryDrawer = document.getElementById("inquiryDrawer");

            openInquiry.addEventListener("click", () => {
                inquiryDrawer.classList.add("active");
                if (brochureBtn) brochureBtn.style.display = "none";
            });

            closeInquiry.addEventListener("click", () => {
                inquiryDrawer.classList.remove("active");

                if (brochureBtn) brochureBtn.style.display = "flex";
            });
        </script>
        <script>
            document.addEventListener("DOMContentLoaded", function () {

            const hamburger = document.getElementById("hamburger");
            const mobileMenu = document.getElementById("mobileMenu");
            const closeMenu = document.getElementById("closeMenu");

            // Open menu
            hamburger.addEventListener("click", () => {
                mobileMenu.classList.add("active");
            });

            // Close menu
            closeMenu.addEventListener("click", () => {
                mobileMenu.classList.remove("active");
            });

            // Main dropdown toggle
            document.querySelectorAll(".mobile-dropdown-toggle").forEach(toggle => {
                toggle.addEventListener("click", function () {
                this.classList.toggle("active"); // rotate arrow
                const dropdown = this.nextElementSibling;
                if (dropdown) dropdown.classList.toggle("active");
                });
            });

            // Sub dropdown toggle
            document.querySelectorAll(".mobile-sub-title").forEach(toggle => {
                toggle.addEventListener("click", function () {
                this.classList.toggle("active"); // rotate arrow
                const sub = this.nextElementSibling;
                if (sub) sub.classList.toggle("active");
                });
            });

            });
        </script>
        <script>
            $('#enquiry_header_id').on('change', function () 
            {
                const headerId = $(this).val();
                const subHeaderSelect = $('#enquiry_subheader_id');

                subHeaderSelect.html('<option value="">Loading...</option>');

                if (!headerId) {
                    subHeaderSelect.html('<option value="">Select Sub Category</option>');
                    return;
                }

                $.get(`/get-subheaders/${headerId}`, function (res) {
                    let options = '<option value="">Select Sub Category</option>';

                    if (res.status && res.data.length > 0) {
                        res.data.forEach(item => {
                            options += `<option value="${item.id}">${item.name}</option>`;
                        });
                    }

                    subHeaderSelect.html(options);
                });
            });
        </script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script src="{{ asset('assets/js/enquiry/enquiry.js') }}"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
        @stack('scripts')
    </body>
</html>
