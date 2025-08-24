@extends('layouts.app')
@section("title","Login")


@section("content")
<div class="container text-center mt-5">
    <h1 class="text-danger">Access Denied</h1>
    <p>You do not have permission to access this page. Please <a href="{{ route('login_get') }}">login</a> first.</p>
</div>
@endsection


