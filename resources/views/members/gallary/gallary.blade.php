@extends('members.layouts.app')

@section('title', 'Gallary')

@section('content')
<div id="loader" style="display:none;">
    <img src="{{ asset('assets/img/logo.png') }}" alt="Loading..." class="loader-img">
</div>

<div class="container-custom py-4">
    <div class="container">
        <div class="row g-4">
            <h4 class="mb-3 text-theme fw-bold">Snapshots</h4>
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

    .container-custom {
        min-height: 80vh;
        background-color: #f5f6fa;
        padding: 20px;
        border-radius: 12px;
    }
    .blog-card {
        border-radius: 12px;
        background: #fff;
        box-shadow: 0 3px 6px rgba(0,0,0,0.1);
        overflow: hidden;
        transition: transform 0.2s ease;
    }
    .blog-card:hover {
        transform: translateY(-5px);
    }
    .blog-img {
        width: 100%;
        height: 200px;
        object-fit: cover;
    }
    .blog-body {
        padding: 15px;
    }
    .text-theme {
        color: #0B1061 !important;
    }

    .pagination {
        display: flex;
        justify-content: center;
        gap: 8px;
    }

    .pagination .page-item .page-link {
        width: 38px;
        height: 38px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #0B1061;
        border: 1px solid #0B1061;
        background-color: #fff;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .pagination .page-item .page-link:hover {
        background-color: #0B1061;
        color: #fff;
    }

    .pagination .page-item.active .page-link {
        background-color: #0B1061;
        color: #fff;
        border-color: #0B1061;
    }

    .pagination .page-item.disabled .page-link {
        opacity: 0.5;
        pointer-events: none;
    }

    .pagination .page-link:focus {
        box-shadow: none;
    }
    @media (max-width: 768px) 
    {
        /* Title fully left aligned */
        h4.text-theme {
            text-align: left !important;
            margin-left: 0 !important;
            padding-left: 5px !important;
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
