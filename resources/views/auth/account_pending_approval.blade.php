@extends('layouts.front_app')
@section("title","Account Created")
@section('right-section')
<div class="d-flex flex-column align-items-center w-100 px-4">
    <img src="{{ asset('assets/img/logo.png') }}" alt="Logo" 
         style="height: 65px; width:180px; object-fit:cover; border-radius:10px; border:1px solid #0B1061" class="mt-2">

    <div class="login-box mt-4 text-center">
        <h5 class="text-success mb-3">Account Created Successfully!</h5>
        <p class="mb-3">
            We have created your account. Kindly contact the administrator for approval and start enjoying the application once approved.
        </p>
        <a href="{{ url('/login') }}" class="btn btn-primary">Login</a>
    </div>
</div>
@endsection
