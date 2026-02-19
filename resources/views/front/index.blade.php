@extends('front.app')
@section('title', 'Home')
@section('content')
    <!-- HERO -->
    <section id="hero" class="hero-slider snap-section" aria-label="Hero slider">
        <div class="slides">
            @foreach($banners as $key => $banner)
                <div class="slide {{ $key == 0 ? 'active' : '' }}">
                    <div class="slide-inner">

                        <!-- LEFT TEXT -->
                        <div class="slide-text">
                            <h1>{{ $banner->title }}</h1>
                            <p>{{ $banner->sub_title }}</p>
                        </div>

                        <!-- RIGHT IMAGE -->
                        <div class="slide-image">
                            <img src="{{ asset($banner->banner_image) }}" alt="Banner Image">
                        </div>

                    </div>
                </div>
            @endforeach
        </div>

        <!-- <div class="slider-nav">
            <button class="slider-btn prev-btn">&#10094;</button>
            <button class="slider-btn next-btn">&#10095;</button>
        </div> -->

        <div class="slider-dots">
            @foreach($banners as $key => $banner)
                <button class="dot {{ $key == 0 ? 'active' : '' }}" data-index="{{ $key }}"></button>
            @endforeach
        </div>
    </section>
    <!-- ABOUT -->
    <section id="about" class="about-section about-section snap-section">
        <div class="container">
            <div class="row align-items-center gy-5">

                <!-- LEFT CONTENT -->
                <div class="col-lg-6">
                    <div class="about-content">

                        <span class="about-tag">Who We Are</span>
                        <h2>Building Smarter, Safer & Connected Infrastructure</h2>

                        <p class="about-lead">
                            Brainstar Technologies is a leading system integrator delivering advanced safety,
                            security and automation solutions across India.
                        </p>

                        <!-- <p>
                            With 5+ years of expertise, we design, implement and maintain mission-critical systems
                            including CCTV, Fire Detection, Access Control, Gas Suppression, Public Addressing,
                            BMS, IBMS and Industrial Automation.
                        </p> -->

                        <!-- HIGHLIGHTS -->
                        <div class="about-highlights">
                            <div class="highlight-box">
                                <i class="bi bi-shield-check"></i>
                                <h5>Security & Safety Experts</h5>
                                <p>Advanced surveillance, fire & access control systems</p>
                            </div>

                            <div class="highlight-box">
                                <i class="bi bi-gear-wide-connected"></i>
                                <h5>Automation Solutions</h5>
                                <p>BMS, IBMS & industrial automation integration</p>
                            </div>

                            <div class="highlight-box">
                                <i class="bi bi-globe"></i>
                                <h5>PAN India Presence</h5>
                                <p>Serving clients across industries nationwide</p>
                            </div>
                        </div>

                        <!-- CTA -->
                        <a href="/about_us" class="about-btn">
                            Explore Our Journey <i class="bi bi-arrow-right"></i>
                        </a>

                    </div>
                </div>

                <!-- RIGHT IMAGE -->
                <div class="col-lg-6">
                    <div class="about-image-card">
                    <img src="{{ asset('assets/img/integared.jpg') }}"
            class="img-fluid w-100 about-img"
            alt="About Company">

                        <div class="about-badge">
                            <h4>20+ Years</h4>
                            <span>Industry Experience</span>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>
    <!-- Testimonial -->
    <!-- @php
        use App\Models\Testimonial;

        // Default online avatar
        $defaultImage = 'https://cdn-icons-png.flaticon.com/512/149/149071.png';

        // Fetch top 3 active & not deleted
        $testimonials = Testimonial::where('is_active', 1)
                        ->where('is_deleted', 0)
                        ->latest()
                        ->take(3)
                        ->get();
    @endphp

    <section class="testimonial-section testimonial-section snap-section">
        <div class="container">
            <h2 class="section-title">What Our Clients Say</h2>
            <p class="section-subtitle">Trusted by professionals across industries</p>

            <div class="row g-4 mt-4">

                @forelse($testimonials as $t)

                    @php
                        $name = $t->name ?: 'NA';
                        $position = $t->position ?: 'NA';
                        $text = $t->testimonial_text ?: 'NA';

                        // Character limits
                        $name = strlen($name) > 22 ? substr($name,0,22).'...' : $name;
                        $position = strlen($position) > 35 ? substr($position,0,35).'...' : $position;
                        $text = strlen($text) > 140 ? substr($text,0,140).'...' : $text;

                        // Image path check
                        $image = (!empty($t->profile_pic) && file_exists(public_path($t->profile_pic)))
                                    ? asset($t->profile_pic)
                                    : $defaultImage;
                    @endphp

                    <div class="col-md-4">
                        <div class="testimonial-card">

                            <img src="{{ $image }}"
                                class="testimonial-img"
                                alt="User"
                                onerror="this.onerror=null;this.src='{{ $defaultImage }}';">

                            <p class="testimonial-text">
                                “{{ $text }}”
                            </p>

                            <h5 class="testimonial-name">{{ $name }}</h5>

                            <span class="testimonial-role">{{ $position }}</span>

                        </div>
                    </div>

                @empty

                    {{-- If no data, show 3 NA cards --}}
                    @for($i = 0; $i < 3; $i++)
                        <div class="col-md-4">
                            <div class="testimonial-card">
                                <img src="{{ $defaultImage }}" class="testimonial-img" alt="User">
                                <p class="testimonial-text">“NA”</p>
                                <h5 class="testimonial-name">NA</h5>
                                <span class="testimonial-role">NA</span>
                            </div>
                        </div>
                    @endfor

                @endforelse

            </div>
        </div>
    </section> -->

   
    <!-- Our Clients -->
    <section class="home-trusted-section">
        <div class="container">
            <h2 class="home-trusted-title">Trusted by Industry Leaders</h2>

            <div class="home-logo-slider">
                <div class="home-logo-track">

                    @php
                        $partners = [
                            'apm.png',
                            'bosch.png',
                        
                            'dblogo.png',
                            'download.png',
                            'psa.png',
                            'siemens.png'
                        ];
                    @endphp

                    {{-- First Loop --}}
                    @foreach($partners as $logo)
                        <img src="{{ asset('assets/img/partners/' . $logo) }}" alt="Partner Logo">
                    @endforeach

                    {{-- Duplicate for infinite scroll --}}
                    @foreach($partners as $logo)
                        <img src="{{ asset('assets/img/partners/' . $logo) }}" alt="">
                    @endforeach

                </div>
            </div>
        </div>
    </section>

    @php
        $adminContact = DB::table('tbl_admin_contact')->first();

        if($adminContact){
            $email1 = $adminContact->email_address1 ? $adminContact->email_address1 : 'support@yourdomain.com';
            $email2 = $adminContact->email_address2 ? $adminContact->email_address2 : 'info@yourdomain.com';

            $phone1 = $adminContact->mobile_number1 ? $adminContact->mobile_number1 : '+91 98765 43210';
            $phone2 = $adminContact->mobile_number2 ? $adminContact->mobile_number2 : '+91 91234 56789';

            $businessHours = $adminContact->business_hours ? $adminContact->business_hours : 'Mon – Fri: 10 AM – 6 PM';
            $businessDay   = $adminContact->business_day ? $adminContact->business_day : 'Sat: 10 AM – 5 PM';
        } else {
            $email1 = 'support@yourdomain.com';
            $email2 = 'info@yourdomain.com';
            $phone1 = '+91 98765 43210';
            $phone2 = '+91 91234 56789';
            $businessHours = 'Mon – Fri: 10 AM – 6 PM';
            $businessDay   = 'Sat: 10 AM – 5 PM';
        }
    @endphp

    <!-- CONTACT -->
    <section class="home-contact-section">
        <div class="container">

            <div class="home-contact-head text-center">
                <span class="home-contact-badge">QUICK CONTACT INFO</span>
                <h2 class="home-contact-title">Contact Information</h2>
            </div>

            <div class="row g-4 home-contact-grid">

                <div class="col-md-3">
                    <div class="home-contact-card">
                        <div class="home-contact-icon"><i class="bi bi-geo-alt"></i></div>
                        <h5>Our Location</h5>
                        <p>1st Floor, Office A 107 Sr.No 55/1/2/1,  <br>Sun City Ambegaon
                        PUNE Maharashtra 411046</p>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="home-contact-card">
                        <div class="home-contact-icon"><i class="bi bi-envelope"></i></div>
                        <h5>Email Us</h5>
                        <p>{{ $email1 }}<br>{{ $email2 }}</p>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="home-contact-card">
                        <div class="home-contact-icon"><i class="bi bi-telephone"></i></div>
                        <h5>Phone Number</h5>
                        <p>{{ $phone1 }}<br>{{ $phone2 }}</p>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="home-contact-card">
                        <div class="home-contact-icon"><i class="bi bi-clock"></i></div>
                        <h5>Business Hours</h5>
                        <p>{{ $businessHours }}<br>{{ $businessDay }}</p>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- Scroll Controls -->
    <div class="scroll-controls">
        <button id="scrollUp" class="scroll-btn up" title="Scroll Up">
            <i class="bi bi-arrow-up"></i>
        </button>
        <button id="scrollDown" class="scroll-btn down" title="Scroll Down">
            <i class="bi bi-arrow-down"></i>
        </button>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- SCROLL TOP BOTTOM JS -->

    <script>
        document.addEventListener("DOMContentLoaded", function () 
        {

            const scrollUpBtn = document.getElementById("scrollUp");
            const scrollDownBtn = document.getElementById("scrollDown");

            const sections = Array.from(document.querySelectorAll("section"));
            const footer = document.querySelector("footer");

            function scrollToNextSection(direction) {
                const scrollPos = window.scrollY;
                const headerOffset = 64;

                let targetSection = null;

                if (direction === "down") {

                    for (let section of sections) {
                        if (section.offsetTop > scrollPos + headerOffset + 5) {
                            targetSection = section;
                            break;
                        }
                    }

                    if (!targetSection && footer) {
                        window.scrollTo({
                            top: footer.offsetTop,
                            behavior: "smooth"
                        });
                        return;
                    }

                } else {

                    for (let i = sections.length - 1; i >= 0; i--) {
                        if (sections[i].offsetTop < scrollPos - 5) {
                            targetSection = sections[i];
                            break;
                        }
                    }
                }

                if (targetSection) {
                    window.scrollTo({
                        top: targetSection.offsetTop - headerOffset,
                        behavior: "smooth"
                    });
                }
            }

            /* ================= BUTTON VISIBILITY CONTROL ================= */
            function updateScrollButtons() {
                const scrollPos = window.scrollY;
                const windowHeight = window.innerHeight;
                const pageHeight = document.body.scrollHeight;

                // Hide UP button at very top
                if (scrollPos < 50) {
                    scrollUpBtn.style.display = "none";
                } else {
                    scrollUpBtn.style.display = "flex";
                }

                // Hide DOWN button when footer is fully in view
                if (scrollPos + windowHeight >= pageHeight - 50) {
                    scrollDownBtn.style.display = "none";
                } else {
                    scrollDownBtn.style.display = "flex";
                }
            }

            scrollDownBtn.addEventListener("click", () => scrollToNextSection("down"));
            scrollUpBtn.addEventListener("click", () => scrollToNextSection("up"));

            window.addEventListener("scroll", updateScrollButtons);
            updateScrollButtons(); // run on load

        });
    </script>

