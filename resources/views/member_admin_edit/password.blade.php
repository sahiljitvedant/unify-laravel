@extends('layouts.app')

@section('title', 'Add Membership')

@push('styles')
<!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
@endpush

@section('content')
<div class="container-custom">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('list_dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('list_member') }}">Members</a></li>
            <li class="breadcrumb-item" aria-current="page">Change User Password</li>
        </ol>
    </nav>
    <form id="memebrPasswordForm" class="p-4 bg-light rounded shadow">
        <h4 class="mb-4">Chnage User Password</h4>
        <div class="col-md-6 col-12 position-relative mt-2">
            <label class="form-label required">New Password</label>
            <input type="password" class="form-control" 
                name="password" id="password"
                placeholder="Enter new password">
            <span class="toggle-password" data-target="password" 
                style="position:absolute; right:15px; top:30px; cursor:pointer;">
                <i class="bi bi-eye"></i>
            </span>
        </div>

        <div class="col-md-6 col-12 position-relative mt-2">
            <label class="form-label required">Confirm New Password</label>
            <input type="password" class="form-control" 
                name="password_confirmation" id="password_confirmation"
                placeholder="Re-enter new password">
            <span class="toggle-password" data-target="password_confirmation" 
                style="position:absolute; right:15px; top:30px; cursor:pointer;">
                <i class="bi bi-eye"></i>
            </span>
        </div>

        <div class="text-end mt-4">
            <button type="submit" class="btn" id="submitPasswordBtn">Submit</button>
        </div>
    </form>
</div>
@endsection
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).on('click', '.toggle-password', function() 
    {
        const inputId = $(this).data('target');
        const input = $('#' + inputId);
        const icon = $(this).find('i');

        if (input.attr('type') === 'password') {
            input.attr('type', 'text');
            icon.removeClass('bi-eye').addClass('bi-eye-slash');
        } else {
            input.attr('type', 'password');
            icon.removeClass('bi-eye-slash').addClass('bi-eye');
        }
    });
</script>
<script>
const stepperupdatePasswordUrl = "{{ route('update_member_password', ['id' => $member->id]) }}";
</script>
<script src="{{ asset('assets/js/gym_package/edit_member_password.js') }}"></script>
<style>
    #submitPasswordBtn
    {
        background: #0b1061;
        color: #fff;
        border: 5px solid #0b1061 !important;
        border-radius: 30px;
        font-size: 12px;
        padding: 5px;
    }
</style>
