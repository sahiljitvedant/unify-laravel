@extends('front.app')

@section('title', 'Careers')

@section('content')
<section id="careers" class="careers-section py-5">
    <div class="container">

        <!-- Heading -->
        <div class="text-center mb-5">
            <h2 class="careers-title">We Are Hiring</h2>
            <p class="careers-subtitle">Join our team and grow with us</p>
            <div class="title-underline"></div>
        </div>

        @if($careers->count())
            <div class="row g-4 justify-content-center">
                @foreach($careers as $career)
                    <div class="col-xl-3 col-lg-4 col-md-6">
                        <div class="career-card">

                            <h5 class="career-title">
                                {{ $career->designation }}
                            </h5>

                            <span class="career-location">
                                <i class="bi bi-geo-alt-fill"></i>
                                {{ $career->location }}
                            </span>

                            <!-- Extra Details -->
                            <div class="career-details">
                                <p><strong>Experience:</strong> {{ $career->experience }}</p>
                                <p><strong>Years:</strong> {{ $career->years_of_experience }}+</p>
                                <p><strong>Work Type:</strong> {{ strtoupper($career->work_type) }}</p>
                            </div>

                            <!-- Apply Button -->
                            

                            <p class="career-btn">
                            <i class="bi bi-send"></i> xyz@gmail.com
                            </p>

                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <!-- Empty State -->
            <div class="text-center mt-5">
                <h5 class="text-muted mb-2">Oops! We’re not hiring right now 😔</h5>
                <p class="text-muted">
                    But don’t worry — exciting opportunities are coming soon.<br>
                    Please check back again or stay connected with us!
                </p>
            </div>
        @endif

    </div>
</section>
@endsection

<style>
    /* ===============================
    Careers – Clean Corporate UI
   =============================== */

    .careers-section {
        background: var(--theme-color);
    }
    .theme
    {
        color: var(--sidebar_color);
    }
    /* Heading */
    .careers-title {
        font-weight: 700;
        color: var(--sidebar_color);
    }

    .careers-subtitle {
        color: #666;
        font-size: var(--front_font_size);
        margin-top: 6px;
    }

    .title-underline {
        width: 60px;
        height: 3px;
        background: var(--sidebar_color);
        margin: 12px auto 0;
        border-radius: 5px;
    }

    /* Card */
    .career-card {
        background:  var(--other_color_fff);
        border-radius: 10px;
        padding: 28px 22px;
        text-align: center;
        border: 1px solid rgba(0,0,0,0.06);
        box-shadow: 0 6px 18px rgba(0,0,0,0.06);
        transition: all 0.3s ease;
        height: 100%;
    }
    .career-title {
        font-size: 17px;
        font-weight: 600;
        color: var(--black_color);
        margin-bottom: 14px;
        /* Ellipsis logic */
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .career-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 14px 32px rgba(0,0,0,0.12);
    }

    /* Title */
    .career-title {
        font-size: 17px;
        font-weight: 600;
        color: var(--black_color);
        margin-bottom: 14px;
    }

    /* Location badge */
    .career-location {
        display: inline-block;
        font-size: 13px;
        color: var(--sidebar_color);
        background: rgba(0,0,0,0.04);
        padding: 6px 12px;
        border-radius: 20px;
        margin-bottom: 22px;
    }

    /* Button */
    .career-btn {
        display: inline-block;
        background: var(--sidebar_color);
        color: #fff;
        font-size: 14px;
        padding: 8px 26px;
        border-radius: 25px;
        transition: all 0.3s ease;
        text-decoration: none;
    }

    /* .career-btn:hover {
        background: var(--sidebar_light);
        color: #fff;
    } */
    /* Job details */
    .career-details {
        font-size: 13px;
        color: #555;
        margin-bottom: 18px;
        line-height: 1.6;
    }

    .career-details p {
        margin-bottom: 4px;
    }


</style>