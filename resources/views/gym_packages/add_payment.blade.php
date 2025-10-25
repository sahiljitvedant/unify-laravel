@extends('layouts.app')

@section('title', 'Add Payment')

@section('content')
<div class="container-custom">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('list_dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('list_payment') }}">Payments</a></li>
            <li class="breadcrumb-item" aria-current="page">Add Payments</li>
        </ol>
    </nav>

    <form id="add_payment" class="p-4 bg-light rounded shadow" >
        <!-- Form Heading -->
        <h4 class="mb-4">Add Payments</h4>
        <div class="step" data-step="2">
            <div class="row g-3">
                <div class="col-md-4 col-12">
                    <label class="form-label required">Select Membership</label>
                    <select class="form-control" name="membership_id" id="membership_id">
                        <option disabled selected>Select Membership</option>
                        @foreach ($membership as $m)
                            <option value="{{ $m->id }}" data-price="{{ $m->price }}"  data-duration="{{ $m->duration_in_days }}">
                                {{ $m->membership_name }}
                            </option>
                        @endforeach
                    </select>
                    <div class="text-danger error-message" data-error-for="membership_id"></div>
                </div>

                <div class="col-md-4 col-12">
                    <label class="form-label required">Price</label>
                    <input type="number" class="form-control" name="price" id="price" placeholder="Enter price" min="50">
                    <div class="text-danger error-message" data-error-for="price"></div>
                </div>

                <div class="col-md-4 col-12">
                    <label class="form-label required">Discount</label>
                    <input type="number" class="form-control" name="discount" id="discount" value="0" min="0">
                    <div class="text-danger error-message" data-error-for="discount"></div>
                </div>
                <div class="col-md-3 col-12">
                    <label class="form-label">Membership Total</label>
                    <input type="number" class="form-control" id="membership_total" disabled>
                </div>

                <div class="col-md-3 col-12">
                    <label class="form-label">Remaining Balance</label>
                    <input type="number" class="form-control" id="remaining_balance" disabled>
                </div>
                <input type="hidden" name="user_id" value="{{ $id ?? '' }}" class="form-control">
                <div class="col-md-4 col-12">
                    <label class="form-label required">Membership Start Date</label>
                    <input type="date" class="form-control" name="membership_start_date" id="membership_start_date">
                    <div class="text-danger error-message" data-error-for="membership_start_date"></div>
                </div>

                <div class="col-md-4 col-12">
                    <label class="form-label required">Membership End Date</label>
                    <input type="date" class="form-control" name="membership_end_date" id="membership_end_date" readonly>
                    <div class="text-danger error-message" data-error-for="membership_end_date"></div>
                </div>
                <div class="col-md-4 col-12">
                    <label class="form-label required">Payment Method</label>
                    <select class="form-control" name="payment_method" id="payment_method" required>
                        <option disabled selected>Select Payment Method</option>
                        <option value="1">Cash</option>
                        <option value="2">Card</option>
                        <option value="3">Online</option>
                    </select>
                    <div class="text-danger error-message" data-error-for="payment_method"></div>
                </div>


            </div>
        </div>
        <div class="text-end mt-4">
            <a href="{{ route('list_payment') }}" class="btn btn-secondary me-2 cncl_btn">
                Cancel
            </a>
            <button type="submit" class="btn" id="submitBtn">{{ __('membership.submit_button') }}</button>
        </div>
    </form>
</div>

@endsection
@push('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    const userId = "{{ $id ?? '' }}";
    const pendingPayment = @json($pendingPayment);
    const submitblog = "{{ route('submit_member_payment', ':id') }}".replace(':id', userId);
    $(document).ready(function () {
        const userId = "{{ $id ?? '' }}";
        const pendingPayment = @json($pendingPayment);

        // 🔹 Step 1: Bind membership change
        $('#membership_id').on('change', function () {
            const membershipId = $(this).val();
            const price = $(this).find(':selected').data('price') || 0;
            $('#membership_total').val(price);

            if (!membershipId || !userId) return;

            $.ajax({
                url: "{{ route('get_remaining_balance') }}",
                method: "GET",
                data: { membership_id: membershipId, user_id: userId },
                success: function (response) {
                    $('#remaining_balance').val(response.remaining ?? 0);
                },
                error: function () {
                    $('#remaining_balance').val(0);
                }
            });

            // Recalculate end date
            calculateEndDate();
        });

        // 🔹 Step 2: Handle pending payment
        if (pendingPayment) {
            const pendingPlanId = pendingPayment.plan_id;

            // Disable all other memberships
            $('#membership_id option').each(function () {
                if ($(this).val() != pendingPlanId) {
                    $(this).prop('disabled', true);
                }
            });

            // Select the pending plan
            $('#membership_id')
                .val(pendingPlanId)
                .prop('disabled', false) // current plan enabled
                .trigger('change');

            // Lock start and end date if payment is pending
            if (pendingPayment.total_amount_remaining > 0) {
                $('#membership_start_date').prop('readonly', true);
                $('#membership_end_date').prop('readonly', true);

                // Optionally, populate the existing dates if stored
                if (pendingPayment.membership_start_date) {
                    $('#membership_start_date').val(pendingPayment.membership_start_date);
                }
                if (pendingPayment.membership_end_date) {
                    $('#membership_end_date').val(pendingPayment.membership_end_date);
                }
            }
        } else {
            // If no pending payment, allow editing
            $('#membership_start_date, #membership_end_date').prop('readonly', false);
        }

        // Calculate end date function
        function calculateEndDate() {
            const startDateStr = $('#membership_start_date').val();
            const membershipDuration = parseInt($('#membership_id option:selected').data('duration')) || 0;

            if (!startDateStr || !membershipDuration) {
                $('#membership_end_date').val('');
                return;
            }

            const startDate = new Date(startDateStr);
            startDate.setDate(startDate.getDate() + membershipDuration);

            const yyyy = startDate.getFullYear();
            const mm = String(startDate.getMonth() + 1).padStart(2, '0');
            const dd = String(startDate.getDate()).padStart(2, '0');
            const endDateStr = `${yyyy}-${mm}-${dd}`;

            $('#membership_end_date').val(endDateStr);
        }

        // Trigger end date calculation
        $('#membership_start_date').on('change', calculateEndDate);
        $('#membership_id').on('change', calculateEndDate);
    });

        // Calculate end date when start date or membership changes
    function calculateEndDate() {
        const startDateStr = $('#membership_start_date').val();
        const membershipDuration = parseInt($('#membership_id option:selected').data('duration')) || 0;

        if (!startDateStr || !membershipDuration) {
            $('#membership_end_date').val('');
            return;
        }

        const startDate = new Date(startDateStr);
        startDate.setDate(startDate.getDate() + membershipDuration);
        
        // Format as yyyy-mm-dd for input[type=date]
        const yyyy = startDate.getFullYear();
        const mm = String(startDate.getMonth() + 1).padStart(2, '0');
        const dd = String(startDate.getDate()).padStart(2, '0');
        const endDateStr = `${yyyy}-${mm}-${dd}`;

        $('#membership_end_date').val(endDateStr);
    }

    // Trigger calculation when membership or start date changes
    $('#membership_start_date').on('change', calculateEndDate);
    $('#membership_id').on('change', calculateEndDate);

</script>
<script src="{{ asset('assets/js/gym_membership/add_member_payment.js') }}"></script>
@endpush

