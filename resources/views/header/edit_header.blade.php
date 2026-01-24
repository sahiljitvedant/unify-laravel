@extends('layouts.app')

@section('title', 'Edit Header')

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
            <li class="breadcrumb-item active">Edit Header</li>
        </ol>
    </nav>

    <form id="header_edit_form" class="p-4 bg-light rounded shadow">
        <h4 class="mb-4">Edit Header</h4>

        <div class="row g-3">

            <!-- Title -->
            <div class="col-12">
                <label class="form-label required">Header Title</label>
                <input type="text"
                       class="form-control"
                       name="title"
                       value="{{ old('title', $header->title) }}">
                <div class="text-danger error-message" data-error-for="title"></div>
            </div>

            <!-- Sequence No -->
            <div class="col-md-6">
                <label class="form-label required">Sequence No</label>
                <input type="number"
                       class="form-control"
                       name="sequence_no"
                       value="{{ old('sequence_no', $header->sequence_no) }}">
                <div class="text-danger error-message" data-error-for="sequence_no"></div>
            </div>

            <!-- Status -->
            <div class="col-md-6">
                <label class="form-label required">Status</label>
                <select class="form-control" name="status">
                    <option value="1" {{ $header->status == 1 ? 'selected' : '' }}>Active</option>
                    <option value="0" {{ $header->status == 0 ? 'selected' : '' }}>Inactive</option>
                </select>
                <div class="text-danger error-message" data-error-for="status"></div>
            </div>

        </div>

        <!-- Buttons -->
        <div class="text-end mt-4">
            <a href="{{ route('list_headers') }}"
               class="btn btn-secondary me-2 cncl_btn">
                Cancel
            </a>

            <button type="submit"
                    class="btn"
                    id="submitBtn">
                Update
            </button>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
    const submitHeaderPage = "{{ route('update_header', $header->id) }}";
</script>

<script src="{{ asset('assets/js/header/edit_header.js') }}"></script>
@endpush
