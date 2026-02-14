@extends('layouts.app')

@section('title', 'Add Testimonial')

@section('content')
<div class="container-custom">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('list_dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('list_testimonials') }}">Testimonials</a></li>
            <li class="breadcrumb-item active">Add Testimonial</li>
        </ol>
    </nav>

    <form id="testimonial_add_form" class="p-4 bg-light rounded shadow">
        <h4 class="mb-4">Add Testimonial</h4>

        <div class="row g-3">

            <!-- Client Name -->
            <div class="col-md-6 col-12">
                <label class="form-label required">Client Name</label>
                <input type="text" class="form-control" name="name" placeholder="Enter client name">
                <div class="text-danger error-message" data-error-for="name"></div>
            </div>

            <!-- Position -->
            <div class="col-md-6 col-12">
                <label class="form-label">Client Position</label>
                <input type="text" class="form-control" name="position" placeholder="Eg: CEO, Manager">
                <div class="text-danger error-message" data-error-for="position"></div>
            </div>

            <!-- Testimonial Text -->
            <div class="col-12">
                <label class="form-label required">Testimonial Text</label>
                <textarea class="form-control" name="testimonial_text" rows="4"></textarea>
                <div class="text-danger error-message" data-error-for="testimonial_text"></div>
            </div>

            <!-- Image Upload (SAME AS FAQ) -->
            <div class="col-6">
                <label class="form-label d-block mb-2">Upload Profile Image</label>

                <div class="faq-image-wrapper d-none" id="faqImageWrapper">
                    <img id="previewFaqImage" style="max-width:200px; border-radius:10px;">
                </div>

                <div class="text-danger error-message" data-error-for="faq_image"></div>
                <input type="hidden" name="profile_pic" id="profile_pic">

                <button type="button" class="profilebtn mt-2" id="uploadFaqButton" data-type="faq_image">
                    Upload Profile Image
                </button>
            </div>

            <!-- Status -->
            <div class="col-md-6 col-12">
                <label class="form-label required">Status</label>
                <select class="form-control" name="is_active">

                    <option disabled selected>Select status</option>
                    <option value="1">Active</option>
                    <option value="0">Inactive</option>
                </select>
                <div class="text-danger error-message" data-error-for="is_active"></div>
            </div>

        </div>

        <div class="text-end mt-4">
            <a href="{{ route('list_testimonials') }}" class="btn btn-secondary me-2">Cancel</a>
            <button type="submit" class="btn">Submit</button>
        </div>
    </form>
</div>

@include('layouts.crop')
@endsection

@push('scripts')
<script>
    const submitTestimonial = "{{ route('store_testimonial') }}";
    const uploadUrl  = "{{ route('profile.cropUpload') }}";
</script>
<script src="{{ asset('assets/js/global/image_crop.js') }}"></script>
<script src="{{ asset('assets/js/testimonials/add_testimonial.js') }}"></script>
@endpush
