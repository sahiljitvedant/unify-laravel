@extends('members.layouts.app')
@section('title', 'Gallary')
@section('content')
<div id="loader" style="display:none;">
    <img src="{{ asset('assets/img/logo.png') }}" alt="Loading..." class="loader-img">
</div>
<div class="container-custom py-4">
    <div class="container">
        <div class="row g-4">
            <h4 class="mb-3 text-theme fw-bold">Snapshots ({{ $galleries }})</h4>
        </div>
        <div class="row" id="blogsContainer"></div>

        <!-- Pagination -->
        <nav>
            <ul class="pagination justify-content-center mt-4" id="paginationLinks"></ul>
        </nav>
    </div>
</div>
@endsection
<style>
    .gallery-card {
        transition: transform 0.3s ease;
    }
    .gallery-card:hover {
        transform: translateY(-5px);
    }
    .gallery-img {
        transition: all 0.3s ease;
        display: block;
    }
    .gallery-overlay {
        background: rgba(0, 0, 0, 0.4);
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    .gallery-card:hover .gallery-img {
        opacity: 0.5;
    }

    .gallery-card:hover .gallery-overlay {
        opacity: 1; 
    }
    .gallery-name {
        font-size: 16px;
        text-align: center;
        opacity: 1; 
        transition: opacity 0.3s ease;
        color: #0B1061 !important; 
        text-transform: capitalize; 
    }
    .gallery-card:hover .gallery-name {
        opacity: 1;
    }

    @media (max-width: 768px) 
    {
        /* Title fully left aligned */
        h4.text-theme {
            text-align: center !important;
            margin-left: 0 !important;
            
        }
        .row > .col-md-4 {
            display: flex;
            justify-content: center;
            align-items: center;
            width: 100%;
        }

        .card {
            width: 100%;
            margin: 0 auto;
        }
        .container
        {
            padding : 1px !important;
        }
    }
</style>
@push('scripts')
<script>
const fetchBlogsUrl = "{{ route('fetch_member_gallary') }}";
const assetBase = "{{ asset('') }}";
</script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="{{ asset('assets/js/memebr_gallary/member_gallary.js') }}"></script>
@endpush
