@extends('members.layouts.app')

@section('title', 'Member Profile')

@section('content')
<div class="container-custom py-4">
    <div class="container">
        <!-- Back Button -->
        <div class="mb-3">
            <a href="{{ url()->previous() }}" class="btn-back">
                <i class="bi bi-arrow-left"></i>
                <span class="btn-text">Back</span>
            </a>
        </div>

        <!-- Member Profile Section -->
        <div class="row g-3">
            <div class="col-12">
                <div class="card profile-card shadow-sm d-flex flex-row p-3 align-items-start">
                    <img src="{{ $member->profile_image ? asset($member->profile_image) : asset('assets/img/download.png') }}"
                        class="rounded-circle me-3"
                        alt="{{ $member->first_name }}"
                        style="width:80px; height:80px; object-fit:cover;">
                    <div class="profile-info">
                        <div class="name-row d-flex align-items-center mb-1">
                            <h5 class="fw-bold mb-0 name">
                                {{ $member->first_name ?? 'Not Available' }} {{ $member->last_name ?? '' }}
                            </h5>
                            <span class="verified-badge ms-2">
                                <i class="bi bi-patch-check-fill"></i>
                            </span>
                        </div>
                        <div class="email mb-1">
                            <i class="bi bi-envelope me-1"></i>{{ $member->email ?? 'Not Available' }}
                        </div>
                        <div class="mobile">
                            <i class="bi bi-telephone me-1"></i>{{ $member->mobile ?? 'Not Available' }}
                        </div>
                    </div>
                </div>
            </div>
            <!-- Membership Info -->
            <div class="col-md-6">
            <div class="card info-card shadow-sm">
                <div class="card-header text-white fw-semibold">Membership Details</div>
                    <div class="card-body small text-muted">
                        <p class="font_size"><strong>Type:</strong> {{ $member->membership_type ?? 'Not Available' }}</p>
                        <p class="font_size"><strong>Joining Date:</strong> {{ $member->joining_date ? date('d-m-Y', strtotime($member->joining_date)) : 'Not Available' }}</p>
                        <p class="font_size"><strong>Expiry Date:</strong> {{ $member->expiry_date ? date('d-m-Y', strtotime($member->expiry_date)) : 'Not Available' }}</p>
                        <p class="font_size"><strong>Payment Method:</strong> {{ $member->payment_method ?? 'Not Available' }}</p>
                    </div>
                </div>
            </div>

            <!-- Fitness Info -->
            <div class="col-md-6">
                <div class="card info-card shadow-sm">
                    <div class="card-header text-white fw-semibold">Fitness Information</div>
                    <div class="card-body small text-muted">
                        <p class="font_size"><strong>Goal:</strong> {{ $member->fitness_goals ?? 'Not Available' }}</p>
                        <p class="font_size"><strong>Preferred Time:</strong> {{ $member->preferred_workout_time ?? 'Not Available' }}</p>
                        <p class="font_size"><strong>Current Weight:</strong> {{ $member->current_weight ?? 'Not Available' }}</p>
                        <p class="font_size"><strong>Notes:</strong> {{ $member->additional_notes ?? 'Not Available' }}</p>
                    </div>
                </div>
            </div>
            <!-- Personal Info -->
            <div class="col-12">
                <div class="card info-card shadow-sm">
                    <div class="card-header text-white fw-semibold">Personal Information</div>
                    <div class="card-body small text-muted">
                        <p class="font_size"><strong>Date of Birth:</strong> 
                            {{ $member->dob ? \Carbon\Carbon::parse($member->dob)->format('d-m-Y') : 'Not Available' }}
                        </p>

                        <p class="font_size"><strong>Gender:</strong> 
                            @php
                                $genderMap = [
                                    1 => 'Male',
                                    2 => 'Female',
                                    3 => 'Other'
                                ];
                            @endphp
                            {{ isset($genderMap[$member->gender]) ? $genderMap[$member->gender] : 'Not Available' }}
                        </p>

                        <p class="font_size"><strong>Address:</strong> {{ $member->residence_address ?? 'Not Available' }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

<style>
   
    .btn-back {
        display: inline-flex;
        align-items: center; 
        gap: 6px; 
        text-decoration: none;
        color: #0B1061;
        font-weight: 500;
    }

    .btn-back:hover {
        color: #05093a;
    }

    .btn-back i {
        font-size: 18px;
        line-height: 1;
    }

    .btn-text {
        font-size: 14px;
        line-height: 1;
    }

    .container-custom {
        min-height: 85vh;
        background-color: #f5f6fa;
        border-radius: 12px;
    }

    .btn-back {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        color: #0B1061;
        font-size: 22px;
        text-decoration: none;
        border: none;
        background: none;
        padding: 0;
        transition: transform 0.15s ease-in-out;
    }
    .btn-back:hover {
        transform: translateX(-3px);
    }

    .profile-card {
        border-radius: 12px;
        background-color: #fff;
        transition: transform 0.15s ease-in-out;
        width: 100%;
        max-width: 100%;
        box-sizing: border-box;
    }

    .profile-card:hover {
        transform: translateY(-1px);
    }
    .verified-badge {
        color: #0B1061;
        font-size: 18px;
    }

    /* Info Cards */
    .info-card {
        border-radius: 12px;
        background-color: #fff;
        transition: transform 0.15s ease-in-out;
    }
    .info-card:hover {
        transform: translateY(-2px);
    }
    .info-card .card-header {
        background-color: #0B1061;
        border-top-left-radius: 12px;
        border-top-right-radius: 12px;
        font-size: 14px;
        padding: 8px 14px;
    }
    .info-card .card-body p {
        margin-bottom: 6px;
        font-size: 13px;
        color: #444;
    }
    .text-muted {
        color: #555 !important;
    }
    .name
    {
        font-size: 16px;
    }
    .email, .mobile 
    {
        font-size: 14px;
    }

    /* Mobile view adjustments */

    @media (max-width: 768px) 
    {
        .info-card,
        .profile-card {
            text-align: left !important;
        }
        
        /* If some inner elements have flex or justify-content styles that center things, override them */
        .info-card .card-body,
        .info-card .card-header,
        .profile-card .profile-info,
        .profile-card .name-row {
            text-align: left !important;
            justify-content: flex-start !important;
            align-items: flex-start !important;
        }
        .container
        {
            padding: 1px !important;
        }

       .btn-text {
            text-align: left !important;
            margin-left: 0 !important;
            padding-left: 5px !important;
        }
        .mb-3 {
        text-align: left !important;
        }

        .profile-card {
            flex-direction: row !important;
            align-items: flex-start;
            text-align: left;
            padding: 10px !important;
            flex-wrap: wrap;
        }

        .profile-card img {
            margin-bottom: 0 !important;
            width: 80px !important;
            height: 80px !important;
            flex-shrink: 0; 
        }

        .profile-info {
            flex: 1;
            display: flex;
            flex-direction: column;
        }

        .name-row {
            display: flex;
            align-items: center;
            flex-wrap: wrap; 
        }

        .verified-badge {
            color: #0B1061;
            font-size: 18px;
        }

        .email, .mobile {
            font-size: 11px;
            margin-top: 4px;
        }
        .name
        {
            font-size: 12px;
        }
        .email i, .mobile i {
            margin-right: 5px;
        }
        .card-header.text-white.fw-semibold
        {
            font-size: 12px;
        }
        .info-card .card-body p {
            margin-bottom: 6px;
            font-size: 11px;
            color: #444;
        }
    }

</style>
