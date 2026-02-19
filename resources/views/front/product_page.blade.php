@extends('front.app')

@section('title', $product->title)

@php
    $type = strtolower($product->header->title ?? '');
@endphp

@section('content')

{{-- ================= PRODUCTS LAYOUT ================= --}}
@if($type === 'products')

<section class="product-hero-top">
    <div class="container text-center">
        <span class="product-badge">Our Products</span>
        <h1 class="product-title">{{ $product->title }}</h1>
        <p class="product-subtitle">Delivering scalable, future-ready technology solutions tailored to your business.</p>
    </div>
</section>

<section class="product-image-banner">
    <div class="container">
        <div class="product-image-card">
            <img src="{{ asset($product->image) }}" alt="{{ $product->title }}">
        </div>
    </div>
</section>

<section class="product-content-section">
    <div class="container">
        <div class="product-content">
            {!! $product->description !!}
        </div>
    </div>
</section>


{{-- ================= SOLUTION LAYOUT ================= --}}
@elseif($type === 'solution')

<section class="solution-section">
    <div class="container">
        <div class="row align-items-start  gy-5">
            <div class="col-lg-5">
                <div class="solution-image-card">
                    <img src="{{ asset($product->image) }}" alt="{{ $product->title }}">
                </div>
            </div>
            <div class="col-lg-7">
                <span class="product-badge">Our Solution</span>
                <h1 class="solution-title">{{ $product->title }}</h1>
                <div class="solution-content">
                    {!! $product->description !!}
                </div>
            </div>
        </div>
    </div>
</section>


@elseif($type === 'services')

<section class="services-section">
    <div class="container">
        <div class="row align-items-start gy-5">

            <!-- LEFT CONTENT -->
            <div class="col-lg-7">
                <span class="product-badge">Our Services</span>
                <h1 class="services-title">{{ $product->title }}</h1>
                <div class="services-content">
                    {!! $product->description !!}
                </div>
            </div>

            <!-- RIGHT IMAGE -->
            <div class="col-lg-5">
                <div class="services-image-card">
                    <img src="{{ asset($product->image) }}" alt="{{ $product->title }}">
                </div>
            </div>

        </div>
    </div>
</section>




{{-- ================= CERTIFICATES ================= --}}
@elseif($type === 'certificates')
<section class="certificate-section">
    <div class="container">
        <div class="row gy-5">

            <!-- LEFT -->
            <div class="col-lg-5">
                <div class="certificate-preview">

                    <!-- PREVIEW -->
                    <div class="zoom-wrapper">

                        <!-- IMAGE -->
                        <img id="certificateImage"
                             src="{{ asset($product->image) }}"
                             alt="{{ $product->title }}">

                        <!-- PDF -->
                        <iframe id="certificatePdf"
                                src="{{ asset($product->image) }}"
                                style="display:none; width:100%; height:100%; border:none;">
                        </iframe>

                    </div>

                    <!-- ZOOM -->
                    <div class="zoom-controls">
                        <button type="button" id="zoomIn">+</button>
                        <button type="button" id="zoomOut">−</button>
                        <button type="button" id="zoomReset">Reset</button>
                    </div>

                    <!-- BUTTONS -->
                    <!-- <div class="certificate-actions">
                        <button type="button" id="togglePdf" class="btn-view">
                            View PDF
                        </button>

                        <a href="{{ asset($product->image) }}"
                           download="brainstar_certificate.pdf"
                           class="btn-download">
                            Download PDF
                        </a>
                    </div> -->

                </div>
            </div>

            <!-- RIGHT -->
            <div class="col-lg-7">
                <span class="product-badge">Certificate</span>
                <h1 class="solution-title">{{ $product->title }}</h1>

                <div class="solution-content">
                    {!! $product->description !!}
                </div>
            </div>

        </div>
    </div>
</section>
@endif


{{-- ================= CTA (COMMON FOR ALL) ================= --}}
<section class="product-cta">
    <div class="container text-center">
        <h3>Need This {{ $product->header->title ?? 'Solution' }} For Your Business?</h3>
        <p>Let’s design a powerful and scalable system built just for you.</p>
        <a href="/contact_us" class="product-btn">Talk to Our Experts</a>
    </div>
</section>

