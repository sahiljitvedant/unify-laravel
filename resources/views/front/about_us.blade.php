@extends('front.app')

@section('title', 'About Us')

@section('content')
<section class="about-section py-5">
    <div class="container">

        <!-- Heading -->
        <div class="text-center mb-5">
            <h2 class="about-title">About Brainstar</h2>
            <p class="about-subtitle">Driven by innovation. Powered by technology.</p>
            <div class="title-underline"></div>
        </div>

        <!-- Company Intro -->
        <div class="row align-items-start mb-5">
            <div class="col-lg-6">
            
            <img src="{{ asset('assets/img/integared.jpg') }}"
            class="img-fluid w-100 about-img"
            alt="About Company">
            </div>
            <div class="col-lg-6">
                <h3 class="about-heading">Who We Are</h3>
                <p class="about-text">
                    Brainstar Technologies is a leading system integrator delivering advanced safety,
                    security and automation solutions across India. With over 20+ years of experience,
                    we specialize in designing, implementing and maintaining mission-critical systems.
                </p>

                <p class="about-text">
                    Our expertise spans CCTV, Fire Detection, Access Control, Gas Suppression,
                    Public Addressing Systems, BMS, IBMS and Industrial Automation.
                </p>
            </div>
        </div>

        <!-- Vision / Mission -->
        <div class="row g-4 mb-5">

            <div class="col-md-6">
                <div class="about-card">
                    <div class="about-icon"><i class="bi bi-bullseye"></i></div>
                    <h5>Our Mission</h5>
                    <p>
                        To deliver reliable, scalable and secure technology solutions
                        that empower businesses and industries to operate safely and efficiently.
                    </p>
                </div>
            </div>

            <div class="col-md-6">
                <div class="about-card">
                    <div class="about-icon"><i class="bi bi-eye"></i></div>
                    <h5>Our Vision</h5>
                    <p>
                        To become India’s most trusted system integrator by continuously
                        innovating and delivering world-class infrastructure solutions.
                    </p>
                </div>
            </div>

        </div>

        <!-- Our Founders -->
        <div class="text-center mb-5">
            <h2 class="about-title">Our Founders</h2>
            <p class="about-subtitle">The leaders behind Brainstar</p>
            <div class="title-underline"></div>
        </div>

        <!-- Founder 1 -->
        <div class="row align-items-center founder-card mb-5">
            <div class="col-lg-4 text-center">
                <img src="{{ asset('assets/img/ratikanta_sir.jpg') }}" class="founder-img" alt="Founder">
                <!-- C:\Users\HP\laravel\public\assets\img\ratikanta_sir.jpg -->
            </div>
            <div class="col-lg-8">
                <h4 class="founder-name">Ratikanta Mohanty</h4>
                <span class="founder-role">Founder & CEO</span>
                <p class="founder-text">
                With 20+ years of expertise in integrated security systems, Ratikanta Mohanty leads Brainstar with a strong focus on engineering excellence, reliability, and customer trust. His hands-on leadership spans CCTV, Access Control, Fire Alarm, Intrusion, and Command & Control systems, delivering secure and future-ready solutions across industries.
                </p>
            </div>
        </div>

        <!-- Founder 2 -->
        <!-- <div class="row align-items-center founder-card mb-5 flex-row-reverse">
            <div class="col-lg-4 text-center">
                <img src="https://images.unsplash.com/photo-1573497019940-1c28c88b4f3e?w=600" class="founder-img" alt="Founder">

            </div>
            <div class="col-lg-8">
                <h4 class="founder-name">Anita Verma</h4>
                <span class="founder-role">Co-Founder & CTO</span>
                <p class="founder-text">
                    Anita Verma leads the technology and engineering division at Brainstar.
                    With deep expertise in integrated systems and automation, she ensures
                    every project meets the highest global standards.
                </p>
            </div>
        </div> -->

        <!-- Why Choose Us -->
        <div class="text-center mb-5">
            <h2 class="about-title">Why Choose Brainstar</h2>
            <p class="about-subtitle">What makes us different</p>
            <div class="title-underline"></div>
        </div>

        <div class="row g-4">

            <div class="col-md-4">
                <div class="about-card">
                    <div class="about-icon"><i class="bi bi-award"></i></div>
                    <h5>Proven Expertise</h5>
                    <p>
                        20+ years of experience delivering enterprise-grade solutions
                        across multiple industries.
                    </p>
                </div>
            </div>

            <div class="col-md-4">
                <div class="about-card">
                    <div class="about-icon"><i class="bi bi-shield-check"></i></div>
                    <h5>Reliable Systems</h5>
                    <p>
                        We design robust, scalable and secure infrastructure
                        that protects critical assets.
                    </p>
                </div>
            </div>

            <div class="col-md-4">
                <div class="about-card">
                    <div class="about-icon"><i class="bi bi-people"></i></div>
                    <h5>Customer First</h5>
                    <p>
                        Long-term partnerships built on trust, transparency and performance.
                    </p>
                </div>
            </div>

        </div>

    </div>
</section>
@endsection
<style>
    /* ===============================
   ABOUT US – CORPORATE THEME
================================ */

.about-section {
    background: var(--theme-color);
}

/* Headings */
.about-title {
    font-weight: 700;
    color: var(--sidebar_color);
}

.about-subtitle {
    color: #666;
    font-size: var(--front_font_size);
    margin-top: 6px;
}

/* Image */
.about-img {
    border-radius: 14px;
    box-shadow: 0 14px 32px rgba(0,0,0,0.15);
}

/* Text */
.about-heading {
    font-weight: 600;
    margin-bottom: 15px;
}

.about-text {
    font-size: 15px;
    line-height: 1.7;
    color: #555;
}

/* Cards */
.about-card {
    background: var(--other_color_fff);
    border-radius: 12px;
    padding: 30px 22px;
    text-align: center;
    border: 1px solid rgba(0,0,0,0.06);
    box-shadow: 0 6px 18px rgba(0,0,0,0.08);
    transition: all 0.3s ease;
    height: 100%;
}

.about-card:hover {
    transform: translateY(-6px);
    box-shadow: 0 16px 36px rgba(0,0,0,0.15);
}

.about-icon {
    font-size: 38px;
    color: var(--sidebar_color);
    margin-bottom: 15px;
}

/* Founder Section */
.founder-card {
    background: var(--other_color_fff);
    padding: 35px;
    border-radius: 14px;
    box-shadow: 0 10px 28px rgba(0,0,0,0.12);
}

.founder-img {
    width: 220px;
    height: 220px;
    object-fit: cover;
    border-radius: 50%;
    box-shadow: 0 10px 26px rgba(0,0,0,0.25);
}

.founder-name {
    font-weight: 700;
    color: var(--sidebar_color);
    margin-bottom: 5px;
}

.founder-role {
    display: block;
    font-size: 14px;
    color: #888;
    margin-bottom: 15px;
}

.founder-text {
    font-size: 15px;
    line-height: 1.7;
    color: #555;
}

</style>