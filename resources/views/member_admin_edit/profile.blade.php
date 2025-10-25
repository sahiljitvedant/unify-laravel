<form id="memebrStepForm" class="">

<div class="step" data-step="2">
    <div class="row g-3">
    <div class="col-md-6 col-12">
        <label class="form-label required">{{ __('global.membership_type_label') }}</label>
        <select class="form-control" name="membership_type" id="membership_type" disabled>
            <option disabled selected>{{ __('global.select_option') }}</option>
            @foreach($memberships as $m)
                <option value="{{ $m->id }}" {{ $member->membership_type == $m->id ? 'selected' : '' }}>
                    {{ $m->membership_name }}
                </option>
            @endforeach
        </select>
        <input type="hidden" name="membership_type" value="{{ $member->membership_type }}">
    </div>


    <div class="col-md-6 col-12">
        <label class="form-label required">{{ __('global.joining_date_label') }}</label>
        <input type="text" class="form-control" 
               value="{{ $member->joining_date ?? 'N/A' }}" disabled>
    </div>
    </div>

    <div class="row g-3 mt-2">
        <div class="col-md-6 col-12">
            <label class="form-label required">{{ __('global.expiry_date_label') }}</label>
            <input type="text" class="form-control" 
                value="{{ $member->expiry_date ?? 'N/A' }}" disabled>
        </div>

        <div class="col-md-6 col-12">
            <label class="form-label required">{{ __('global.amount_paid_label') }}</label>
            <input type="text" class="form-control" 
                value="{{ $member->amount_paid ?? 'N/A' }}" disabled>
        </div>
    </div>

    <div class="row g-3 mt-2">
        <div class="col-md-6 col-12">
            <label class="form-label required">{{ __('global.payment_method_label') }}</label>
            <select class="form-control" name="payment_method" id="payment_method" disabled>
                <option disabled {{ !$member->payment_method ? 'selected' : '' }}>
                    {{ __('global.select_option') }}
                </option>
                <option value="1" {{ $member->payment_method == 1 ? 'selected' : '' }}>
                    {{ __('global.cash') }}
                </option>
                <option value="2" {{ $member->payment_method == 2 ? 'selected' : '' }}>
                    {{ __('global.card') }}
                </option>
                <option value="3" {{ $member->payment_method == 3 ? 'selected' : '' }}>
                    {{ __('global.online') }}
                </option>
            </select>
            <input type="hidden" name="payment_method" value="{{ $member->payment_method ?? '' }}">
            <div class="text-danger error-message" data-error-for="payment_method"></div>
        </div>


        @php
            $paymentMembership = optional($latestPayment)->membership;
        @endphp

        <div class="col-md-6 col-12">
            <label class="form-label required">Trainer Inculded</label>
            <input type="text" class="form-control"
                value="{{ $paymentMembership ? ($paymentMembership->trainer_included ? 'Yes' : 'No') : 'N/A' }}"
                disabled>
        </div>


    </div>
</div>
<!-- <div class="text-end mt-4">
    <button type="submit" class="btn" id="submitMemebrBtn">Submit</button>
</div> -->
</form>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
const steppermemberEditUrl = "{{ route('stepper.update', ['id' => $member->id]) }}";
</script>

<script src="{{ asset('assets/js/gym_package/edit_member_profile.js') }}"></script>
<style>
     #submitMemebrBtn
    {
        background: #0b1061;
        color: #fff;
        border: 5px solid #0b1061 !important;
        border-radius: 30px;
        font-size: 12px;
        padding: 5px;
    }
</style>