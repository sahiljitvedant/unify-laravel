@extends('front.app')
@section('title', 'FAQ')
<!-- Bootstrap CSS -->
 <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"> 
<!-- Bootstrap JS (includes Popper) --> 
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
@section('content')
<section id="faq-section" class="faq-section py-5">
    <div class="container">
        <h2 class="mb-4" style="color: var(--sidebar_color);">FAQ</h2>
        <div class="faq-description" style="background: var(--other_color_fff); padding:20px; border-radius:10px; box-shadow:0 2px 5px rgba(0,0,0,0.1);">
        <div class="accordion" id="faqAccordion">
            @foreach ($faqs as $faq)
                <div class="accordion-item mb-3">
                    <!-- Question -->
                    <h2 class="accordion-header" id="heading{{ $faq->id }}">
                        <button class="accordion-button collapsed" type="button" 
                                data-bs-toggle="collapse" 
                                data-bs-target="#collapse{{ $faq->id }}" 
                                aria-expanded="false" 
                                aria-controls="collapse{{ $faq->id }}">
                            {{ $faq->question }}
                        </button>
                    </h2>

                    <!-- Answer -->
                    <div id="collapse{{ $faq->id }}" 
                         class="accordion-collapse collapse" 
                         aria-labelledby="heading{{ $faq->id }}" 
                         data-bs-parent="#faqAccordion">
                        <div class="accordion-body">
                            <p>{{ $faq->answer }}</p>

                            <div class="faq-media-row">
                                {{-- If YouTube link exists, embed video --}}
                                @if ($faq->youtube_link)
                                    @php
                                        $youtubeUrl = $faq->youtube_link;
                                        $videoId = null;

                                        // Standard URL (watch?v=ID)
                                        if (preg_match('/[?&]v=([^&]+)/', $youtubeUrl, $matches)) {
                                            $videoId = $matches[1];
                                        } 
                                        // Short URL (youtu.be/ID)
                                        elseif (preg_match('/youtu\.be\/([^?&]+)/', $youtubeUrl, $matches)) {
                                            $videoId = $matches[1];
                                        }

                                        $embedLink = $videoId ? "https://www.youtube.com/embed/$videoId" : null;
                                    @endphp

                                    @if ($embedLink)
                                        <div class="faq-video">
                                            <iframe src="{{ $embedLink }}" 
                                                    title="YouTube video" 
                                                    frameborder="0" 
                                                    allowfullscreen>
                                            </iframe>
                                        </div>
                                    @endif
                                @endif

                                {{-- If image exists, show image --}}
                                @if ($faq->faq_image)
                                    <div class="faq-image">
                                        <img src="{{ asset($faq->faq_image) }}" alt="FAQ Image">
                                    </div>
                                @endif
                            </div>

                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        </div>
    </div>
</section>
@endsection

<style>
    .faq-section {
        background: var(--theme-color);
        min-height: 100vh;
    }

    .accordion-button {
        font-weight: 700;         /* bold question */
        font-size: 14px;          /* question font size */
        color: #0B1061;
    }

    .accordion-button:not(.collapsed) {
        color: var(--sidebar_color) !important;
        background-color: var(--theme-color) !important;
        box-shadow: 0 4px 6px #052c65 !important;
    }

    .accordion-button:focus {
        box-shadow: 0 4px 6px #052c65 !important;
    }

    .accordion-body {
        font-size: 14px;         /* answer font size */
        color: #555;
        line-height: 1.6;
    }

    /* Video & Image side by side */
    .faq-media-row {
        display: flex;
        gap: 15px;
        flex-wrap: wrap;
        margin-top: 10px;
    }

    .faq-video iframe {
        width: 280px;
        height: 160px;
        border-radius: 8px;
    }

    .faq-image img {
        max-width: 200px;
        height: auto;
        border-radius: 8px;
    }
</style>
