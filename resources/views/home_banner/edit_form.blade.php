@extends('layouts.app')

@section('title', 'Edit Home Banner')

@section('content')
<div class="container-custom">

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('list_dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('home_banner') }}">Home Banners</a></li>
            <li class="breadcrumb-item active">Edit Home Banner</li>
        </ol>
    </nav>

    <form id="home_banner_edit_form" class="p-4 bg-light rounded shadow">
        <h4 class="mb-4">Edit Home Banner</h4>

        <div class="row g-3">

            <div class="col-12">
                <label class="form-label required">Title</label>
                <input type="text" class="form-control" name="title"
                    value="{{ old('title', $banner->title) }}">
                <div class="text-danger error-message" data-error-for="title"></div>
            </div>

            <div class="col-12">
                <label class="form-label required">Sub Title</label>
                <input type="text" class="form-control" name="sub_title"
                    value="{{ old('sub_title', $banner->sub_title) }}">
                <div class="text-danger error-message" data-error-for="sub_title"></div>
            </div>

            <div class="col-md-6">
                <label class="form-label">Banner Image</label>

                <div id="faqImageWrapper">
                    @if($banner->banner_image)
                        <img id="previewFaqImage"
                             src="{{ asset($banner->banner_image) }}"
                             class="img-thumbnail mb-2"
                             style="max-width:200px; border-radius:10px;">
                    @else
                        <img id="previewFaqImage"
                             class="img-thumbnail mb-2 d-none"
                             style="max-width:200px; border-radius:10px;">
                    @endif
                </div>

                <input type="hidden" name="faq_image" id="faq_image_path"
                       value="{{ $banner->banner_image }}">

                <button type="button" class="profilebtn mt-2"
                        id="uploadFaqButton" data-type="faq_image">
                    Change Banner Image
                </button>

                <div class="text-danger error-message" data-error-for="faq_image"></div>
            </div>

            <div class="col-md-6">
                <label class="form-label required">Status</label>
                <select class="form-control" name="is_active">
                    <option value="1" {{ $banner->status == 1 ? 'selected' : '' }}>Active</option>
                    <option value="0" {{ $banner->status == 0 ? 'selected' : '' }}>Inactive</option>
                </select>
                <div class="text-danger error-message" data-error-for="is_active"></div>
            </div>

        </div>

        <div class="text-end mt-4">
            <a href="{{ route('home_banner') }}"
               class="btn btn-secondary me-2 cncl_btn">Cancel</a>
            <button type="submit" class="btn" id="submitBtn">Update</button>
        </div>
    </form>
</div>

@include('layouts.crop')
@endsection

@push('scripts')
<script>
    const uploadUrl   = "{{ route('profile.cropUpload') }}";
    const submitBanner = "{{ route('update_home_banner', $banner->id) }}";
</script>
<script src="{{ asset('assets/js/global/image_crop.js') }}"></script>
<script src="{{ asset('assets/js/home_banner/edit_banner.js') }}"></script>
@endpush
