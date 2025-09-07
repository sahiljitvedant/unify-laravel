@extends('front.app')

@section('content')
  <div class="gallary_section">
    <!-- Gallery 2025 -->
    <h2 class="year-title">2025</h2>
    <div class="gallery">
        @forelse($galleries2025 as $gallery)
          <a href="{{ route('gallary_details', $gallery->id) }}">
            <div class="img-box">
                <img src="{{ $gallery->main_thumbnail 
                    ? asset($gallery->main_thumbnail) 
                    : 'https://via.placeholder.com/250x150?text=No+Image' }}" 
                    alt="{{ $gallery->gallery_name }}">
                <div class="caption">{{ $gallery->gallery_name ?? 'No data found' }}</div>
            </div>
          </a>
        @empty
            <p>No gallery found for 2025.</p>
        @endforelse
    </div>




    <!-- Gallery 2024 -->
    <h2 class="year-title">2024</h2>
    <div class="gallery">
      <!-- Independence Day -->
      <a href="independence.html">
        <div class="img-box">
        <img src="https://images.unsplash.com/photo-1605296867424-35fc25c9212a?w=600" alt="Yoga">
          <div class="caption">Independence Day 2024</div>
        </div>
      </a>

      <!-- Christmas -->
      <a href="christmas.html">
        <div class="img-box">
        <img src="https://images.unsplash.com/photo-1605296867424-35fc25c9212a?w=600" alt="Yoga">
          <div class="caption">Christmas 2024</div>
        </div>
      </a>
    </div>
  </div>
@endsection
<style>
  body 
  {
    font-family: Arial, sans-serif;
    background: #fff;
    color: #333;
    margin: 0;
    padding: 0;
  }

  .gallary_section 
  {
    padding: 30px 20px;
    background: #f9f9f9; 
  }

  .year-title {
    text-align: center;
    font-size: 28px;
    color: #0B1061;
    margin: 0px 0 10px; 
    font-weight: bold;
    position: relative;
  }

  .year-title::after {
    content: "";
    display: block;
    width: 60px;
    height: 3px;
    background: #0B1061;
    margin: 10px auto 0;
    border-radius: 2px;
  }

  .gallery {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
    gap: 20px;
    padding: 20px 0 40px;
  }

  .img-box {
    position: relative;
    overflow: hidden;
    border-radius: 10px;
    box-shadow: 0px 4px 12px rgba(0,0,0,0.1);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    background: #fff;
  }

  .img-box img {
    width: 100%;
    display: block;
    transition: transform 0.3s ease;
  }

  .img-box:hover {
    transform: translateY(-5px);
    box-shadow: 0px 6px 16px rgba(0,0,0,0.15);
  }

  .img-box:hover img {
    transform: scale(1.08);
  }

  .caption {
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    background: rgba(0, 0, 0, 0.6);
    color: #fff;
    text-align: center;
    padding: 10px;
    font-size: 16px;
    opacity: 0;
    transition: opacity 0.3s ease;
  }

  .img-box:hover .caption {
    opacity: 1;
  }

</style>