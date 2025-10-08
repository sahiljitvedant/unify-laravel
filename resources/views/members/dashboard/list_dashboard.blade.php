@extends('members.layouts.app')

@section('title', 'Member Dashboard')

@section('content')

<div id="loader" style="display:none;">
    <img src="{{ asset('assets/img/logo.png') }}" alt="Loading..." class="loader-img">
</div>

<div class="container-custom py-4">
    <div class="container">
        <h4 class="mb-4 text-theme fw-bold">Dashboard</h4>
        {{-- =======================
            1️⃣ Row: Profile & Current Plan
        ======================== --}}
        <div class="row mb-4">
            <!-- Profile Completion -->
            <div class="col-md-6 mb-3">
                <a href="{{ $authUserId ? route('edit_member', ['id' => $authUserId]) : '#' }}" class="text-decoration-none">
                    <div class="card shadow-sm p-3 h-100 d-flex flex-row align-items-center justify-content-between cursor-pointer hover-translate" style="min-height: 100px;">
                        <!-- Left: Circle + Text -->
                        <div class="d-flex align-items-center">
                            <div class="icon-wrapper me-3">
                                <div class="progress-circle-sm">
                                    <div class="circle" style="width: 50px; height: 50px;">
                                        <div class="inside-circle" style="width: 40px; height: 40px; font-size: 0.9rem;">80%</div>
                                    </div>
                                </div>
                            </div>
                            <div class="text-start">
                                <h6 class="text-theme mb-1" style="font-weight: 600;">Profile Completed</h6>
                                <small class="text-muted">Keep updating to reach 100%</small>
                            </div>
                        </div>

                        <!-- Right: Arrow -->
                        <i class="bi bi-arrow-up-right fs-5 text-theme"></i>
                    </div>
                </a>
            </div>
            <!-- Active Plan -->
            <div class="col-md-6 mb-3">
                <a href="{{ route('member_subscription') }}" class="text-decoration-none">
                    <div class="card shadow-sm p-3 h-100 d-flex flex-row align-items-center justify-content-between cursor-pointer hover-translate" style="min-height: 100px;">
                        <!-- Info on the left -->
                        <div class="text-start">
                            <h6 class="text-theme mb-1" style="font-weight: 600;">Premium Membership</h6>
                            <small class="text-muted">Renews on: 15 Oct 2025</small>
                        </div>

                        <!-- Arrow on the right -->
                        <i class="bi bi-arrow-up-right fs-5 text-theme"></i>
                    </div>
                </a>
            </div>


        </div>
        {{-- =======================
            5️⃣ Row: Upcoming Sessions / Trainers
        ======================== --}}
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="fw-bold text-theme mb-0">Flashbacks of Sachii</h5>
            <a href="{{ route('member_gallary') }}" class="text-decoration-none text-theme fw-semibold small">See all</a>
        </div>
        <div class="row g-3 mb-5">
            <div class="swiper mySwiper">
                <div class="swiper-wrapper">
                    @foreach($galleries as $gallery)
                        <div class="swiper-slide">
                            <div class="card">
                                <img src="{{ asset($gallery->main_thumbnail) }}" 
                                    class="card-img-top" 
                                    alt="{{ $gallery->gallery_name }}">
                                <div class="card-body text-center">
                                    <h6 class="card-title">{{ $gallery->gallery_name }}</h6>
                                    <p class="card-text small text-muted">{{ $gallery->description }}</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <!-- Navigation buttons -->
                <div class="swiper-button-next"></div>
                <div class="swiper-button-prev"></div>
            </div>
        </div>
       
        {{-- =======================
            2️⃣ Row: Recent Blogs
        ======================== --}}
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="fw-bold text-theme mb-0">Recent Blogs</h5>
            <a href="{{ route('member_blogs') }}" class="text-decoration-none text-theme fw-semibold small">See all</a>
        </div>

        <div class="row g-3 mb-5">
            @forelse($blogs as $blog)
                <div class="col-md-3 col-sm-6">
                    <div class="blog-card h-100">
                        <img src="{{ $blog->blog_image ? asset($blog->blog_image) : asset('assets/img/default_blog.jpg') }}" 
                            class="blog-img" 
                            alt="{{ $blog->title }}">
                        <div class="blog-body">
                            <h6 class="fw-semibold text-dark mb-1">{{ $blog->blog_title }}</h6>
                            <small class="text-muted">{{ \Carbon\Carbon::parse($blog->publish_date)->format('d M Y') }}</small>
                        </div>
                    </div>
                </div>
            @empty
                <p class="text-muted">No recent blogs available.</p>
            @endforelse
        </div>

        {{-- =======================
            3️⃣ Row: Meet New Members
        ======================== --}}
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="fw-bold text-theme mb-0">Meet New Members</h5>
            <a href="{{ route('member_my_team') }}" class="text-decoration-none text-theme fw-semibold small">See all</a>
        </div>

        <div class="row g-3">
            @foreach($latestMembers as $member)
                <div class="col-lg-2 col-md-4 col-sm-6 text-center">
                    <a href="{{ route('my_profile', ['id' => $member->id]) }}" class="text-decoration-none ">
                        <div class="card h-100 py-3 shadow-sm cursor-pointer hover-translate">
                            <img 
                                src="{{ $member->profile_image ? asset($member->profile_image) : asset('assets/img/download.png') }}" 
                                class="rounded-circle mx-auto mb-2" 
                                width="70" height="70" 
                                alt="{{ $member->first_name }}">
                            <h6 class="fw-semibold text-dark mb-0">{{ $member->first_name }} {{ $member->last_name }}</h6>
                            <small class="text-muted">Joined {{ \Carbon\Carbon::parse($member->joining_date)->format('M Y') }}</small>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>

        {{-- =======================
            4️⃣ Row: Workout Progress
        ======================== --}}
        <!-- <div class="d-flex justify-content-between align-items-center mb-3 mt-4">
            <h5 class="fw-bold text-theme mb-0">Workout Progress</h5>
            <a href="#" class="text-decoration-none text-theme fw-semibold small">View details</a>
        </div>
        <div class="row g-3">
            <div class="col-md-6">
                <div class="card shadow-sm p-4 h-100">
                    <h6 class="fw-bold text-dark mb-3">Monthly Attendance</h6>
                    <div class="progress mb-2" style="height: 10px;">
                        <div class="progress-bar bg-theme" style="width: 75%;"></div>
                    </div>
                    <small class="text-muted">You attended <span class="text-theme fw-semibold">15</span> out of 20 sessions this month</small>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card shadow-sm p-4 h-100 text-center">
                    <h6 class="fw-bold text-dark mb-3">Calories Burned</h6>
                    <h3 class="fw-bold text-theme mb-1">12,540 kcal</h3>
                    <small class="text-muted">This month’s total activity</small>
                </div>
            </div>
        </div> -->

        
    </div>
