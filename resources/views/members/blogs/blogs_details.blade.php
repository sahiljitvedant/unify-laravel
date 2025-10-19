@extends('members.layouts.app')
@section('title', 'Blog Details')
@section('content')
<div id="loader" style="display:none;">
    <img src="{{ asset('assets/img/logo.png') }}" alt="Loading..." class="loader-img">
</div>
<div class="container-custom py-4">  
    <div class="container">
        <a href="{{ url()->previous() }}" class="btn-back mb-3">
            <i class="bi bi-arrow-left"></i>
            <span class="btn-text">Back</span>
        </a>
        <!-- Blog Thumbnail -->
        <div class="card position-relative overflow-hidden mb-1" style="height: 300px;">
            <img src="{{ $blogs->blog_image ? asset($blogs->blog_image) : asset('assets/img/download.png') }}" 
                 class="card-img-top" 
                 style="object-fit: cover; width: 100%; height: 100%;" 
                 alt="{{ ucfirst($blogs->blog_title) }}">
            
            <div class="position-absolute top-0 start-0 w-100 h-100 d-flex align-items-center justify-content-center overlay">
                <!-- optional title overlay removed -->
            </div>
        </div>
        <!-- Blog Full Details -->
        <div class="card shadow-sm border-0 rounded-3">
            <div class="card-body">

                <div class="row mb-3">
                    <div class="col-md-6">
                        <!-- Blog Title -->
                        <div class="d-flex align-items-center gap-2 mb-2">
                            <i class="bi bi-card-text text-theme fs-13"></i>
                            <p class="mb-0 fw-semibold text-dark fs-14">{{ ucfirst($blogs->blog_title) }}</p>
                        </div>

                        <!-- Publish Date -->
                        <div class="d-flex align-items-center gap-2">
                            <i class="bi bi-calendar-event text-theme fs-13"></i>
                            <p class="mb-0 fw-text-dark fs-14">{{ \Carbon\Carbon::parse($blogs->publish_date)->format('d M Y') }}</p>
                        </div>
                    </div>
                </div>


                <hr>

                <h6 class="fw-semibold text-theme mb-2">Description</h6>
                    <div class="text-dark mb-3 fs-12">
                        {!! $blogs->description !!}
                    </div>
            </div>
        </div>
    </div>
</div>
@endsection
<style>
    .fs-14 {
        font-size: 14px;
    }
    .fs-12 {
        font-size: 12px;
    }
    .fs-10 
    {
        font-size: 10px;
        line-height: 1.6; 
        text-align: justify; 
    }
    .overlay {
        background: rgba(0,0,0,0.4);
        text-transform: capitalize;
    }
    .text-dark.mb-3.fs-12
    {
        text-align: justify;
    }
    @media (max-width: 768px) 
    {
        .container
        {
            padding: 1px !important;
        }
        .btn-back {
            display: block;
            text-align: left;
            justify-content: flex-start;
        }
        .btn-text {
            display: inline-block;
            margin-left: 5px;
        }
        .fw-semibold.text-theme.mb-2
        {
            text-align: left !important;
        }
        .fs-10 
        {
            text-align: left; 
        }
    }
</style>
