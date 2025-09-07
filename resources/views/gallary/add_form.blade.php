@extends('layouts.app')

@section('title', 'Add Gallery')

@section('content')
<div class="container-custom">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('list_dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="#">Gallery</a></li>
            <li class="breadcrumb-item" aria-current="page">Add Gallery</li>
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
                <input type="text" class="form-control" name="gallery_name" id="gallery_name" 
                    placeholder="Enter gallery name">
                <div class="text-danger error-message" data-error-for="gallery_name"></div>
            </div>

            <!-- Status -->
            <div class="col-md-6 col-12">
                <label class="form-label required">{{ __('membership.active_label') }}</label>
                <select class="form-select" name="is_active" id="is_active">
                    <option disabled selected>{{ __('membership.select_status') }}</option>
                    <option value="1">{{ __('membership.active') }}</option>
                    <option value="0">{{ __('membership.inactive') }}</option>
                </select>
                <div class="text-danger error-message" data-error-for="is_active"></div>
            </div>
        </div>

        <!-- Main Thumbnail -->
        <div class="row g-3 mt-3">
            <div class="col-12">
                <label class="form-label required">Main Thumbnail</label>
                <!-- Hidden input -->
                <input type="file" class="form-control d-none" name="main_thumbnail" id="main_thumbnail" accept=".jpeg,.jpg,.png">
                <!-- Upload button -->
                <button type="button" class="btn btn-primary" id="uploadThumbnailBtn">Upload Thumbnail</button>
                <div class="text-danger error-message" data-error-for="main_thumbnail"></div>

                <!-- Preview -->
                <div class="mt-2 position-relative d-inline-block" id="thumbnailWrapper" style="display:none;">
                <img id="thumbnailPreview" src="" alt="Thumbnail" style="max-width:150px; border:1px solid #ddd; border-radius:5px;">
                <button type="button" class="btn btn-sm btn-danger position-absolute top-0 end-0 remove-thumbnail">&times;</button>
                </div>
            </div>
        </div>

        <!-- Multiple Images -->
        <div class="row g-3 mt-3">
        <div class="col-12">
            <label class="form-label">Gallery Images</label>
            <!-- Hidden input -->
            <input type="file" class="form-control d-none" name="gallery_images[]" id="gallery_images" accept=".jpeg,.jpg,.png" multiple>
            <!-- Upload button -->
            <button type="button" class="btn btn-primary" id="uploadGalleryBtn">Upload Images</button>
            <div class="text-danger error-message" data-error-for="gallery_images"></div>

            <!-- Preview area -->
            <div class="mt-2 d-flex flex-wrap gap-2" id="galleryPreview"></div>
        </div>
        </div>

        <!-- YouTube Links with Add/Remove -->
        <div class="row g-3 mt-3">
            <div class="col-12">
                <label class="form-label">YouTube Links</label>
                <div id="youtubeLinksWrapper"></div> <!-- start empty -->
                <div class="text-danger error-message" data-error-for="youtube_links[]"></div>
                <button type="button" class="btn btn-primary mt-2" id="addYoutubeLink">+ Add Link</button>
            </div>
        </div>
    </div>

    <!-- Buttons -->
    <div class="text-end mt-4">
        <a href="#" class="btn btn-secondary me-2 cncl_btn">
            Cancel
        </a>
        <button type="submit" class="btn" id="submitBtn">{{ __('membership.submit_button') }}</button>
    </div>
</form>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
const submitGallary = "{{ route('add_gallery') }}";
</script>

<script src="{{ asset('assets/js/gallary/add_gallary.js') }}"></script>

<script>
  // Trigger file inputs on button click
$('#uploadThumbnailBtn').on('click', function() {
    $('#main_thumbnail').click();
});

$('#uploadGalleryBtn').on('click', function() {
    $('#gallery_images').click();
});

// Thumbnail preview + remove
$('#main_thumbnail').on('change', function() {
    const file = this.files[0];
    if (file && /\.(jpe?g|png)$/i.test(file.name)) {
        const reader = new FileReader();
        reader.onload = function(e) {
            $('#thumbnailPreview').attr('src', e.target.result);
            $('#thumbnailWrapper').show();
        }
        reader.readAsDataURL(file);
    }
});

$(document).on('click', '.remove-thumbnail', function() {
    let input = document.getElementById('main_thumbnail');
    let dt = new DataTransfer(); // empty file list
    input.files = dt.files;      // reset the file input
    $('#thumbnailWrapper').hide();
    $('#thumbnailPreview').attr('src', '');
});

// Gallery images preview + remove
$('#gallery_images').on('change', function() {
    $('#galleryPreview').html('');
    const files = Array.from(this.files);

    files.forEach((file, index) => {
        if (/\.(jpe?g|png)$/i.test(file.name)) {
            const reader = new FileReader();
            reader.onload = function(e) {
                $('#galleryPreview').append(`
                    <div class="position-relative d-inline-block" style="max-width:100px;">
                        <img src="${e.target.result}" style="max-width:100px; max-height:100px; border:1px solid #ddd; border-radius:5px;">
                        <button type="button" class="btn btn-sm btn-danger position-absolute top-0 end-0 remove-image" data-index="${index}">&times;</button>
                    </div>
                `);
            }
            reader.readAsDataURL(file);
        }
    });
});

// Remove selected gallery image
$(document).on('click', '.remove-image', function() {
    const index = $(this).data('index');
    let dt = new DataTransfer();
    let input = document.getElementById('gallery_images');
    let { files } = input;

    // Rebuild FileList without the removed file
    Array.from(files).forEach((file, i) => {
        if (i !== index) dt.items.add(file);
    });

    input.files = dt.files;
    $(this).parent().remove();
});

</script>

<style>
    /* Keep label normal even if checkbox is disabled */
    .form-check-input:disabled + .form-check-label {
        color: inherit !important;
        opacity: 1 !important;
    }
</style>
@endsection
