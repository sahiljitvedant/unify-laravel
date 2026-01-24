@extends('layouts.app')

@section('title', 'Edit Terms & Conditions')

@section('content')
<div class="container-custom">

    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('list_dashboard') }}">Dashboard</a>
            </li>
            <li class="breadcrumb-item" aria-current="page">
                Edit Terms & Conditions
            </li>
        </ol>
    </nav>

    <form id="add_terms_form" class="p-4 bg-light rounded shadow">

        <h4 class="mb-4">Edit Terms & Conditions</h4>

        <div class="row g-3 mt-3">
            <div class="col-12">
                <label class="form-label required">Terms & Conditions Description</label>
                <textarea
                    class="form-control"
                    name="terms_description"
                    id="terms_description"
                    rows="4"
                    placeholder="Enter terms & conditions description"
                >{{ $terms_description ?? '' }}</textarea>

                <div class="text-danger error-message" data-error-for="terms_description"></div>
            </div>
        </div>

        <div class="text-end mt-4">
            <a href="{{ route('list_dashboard') }}" class="btn btn-secondary me-2 cncl_btn">
                Cancel
            </a>
            <button type="submit" class="btn" id="submitBtn">
                {{ __('membership.submit_button') }}
            </button>
        </div>

    </form>
</div>
@endsection


@push('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.ckeditor.com/ckeditor5/41.3.1/classic/ckeditor.js"></script>

<script>
    const submitTerms = "{{ route('add_terms_conditions') }}";
</script>

<script src="{{ asset('assets/js/terms_conditions/add_terms_conditions.js') }}"></script>
@endpush
