@extends('members.layouts.app')

@section('title', 'Member Dashboard')

@section('content')

<div id="loader" style="display:none;">
    <img src="{{ asset('assets/img/logo.png') }}" alt="Loading..." class="loader-img">
</div>

<div class="container-custom py-4">
    <div class="container">
        <div class="row g-4">
            <h4 class="mb-3 text-theme fw-bold">My Subscription</h4>
        </div>
        <div class="row">
            @foreach($memberships as $membership)
                @php
                    $buttonText = 'Subscribe';
                    $isCurrentPlan = false;
                    $showButton = true;

                    // Check if this is the user's current plan
                    if($currentSubscription && $membership->id == $currentSubscription->plan_id){
                        $isCurrentPlan = true;
                        $showButton = false;
                    }

                    // Hide button for lower/equal price plans (except current plan)
                    if($currentSubscription && $membership->price <= $currentSubscription->amount && !$isCurrentPlan)
                    {
                        $showButton = false;
                    }

                    // Higher price plans → show Upgrade button
                    if($currentSubscription && $membership->price > $currentSubscription->amount)
                    {
                        $buttonText = 'Upgrade';
                    }

                    // Simulate paid amount (you'll fetch this later from DB)
                    $paidAmount = $membership->paid_amount ?? 0;
                    $remaining = max($membership->price - $paidAmount, 0);
                @endphp

                <div class="col-md-4 mb-4">
                    <div class="card d-flex flex-column p-4 position-relative">

                        {{-- Current Plan Badge --}}
                        @if($isCurrentPlan)
                            <span class="badge_icon position-absolute">Current Plan</span>
                        @endif

                        <h5 class="card-title mb-3">{{ $membership->membership_name }}</h5>
                        <div class="fw-bold fs-5 mb-2">₹{{ number_format($membership->price, 0) }}</div>

                        <hr class="my-2">

                        <div class="card-text text-start flex-grow-1 scroll-desc">
                            <p>✔ Cardio – Great for building stamina and overall fitness.</p>
                            <p>✔ Yoga – Excellent for flexibility, balance, and stress.</p>
                            <p>✔ Zumba – Fun way to burn calories with dance workouts.</p>
                            <p>✖ Steam Bath – Not included.</p>
                            <p>✖ Swimming Pool / ✖ Sauna – Missing amenities.</p>
                        </div>

                        @if($showButton)
                            <div class="mt-3">
                                {{-- Remaining balance info --}}
                                <p class="small text-muted mb-1">
                                    Remaining balance: ₹<span class="remaining">{{ $remaining }}</span>
                                </p>

                                {{-- Payment Input --}}
                                <input type="number"
                                       class="form-control mb-2 payment-amount"
                                       placeholder="Enter amount (min ₹100)"
                                       min="100"
                                       step="1"
                                       data-max="{{ $remaining }}"
                                       {{ $remaining < 100 ? 'disabled' : '' }}>

                                {{-- Pay/Subscribe Button --}}
                                <button class="btn btn-primary w-100 subscribe-btn"
                                        data-plan="{{ $membership->membership_name }}"
                                        data-id="{{ $membership->id }}">
                                    {{ $buttonText }}
                                </button>
                            </div>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>