@endsection
<style>
    /* ===== COMMON BADGE ===== */
    .product-badge {
        display: inline-block;
        background: rgba(0,150,136,0.1);
        color: var(--sidebar_color);
        padding: 6px 18px;
        border-radius: 30px;
        font-size: 13px;
        font-weight: 600;
        margin-bottom: 15px;
    }

    /* ================= PRODUCTS ================= */
    .product-hero-top {
        padding: 40px 0 20px;
        background: linear-gradient(135deg, #f9fbfc, #eef6f5);
    }
    .product-title { font-size: 42px; font-weight: 700; color: var(--sidebar_color); }
    .product-subtitle { color: #666; }

    .product-image-banner { padding: 10px 0 10px; background: var(--theme-color); }
    .product-image-card {
        margin: 0 auto;   /* center card */
        display: flex;
        align-items: center;
        justify-content: center;
    }

  

    .product-image-card img {
        max-width: 100%;
        max-height: 100%;
        object-fit: contain;   /* full image visible */
        border: 2px solid #ddd; /* simple border */
        border-radius: 8px;     /* optional soft corners */
    }




    .product-content-section { padding: 80px 0; }
    .product-content { max-width: 900px; margin: auto; line-height: 1.9; }

    /* ================= SOLUTION ================= */
    .solution-section { padding: 80px 0; background: #fff; }
    .solution-image-card {
        border-radius: 18px;
        overflow: hidden;
        box-shadow: 0 20px 55px rgba(0,0,0,0.15);
    }
    .solution-image-card img { width: 100%; height: 100%; object-fit: cover; }
    .solution-title { font-size: 34px; color: var(--sidebar_color); }

    /* ================= SERVICES ================= */
    .services-section {
        padding: 80px 0;
        background: #fff;
    }

    .services-image-card {
        border-radius: 18px;
        overflow: hidden;
        box-shadow: 0 20px 55px rgba(0, 0, 0, 0.15);
    }

    .services-image-card img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .services-title {
        font-size: 34px;
        color: var(--sidebar_color);
    }

    .services-content {
        margin-top: 15px;
    }


    /* ================= CTA ================= */
    .product-cta {
        background: var(--sidebar_color);
        color: #fff;
        padding: 90px 0;
    }
    .product-btn {
        display: inline-block;
        background: #fff;
        color: var(--sidebar_color);
        padding: 12px 34px;
        border-radius: 30px;
        font-weight: 600;
        text-decoration: none;
        transition: 0.3s;
    }
    .product-btn:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 30px rgba(0,0,0,0.25);
    }
   /* ================= CERTIFICATES ================= */
   .certificate-section {
    padding: 80px 0;
    background: #fff;
    }

    .certificate-preview {
        position: sticky;
        top: 120px;
    }

    .zoom-wrapper {
        height: 420px;
        border: 1px solid #ddd;
        border-radius: 12px;
        overflow: hidden;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #f9f9f9;
    }

    .zoom-wrapper img,
    .zoom-wrapper iframe {
        max-width: 100%;
        max-height: 100%;
    }

    .zoom-controls {
        margin-top: 12px;
        display: flex;
        gap: 10px;
    }

    .zoom-controls button {
        padding: 6px 14px;
        border: none;
        background: var(--sidebar_color);
        color: #fff;
        border-radius: 6px;
        cursor: pointer;
    }

    .certificate-actions {
        margin-top: 15px;
        display: flex;
        gap: 10px;
    }

    .btn-view {
        flex: 1;
        background: #3498db;
        color: white;
        border: none;
        border-radius: 6px;
        padding: 10px;
        font-weight: 600;
        cursor: pointer;
    }

    .btn-download {
        flex: 1;
        background: #2ecc71;
        color: white;
        border-radius: 6px;
        padding: 10px;
        font-weight: 600;
        text-align: center;
        text-decoration: none;
    }
    /* ===== FIX BULLETS FOR PRODUCT/SERVICE/SOLUTION DESCRIPTION ===== */

    .product-content ul,
    .solution-content ul,
    .services-content ul {
        list-style-type: disc;
        padding-left: 22px;
        margin-bottom: 12px;
    }

    .product-content ul ul,
    .solution-content ul ul,
    .services-content ul ul {
        list-style-type: circle;
        padding-left: 22px;
    }

    .product-content ul ul ul,
    .solution-content ul ul ul,
    .services-content ul ul ul {
        list-style-type: square;
    }

    .product-content li,
    .solution-content li,
    .services-content li {
        margin-bottom: 6px;
    }


</style>
<script src="https://unpkg.com/@panzoom/panzoom/dist/panzoom.min.js"></script>

<script>
    document.addEventListener("DOMContentLoaded", function () 
    {

        const image = document.getElementById("certificateImage");
        const pdf = document.getElementById("certificatePdf");
        const toggleBtn = document.getElementById("togglePdf");

        if (!image) return;

        const panzoom = Panzoom(image, {
            maxScale: 5,
            minScale: 1
        });

        document.getElementById("zoomIn").addEventListener("click", () => panzoom.zoomIn());
        document.getElementById("zoomOut").addEventListener("click", () => panzoom.zoomOut());
        document.getElementById("zoomReset").addEventListener("click", () => panzoom.reset());

        let showingPdf = false;

        toggleBtn.addEventListener("click", function () {
            if (!showingPdf) {
                image.style.display = "none";
                pdf.style.display = "block";
                toggleBtn.innerText = "View Image";
                showingPdf = true;
            } else {
                image.style.display = "block";
                pdf.style.display = "none";
                toggleBtn.innerText = "View PDF";
                showingPdf = false;
            }
        });

    });
</script>



