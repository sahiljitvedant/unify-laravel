@extends('front.app')
@section('title', 'FAQ')
<!-- Bootstrap CSS -->
 <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"> 
<!-- Bootstrap JS (includes Popper) --> 
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
@section('content')
<section id="faq-section" class="faq-section py-5">
    <div class="container">
        <h2 class="mb-4" style="color: var(--sidebar_color);">FAQ's</h2>
        <div class="faq-description" style="background: var(--other_color_fff); padding:20px; border-radius:10px;">
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
                            <p>{!! $faq->answer !!}</p>

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
    /* ===== FAQ SECTION ===== */
.faq-section {
    background: var(--theme-color);
    padding: 80px 0;
}

/* Container Card */
.faq-description {
    background: #ffffff;
    padding: 25px;
    border-radius: 14px;
    box-shadow: 0 12px 35px rgba(0,0,0,0.08);
}

/* ===== ACCORDION ===== */
.accordion-item {
    border: none;
    border-radius: 12px !important;
    overflow: hidden;
    box-shadow: 0 8px 22px rgba(0,0,0,0.06);
    transition: all 0.3s ease;
}

.accordion-item:hover {
    transform: translateY(-3px);
    box-shadow: 0 14px 35px rgba(0,0,0,0.12);
}

/* Question Button */
.accordion-button {
    font-weight: 600;
    font-size: 15px;
    color: #0B1061;
    background: #f9fbfc;
    padding: 16px 18px;
}

.accordion-button:not(.collapsed) {
    color: var(--sidebar_color) !important;
    background-color: #eaf6f3 !important;
    box-shadow: none !important;
}

.accordion-button:focus {
    box-shadow: 0 0 0 0.2rem rgba(0,150,136,0.25) !important;
}

/* Answer Body */
.accordion-body {
    font-size: 14px;
    color: #555;
    line-height: 1.7;
    background: #ffffff;
    padding: 18px;
    border-top: 1px solid #f1f1f1;
}

/* ===== MEDIA (Video + Image) ===== */
.faq-media-row {
    display: flex;
    gap: 18px;
    flex-wrap: wrap;
    margin-top: 15px;
    align-items: flex-start;
}

/* Video */
.faq-video iframe {
    width: 320px;
    height: 180px;
    border-radius: 10px;
    box-shadow: 0 8px 20px rgba(0,0,0,0.15);
}

/* Image */
.faq-image img {
    max-width: 240px;
    border-radius: 10px;
    box-shadow: 0 8px 20px rgba(0,0,0,0.12);
}

/* ===== MOBILE RESPONSIVE ===== */
@media (max-width: 768px) 
{

    .faq-description {
        padding: 18px;
    }

    .accordion-button {
        font-size: 14px;
        padding: 14px;
    }

    .accordion-body {
        font-size: 13px;
        padding: 15px;
    }

    .faq-media-row {
        flex-direction: column;
    }

    .faq-video iframe {
        width: 100%;
        height: 200px;
    }

    .faq-image img {
        max-width: 100%;
    }
}

</style>