@endsection
<style>
    .badge_icon
    {
        top:10px;
        right:10px;
        font-size:12px;
        padding:  5px 10px 5px 20px;
        border-radius: 12px;
        background: #DFFFE4;
        border: solid 1px #9AECA7;
        font-size: 10px;
        font-weight: 500;
        font-family: "Montserrat", sans-serif;
        position: absolute;
        border-radius: 28px;
        color: #10AB29;
        
    }
    .container-custom {
        min-height: 80vh;
        background-color: #f5f6fa;
        padding: 20px;
        border-radius: 12px;
    }
    .text-theme { color: #0B1061 !important; }
    .card {
        background-color: #f2f2f2 !important;
        border-radius: 25px !important;
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        display: flex;
        flex-direction: column;
        padding: 20px;
        height: 420px;
    }

    .card:hover {
        /* transform: translateY(-5px); */
    }

    .card-title {
        font-size: 18px;
        font-weight: 600;
        color: #0B1061;
    }

    .card-text {
        font-size: 14px;
        flex-grow: 1;
        overflow-y: auto; 
        padding-right: 5px;
        margin-bottom: 10px;
    }

    .scroll-desc::-webkit-scrollbar {
        width: 5px;
    }

    .scroll-desc::-webkit-scrollbar-thumb {
        background-color: rgba(0,0,0,0.2);
        border-radius: 5px;
    }

    .feature {
     margin-bottom: 10px;
    }

    .btn-primary {
    background-color: #0B1061 !important;
    border: none !important;
    padding: 10px 0;
    border-radius: 12px;
    }

    .card > div.mt-3 {
    margin-top: auto;
    }
   
    @media (max-width: 768px) 
    {
        .container
        {
            padding: 1px !important;
        }
        /* Title fully left aligned */
        h4.text-theme {
            text-align: center !important;
        
            
        }

        .card {
            text-align: left !important;
            padding: 12px !important;
        }

        .card-title {
            font-size: 14px !important;
            margin-bottom: 6px !important;
            line-height: 1.3;
        }

        .card-text p {
            font-size: 12px !important;
            margin-bottom: 4px !important;
            line-height: 1.4;
        }

        .subscribe-btn {
            font-size: 12px !important;
            padding: 6px 10px !important;
            margin-top: 6px !important;
        }

        .fw-bold.fs-5 {
            font-size: 13px !important;
            margin-bottom: 6px !important;
        }

        .badge_icon {
            font-size: 11px !important;
            top: 8px;
            right: 8px;
            padding: 3px 6px !important;
        }

        hr.my-2 {
            margin: 6px 0 !important;
        }
    }



</style>
@push('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
<script>
    $(document).ready(function () 
    {
        $(document).on('click', '.subscribe-btn', function () {
            const $btn = $(this);
            const $card = $btn.closest('.card');
            const $loader = $("#loader");
            const planId = $btn.data('id');
            const planName = $btn.data('plan');
            const planAmount = parseFloat($btn.data('amount')); // full plan amount
            const enteredAmount = parseFloat($card.find('.payment-amount').val());
            const remaining = parseFloat($card.find('.payment-amount').data('max'));

            // ---- VALIDATION ----
            if (isNaN(enteredAmount)) {
                Swal.fire('Warning', 'Please enter an amount.', 'warning');
                return;
            }
            if (enteredAmount < 100 && remaining >= 100) {
                Swal.fire('Warning', 'Minimum payment is ₹100.', 'warning');
                return;
            }
            if (enteredAmount > remaining) {
                Swal.fire('Warning', 'You cannot pay more than ₹' + remaining + '.', 'warning');
                return;
            }

            $loader.show();

            // ---- STEP 1: CREATE ORDER ----
            $.ajax({
                url: "{{ route('payment.create') }}",
                type: "POST",
                data: {
                    plan_id: planId,
                    plan_name: planName,
                    amount: enteredAmount, // user-entered partial amount
                    _token: "{{ csrf_token() }}"
                },
                success: function (response) {
                    // ---- STEP 2: OPEN RAZORPAY ----
                    var options = {
                        "key": response.razorpay_key,
                        "amount": response.amount * 100,
                        "currency": response.currency,
                        "name": "MyApp Subscription",
                        "description": response.plan_name,
                        "order_id": response.order_id,
                        "handler": function (paymentResponse) {
                            // ---- STEP 3: VERIFY PAYMENT ----
                            $.ajax({
                                url: "{{ route('payment.verify') }}",
                                type: "POST",
                                data: {
                                    order_id: response.order_id,
                                    payment_id: paymentResponse.razorpay_payment_id,
                                    signature: paymentResponse.razorpay_signature,
                                    plan_id: planId,
                                    amount: response.amount,
                                    _token: "{{ csrf_token() }}"
                                },
                                success: function (verifyRes) {
                                    Swal.fire({
                                        icon: verifyRes.status === 'success' ? 'success' : 'error',
                                        title: verifyRes.status === 'success' ? 'Payment Successful' : 'Payment Failed',
                                        text: verifyRes.status === 'success'
                                            ? 'Your payment of ₹' + enteredAmount + ' was successful!'
                                            : verifyRes.message,
                                    }).then(() => window.location.reload());
                                },
                                error: function (err) {
                                    console.error(err);
                                    Swal.fire('Error', 'Payment verification failed!', 'error');
                                }
                            });
                        },
                        "theme": { "color": "#0B1061" }
                    };
                    var rzp1 = new Razorpay(options);
                    rzp1.open();
                },
                error: function (err) {
                    console.error(err);
                    Swal.fire('Error', 'Order creation failed!', 'error');
                },
                complete: function () {
                    $loader.hide();
                }
            });
        });
    });
</script>
@endpush

