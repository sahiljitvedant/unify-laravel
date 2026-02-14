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


{{-- ================= SERVICES LAYOUT ================= --}}
@elseif($type === 'services')

<section class="solution-section"> {{-- reuse same spacing style --}}
    <div class="container">
        <div class="row align-items-start gy-5">

            <!-- CONTENT LEFT -->
            <div class="col-lg-7">
                <span class="product-badge">Our Services</span>
                <h1 class="solution-title">{{ $product->title }}</h1>

                <div class="solution-content">
                    {!! $product->description !!}
                </div>
            </div>

            <!-- IMAGE RIGHT -->
            <div class="col-lg-5">
                <div class="solution-image-card">
                    <img src="{{ asset($product->image) }}" alt="{{ $product->title }}">
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
    .service-hero {
        padding: 90px 0 40px;
        background: linear-gradient(135deg, #f0f7f6, #e5f1ef);
    }
    .service-title {
        font-size: 38px;
        font-weight: 700;
        color: var(--sidebar_color);
    }
    .service-content-section { padding: 70px 0; }
    .service-content { max-width: 900px; margin: auto; line-height: 1.9; }

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

</style>