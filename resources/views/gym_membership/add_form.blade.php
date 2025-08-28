@extends('layouts.app')

@section('title', 'Add Membership')

@section('content')
<div class="container-custom">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('list_dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('list_membership') }}">Memberships</a></li>
            <li class="breadcrumb-item" aria-current="page">Add Membership</li>
        </ol>
    </nav>

    <form id="gym_member_add_form" class="p-4 bg-light rounded shadow" >
        <!-- Form Heading -->
        <h4 class="mb-4">Add Membership</h4>
        <div class="step" data-step="2">
            <div class="row g-3">
                <div class="col-md-6 col-12">
                    <label class="form-label required">{{ __('membership.name_label') }}</label>
                    <input type="text" class="form-control" name="membership_name" id="membership_name" 
                        placeholder="{{ __('membership.name_placeholder') }}">
                    <div class="text-danger error-message" data-error-for="membership_name"></div>
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
                <div class="col-md-6 col-12">
                    <label class="form-label required">{{ __('membership.duration_label') }}</label>
                    <input type="number" class="form-control" name="duration_in_days" id="duration_in_days"
                        placeholder="{{ __('membership.duration_placeholder') }}">
                    <div class="text-danger error-message" data-error-for="duration_in_days"></div>
                </div>

                <div class="col-md-6 col-12">
                    <label class="form-label required">{{ __('membership.price_label') }}</label>
                    <input type="number" class="form-control" name="price" id="price"
                        placeholder="{{ __('membership.price_placeholder') }}">
                    <div class="text-danger error-message" data-error-for="price"></div>
                </div>
            </div>

            <div class="row g-3 mt-2">
                <div class="col-md-6 col-12">
                    <label class="form-label required">{{ __('membership.trainer_label') }}</label>
                    <select class="form-select" name="trainer_included" id="trainer_included">
                        <option disabled selected>{{ __('membership.select_option') }}</option>
                        <option value="yes">{{ __('membership.yes') }}</option>
                        <option value="no">{{ __('membership.no') }}</option>
                    </select>
                    <div class="text-danger error-message" data-error-for="trainer_included"></div>
                </div>

                <div class="col-md-6 col-12">
                    <label class="form-label">{{ __('membership.facilities_label') }}</label>
                    @foreach(config('app.facilities') as $id => $label)
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" 
                                name="facilities_included[]" 
                                id="facility_{{ $id }}" 
                                value="{{ $id }}"
                                @if($id == 3) checked disabled @endif>
                            <label class="form-check-label" for="facility_{{ $id }}">
                                {{ $label }}
                            </label>

                            {{-- Hidden input to ensure disabled value is submitted --}}
                            @if($id == 3)
                                <input type="hidden" name="facilities_included[]" value="{{ $id }}">
                            @endif
                        </div>
                    @endforeach
                    <div class="text-danger error-message" data-error-for="facilities_included"></div>
                </div>
            </div>

        </div>

        <div class="text-end mt-4">
            <a href="{{ route('list_membership') }}" class="btn btn-secondary me-2">
                Cancel
            </a>
            <button type="submit" class="btn " id="submitBtn">{{ __('membership.submit_button') }}</button>
        </div>
    </form>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
const stepperSubmitUrl = "{{ route('add_membership') }}";
</script>

<script src="{{ asset('assets/js/gym_membership/add_membership.js') }}"></script>
<style>
    /* Keep label normal even if checkbox is disabled */
    .form-check-input:disabled + .form-check-label 
    {
        color: inherit !important;
        opacity: 1 !important;
    }
   
</style>
@endsection