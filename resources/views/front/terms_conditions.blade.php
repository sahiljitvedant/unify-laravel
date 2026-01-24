
@extends('front.app')
@section('title', 'Terms & Condition')
@section('content')
    <!-- Privacy Policy Section -->
    <section id="privacy-policy" class="py-5" style="background: var(--theme-color);">
        <div class="container">
            <h2 class="mb-4" style="color: var(--sidebar_color);">Terms and Condition</h2>

            <!-- Description from DB -->
            <div class="policy-description" style="background: var(--other_color_fff); padding:20px; border-radius:10px; box-shadow:0 2px 5px rgba(0,0,0,0.1); font-size: 12px;">
                {!! nl2br($terms->description) !!}
            </div>
        </div>
    </section>
@endsection


