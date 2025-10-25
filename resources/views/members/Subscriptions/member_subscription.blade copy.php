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
                        $showButton = false; // hide button for current plan
                    }

                    // Hide button for lower/equal price plans (except current plan)
                    if($currentSubscription && $membership->price <= $currentSubscription->amount && !$isCurrentPlan){
                        $showButton = false;
                    }

                    // Higher price plans → show Upgrade button
                    if($currentSubscription && $membership->price > $currentSubscription->amount){
                        $buttonText = 'Upgrade';
                    }

                    // All possible facilities
                    $allFacilities = [
                        1 => 'Cardio',
                        2 => 'Yoga',
                        3 => 'Zumba',
                        4 => 'Steam Bath',
                        5 => 'Swimming Pool',
                        6 => 'Sauna',
                    ];

                    // Decode membership facilities
                    $included = $membership->facilities_included ? json_decode($membership->facilities_included, true) : [];
                @endphp

                <div class="col-md-4 mb-4">
                    <div class="card d-flex flex-column p-4 position-relative">
                        
                        {{-- Current Plan Badge --}}
                        @if($isCurrentPlan)
                            <span class="badge_icon  position-absolute"> Current Plan</span>
                        @endif

                        <h5 class="card-title mb-3" style="{{ $isCurrentPlan ? '' : '' }}">
                            {{ $membership->membership_name }}
                        </h5>
                        <div class="fw-bold fs-5 mb-2">₹{{ number_format($membership->price, 0) }}</div>


                        <hr class="my-2"> 

                        <div class="card-text text-start flex-grow-1 scroll-desc" style="{{ $isCurrentPlan ? '' : '' }}">
                            <!-- @foreach($allFacilities as $id => $name)
                                @if(in_array($id, $included))
                                    <p class="feature text-success">✓ {{ $name }}</p>
                                @else
                                    <p class="feature text-danger">✗ {{ $name }}</p>
                                @endif
                            @endforeach -->
                            <p> ✔ Cardio – Great for building stamina and overall fitness.</p>            
                            <p> ✔ Yoga – Excellent for flexibility, balance, and stress</p>                  
                            <p>✔ Zumba – Fun way to burn calories with dance workouts.</p>
                            <p> ✖ Steam Bath – Not included, so users needing relaxation won’t have it.</p>
                            <p> ✖ Swimming Pool / ✖ Sauna – Missing amenities for aquatic and heat-based</p> 
                        </div>

                        <div class="mt-3">
                           
                            
                            @if($showButton)
                                <button class="btn btn-primary w-100 subscribe-btn" 
                                        data-amount="{{ $membership->price }}" 
                                        data-plan="{{ $membership->membership_name }}"
                                        data-id="{{ $membership->id }}">
                                    {{ $buttonText }}
                                </button>
                            @endif
                        </div>
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

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
<script>
$(document).on('click', '.subscribe-btn', function() {
    let planId   = $(this).data('id');  // plan_id from button
    let planName = $(this).data('name'); // optional display
    let amount   = $(this).data('amount');    // amount from plan
    $.ajax({
        url: "{{ route('payment.create') }}",
        type: "POST",
        data: {
            plan_id: planId,
            plan_name: planName,
            amount: amount,
            _token: "{{ csrf_token() }}"
        },
        success: function(response) {
            var options = {
                "key": response.razorpay_key,
                "amount": response.amount * 100,
                "currency": response.currency,
                "name": "MyApp Subscription",
                "description": response.plan_name,
                "order_id": response.order_id,
                "handler": function (paymentResponse) {
                    $.ajax({
                        url: "{{ route('payment.verify') }}",
                        type: "POST",
                        data: {
                            order_id: response.order_id,
                            payment_id: paymentResponse.razorpay_payment_id,
                            signature: paymentResponse.razorpay_signature,
                            plan_id: planId,     // ✅ send back
                            amount: response.amount,       // ✅ send back
                            _token: "{{ csrf_token() }}"
                        },
                        success: function(verifyRes) {
                            Swal.fire({
                                icon: verifyRes.status === 'success' ? 'success' : 'error',
                                title: verifyRes.status === 'success' ? 'Payment Successful' : 'Payment Failed',
                                text: verifyRes.status === 'success' 
                                        ? 'Your subscription has started!' 
                                        : verifyRes.message,
                            }).then(() => window.location.reload());
                        },
                        error: function(err){
                            console.error(err);
                            Swal.fire('Error', 'Payment verification failed!', 'error');
                        }
                    });
                },
                "theme": {"color": "#0B1061"}
            };
            var rzp1 = new Razorpay(options);
            rzp1.open();
        },
        error: function(err){
            console.error(err);
            Swal.fire('Error', 'Order creation failed!', 'error');
        }
    });
});
</script>
