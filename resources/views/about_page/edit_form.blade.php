@extends('layouts.app')

@section('title', 'Edit About Page')

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
            <li class="breadcrumb-item active">Edit About Page</li>
        </ol>
    </nav>

    <form id="about_edit_form" class="p-4 bg-light rounded shadow">

        <h4 class="mb-4">Edit About Page</h4>

        <div class="row g-3">

            <!-- Title -->
            <div class="col-12">
                <label class="form-label required">Title</label>
                <input type="text" class="form-control" name="title"
                       value="{{ $page->title }}">
                <div class="text-danger error-message" data-error-for="title"></div>
            </div>

            <!-- Slug -->
            <div class="col-12">
                <label class="form-label required">Route Name (Slug)</label>
                <input type="text" class="form-control" name="slug"
                       value="{{ $page->slug }}">
                <div class="text-danger error-message" data-error-for="slug"></div>
            </div>

            <!-- Header -->
            <div class="col-md-6">
                <label class="form-label required">Header</label>
                <select class="form-control" name="header_id" id="header_id">
                    <option value="">Select Header</option>
                    @foreach($headers as $header)
                        <option value="{{ $header->id }}"
                            {{ $page->header_id == $header->id ? 'selected' : '' }}>
                            {{ $header->title }}
                        </option>
                    @endforeach
                </select>
                <div class="text-danger error-message" data-error-for="header_id"></div>
            </div>

            <!-- SubHeader -->
            <div class="col-md-6">
                <label class="form-label">SubHeader</label>
                <select class="form-control" name="subheader_id" id="subheader_id">
                    <option value="">Select SubHeader</option>
                    @foreach($subheaders as $sub)
                        <option value="{{ $sub->id }}"
                            {{ $page->subheader_id == $sub->id ? 'selected' : '' }}>
                            {{ $sub->name }}
                        </option>
                    @endforeach
                </select>
                <div class="text-danger error-message" data-error-for="subheader_id"></div>
            </div>

        </div>

        <!-- Description -->
        <div class="row g-3 mt-2">
            <div class="col-12">
                <label class="form-label required">Description</label>
                <textarea class="form-control" id="description" name="description"
                          rows="5">{!! $page->description !!}</textarea>
                <div class="text-danger error-message" data-error-for="description"></div>
            </div>
        </div>

        <!-- Image -->
        <div class="row g-3 mt-2">
            <div class="col-md-6">
                <label class="form-label">Page Image</label>

                <div class="about-image-wrapper {{ $page->image ? '' : 'd-none' }}" id="aboutImageWrapper">
                    <img id="previewAboutImage"
                         src="{{ $page->image ? asset($page->image) : '' }}"
                         class="about-preview-image">
                </div>

                <input type="hidden" name="page_image" id="page_image"
                       value="{{ $page->image }}">

                <div class="text-danger error-message" data-error-for="page_image"></div>

                <button type="button"
                        class="profilebtn mt-2"
                        data-type="about_image">
                    Change Page Image
                </button>
            </div>

            <!-- Status -->
            <div class="col-md-6">
                <label class="form-label required">Status</label>
                <select class="form-control" name="is_active">
                    <option value="1" {{ $page->status == 1 ? 'selected' : '' }}>Active</option>
                    <option value="0" {{ $page->status == 0 ? 'selected' : '' }}>Inactive</option>
                </select>
                <div class="text-danger error-message" data-error-for="is_active"></div>
            </div>
        </div>

        <div class="text-end mt-4">
            <a href="{{ route('about_page') }}" class="btn btn-secondary me-2">Cancel</a>
            <button type="submit" class="btn" id="submitBtn">Update</button>
        </div>

    </form>
</div>

@include('layouts.crop')
@endsection

<style>
   
    .about-image-wrapper {
        width: 100%;
        height: 300px;
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


@push('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.ckeditor.com/ckeditor5/41.3.1/classic/ckeditor.js"></script>
<script>
    const uploadUrl      = "{{ route('profile.cropUpload') }}";
    const submitAboutPage = "{{ route('update_about_page', $page->id) }}";
    const savedSubHeaderId = "{{ $page->subheader_id }}";
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
                        const selected = item.id == savedSubHeaderId ? 'selected' : '';
                        options += `<option value="${item.id}" ${selected}>${item.name}</option>`;
                    });
                }

                subHeaderSelect.html(options);
            },
            error: function () {
                subHeaderSelect.html('<option value="">Error loading subheaders</option>');
            }
        });
    });
    $(document).ready(function () 
    {
        const headerId = $('#header_id').val();

        if (headerId) {
            $('#header_id').trigger('change');
        }
    });

</script>

<script src="{{ asset('assets/js/global/image_crop.js') }}"></script>
<script src="{{ asset('assets/js/about_page/edit_page.js') }}"></script>
@endpush
