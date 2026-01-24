@extends('front.app')

@section('title', 'Contact Us')

@section('content')
<section id="contact-us" class="contact-section py-5">
    <div class="container">

        <!-- Heading -->
        <div class="text-center mb-5">
            <h2 class="contact-title">Contact Us</h2>
            <p class="contact-subtitle">We’d love to hear from you</p>
            <div class="title-underline"></div>
        </div>

        <!-- Contact Cards -->
        <div class="row g-4 justify-content-center mb-5">

            <!-- Nashik Office -->
            <!-- <div class="col-lg-3 col-md-6">
                <div class="contact-card">
                    <div class="contact-icon">
                        <i class="bi bi-geo-alt-fill"></i>
                    </div>
                    <h5 class="contact-card-title">Nashik Office</h5>
                    <p class="contact-text">
                        Business Bay, Office No. 58, 6th Floor,<br>
                        Mumbai Naka, Nashik – 422009
                    </p>
                </div>
            </div> -->

            <!-- Pune Office -->
            <div class="col-lg-4 col-md-6">
                <div class="contact-card">
                    <div class="contact-icon">
                        <i class="bi bi-geo-alt-fill"></i>
                    </div>
                    <h5 class="contact-card-title">Pune Office</h5>
                    <p class="contact-text">
                        Office 809, 8th Floor, Niyati Emporius,<br>
                        Mahalunge, Pune – 411045
                    </p>
                </div>
            </div>

            <!-- Email -->
            <div class="col-lg-4 col-md-6">
                <div class="contact-card">
                    <div class="contact-icon">
                        <i class="bi bi-envelope-fill"></i>
                    </div>
                    <h5 class="contact-card-title">Email Us</h5>
                    <p class="contact-text">
                        support@yourdomain.com<br>
                        info@yourdomain.com
                    </p>
                </div>
            </div>

            <!-- Call -->
            <div class="col-lg-4 col-md-6">
                <div class="contact-card">
                    <div class="contact-icon">
                        <i class="bi bi-telephone-fill"></i>
                    </div>
                    <h5 class="contact-card-title">Call Us</h5>
                    <p class="contact-text">
                        +91 98765 43210<br>
                        +91 91234 56789
                    </p>
                </div>
            </div>

        </div>

        <!-- Map Section (Same as before) -->
        <div class="row justify-content-center">
            <div class="col-lg-6 col-md-10">
                <div class="map-card">
                    <iframe
                        src="https://www.google.com/maps?q=Narhe+Maharashtra&output=embed"
                        width="100%"
                        height="350"
                        style="border:0;"
                        allowfullscreen=""
                        loading="lazy">
                    </iframe>
                </div>
            </div>
        </div>

    </div>
</section>
@endsection


<style>
    /* ===============================
        Contact Us – Corporate UI
    =============================== */

    .contact-section {
        background: var(--theme-color);
    }

    /* Heading */
    .contact-title {
        font-weight: 700;
        color: var(--sidebar_color);
    }

    .contact-subtitle {
        color: #666;
        font-size: var(--front_font_size);
        margin-top: 6px;
    }

    /* Card */
    .contact-card {
        background: var(--other_color_fff);
        border-radius: 10px;
        padding: 20px 20px;
        text-align: center;
        border: 1px solid rgba(0,0,0,0.06);
        box-shadow: 0 6px 18px rgba(0,0,0,0.06);
        transition: all 0.3s ease;
        height: 100%;
    }

    .contact-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 14px 32px rgba(0,0,0,0.12);
    }

    .contact-card-title {
        font-size: 17px;
        font-weight: 600;
        color: var(--black_color);
        margin-bottom: 12px;
    }

    .contact-text {
        font-size: 14px;
        color: #555;
        line-height: 1.6;
        margin-bottom: 20px;
    }

    /* Button */
    .contact-btn {
        display: inline-block;
        background: var(--sidebar_color);
        color: #fff;
        font-size: 14px;
        padding: 8px 26px;
        border-radius: 25px;
        text-decoration: none;
        transition: all 0.3s ease;
    }

    .contact-btn:hover {
        opacity: 0.9;
        color: #fff;
    }

    /* Map */
    .map-card {
        background: #fff;
        padding: 12px;
        border-radius: 10px;
        box-shadow: 0 6px 18px rgba(0,0,0,0.08);
    }

</style>