@extends('layouts.app')

@section('title', 'Add Header')

@section('content')
<div class="container-custom">

    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('list_dashboard') }}">Dashboard</a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{ route('list_headers') }}">Headers</a>
            </li>
            <li class="breadcrumb-item active">Add Header</li>
        </ol>
    </nav>

    <form id="header_add_form" class="p-4 bg-light rounded shadow">

        <h4 class="mb-4">Add Header</h4>

        <div class="row g-3">

            <div class="col-12">
                <label class="form-label required">Header Title</label>
                <input type="text" class="form-control" name="title" id="title">
                <div class="text-danger error-message" data-error-for="title"></div>
            </div>

            <div class="col-md-6 col-12">
                <label class="form-label required">Sequence No</label>
                <input type="number" class="form-control" name="sequence_no" id="sequence_no">
                <div class="text-danger error-message" data-error-for="sequence_no"></div>
            </div>

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
            <a href="{{ route('list_headers') }}" class="btn btn-secondary me-2 cncl_btn">
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
    const submitHeaderUrl = "{{ route('store_header') }}";
</script>
<script src="{{ asset('assets/js/header/add_header.js') }}"></script>
@endpush
