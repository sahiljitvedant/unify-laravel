@extends('members.layouts.app')

@section('title', 'Member Profile')

@section('content')
<div class="container-custom py-3 px-5">

    <!-- Back Button -->
    <div class="mb-3">
    <a href="{{ route('member_my_team') }}" class="btn-back">
        <i class="bi bi-arrow-left"></i>
        <span class="btn-text">Back</span>
    </a>
</div>

    <!-- Member Profile Section -->
    <div class="row g-3">
        <!-- Profile Card -->
        <div class="col-12">
            <div class="card profile-card shadow-sm d-flex align-items-center flex-row p-3">
                <img src="{{ $member->profile_image ? asset($member->profile_image) : asset('assets/img/download.png') }}"
                     class="rounded-circle me-3"
                     alt="{{ $member->first_name }}"
                     style="width:80px; height:80px; object-fit:cover;">
                <div>
                    <h5 class="mb-1 fw-bold">
                        {{ $member->first_name ?? 'Not Available' }} {{ $member->last_name ?? '' }}
                        <span class="verified-badge ms-1">
                            <i class="bi bi-patch-check-fill"></i>
                        </span>
                    </h5>
                    <div class="text-muted small">
                        <i class="bi bi-envelope me-1"></i>{{ $member->email ?? 'Not Available' }} <br>
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
                    <p><strong>Type:</strong> {{ $member->membership_type ?? 'Not Available' }}</p>
                    <p><strong>Joining Date:</strong> {{ $member->joining_date ? date('d-m-Y', strtotime($member->joining_date)) : 'Not Available' }}</p>
                    <p><strong>Expiry Date:</strong> {{ $member->expiry_date ? date('d-m-Y', strtotime($member->expiry_date)) : 'Not Available' }}</p>

                    <p><strong>Payment Method:</strong> {{ $member->payment_method ?? 'Not Available' }}</p>
                </div>
            </div>
        </div>

        <!-- Fitness Info -->
        <div class="col-md-6">
            <div class="card info-card shadow-sm">
                <div class="card-header text-white fw-semibold">Fitness Information</div>
                <div class="card-body small text-muted">
                    <p><strong>Goal:</strong> {{ $member->fitness_goals ?? 'Not Available' }}</p>
                    <p><strong>Preferred Time:</strong> {{ $member->preferred_workout_time ?? 'Not Available' }}</p>
                    <p><strong>Current Weight:</strong> {{ $member->current_weight ?? 'Not Available' }}</p>
                    <p><strong>Notes:</strong> {{ $member->additional_notes ?? 'Not Available' }}</p>
                </div>
            </div>
        </div>
        <!-- Personal Info -->
        <div class="col-12">
            <div class="card info-card shadow-sm">
                <div class="card-header text-white fw-semibold">Personal Information</div>
                <div class="card-body small text-muted">
                    <p><strong>Date of Birth:</strong> 
                        {{ $member->dob ? \Carbon\Carbon::parse($member->dob)->format('d-m-Y') : 'Not Available' }}
                    </p>

                    <p><strong>Gender:</strong> 
                        @php
                            $genderMap = [
                                1 => 'Male',
                                2 => 'Female',
                                3 => 'Other'
                            ];
                        @endphp
                        {{ isset($genderMap[$member->gender]) ? $genderMap[$member->gender] : 'Not Available' }}
                    </p>

                    <p><strong>Address:</strong> {{ $member->residence_address ?? 'Not Available' }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

<style>
    .btn-back {
    display: inline-flex;
    align-items: center; /* vertically centers icon & text */
    gap: 6px; /* small spacing between icon and text */
    text-decoration: none;
    color: #0B1061; /* theme color */
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

/* Container */
.container-custom {
    min-height: 85vh;
    background-color: #f5f6fa;
    border-radius: 12px;
}

/* Back Button */
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

/* Profile Card */
.profile-card {
    border-radius: 12px;
    background-color: #fff;
    transition: transform 0.15s ease-in-out;
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
</style>
