@extends('layouts.app')
@section('title', 'Add Gallery')
@section('content')
<div class="container-custom">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('list_dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('list_gallery') }}">Gallery</a></li>
            <li class="breadcrumb-item active" aria-current="page">Add Gallery</li>
        </ol>
    </nav>

    <form id="add_gallery" class="p-4 bg-light rounded shadow">
        <!-- Form Heading -->
        <h4 class="mb-4">Add Gallery</h4>

        <div class="step" data-step="2">
            <div class="row g-3">
                <!-- Gallery Name -->
                <div class="col-md-6 col-12">
                    <label class="form-label required">Gallery Name</label>
                    <input type="text" class="form-control" name="gallery_name" id="gallery_name" placeholder="Enter gallery name">
                    <div class="text-danger error-message" data-error-for="gallery_name"></div>
                </div>

                <!-- Status -->
                <div class="col-md-6 col-12">
                    <label class="form-label required">{{ __('membership.active_label') }}</label>
                    <select class="form-control" name="is_active" id="is_active">
                        <option disabled selected>{{ __('membership.select_status') }}</option>
                        <option value="1">{{ __('membership.active') }}</option>
                        <option value="0">{{ __('membership.inactive') }}</option>
                    </select>
                    <div class="text-danger error-message" data-error-for="is_active"></div>
                </div>
            </div>
            <div class="row g-3">
        

            <div class="col-md-6 col-12 mt-4">
                <label class="form-label d-block mb-2 required ">Upload Gallary Image</label>

                <!-- Preview wrapper (hidden by default) -->
                <div class="gallary-image-wrapper d-none" id="galleryThumbWrapper">
                    <img id="previewGallaryImage" class="gallary-preview-image" style="max-width:200px; border-radius:10px;">
                </div>

                <div class="text-danger error-message" data-error-for="gallary_image"></div>

                <!-- Upload button -->
                <button type="button" class="profilebtn mt-2" id="uploadGallaryButton" data-type="gallary_image">
                    Upload Gallary Image
                </button>
            </div>


            <!-- Multiple Gallery Images (Crop 500x500 each) -->
            <div class="col-md-6 col-12 mt-4">
                <label class="form-label d-block mb-2">Gallery Images (500x500)</label>

                <div id="multiGalleryWrapper" class="d-flex flex-wrap justify-content-center gap-3"></div>
                <div class="text-danger error-message" data-error-for="gallery_images[]"></div>

                
                <button type="button" class="profilebtn mt-2" id="uploadMultipleGallery" data-type="gallery_multiple" onclick="handleMultipleGalleryUpload()">
                    Upload Gallery Images
                </button>

            </div>

            <!-- YouTube Links -->
            <div class="row g-3 mt-4">
                <div class="col-12">
                    <label class="form-label">YouTube Links</label>
                    <div id="youtubeLinksWrapper"></div>
                    <div class="text-danger error-message" data-error-for="youtube_links[]"></div>
                    <button type="button" class="btn youtube_button mt-2" id="addYoutubeLink">+ Add Link</button>
                </div>
            </div>
        </div>

        <!-- Buttons -->
        <div class="text-end mt-4">
            <a href="#" class="btn btn-secondary me-2 cncl_btn">Cancel</a>
            <button type="submit" class="btn" id="submitBtn">{{ __('membership.submit_button') }}</button>
        </div>
    </form>
</div>
<!-- Crop Image Modal -->
@include('layouts.crop')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
const submitGallary = "{{ route('add_gallery') }}";
const uploadUrl = "{{ route('profile.cropUpload') }}"; // same controller handles crop upload
</script>
<script src="{{ asset('assets/js/global/image_crop.js') }}"></script>
<script src="{{ asset('assets/js/gallary/add_gallary.js') }}"></script>

<style>
    .blog-image-wrapper {
        width: 100%;
        height: 100px;
        overflow: hidden;
        border-radius: 10px;
        border: 1px solid #ddd;
        margin-bottom: 10px;
        display: flex;
        justify-content: center;
        align-items: center;
        background: #f5f5f5;
    }

    .blog-preview-image {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

 
    .youtube_button,.youtube_button:hover
    {
        background: #0b1061;
        color: #fff;
        border: 1px solid #0b1061 !important;
        border-radius: 5px;
        font-size:12px;
    }
  
</style>
@endsection
