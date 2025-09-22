@extends('layouts.app')

@section('title', 'Add Trainer')

@section('content')
<div class="container-custom">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('list_dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('list_trainer') }}">Trainer</a></li>
            <li class="breadcrumb-item" aria-current="page">Add Trainer</li>
        </ol>
    </nav>

    <form id="add_trainer_form" class="p-4 bg-light rounded shadow" >
        <!-- Form Heading -->
        <h4 class="mb-4">Add Trainer</h4>
        <div class="step" data-step="2">
            <div class="row g-3">
                <div class="col-md-6 col-12">
                    <label class="form-label required">Trainer name</label>
                    <input type="text" class="form-control" name="trainer_name" id="trainer_name" 
                        placeholder="Trainer name">
                    <div class="text-danger error-message" data-error-for="trainer_name"></div>
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
                <div class="col-12 col-md-6 mb-3">
                    <label class="form-label required">Joining date</label>
                    <input type="date" class="form-control" name="joining_date" id="joining_date" placeholder="DD-MM-YYYY">
                    <div class="text-danger error-message" data-error-for="joining_date"></div>
                </div>

                <div class="col-12 col-md-6 mb-3">
                    <label class="form-label">Leaving date</label>
                    <input type="date" class="form-control" name="expiry_date" id="expiry_date" placeholder="DD-MM-YYYY">
                    <div class="text-danger error-message" data-error-for="expiry_date"></div>
                </div>
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
const submitTrainer = "{{ route('add_trainer') }}";
</script>

<script src="{{ asset('assets\js\trainer\add_trainer.js') }}"></script>

<style>
    /* Keep label normal even if checkbox is disabled */
    .form-check-input:disabled + .form-check-label 
    {
        color: inherit !important;
        opacity: 1 !important;
    }
   
</style>
@endsection