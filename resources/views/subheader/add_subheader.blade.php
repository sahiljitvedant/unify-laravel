@extends('layouts.app')

@section('title', 'Add SubHeader')

@section('content')
<div class="container-custom">

    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('list_dashboard') }}">Dashboard</a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{ route('list_subheaders') }}">SubHeaders</a>
            </li>
            <li class="breadcrumb-item active">Add SubHeader</li>
        </ol>
    </nav>

    <form id="subheader_add_form" class="p-4 bg-light rounded shadow">

        <h4 class="mb-4">Add SubHeader</h4>

        <div class="row g-3">

            <!-- Header Dropdown -->
            <div class="col-12">
                <label class="form-label required">Header</label>
                <select class="form-control" name="header_id" id="header_id">
                    <option disabled selected>Select Header</option>
                    @foreach($headers as $header)
                        <option value="{{ $header->id }}">
                            {{ $header->title }}
                        </option>
                    @endforeach
                </select>
                <div class="text-danger error-message" data-error-for="header_id"></div>
            </div>

            <!-- SubHeader Name -->
            <div class="col-12">
                <label class="form-label required">SubHeader Name</label>
                <input type="text" class="form-control" name="name" id="name">
                <div class="text-danger error-message" data-error-for="name"></div>
            </div>

            <!-- Status -->
            <div class="col-md-6 col-12">
                <label class="form-label required">Status</label>
                <select class="form-control" name="status" id="status">
                    <option disabled selected>Select status</option>
                    <option value="1">Active</option>
                    <option value="0">Inactive</option>
                </select>
                <div class="text-danger error-message" data-error-for="status"></div>
            </div>

        </div>

        <div class="text-end mt-4">
            <a href="{{ route('list_subheaders') }}" class="btn btn-secondary me-2 cncl_btn">
                Cancel
            </a>
            <button type="submit" class="btn" id="submitBtn">
                Submit
            </button>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
    const submitSubHeaderUrl = "{{ route('store_subheader') }}";
</script>
<script src="{{ asset('assets/js/subheader/add_subheader.js') }}"></script>
@endpush
