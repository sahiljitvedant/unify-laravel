@extends('layouts.app')

@section('title', 'Edit Policy')

@section('content')
<div class="container-custom">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('list_dashboard') }}">Dashboard</a></li>
         
            <li class="breadcrumb-item" aria-current="page">Edit Policy</li>
        </ol>
    </nav>

    <form id="add_policy_form" class="p-4 bg-light rounded shadow" >
        <!-- Form Heading -->
        <h4 class="mb-4">Edit Policy</h4>
        <div class="step" data-step="2">
        <div class="row g-3 mt-3">
    <div class="col-12">
        <label class="form-label required">Policy Description</label>
        <textarea class="form-control" name="policy_description" id="policy_description" 
                  placeholder="Enter policy description" rows="4">{{ $policy_description ?? '' }}</textarea>
        <div class="text-danger error-message" data-error-for="policy_description"></div>
    </div>
</div>

        <div class="text-end mt-4">
            <a href="{{ route('list_trainer') }}" class="btn btn-secondary me-2 cncl_btn">
                Cancel
            </a>
            <button type="submit" class="btn" id="submitBtn">{{ __('membership.submit_button') }}</button>
        </div>
    </form>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
const submitPolicy = "{{ route('add_policy') }}";
</script>

<script src="{{ asset('assets\js\policy\add_policy.js') }}"></script>


<style>
    /* Keep label normal even if checkbox is disabled */
    .form-check-input:disabled + .form-check-label 
    {
        color: inherit !important;
        opacity: 1 !important;
    }
   
</style>
@endsection