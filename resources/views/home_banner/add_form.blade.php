@extends('layouts.app')

@section('title', 'Add Home Banner')

@section('content')
<div class="container-custom">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('list_dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('home_banner') }}">Home Banner</a></li>
            <li class="breadcrumb-item" aria-current="page">Add Home Banner</li>
        </ol>
    </nav>

    <form id="faq_add_form" class="p-4 bg-light rounded shadow">
        <h4 class="mb-4">Add Home Banner</h4>

        <div class="row g-3">
            <div class="col-12">
                <label class="form-label required">Title</label>
                <input type="text" class="form-control" name="title" id="title" placeholder="Enter your title">
                <div class="text-danger error-message" data-error-for="title"></div>
            </div>

            <div class="col-12">
                <label class="form-label required">Sub Title</label>
                <input type="text" class="form-control" name="sub_title" id="sub_title" placeholder="Enter your sub title">
                <div class="text-danger error-message" data-error-for="sub_title"></div>
            </div>
            <div class="col-6 ">
                <label class="form-label d-block mb-2 ">Upload Banner Image</label>

                <!-- Preview wrapper (hidden by default) -->
                <div class="faq-image-wrapper d-none" id="faqImageWrapper">
                    <img id="previewFaqImage" class="faq-preview-image" style="max-width:200px; border-radius:10px;">
                </div>

                <div class="text-danger error-message" data-error-for="faq_image"></div>

                <!-- Upload button -->
                <button type="button" class="profilebtn mt-2" id="uploadFaqButton" data-type="faq_image">
                    Upload Banner Image
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
           
        </div>

        <div class="text-end mt-4">
           
            <a href="{{ route('home_banner') }}" class="btn btn-secondary me-2 cncl_btn">
                Cancel
            </a>
     
            <button type="submit" class="btn" id="submitBtn">{{ __('membership.submit_button') }}</button>
        </div>
    </form>

</div>
<!-- Crop Image Modal -->
@include('layouts.crop')
<style>
    /* Keep label normal even if checkbox is disabled */
    .form-check-input:disabled + .form-check-label 
    {
        color: inherit !important;
        opacity: 1 !important;
    }
</style>
@endsection
@push('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.ckeditor.com/ckeditor5/41.3.1/classic/ckeditor.js"></script>
<script>
    const uploadUrl  = "{{ route('profile.cropUpload') }}";
    const submitBanner = "{{ route('add_home_banner') }}";
</script>
<script src="{{ asset('assets/js/global/image_crop.js') }}"></script>
<script src="{{ asset('assets/js/home_banner/add_banner.js') }}"></script>
@endpush
