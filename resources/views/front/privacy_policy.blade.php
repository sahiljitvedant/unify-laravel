
@extends('front.app')
@section('title', 'Privacy Policy')
@section('content')
    <!-- Privacy Policy Section -->
    <section id="privacy-policy" class="py-5" style="background:#f9f9f9;">
        <div class="container">
            <h2 class="mb-4" style="color: #0B1061;">Privacy Policy</h2>

            <!-- Description from DB -->
            <div class="policy-description" style="background: #f2f2f2; padding:20px; border-radius:10px; box-shadow:0 2px 5px rgba(0,0,0,0.1);">
            {!! nl2br($policy->description) !!}
            </div>
        </div>
    </section>
@endsection


