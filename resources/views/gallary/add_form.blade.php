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
        

            <div class="col-6 ">
                <label class="form-label d-block mb-2 ">Upload Gallary Image</label>

                <!-- Preview wrapper (hidden by default) -->
                <div class="gallary-image-wrapper d-none" id="galleryThumbWrapper">
                    <img id="previewGallaryImage" class="gallary-preview-image" style="max-width:200px; border-radius:10px;">
                </div>

                <div class="text-danger error-message" data-error-for="gallary_image"></div>

                <!-- Upload button -->
                <button type="button" class="profilebtn mt-2" id="uploadGallaryButton" data-type="gallary_image">
                    Upload Gallry Image
                </button>
            </div>


            <!-- Multiple Gallery Images (Crop 500x500 each) -->
            <div class="col-12 text-center mt-4">
                <label class="form-label d-block mb-2">Gallery Images (500x500)</label>

                <div id="multiGalleryWrapper" class="d-flex flex-wrap justify-content-center gap-3"></div>
                <div class="text-danger error-message" data-error-for="gallery_images[]"></div>

                <button type="button" class="profilebtn mt-2" id="uploadMultipleGallery" data-type="gallery_images">
                    Upload Gallery Images
                </button>
            </div>

            <!-- YouTube Links -->
            <div class="row g-3 mt-4">
                <div class="col-12">
                    <label class="form-label">YouTube Links</label>
                    <div id="youtubeLinksWrapper"></div>
                    <div class="text-danger error-message" data-error-for="youtube_links[]"></div>
                    <button type="button" class="btn btn-primary mt-2" id="addYoutubeLink">+ Add Link</button>
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
<div class="modal fade" id="cropImageModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-md modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <!-- We'll update this title dynamically via JS -->
                <h5 class="modal-title" id="cropModalTitle">Upload Image</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body d-flex flex-column">

                <!-- Image Preview -->
                <div class="text-center mb-3" id="imagePreviewContainer" style="display:none;">
                    <img id="imageToCrop" style="max-width: 100%; border-radius:10px;">
                </div>

                <!-- Progress Bar -->
                <div class="progress mb-3" id="uploadProgress" style="display:none;">
                    <div class="progress-bar" role="progressbar" style="width:0%">0%</div>
                </div>

                <!-- Buttons -->
                <div class="d-flex justify-content-center gap-2 mt-auto">
                    <input type="file" id="browseImage" accept="image/*" class="d-none">
                    <button type="button" id="browseBtn" class="btn btn-secondary">Browse</button>
                    <button type="button" id="uploadCropped" class="btn btn-primary" disabled>Upload</button>
                </div>

            </div>
        </div>
    </div>
</div>

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

    .profilebtn {
        background: #0b1061;
        color: #fff;
        border: 5px solid #0b1061 !important;
        border-radius: 5px;
    }

    .progressbar {
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .circle {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: #ddd;
        color: #000;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
    }

    .circle.active {
        background: #0b1061;
        color: #fff;
    }

    .circle.completed {
        background: #28a745;
        color: #fff;
    }

    .line {
        flex: 1;
        height: 4px;
        background: #ddd;
    }

    .line.active {
        background: #28a745;
    }
</style>
@endsection
