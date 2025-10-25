@extends('members.layouts.app')
@section("title","Login")


@section("content")
<div class="container text-center mt-5">
    <h1 class="text-danger">Access Denied</h1>
    <p>You do not have permission to access this page.</p>

    <a href="{{ route('login_get') }}" class="btn btn_bg_color px-4 py-2">
        <i class="bi bi-box-arrow-in-right me-2"></i> Go to Login
    </a>
</div>
@endsection


