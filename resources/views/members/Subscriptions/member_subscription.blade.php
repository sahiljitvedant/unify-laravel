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
                    $isCurrentPlan = $latestPayment && $latestPayment->plan_id == $membership->id;

                    // Days left calculation
                    $daysLeft = 0;
                    if($isCurrentPlan && $latestPayment->membership_end_date) {
                        $today = \Carbon\Carbon::today();
                        $endDate = \Carbon\Carbon::parse($latestPayment->membership_end_date);
                        $daysLeft = $endDate->diffInDays($today, false);
                        if($daysLeft < 0) $daysLeft = 0;
                    }
                @endphp

                <div class="col-md-4 mb-4">
                    <div class="card d-flex flex-column p-4 position-relative">

                        {{-- Current Plan Badge --}}
                        @if($isCurrentPlan)
                            <div class="badge_icon position-absolute">Current Plan</div>
                        @endif

                        <h5 class="card-title mb-3">{{ $membership->membership_name }}</h5>
                        <div class="fw-bold fs-5 mb-2">₹{{ number_format($membership->price, 0) }}</div>

                        <hr class="my-2">
                        <div class="card-text text-start flex-grow-1 scroll-desc">
                            {!! $membership->description !!}
                        </div>
                        @if($isCurrentPlan)
                        <hr class="my-2">
                     
                        <div class="current-plan-info mb-2">
                            <div class="d-flex justify-content-between mb-1">
                                <span><strong>Start:</strong> {{ \Carbon\Carbon::parse($latestPayment->membership_start_date)->format('d M, Y') }}</span>
                                <span><strong>End:</strong> {{ \Carbon\Carbon::parse($latestPayment->membership_end_date)->format('d M, Y') }}</span>
                            </div>
                            <div class="d-flex justify-content-between">
                                <span><strong>Days Left:</strong> {{ \Carbon\Carbon::today()->diffInDays(\Carbon\Carbon::parse($latestPayment->membership_end_date)) }} day{{ \Carbon\Carbon::today()->diffInDays(\Carbon\Carbon::parse($latestPayment->membership_end_date)) > 1 ? 's' : '' }}</span>
                                <span><strong>Remaining:</strong> ₹{{ number_format($latestPayment->total_amount_remaining, 0) }}</span>
                            </div>
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
.badge_icon {
    top: 10px;
    right: 10px;
    padding: 5px 10px;
    font-size: 10px;
    font-weight: 600;
    color: #10AB29;
    background: #DFFFE4;
    border: 1px solid #9AECA7;
    border-radius: 12px;
    position: absolute;
    z-index: 10;
}


.card {
    background-color: #f2f2f2 !important;
    border-radius: 25px !important;
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    display: flex;
    flex-direction: column;
    padding: 20px;
    height: 420px;
    position: relative;
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
.current-plan-info {
    font-size: 12px;
    line-height: 1.3;
    margin-bottom: 5px;
}

.current-plan-info p {
    margin: 2px 0;
}

@media (max-width: 768px) 
{
    .container { padding: 1px !important; }
    h4.text-theme { text-align: center !important; }
    .card { text-align: left !important; padding: 12px !important; }
    .card-title { font-size: 14px !important; margin-bottom: 6px !important; }
    .card-text p { font-size: 12px !important; margin-bottom: 4px !important; }
    .fw-bold.fs-5 { font-size: 13px !important; margin-bottom: 6px !important; }
    .badge_icon { font-size: 11px !important; top: 8px; right: 8px; padding: 3px 6px !important; }
    hr.my-2 { margin: 6px 0 !important; }
}
</style>
