@extends('members.layouts.app')

@section('title', 'Gallery')

@section('content')
<div id="loader" style="display:none;">
    <img src="{{ asset('assets/img/logo.png') }}" alt="Loading..." class="loader-img">
</div>

<div class="container-custom py-4">  
    <div class="container">
        <a href="{{ route('member_gallary') }}" class="btn-back mb-2">
            <i class="bi bi-arrow-left"></i>
            <span class="btn-text">Back</span>
        </a>

        <!-- Main Thumbnail -->
        <div class="card position-relative overflow-hidden mb-3" style="height: 300px;">
            <img src="{{ asset($gallery->main_thumbnail) }}" class="card-img-top" style="object-fit: cover; width: 100%; height: 100%;" alt="{{ ucfirst($gallery->gallery_name) }}">
            
            <!-- Overlay with Gallery Name -->
            <div class="position-absolute top-0 start-0 w-100 h-100 d-flex align-items-center justify-content-center overlay">
                <h2 class="text-white text-center px-2">{{ ucfirst($gallery->gallery_name) }}</h2>
            </div>
        </div>

        <!-- Gallery Images -->
        @php
            $images = $gallery->gallery_images ?? [];
        @endphp

        <!-- Wrapper for all gallery images -->
        <div class="gallery-images-wrapper border p-3 rounded">
            <div class="row g-2">
                @foreach($images as $img)
                    @php
                        // Define image path inside the loop
                        $imagePath = $img && file_exists(public_path($img)) 
                                    ? asset($img) 
                                    : asset('assets/img/download.png');
                    @endphp

                    <div class="col-12 col-sm-6 col-md-3">
                        <div class="gallery-image">
                            <img src="{{ $imagePath }}" alt="Gallery Image" class="img-thumbnail">
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

      
    </div>
</div>
@endsection
<style>
      .container-custom {
        min-height: 80vh;
        background-color: #f5f6fa;
        padding: 20px;
        border-radius: 12px;
    }
    /* Back Button */
    .btn-back:hover {
        color: #05093a;
        transform: translateX(-3px);
    }
    .btn-back i {
        font-size: 18px;
    }
    .btn-text {
        font-size: 14px;
    }
    .btn-back {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        color: #0B1061;
        font-size: 22px;
        text-decoration: none;
        border: none;
        background: none;
        padding: 0;
        transition: transform 0.15s ease-in-out;
    }

    /* Overlay */
    .overlay {
        background: rgba(0,0,0,0.4);
        text-transform: capitalize;
    }

    /* Gallery images */
    .gallery-image img {
        width: 100%;
        height: 250px;
        object-fit: cover;
        border: none; /* remove white border */
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        cursor: pointer; /* pointer on hover */
    }
    .gallery-image img:hover {
        transform: scale(1.05); /* pop-out effect */
        box-shadow: 0 8px 20px rgba(0,0,0,0.3);
    }
   
    /* Responsive adjustments */
    @media (max-width: 768px) {
        .btn-back {
        display: block;           /* full width */
        text-align: left;         /* left align content */
        justify-content: flex-start; /* optional */
    }

    .btn-text {
        display: inline-block;
        margin-left: 5px;
        padding-left: 0;
        text-align: left;
    }

        /* 1 image per row on mobile */
        .col-12.col-sm-6.col-md-3 {
            flex: 0 0 100%;
            max-width: 100%;
        }

        .mb-3 {
            text-align: left !important;
        }
    }

</style>