@endsection
<style>


    /* Slider Navigation */
    .slider-nav {
        position: absolute;
        top: 50%;
        width: 100%;
        transform: translateY(-50%);
        display: flex;
        justify-content: space-between;
        padding: 0 25px;
        z-index: 10;
        pointer-events: none;
    }

    /* .slider-btn {
        pointer-events: all;
        width: 52px;
        height: 52px;
        border-radius: 50%;
        border: none;
        background: rgba(0,0,0,0.45);
        color: #fff;
        font-size: 26px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.3s ease;
        backdrop-filter: blur(4px);
    }

    .slider-btn:hover {
        background: var(--sidebar_color);
        transform: scale(1.12);
        box-shadow: 0 10px 25px rgba(0,0,0,0.4);
    } */

    /* Mobile size */
    /* @media(max-width:768px){
        .slider-btn{
            width:42px;
            height:42px;
            font-size:20px;
        }
    } */
   

    /* ================= TRUSTED CLIENTS ================= */
    .home-trusted-title {
        text-align: center;
        margin-bottom: 20px;
        font-weight: 600;
        color: var(--sidebar_color);
    }

    .home-logo-slider {
        overflow: hidden;
        width: 100%;
    }

    .home-logo-track {
        display: flex;
        gap: 60px;
        animation: home-scroll 25s linear infinite;
    }

    .home-logo-track img {
        height: 60px;
        /* filter: grayscale(100%); */
        opacity: 0.7;
        transition: 0.3s;
    }

    .home-logo-track img:hover {
        filter: grayscale(0%);
        opacity: 1;
    }

    @keyframes home-scroll {
        from { transform: translateX(0); }
        to { transform: translateX(-50%); }
    }

    /* ================= CONTACT SECTION ================= */
    .home-contact-head {
        margin-bottom: 40px;
    }

    .home-contact-badge {
        font-size: 12px;
        letter-spacing: 2px;
        color: var(--sidebar_color);
        font-weight: 600;
    }

    .home-contact-title {
        font-weight: 700;
        color: var(--sidebar_color);
    }

    .home-contact-card {
        background: #ffffff;
        border-radius: 12px;
        padding: 25px;
        text-align: center;
        box-shadow: 0 10px 25px rgba(0,0,0,0.06);
        transition: 0.3s;
        height: 100%;
    }

    .home-contact-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 14px 35px rgba(0,0,0,0.12);
    }

    .home-contact-icon {
        width: 60px;
        height: 60px;
        margin: 0 auto 15px;
        border-radius: 50%;
        background: rgba(0,150,136,0.1);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
        color: var(--sidebar_color);
    }

    .home-contact-card h5 {
        font-weight: 600;
        margin-bottom: 10px;
    }

    .home-contact-card p {
        font-size: 14px;
        color: #555;
        margin: 0;
    }

    /* ================= MOBILE FIX ================= */
    @media (max-width: 768px) {

        /* Let sections grow naturally */
        .home-trusted-section,
        .home-contact-section {
            height: auto;
            padding: 50px 0;
        }

        /* ---------- TRUSTED SECTION ---------- */
        .home-trusted-title {
            font-size: 18px;
            margin-bottom: 15px;
        }

        .home-logo-track {
            gap: 35px;
            animation: home-scroll 18s linear infinite;
        }

        .home-logo-track img {
            height: 28px;
        }

        /* ---------- CONTACT SECTION ---------- */
        .home-contact-head {
            margin-bottom: 25px;
            padding: 0 15px;
        }

        .home-contact-badge {
            font-size: 11px;
            letter-spacing: 1.5px;
        }

        .home-contact-title {
            font-size: 20px;
            line-height: 1.3;
        }

        .home-contact-grid {
            padding: 0 10px;
        }

        .home-contact-card {
            padding: 20px 15px;
            border-radius: 10px;
        }

        .home-contact-icon {
            width: 50px;
            height: 50px;
            font-size: 20px;
            margin-bottom: 12px;
        }

        .home-contact-card h5 {
            font-size: 15px;
            margin-bottom: 6px;
        }

        .home-contact-card p {
            font-size: 13px;
            line-height: 1.5;
        }
    }
    /* ================= DESKTOP LAYOUT ================= */
    @media (min-width: 1025px) {

            .home-trusted-section {
            background: #f9fbfb;
        }

        .home-logo-slider {
            overflow: hidden;
            width: 100%;
            position: relative;
        }

        .home-logo-track {
            display: flex;
            gap: 60px;
            width: max-content;
            animation: home-scroll 25s linear infinite;
        }

        .home-contact-section {
          
            display: flex;
            align-items: center;
            background: #ffffff;
        }
        }

        /* ================= TABLET & MOBILE ================= */
        @media (max-width: 1024px) {

        .home-trusted-section,
        .home-contact-section {
            height: auto;            /* 🔥 allow natural height */
            padding: 60px 0;
        }
    }
    /* ================= GLOBAL MOBILE SAFETY FIX ================= */
    @media (max-width: 768px) 
    {

        /* Prevent any section from being viewport-locked */
        section {
            height: auto !important;
            min-height: auto !important;
        }

        /* Fix About image badge overlapping */
        .about-image-card {
            position: relative;
        }

        .about-image-card img {
            width: 100%;
            height: auto;
            display: block;
        }

        .about-badge {
            position: static !important;
            margin-top: 15px;
            display: inline-block;
        }

        /* Stop scroll snapping issues on mobile */
        html {
            scroll-snap-type: none !important;
        }

        .snap-section {
            scroll-snap-align: none !important;
        }
    }

    /* Prevent horizontal scroll caused by absolute elements */
    body {
    overflow-x: hidden;
    }
    /* ================= HERO SLIDER FIX ================= */


    #hero .slides {
        position: relative;
        width: 100%;
        height: 100%;
    }

    #hero .slide {
        position: absolute;
        inset: 0;
        width: 100%;
        height: 100%;
    }
    @media (max-width: 768px) 
    {
       
        .slide-content {
            padding: 0 20px;
            text-align: center;
        }

        .slide-content h1 {
            font-size: 26px;
            line-height: 1.2;
        }

        .slide-content p {
            font-size: 14px;
        }
    }
    /* ================= HERO VISIBILITY FIX ================= */
    #hero {
        position: relative;
        z-index: 1;
    }

    #about {
        position: relative;
        z-index: 2;
    }
    /* ===== FIX HERO HIDDEN BEHIND HEADER ===== */
    /* ===== HERO MUST NOT USE SNAP FLEX LAYOUT ===== */
    #hero.snap-section {
    display: block;
    min-height: 100vh;
    height: 100vh;
    scroll-snap-align: none;
    }

</style>

