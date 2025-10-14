@extends('layouts.app')

@section('title', 'Add FAQS')

@section('content')
<div class="container-custom">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('list_dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('list_faqs') }}">FAQS</a></li>
            <li class="breadcrumb-item" aria-current="page">Add FAQ</li>
        </ol>
    </nav>

    <form id="faq_add_form" class="p-4 bg-light rounded shadow">
        <h4 class="mb-4">Add FAQ</h4>

        <div class="row g-3">
            <div class="col-12">
                <label class="form-label required">Question</label>
                <input type="text" class="form-control" name="question" id="question" placeholder="Enter your question">
                <div class="text-danger error-message" data-error-for="question"></div>
            </div>

            <div class="col-12">
                <label class="form-label required">Answer</label>
                <textarea class="form-control" name="answer" id="answer" rows="4" placeholder="Enter the answer"></textarea>
                <div class="text-danger error-message" data-error-for="answer"></div>
            </div>
            <div class="col-6 ">
                <label class="form-label d-block mb-2 ">Upload FAQ Image</label>

                <!-- Preview wrapper (hidden by default) -->
                <div class="faq-image-wrapper d-none" id="faqImageWrapper">
                    <img id="previewFaqImage" class="faq-preview-image" style="max-width:200px; border-radius:10px;">
                </div>

                <div class="text-danger error-message" data-error-for="faq_image"></div>

                <!-- Upload button -->
                <button type="button" class="profilebtn mt-2" id="uploadFaqButton" data-type="faq_image">
                    Upload FAQ Image
                </button>
            </div>
            <div class="col-md-6 col-12">
                <label class="form-label required">{{ __('membership.active_label') }}</label>
                <select class="form-control" name="is_active" id="is_active">
                    <option disabled selected>{{ __('membership.select_status') }}</option>
                    <option value="1">{{ __('membership.active') }}</option>
                    <option value="0">{{ __('membership.inactive') }}</option>
                </select>
                <div class="text-danger error-message" data-error-for="is_active"></div>
            </div>
            <div class="col-12">
                <label class="form-label">YouTube Link (Optional)</label>
                <input type="url" class="form-control" name="youtube_link" id="youtube_link" placeholder="Enter YouTube URL">
                <div class="text-danger error-message" data-error-for="youtube_link"></div>
            </div>
        </div>

        <div class="text-end mt-4">
           
            <a href="{{ route('list_faqs') }}" class="btn btn-secondary me-2 cncl_btn">
                Cancel
            </a>
     
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
<style>
    /* Keep label normal even if checkbox is disabled */
    .form-check-input:disabled + .form-check-label 
    {
        color: inherit !important;
        opacity: 1 !important;
    }
    .profilebtn{
        background: #0b1061;
        color: #fff;
        border: 5px solid #0b1061 !important;
        border-radius: 5px
    }
   
</style>
@endsection
@push('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

<!-- ✅ CKEditor 5 Classic build -->
<script src="https://cdn.ckeditor.com/ckeditor5/41.3.1/classic/ckeditor.js"></script>

<script>
    const uploadUrl  = "{{ route('profile.cropUpload') }}";
    const submitfaq = "{{ route('add_faq') }}";
</script>
<script src="{{ asset('assets/js/global/image_crop.js') }}"></script>
<script src="{{ asset('assets/js/faqs/add_faqs.js') }}"></script>
@endpush
