@extends('front.app')

@section('content')
<!-- BLOG DETAILS SECTION -->
<section id="blog-details" class="blog-details py-5">
    <!-- Back Button outside container -->
    <div class="container">
        <div class="back-btn mb-3 px-3">
            <a href="javascript:void(0);" onclick="history.back()" class="btn-read">
                <i class="bi bi-arrow-left fs-5 me-1 align-middle"></i> Back
            </a>
        </div>
        <div class="blog-cardd">

            <!-- Blog Image -->
            <img src="{{ $blog->blog_image ? asset($blog->blog_image) : 'https://images.unsplash.com/photo-1605296867424-35fc25c9212a?w=1200' }}" 
            class="blog-image mb-3" 
            alt="{{ $blog->blog_title }}">


            <!-- Publish Date -->
            <span class="blog-date mb-3 d-block">
                Published on: {{ \Carbon\Carbon::parse($blog->publish_date)->format('d M Y') }}
            </span>

            <!-- Blog Content -->
            <div class="blog-content">
                <h2 class="blog-title mb-3">{{ $blog->blog_title }}</h2>
                <p class="blog-description mb-4">
                    {{ $blog->description }}
                </p>
            </div>
        </div>
    </div>
</section>
@endsection


<style>
    .blog-image-container{
        padding: 20px;
        border-radius: 40px;
    }
    .blog-date
    {
        padding-left: 20px;
    }
    .blog-details {
        background: #f8f9fa;
        min-height: 100vh;
        padding-top: 60px;
        padding-bottom: 60px;
    }

    .blog-cardd
    {
        background: #f2f2f2;
        border-radius: 20px;
    }

    .back-btn a {
        text-decoration: none;
        font-weight: 500;
        color: #0B1061;
        transition: 0.3s;
    }

    .back-btn a:hover {
        text-decoration: underline;
    }

    .blog-image {
        width: 100%;
        max-height: 500px;
        object-fit: cover;
        border-radius: 12px;
        margin-bottom: 15px; /* space below image */
    }

    .blog-date {
        font-size: 0.95rem;
        color: #888;
    }

    .blog-title {
        font-size: 2rem;
        font-weight: 700;
        color: #0B1061;
    }

    .blog-description {
        font-size: 1rem;
        color: #555;
        line-height: 1.8;
    }

    .btn-read {
        display: inline-block;
        color: #0B1061;
        font-weight: 600;
        text-decoration: none;
    }

    .btn-read:hover {
        text-decoration: underline;
    }
</style>