</div>
@endsection
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css" />
<style>
    .hover-translate {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .hover-translate:hover {
        transform: translateY(-5px);
        box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
    }
    .container-custom {
        min-height: 80vh;
        background-color: #f5f6fa;
        padding: 20px;
        border-radius: 12px;
    }
    .text-theme { color: #0B1061 !important; }
    .card {
        border: none;
        border-radius: 12px;
    }
    .blog-card {
        border-radius: 12px;
        background: #fff;
        box-shadow: 0 3px 6px rgba(0,0,0,0.1);
        overflow: hidden;
        transition: transform 0.2s ease;
    }
    .blog-card:hover { transform: translateY(-5px); }
    .blog-img {
        width: 100%;
        height: 180px;
        object-fit: cover;
    }
    .blog-body { padding: 12px; }

        /* Profile Completion Circle */
        .progress-circle {
            position: relative;
            width: 100px;
            height: 100px;
        }
    /* Profile Completion Circle */
    .progress-circle-sm {
        position: relative;
        width: 60px;      /* smaller outer circle */
        height: 60px;
    }

    .circle {
        position: relative;
        width: 60px;      /* match smaller size */
        height: 60px;
        background: conic-gradient(#0B1061 0deg 288deg, #e9ecef 288deg 360deg);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .inside-circle {
        position: absolute;
        background: #fff;
        width: 46px;      /* smaller inner circle */
        height: 46px;
        border-radius: 50%;
        font-weight: bold;
        font-size: 0.8rem;  /* smaller font to fit */
        color: #0B1061;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .swiper {
        width: 100%;
        margin-bottom: 0;
    }

    .swiper-wrapper {
        align-items: center;
        height: auto;
        width: auto;
    }

    .swiper-slide {
        display: flex;
        justify-content: center;
        align-items: stretch;
    }

    .swiper-slide .card {
        height: 200px; /* increased for better visibility */
        width: 350px;  /* adjust width if needed */
        border: none;
        border-radius: 15px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        overflow: hidden;
        position: relative;
        transition: transform 0.3s ease;
    }

    .swiper-slide .card img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: opacity 0.3s ease;
    }

    .swiper-slide .card .card-body {
        position: absolute;
        bottom: 0;
        left: 0;
        width: 100%;
        padding: 10px;
        text-align: center;
        background: rgba(0, 0, 0, 0.5); /* semi-transparent background for text */
        color: #fff;
        opacity: 0; /* hidden by default */
        transition: opacity 0.3s ease;
    }

    .swiper-slide .card:hover {
        transform: translateY(-5px);
    }

    .swiper-slide .card:hover img {
        opacity: 0.6; /* reduce image opacity on hover */
    }

    .swiper-slide .card:hover .card-body {
        opacity: 1; /* show text on hover */
    }

    .swiper-button-next,
    .swiper-button-prev {
        color: #0B1061;
        top: 65% !important;
        transform: translateY(-50%);
        width: 35px;
        height: 35px;
        background: rgba(255,255,255,0.8);
        border-radius: 50%;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .swiper-button-next::after,
    .swiper-button-prev::after {
        font-size: 20px;
        font-weight: bold;
    }

    .swiper-pagination {
        margin-top: 5px !important;
        position: relative !important;
    }
</style>

@push('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>
<script>
    const swiper = new Swiper(".mySwiper", 
    {
        slidesPerView: 3,
        spaceBetween: 30,
        loop: true,
        pagination: {
        el: ".swiper-pagination",
        clickable: true,
        },
        navigation: {
        nextEl: ".swiper-button-next",
        prevEl: ".swiper-button-prev",
        },
        breakpoints: {
        0: { slidesPerView: 1 },
        576: { slidesPerView: 2 },
        992: { slidesPerView: 3 }
        }
    });
</script>
@endpush
