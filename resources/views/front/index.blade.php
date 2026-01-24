@extends('front.app')

@section('title', 'Home')

@section('content')
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
                        <!-- <a class="btn-see-more btn-read" href="#about">Get Started</a> -->
                    </div>

                </div>
            @endforeach
        </div>
        <!-- Slider Navigation -->
        <div class="slider-nav">
            <button class="slider-btn prev-btn" aria-label="Previous Slide">
                <i class="bi bi-chevron-left"></i>
            </button>

            <button class="slider-btn next-btn" aria-label="Next Slide">
                <i class="bi bi-chevron-right"></i>
            </button>
        </div>


    </section>
    <!-- ABOUT -->
    <section id="about" class="about-section">
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
                    <img src="https://images.unsplash.com/photo-1556761175-5973dc0f32e7?w=1200" alt="Brainstar Office">

                    <div class="about-badge">
                        <h4>5+ Years</h4>
                        <span>Industry Experience</span>
                    </div>
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
    <!-- <section id="classes" class="classes">
        <div class="container">
        <h2>Blogs</h2>
        <div class="class-grid">
            @foreach($recent_blogs as $blog)
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
    </section> -->
    <!-- CONTACT -->
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

        .slider-btn {
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
        }

        /* Mobile size */
        @media(max-width:768px){
            .slider-btn{
                width:42px;
                height:42px;
                font-size:20px;
            }
        }

    </style>

