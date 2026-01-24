@extends('layouts.app')

@section('title', 'Edit SubHeader')

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
            <li class="breadcrumb-item active">Edit SubHeader</li>
        </ol>
    </nav>

    <form id="subheader_edit_form" class="p-4 bg-light rounded shadow">
        <h4 class="mb-4">Edit SubHeader</h4>

        <div class="row g-3">

            <!-- Header Dropdown -->
            <div class="col-12">
                <label class="form-label required">Header</label>
                <select class="form-control" name="header_id">
                    <option disabled>Select Header</option>
                    @foreach($headers as $header)
                        <option value="{{ $header->id }}"
                            {{ $subheader->header_id == $header->id ? 'selected' : '' }}>
                            {{ $header->title }}
                        </option>
                    @endforeach
                </select>
                <div class="text-danger error-message" data-error-for="header_id"></div>
            </div>

            <!-- SubHeader Name -->
            <div class="col-12">
                <label class="form-label required">SubHeader Name</label>
                <input type="text"
                       class="form-control"
                       name="name"
                       value="{{ old('name', $subheader->name) }}">
                <div class="text-danger error-message" data-error-for="name"></div>
            </div>

            <!-- Status -->
            <div class="col-md-6">
                <label class="form-label required">Status</label>
                <select class="form-control" name="status">
                    <option value="1" {{ $subheader->status == 1 ? 'selected' : '' }}>
                        Active
                    </option>
                    <option value="0" {{ $subheader->status == 0 ? 'selected' : '' }}>
                        Inactive
                    </option>
                </select>
                <div class="text-danger error-message" data-error-for="status"></div>
            </div>

        </div>

        <!-- Buttons -->
        <div class="text-end mt-4">
            <a href="{{ route('list_subheaders') }}"
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
    const submitSubHeaderPage = "{{ route('update_subheader', $subheader->id) }}";
</script>

<script src="{{ asset('assets/js/subheader/edit_subheader.js') }}"></script>
@endpush
