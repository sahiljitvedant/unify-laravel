@extends('layouts.app')
@section('title', 'Admin Contact Details')

@section('content')
<div class="container-custom">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('list_dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item" aria-current="page">Admin Contact Details</li>
        </ol>
    </nav>

    <form id="admin_contact_form" class="p-4 bg-light rounded shadow">
        <h4 class="mb-4">Admin Contact Details</h4>

        <div class="row g-3">

            <!-- Social Links -->
            <div class="col-md-6">
                <label class="form-label">YouTube URL</label>
                <input type="text" class="form-control" name="youtube_url" value="{{ $contact->youtube_url ?? '' }}">
                <div class="text-danger error-message" data-error-for="youtube_url"></div>
            </div>

            <div class="col-md-6">
                <label class="form-label">Facebook URL</label>
                <input type="text" class="form-control" name="facebook_url" value="{{ $contact->facebook_url ?? '' }}">
                <div class="text-danger error-message" data-error-for="facebook_url"></div>
            </div>

            <div class="col-md-6">
                <label class="form-label">LinkedIn URL</label>
                <input type="text" class="form-control" name="linkedin_url" value="{{ $contact->linkedin_url ?? '' }}">
                <div class="text-danger error-message" data-error-for="linkedin_url"></div>
            </div>

            <div class="col-md-6">
                <label class="form-label">Instagram URL</label>
                <input type="text" class="form-control" name="instagram_url" value="{{ $contact->instagram_url ?? '' }}">
                <div class="text-danger error-message" data-error-for="instagram_url"></div>
            </div>

            <!-- Contact Numbers -->
            <div class="col-md-6">
                <label class="form-label">Mobile Number 1</label>
                <input type="text" class="form-control" name="mobile_number1" value="{{ $contact->mobile_number1 ?? '' }}">
                <div class="text-danger error-message" data-error-for="mobile_number1"></div>
            </div>

            <div class="col-md-6">
                <label class="form-label">Mobile Number 2</label>
                <input type="text" class="form-control" name="mobile_number2" value="{{ $contact->mobile_number2 ?? '' }}">
                <div class="text-danger error-message" data-error-for="mobile_number2"></div>
            </div>

            <!-- Emails -->
            <div class="col-md-6">
                <label class="form-label">Email Address 1</label>
                <input type="email" class="form-control" name="email_address1" value="{{ $contact->email_address1 ?? '' }}">
                <div class="text-danger error-message" data-error-for="email_address1"></div>
            </div>

            <div class="col-md-6">
                <label class="form-label">Email Address 2</label>
                <input type="email" class="form-control" name="email_address2" value="{{ $contact->email_address2 ?? '' }}">
                <div class="text-danger error-message" data-error-for="email_address2"></div>
            </div>

            <!-- Business Info -->
            <div class="col-md-6">
                <label class="form-label">Business Hours</label>
                <input type="text" class="form-control" name="business_hours" value="{{ $contact->business_hours ?? '' }}">
                <div class="text-danger error-message" data-error-for="business_hours"></div>
            </div>

            <div class="col-md-6">
                <label class="form-label">Business Day Text</label>
                <input type="text" class="form-control" name="business_day" value="{{ $contact->business_day ?? '' }}">
                <div class="text-danger error-message" data-error-for="business_day"></div>
            </div>

        </div>

        <div class="text-end mt-4">
            <button type="submit" class="btn btn-primary" id="submitBtn">Save Details</button>
        </div>
    </form>
</div>
@endsection
@push('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="{{ asset('assets/js/admincontact/admin_contact.js') }}"></script>
@endpush
