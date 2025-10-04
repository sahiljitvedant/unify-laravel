<form id="memebrStepForm" class="">

<div class="step" data-step="2">
    <div class="row g-3">
        <div class="col-md-6 col-12">
            <label class="form-label">{{ __('global.membership_type_label') }}</label>
            <select class="form-select" name="membership_type" id="membership_type" required>
                <option disabled {{ !$member->membership_type ? 'selected' : '' }}>
                    {{ __('global.select_option') }}
                </option>
                @foreach($memberships as $id => $name)
                    <option value="{{ $id }}" {{ (int)$member->membership_type === (int)$id ? 'selected' : '' }}>
                        {{ $name }}
                    </option>
                @endforeach
            </select>
            <div class="text-danger error-message" data-error-for="membership_type"></div>
        </div>

        <div class="col-md-6 col-12">
            <label class="form-label">{{ __('global.joining_date_label') }}</label>
            <input type="date" class="form-control"
                name="joining_date" id="joining_date"
                value="{{ old('joining_date', $member->joining_date) }}"
                placeholder="{{ __('global.joining_date_placeholder') }}">
            <div class="text-danger error-message" data-error-for="joining_date"></div>
        </div>
    </div>

    <div class="row g-3 mt-2">
        <div class="col-md-6 col-12">
            <label class="form-label">{{ __('global.expiry_date_label') }}</label>
            <input type="date" class="form-control"
                name="expiry_date" id="expiry_date"
                value="{{ old('expiry_date', $member->expiry_date) }}"
                placeholder="{{ __('global.expiry_date_placeholder') }}">
            <div class="text-danger error-message" data-error-for="expiry_date"></div>
        </div>

        <div class="col-md-6 col-12">
            <label class="form-label">{{ __('global.amount_paid_label') }}</label>
            <input type="number" class="form-control"
                name="amount_paid" id="amount_paid"
                value="{{ old('amount_paid', $member->amount_paid) }}"
                placeholder="{{ __('global.amount_paid_placeholder') }}">
            <div class="text-danger error-message" data-error-for="amount_paid"></div>
        </div>
    </div>

    <div class="row g-3 mt-2">
        <div class="col-md-6 col-12">
            <label class="form-label">{{ __('global.payment_method_label') }}</label>
            <select class="form-select" name="payment_method" id="payment_method">
                <option disabled {{ !$member->payment_method ? 'selected' : '' }}>
                    {{ __('global.select_option') }}
                </option>
                <option value="cash" {{ $member->payment_method == 'cash' ? 'selected' : '' }}>
                    {{ __('global.cash') }}
                </option>
                <option value="card" {{ $member->payment_method == 'card' ? 'selected' : '' }}>
                    {{ __('global.card') }}
                </option>
                <option value="upi" {{ $member->payment_method == 'upi' ? 'selected' : '' }}>
                    {{ __('global.upi') }}
                </option>
            </select>
            <div class="text-danger error-message" data-error-for="payment_method"></div>
        </div>

        <div class="col-md-6 col-12">s
            <label class="form-label">{{ __('global.trainer_assigned_label') }}</label>
            <select class="form-select" name="trainer_assigned" id="trainer_assigned">
                <option disabled {{ !$member->trainer_assigned ? 'selected' : '' }}>
                    {{ __('global.select_option') }}
                </option>
                @foreach($trainer as $id => $name)
                    <option value="{{ $id }}" {{ (int)$member->trainer_assigned === (int)$id ? 'selected' : '' }}>
                        {{ $name }}
                    </option>
                @endforeach
            </select>
            <div class="text-danger error-message" data-error-for="trainer_assigned"></div>
        </div>

    </div>
</div>
<div class="text-end mt-4">
    <button type="submit" class="btn btn-primary" id="submitMemebrBtn">Submit</button>
</div>
</form>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
const steppermemberEditUrl = "{{ route('stepper.update', ['id' => $member->id]) }}";
</script>

<script src="{{ asset('assets/js/gym_package/edit_member_profile.js') }}"></script>
