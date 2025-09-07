@extends('layouts.app')

@section('title', 'Add Blogs')

@section('content')
<div class="container-custom">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('list_dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('list_blogs') }}">Blogs</a></li>
            <li class="breadcrumb-item" aria-current="page">Add Blogs</li>
        </ol>
    </nav>

    <form id="add_blogs" class="p-4 bg-light rounded shadow" >
        <!-- Form Heading -->
        <h4 class="mb-4">Add Blogs</h4>
        <div class="step" data-step="2">
            <div class="row g-3">
                <div class="col-md-6 col-12">
                    <label class="form-label required">Blog Title</label>
                    <input type="text" class="form-control" name="blog_title" id="blog_title" 
                        placeholder="blog title">
                    <div class="text-danger error-message" data-error-for="blog_title"></div>
                </div>
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

            <div class="row g-3 mt-2">
                <div class="col-12">
                    <label class="form-label required">{{ __('membership.description_label') }}</label>
                    <textarea class="form-control" name="description" id="description" rows="3"
                        placeholder="{{ __('membership.description_placeholder') }}"></textarea>
                    <div class="text-danger error-message" data-error-for="description"></div>
                </div>
            </div>

            <div class="row g-3 mt-2">
                <div class="col-12 col-md-6 mb-3">
                    <label class="form-label required">Publish Date</label>
                    <input type="date" class="form-control" name="publish_date" id="publish_date" placeholder="DD-MM-YYYY">
                    <div class="text-danger error-message" data-error-for="publish_date"></div>
                </div>

                
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
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
const submitblog = "{{ route('add_blogs') }}";
</script>

<script src="{{ asset('assets/js/blogs/add_blogs.js') }}"></script>
<style>
    /* Keep label normal even if checkbox is disabled */
    .form-check-input:disabled + .form-check-label 
    {
        color: inherit !important;
        opacity: 1 !important;
    }
   
</style>
@endsection