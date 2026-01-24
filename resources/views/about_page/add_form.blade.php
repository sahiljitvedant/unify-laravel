@extends('layouts.app')

@section('title', 'Add About Page')

@section('content')
<div class="container-custom">

    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('list_dashboard') }}">Dashboard</a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{ route('about_page') }}">About Page</a>
            </li>
            <li class="breadcrumb-item active">Add About Page</li>
        </ol>
    </nav>

    <form id="about_add_form" class="p-4 bg-light rounded shadow">

        <h4 class="mb-4">Add About Page</h4>

        <div class="row g-3">

            <!-- Title -->
            <div class="col-12">
                <label class="form-label required">Title</label>
                <input type="text" class="form-control" name="title" id="title">
                <div class="text-danger error-message" data-error-for="title"></div>
            </div>

            <!-- Slug -->
            <div class="col-12">
                <label class="form-label required">Route Name (Slug)</label>
                <input type="text" class="form-control" name="slug" id="slug">
                <div class="text-danger error-message" data-error-for="slug"></div>
            </div>

            <!-- Header Dropdown (MANDATORY) -->
            <div class="col-md-6">
                <label class="form-label required">Header</label>
                <select class="form-control" name="header_id" id="header_id">
                    <option value="">Select Header</option>
                    @foreach($headers as $header)
                        <option value="{{ $header->id }}">{{ $header->title }}</option>
                    @endforeach
                </select>
                <div class="text-danger error-message" data-error-for="header_id"></div>
            </div>

            <!-- SubHeader Dropdown -->
            <div class="col-md-6">
                <label class="form-label">SubHeader</label>
                <select class="form-control" name="subheader_id" id="subheader_id">
                    <option value="">Select SubHeader</option>
                </select>
                <div class="text-danger error-message" data-error-for="subheader_id"></div>
            </div>

        </div>

        <!-- Description (CKEditor) -->
        <div class="row g-3 mt-2">
            <div class="col-12">
                <label class="form-label required">{{ __('membership.description_label') }}</label>
                <textarea class="form-control"
                          name="description"
                          id="description"
                          rows="5"></textarea>
                <div class="text-danger error-message" data-error-for="description"></div>
            </div>
        </div>

        <!-- Image Upload -->
        <div class="row g-3 mt-2">
            <div class="col-md-6">
                <label class="form-label required">Upload Page Image</label>

                <div class="about-image-wrapper d-none" id="aboutImageWrapper">
                    <img id="previewAboutImage" class="about-preview-image">
                </div>

                <input type="hidden" name="page_image" id="page_image">

                <div class="text-danger error-message" data-error-for="page_image"></div>

                <button type="button"
                        class="profilebtn mt-2"
                        id="uploadAboutButton"
                        data-type="about_image">
                    Upload Page Image
                </button>
            </div>

            <!-- Status -->
            <div class="col-md-6">
                <label class="form-label required">Status</label>
                <select class="form-control" name="is_active" id="is_active">
                    <option value="">Select Status</option>
                    <option value="1">Active</option>
                    <option value="0">Inactive</option>
                </select>
                <div class="text-danger error-message" data-error-for="is_active"></div>
            </div>
        </div>

        <!-- Buttons -->
        <div class="text-end mt-4">
            <a href="{{ route('about_page') }}" class="btn btn-secondary me-2 cncl_btn">
                Cancel
            </a>
            <button type="submit" class="btn" id="submitBtn">
                Submit
            </button>
        </div>

    </form>
</div>

@include('layouts.crop')
<style>
    .form-check-input:disabled + .form-check-label {
        color: inherit !important;
        opacity: 1 !important;
    }

    .about-image-wrapper {
        width: 100%;
        height: 300px; /* Adjust height */
        overflow: hidden;
        border-radius: 10px;
        border: 1px solid #ddd;
        margin-bottom: 10px;
        display: flex;
        justify-content: center;
        align-items: center;
        background: #f5f5f5;
    }

    .about-preview-image {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }


</style>
@endsection

@push('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.ckeditor.com/ckeditor5/41.3.1/classic/ckeditor.js"></script>

<script>
    const uploadUrl  = "{{ route('profile.cropUpload') }}";
    const submitAboutPage = "{{ route('add_about_page') }}";
    $('#header_id').on('change', function () 
    {
        const headerId = $(this).val();
        const subHeaderSelect = $('#subheader_id');

        subHeaderSelect.html('<option value="">Loading...</option>');

        if (!headerId) {
            subHeaderSelect.html('<option value="">Select SubHeader</option>');
            return;
        }

        $.ajax({
            url: `/get-subheaders/${headerId}`,
            type: 'GET',
            success: function (res) {
                let options = '<option value="">Select SubHeader</option>';

                if (res.status && res.data.length > 0) {
                    res.data.forEach(item => {
                        options += `<option value="${item.id}">${item.name}</option>`;
                    });
                }

                subHeaderSelect.html(options);
            },
            error: function () {
                subHeaderSelect.html('<option value="">Error loading subheaders</option>');
            }
        });
    });

</script>

<script src="{{ asset('assets/js/global/image_crop.js') }}"></script>
<script src="{{ asset('assets/js/about_page/add_page.js') }}"></script>
@endpush
