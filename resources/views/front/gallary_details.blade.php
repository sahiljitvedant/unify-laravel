@extends('front.app')

@section('content')
<div class="gallery-details" style="padding:20px;">

    <h2>{{ $gallery->gallery_name }}</h2>

    {{-- Main Thumbnail --}}
    <div class="mb-4">
        <img src="{{ asset($gallery->main_thumbnail) }}" 
             alt="{{ $gallery->gallery_name }}" 
             style="max-width:400px; border-radius:8px;">
    </div>

    {{-- Description --}}
    <p><strong>Description:</strong> {{ $gallery->gallery_description ?? 'No description available.' }}</p>

    {{-- Gallery Images --}}
    <h3>Gallery Images</h3>
    @if(!empty($gallery->gallery_images))
        <div style="display:flex; flex-wrap:wrap; gap:15px;">
            @foreach($gallery->gallery_images as $img)
                <div style="width:180px;">
                    <img src="{{ asset($img) }}" alt="Gallery Image" 
                         style="width:100%; border-radius:8px; border:1px solid #ddd;">
                </div>
            @endforeach
        </div>
    @else
        <p>No additional images found.</p>
    @endif

    {{-- YouTube Links --}}
    <h3 class="mt-4">YouTube Videos</h3>
    @if(!empty($gallery->youtube_links))
        <div style="display:grid; grid-template-columns:repeat(auto-fill, minmax(300px, 1fr)); gap:20px;">
            @foreach($gallery->youtube_links as $link)
                <div class="video-container">
                    <iframe width="100%" height="200" 
                        src="{{ str_replace('watch?v=', 'embed/', $link) }}" 
                        frameborder="0" allowfullscreen></iframe>
                </div>
            @endforeach
        </div>
    @else
        <p>No YouTube links found.</p>
    @endif

</div>
@endsection
