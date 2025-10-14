@extends('layouts.app')

@section('title', 'Edit FAQS')

@section('content')
<div class="container-custom">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('list_dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('list_faqs') }}">FAQS</a></li>
            <li class="breadcrumb-item" aria-current="page">Edit FAQ</li>
        </ol>
    </nav>

    <form id="faq_edit_form" class="p-4 bg-light rounded shadow">
        <h4 class="mb-4">Edit FAQ</h4>

        <div class="row g-3">
            <div class="col-md-12">
                <label class="form-label required">Question</label>
                <input type="text" class="form-control" name="question" 
                    value="{{ old('question', $faq->question) }}">
                    <div class="text-danger error-message" data-error-for="question"></div>
            </div>
            <div class="col-md-12">
                <label class="form-label required">Answer</label>
                <textarea id="answer" class="form-control" name="answer" rows="4">{{ old('answer', $faq->answer) }}</textarea>

                <div class="text-danger error-message" data-error-for="answer"></div>
            </div>
            <div class="col-md-12">
                <label class="form-label">FAQ Image</label>
                <div id="faqImageWrapper">
                    @if($faq->faq_image)
                        <img id="previewFaqImage" 
                            src="{{ asset($faq->faq_image) }}" 
                            class="img-thumbnail mb-2" 
                            style="max-width:200px; border-radius:10px;">
                    @else
                        <img id="previewFaqImage" 
                            src="" 
                            class="img-thumbnail mb-2 d-none" 
                            style="max-width:200px; border-radius:10px;">
                    @endif
                </div>

                <input type="hidden" name="faq_image" id="faq_image_path" 
                    value="{{ old('faq_image', $faq->faq_image) }}">

                <button type="button" class="profilebtn mt-2" id="uploadFaqButton" data-type="faq_image">
                    Change FAQ Image
                </button>
            </div>

            <div class="col-md-6">
                <label class="form-label required">Status</label>
                <select class="form-control" name="is_active">
                    <option value="1" {{ old('is_active', $faq->status) == 1 ? 'selected' : '' }}>Active</option>
                    <option value="0" {{ old('is_active', $faq->status) == 0 ? 'selected' : '' }}>Inactive</option>
                </select>

            </div>
            <div class="col-md-12">
                <label class="form-label">YouTube Link</label>
                <input type="text" class="form-control" name="youtube_link"
                    value="{{ old('youtube_link', $faq->youtube_link) }}">
                    <div class="text-danger error-message" data-error-for="youtube_link"></div>
            </div>
        </div>

        <div class="text-end mt-4">
            <a href="{{ route('list_faqs') }}" class="btn btn-secondary me-2 cncl_btn">
                Cancel
            </a>
            <button type="submit" class="btn" id="submitBtn">Submit</button>

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
    const submitfaq = "{{ route('update_faqs', ['id' => $faq->id]) }}";
</script>
<script src="{{ asset('assets/js/global/image_crop.js') }}"></script>
<script src="{{ asset('assets/js/faqs/edit_faq.js') }}"></script>
@endpush
