@extends('layouts.app')

@section('title', 'Company Brochure')

@section('content')
<div class="container-custom">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('list_dashboard') }}">Dashboard</a>
            </li>
            <li class="breadcrumb-item active">Company Brochure</li>
        </ol>
    </nav>

    <form id="add_brochure_form" class="p-4 bg-light rounded shadow" enctype="multipart/form-data">
        <h4 class="mb-4">
            {{ isset($brochure) ? 'Update' : 'Add' }} Company Brochure
        </h4>

        <div class="row g-3">

            <!-- Current File -->
            @if(isset($brochure) && $brochure->file_path)
            <div class="col-12">
                <label class="form-label">Current Brochure</label>
                <div>
                    <a href="{{ asset($brochure->file_path) }}" target="_blank" class="btn btn_style">
                        View / Download
                    </a>
                </div>
            </div>
            @endif

            <!-- Upload -->
            <div class="col-12">
                <label class="form-label required">Upload Brochure (PDF)</label>

                <input type="file"
                       name="brochure_file"
                       id="brochure_file"
                       class="form-control"
                       accept=".pdf">

                <div class="text-danger error-message" data-error-for="brochure_file"></div>
            </div>

        </div>

        <div class="text-end mt-4">
            <a href="{{ route('list_dashboard') }}" class="btn btn-secondary me-2">
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
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    const submitPolicy = "{{ route('submit_company_brochure') }}";
</script>

<script src="{{ asset('assets/js/company_brochure/add.js') }}"></script>
@endpush
<style>
   
    .btn_style {
    background: var(--sidebar_color) !important;
    border: none;
    color: #fff;
    padding: 14px 18px;
    border-radius: 50%;
    cursor: pointer;
    font-size: 10px !important;
    transition: background 0.3s ease, transform 0.2s ease;
    }

.btn_style:hover {
  background: var(--sidebar_color) !important;
  /* transform: scale(1.1); */
}
</style>