@extends('layouts.app')
@section('title', 'Edit Gallery')
@section('content')
<div class="container-custom">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('list_dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('list_gallery') }}">Gallery</a></li>
            <li class="breadcrumb-item active" aria-current="page">Edit Gallery</li>
        </ol>
    </nav>

    <form id="edit_gallery" class="p-4 bg-light rounded shadow">
        <h4 class="mb-4">Edit Gallery</h4>

        <div class="step" data-step="2">
            <div class="row g-3">
                <!-- Gallery Name -->
                <div class="col-md-6 col-12">
                    <label class="form-label required">Gallery Name</label>
                    <input type="text" class="form-control" name="gallery_name" id="gallery_name" placeholder="Enter gallery name" value="{{ old('gallery_name', $gallery->gallery_name) }}">
                    <div class="text-danger error-message" data-error-for="gallery_name"></div>
                </div>

                <!-- Status -->
                <div class="col-md-6 col-12">
                    <label class="form-label required">{{ __('membership.active_label') }}</label>
                    <select class="form-control" name="is_active" id="is_active">
                        <option disabled {{ $gallery->is_active === null ? 'selected' : '' }}>{{ __('membership.select_status') }}</option>
                        <option value="1" {{ $gallery->is_active == 1 ? 'selected' : '' }}>{{ __('membership.active') }}</option>
                        <option value="0" {{ $gallery->is_active == 0 ? 'selected' : '' }}>{{ __('membership.inactive') }}</option>
                    </select>
                    <div class="text-danger error-message" data-error-for="is_active"></div>
                </div>
            </div>

            <div class="row g-3 mt-4">
                <!-- Main Gallery Image -->
                <div class="col-md-6 col-12">
                    <label class="form-label d-block mb-2 required">Upload Gallery Image</label>

                    <div class="gallary-image-wrapper {{ $gallery->main_thumbnail ? '' : 'd-none' }}" id="galleryThumbWrapper">
                        <img id="previewGallaryImage" class="gallary-preview-image" style="max-width:200px; border-radius:10px;" 
                            src="{{ $gallery->main_thumbnail ? asset($gallery->main_thumbnail) : '' }}">
                    </div>

                    <div class="text-danger error-message" data-error-for="gallary_image"></div>

                    <button type="button" class="profilebtn mt-2" id="uploadGallaryButton" data-type="gallary_image">
                        Upload Gallery Image
                    </button>


                    <input type="hidden" name="gallary_image_path" id="gallary_image_path" 
                    value="{{ $gallery->main_thumbnail ? asset($gallery->main_thumbnail) : '' }}">
                </div>

                
                <!-- Multiple Gallery Images -->
                  
                <div class="col-md-6 col-12">
                    <label class="form-label d-block mb-2">Gallery Images (500x500)</label>

                    <div id="multiGalleryWrapper" class="d-flex flex-wrap gap-3">
                        @php
                            $images = $gallery->gallery_images
                                        ? (is_array($gallery->gallery_images) 
                                            ? $gallery->gallery_images 
                                            : json_decode($gallery->gallery_images, true)) 
                                        : [];
                            $image_urls = '';
                        @endphp

                        @foreach($images as $image)
                            <div class="gallery-thumb-wrapper position-relative d-inline-block m-2" data-path="{{ $image }}">
                                <img src="{{ asset($image) }}" 
                                    style="width:100px;height:100px;object-fit:cover;border-radius:10px; border:1px solid #ddd;">
                                <button type="button" class="btn btn-sm btn-danger position-absolute top-0 end-0 remove-image" 
                                        style="padding:2px 6px; font-size:14px;">&times;</button>
                            </div>
                            @php
                                $image_urls .= $image.',';
                            @endphp
                        @endforeach
                    </div>
                    <!-- Hidden input to store gallery image paths -->


                    <div class="text-danger error-message" data-error-for="gallery_images[]"></div>

                    <button type="button" class="profilebtn mt-2" id="uploadMultipleGallery" data-type="gallery_multiple">
                        Upload Gallery Images
                    </button>
                </div>
            </div>
            <input type="hidden" name="gallery_images" id="gallery_images_path" id="" value="{{trim($image_urls, ',')}}">
            <!-- YouTube Links -->
            <div class="row g-3 mt-4">
                <div class="col-12">
                    <label class="form-label">YouTube Links</label>
                    <div id="youtubeLinksWrapper">
                        @if($gallery->youtube_links)
                            @php
                                $youtubeLinks = is_array($gallery->youtube_links) 
                                                ? $gallery->youtube_links 
                                                : json_decode($gallery->youtube_links, true);
                            @endphp

                            @foreach($youtubeLinks as $link)
                                <div class="d-flex mb-2 youtube-link-row">
                                    <input type="url" class="form-control youtube-input" name="youtube_links[]" value="{{ $link }}" placeholder="Enter YouTube link">
                                    <button type="button" class="btn btn-danger ms-2 remove-link">-</button>
                                </div>
                            @endforeach
                        @endif
                    </div>
                    <div class="text-danger error-message" data-error-for="youtube_links[]"></div>
                    <button type="button" class="btn youtube_button mt-2" id="addYoutubeLink">+ Add Link</button>
                </div>
            </div>

        </div>

        <!-- Buttons -->
        <div class="text-end mt-4">
            <a href="{{ route('list_gallery') }}" class="btn btn-secondary me-2 cncl_btn">Cancel</a>
            <button type="submit" class="btn" id="submitBtn">Update Gallery</button>
        </div>
    </form>
</div>
<!-- Crop Image Modal -->
@include('layouts.crop')
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
<script>
const submitGalleryUpdate = "{{ route('update_gallery', $gallery->id) }}"; // Update route
const uploadUrl = "{{ route('profile.cropUpload') }}"; // same controller handles crop upload
</script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="{{ asset('assets/js/global/image_crop.js') }}"></script>
<script src="{{ asset('assets/js/gallary/edit_gallary.js') }}"></script> 
@endsection
