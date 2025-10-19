@extends('layouts.app')

@section('title', 'Edit Blogs')

@section('content')
<div class="container-custom">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('list_dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('list_blogs') }}">Blogs</a></li>
            <li class="breadcrumb-item" aria-current="page">Edit Blogs</li>
        </ol>
    </nav>

    <form id="edit_blogs" class="p-4 bg-light rounded shadow" >
        <!-- Form Heading -->
        <h4 class="mb-4">Edit Blogs</h4>
        <div class="step" data-step="2">

            <div class="row g-3">
                <div class="col-md-6 col-12">
                    <label class="form-label d-block mb-2 required">Upload Blog Image</label>

                    <!-- Preview wrapper -->
                    <div class="blog-image-wrapper {{ !empty($member->blog_image) ? '' : 'd-none' }}" id="blogImageWrapper">
                        <img id="previewBlogImage" class="blog-preview-image" 
                            src="{{ !empty($member->blog_image) ? asset($member->blog_image) : '' }}" 
                            style="">
                    </div>

                    <div class="text-danger error-message" data-error-for="blog_image"></div>

                    <!-- Hidden input to store DB value -->
                    <input type="hidden" name="blog_image" id="blog_image_path" 
                        value="{{ !empty($member->blog_image) ? $member->blog_image : '' }}">

                    <!-- Upload button -->
                    <button type="button" class="profilebtn mt-2" id="uploadBlogButton" data-type="blog_image">
                        Upload Blog Image
                    </button>
                </div>

                <div class="col-12 col-md-6 mb-3">
                    <label class="form-label required">Publish date</label>
                    <input type="date" 
                        class="form-control" 
                        name="publish_date" 
                        id="publish_date" 
                        value="{{ old('publish_date', $member->publish_date) }}">
                    <div class="text-danger error-message" data-error-for="publish_date"></div>
                </div>
            </div>

            <div class="row g-3">
                <div class="col-md-6 col-12">
                    <label class="form-label required">Blog title</label>
                    <input type="text" 
                        class="form-control" 
                        name="blog_title" 
                        id="blog_title" 
                        value="{{ old('blog_title', $member->blog_title) }}" 
                        placeholder="Blog title">
                    <div class="text-danger error-message" data-error-for="blog_title"></div>
                </div>

                <div class="col-md-6 col-12">
                    <label class="form-label required">{{ __('membership.active_label') }}</label>
                    <select class="form-control" name="is_active" id="is_active">
                        <option disabled>{{ __('membership.select_status') }}</option>
                        <option value="1" {{ old('is_active', $member->is_active) == 1 ? 'selected' : '' }}>
                            {{ __('membership.active') }}
                        </option>
                        <option value="0" {{ old('is_active', $member->is_active) == 0 ? 'selected' : '' }}>
                            {{ __('membership.inactive') }}
                        </option>
                    </select>
                    <div class="text-danger error-message" data-error-for="is_active"></div>
                </div>
            </div>

            <div class="row g-3 mt-2">
                <div class="col-12">
                    <label class="form-label required">{{ __('membership.description_label') }}</label>
                    <textarea class="form-control" 
                            name="description" 
                            id="description" 
                            rows="5"
                            placeholder="{{ __('membership.description_placeholder') }}">{{ old('description', $member->description) }}</textarea>
                    <div class="text-danger error-message" data-error-for="description"></div>
                </div>
            </div>

            <div class="row g-3 mt-2">
                
            </div>
        </div>
        <div class="text-end mt-4">
            <a href="{{ route('list_membership') }}" class="btn btn-secondary me-2 cncl_btn">
                Cancel
            </a>
            <button type="submit" class="btn" id="submitBtn">{{ __('membership.submit_button') }}</button>
        </div>
    </form>
</div>
<!-- Crop Image Modal -->
@include('layouts.crop')
<style>
  .blog-image-wrapper {
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

    .blog-preview-image {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

</style>
@endsection
@push('scripts')
<!-- jQuery & Bootstrap -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.ckeditor.com/ckeditor5/41.3.1/classic/ckeditor.js"></script>
<script>
const stepperSubmitUrl = "{{ route('update_blogs', ['id' => $member->id]) }}";
const uploadUrl  = "{{ route('profile.cropUpload') }}";
</script>
<script src="{{ asset('assets/js/global/image_crop.js') }}"></script>
<script src="{{ asset('assets/js/blogs/edit_blogs.js') }}"></script>
@endpush