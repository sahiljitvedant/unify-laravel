@extends('layouts.app')

@section('title', 'Edit Membership')

@section('content')
<div class="container-custom">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('list_membership') }}">Memberships</a></li>
            <li class="breadcrumb-item" aria-current="page">Edit Membership</li>
        </ol>
    </nav>

    <form id="gym_member_edit_form" class="p-4 bg-light rounded shadow">
        <!-- Form Heading -->
        <h4 class="mb-4">Edit Membership</h4>
        <div class="step" data-step="2">
            <div class="row g-3">
                <div class="col-md-6 col-12">
                    <label class="form-label required">{{ __('membership.name_label') }}</label>
                    <input type="text" class="form-control" name="membership_name" id="membership_name" 
                        value="{{ $member->membership_name }}" 
                        placeholder="{{ __('membership.name_placeholder') }}">
                    <div class="text-danger error-message" data-error-for="membership_name"></div>
                </div>

                <div class="col-md-6 col-12">
                    <label class="form-label required">{{ __('membership.active_label') }}</label>
                    <select class="form-select" name="is_active" id="is_active">
                        <option disabled>{{ __('membership.select_status') }}</option>
                        <option value="1" {{ $member->is_active == 1 ? 'selected' : '' }}>{{ __('membership.active') }}</option>
                        <option value="0" {{ $member->is_active == 0 ? 'selected' : '' }}>{{ __('membership.inactive') }}</option>
                    </select>
                    <div class="text-danger error-message" data-error-for="is_active"></div>
                </div>
            </div>

            <div class="row g-3 mt-2">
                <div class="col-12">
                    <label class="form-label required">{{ __('membership.description_label') }}</label>
                    <textarea class="form-control" name="description" id="description" rows="3"
                        placeholder="{{ __('membership.description_placeholder') }}">{{ $member->description }}</textarea>
                    <div class="text-danger error-message" data-error-for="description"></div>
                </div>
            </div>

            <div class="row g-3 mt-2">
                <div class="col-md-6 col-12">
                    <label class="form-label required">{{ __('membership.duration_label') }}</label>
                    <input type="number" class="form-control" name="duration_in_days" id="duration_in_days"
                        value="{{ $member->duration_in_days }}"
                        placeholder="{{ __('membership.duration_placeholder') }}">
                    <div class="text-danger error-message" data-error-for="duration_in_days"></div>
                </div>

                <div class="col-md-6 col-12">
                    <label class="form-label required">{{ __('membership.price_label') }}</label>
                    <input type="number" class="form-control" name="price" id="price"
                        value="{{ $member->price }}"
                        placeholder="{{ __('membership.price_placeholder') }}">
                    <div class="text-danger error-message" data-error-for="price"></div>
                </div>
            </div>

            <div class="row g-3 mt-2">
                <div class="col-md-6 col-12">
                    <label class="form-label required">{{ __('membership.trainer_label') }}</label>
                    <select class="form-select" name="trainer_included" id="trainer_included">
                        <option disabled>{{ __('membership.select_option') }}</option>
                        <option value="yes" {{ $member->trainer_included == 'yes' ? 'selected' : '' }}>{{ __('membership.yes') }}</option>
                        <option value="no" {{ $member->trainer_included == 'no' ? 'selected' : '' }}>{{ __('membership.no') }}</option>
                    </select>
                    <div class="text-danger error-message" data-error-for="trainer_included"></div>
                </div>

                @php
                    $selectedFacilities = $member->facilities_included 
                                            ? json_decode($member->facilities_included, true) 
                                            : [];
                    if (!is_array($selectedFacilities)) $selectedFacilities = [];
                @endphp

                <div class="col-md-6 col-12">
                    <label class="form-label">{{ __('membership.facilities_label') }}</label>
                    @foreach(config('app.facilities') as $id => $label)
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" 
                                name="facilities_included[]" 
                                id="facility_{{ $id }}" 
                                value="{{ $id }}"
                                {{ in_array($id, $selectedFacilities) ? 'checked' : '' }}
                                @if($id == 3) disabled @endif>
                            <label class="form-check-label" for="facility_{{ $id }}">
                                {{ $label }}
                            </label>

                            @if($id == 3)
                                <input type="hidden" name="facilities_included[]" value="{{ $id }}">
                            @endif
                        </div>
                    @endforeach
                    <div class="text-danger error-message" data-error-for="facilities_included"></div>
                </div>
            </div>

        <div class="text-end mt-4">
            <a href="{{ route('list_membership') }}" class="btn btn-secondary me-2">
                Cancel
            </a>
            <button type="submit" class="btn btn-success" id="submitBtn">{{ __('membership.submit_button') }}</button>
        </div>
    </form>

</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
const stepperSubmitUrl = "{{ route('update_membership', ['id' => $member->id]) }}";
</script>

<script src="{{ asset('assets/js/gym_membership/edit_membership.js') }}"></script>
<style>
    /* Keep label normal even if checkbox is disabled */
    .form-check-input:disabled + .form-check-label 
    {
        color: inherit !important;
        opacity: 1 !important;
    }
   
</style>
@endsection