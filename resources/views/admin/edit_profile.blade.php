@extends('layouts.app')
@section('title', 'Edit Profile')
@section('content')
<div class="container-custom">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('list_dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item" aria-current="page">Edit Profile</li>
        </ol>
    </nav>

    <form id="admin_profile_edit_form" class="p-4 bg-light rounded shadow">
        <h4 class="mb-4">Edit Profile</h4>

        <div class="row g-3">
            <div class="col-md-6 col-12">
                <label class="form-label required">Name</label>
                <input type="text" class="form-control" name="name" id="name"
                    value="{{ $user->name }}"
                    placeholder="Enter your full name">
                <div class="text-danger error-message" data-error-for="name"></div>
            </div>

            <div class="col-md-6 col-12">
                <label class="form-label required">Email</label>
                <input type="email" class="form-control" name="email" id="email"
                    value="{{ $user->email }}"
                    placeholder="Enter your email address">
                <div class="text-danger error-message" data-error-for="email"></div>
            </div>
        </div>

        <div class="text-end mt-4">
            <a href="{{ url()->previous() }}" class="btn btn-secondary me-2 cncl_btn">Cancel</a>
            <button type="submit" class="btn btn-primary" id="submitBtn">Update Profile</button>
        </div>
    </form>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
 const updateProfileUrl = "{{ route('update_admin_profile', ['id' => $user->id]) }}";
</script>
<script src="{{ asset('assets/js/admin/edit_profile.js') }}"></script>
@endsection
