@extends('members.layouts.app')

@section('title', 'Blogs')

@section('content')
<div id="loader" style="display:none;">
    <img src="{{ asset('assets/img/logo.png') }}" alt="Loading..." class="loader-img">
</div>

<div class="container-custom py-4">
    <div class="row">
        <!-- LEFT: All Blogs -->
        <div class="col-lg-8">
            <h4 class="mb-3 text-theme fw-bold">All Blogs</h4>
            <div class="row g-4" id="blogsContainer"></div>

            <!-- Pagination -->
            <nav>
                <ul class="pagination justify-content-center mt-4" id="paginationLinks"></ul>
            </nav>
        </div>

        <!-- RIGHT: Recent Blogs Sidebar -->
        <div class="col-lg-4">
            <h4 class="mb-3 text-theme fw-bold">Member Choice</h4>
            <div class="recent-blogs-sidebar position-sticky" style="top: 20px;">
                @foreach($blogs->take(3) as $blog)
                <div class="blog-card shadow-hover mb-4">
                    <img src="{{ asset($blog->image_path ?? 'assets/img/download.png') }}" class="blog-img" alt="{{ $blog->title }}">
                    <div class="blog-body">
                        <h6 class="fw-bold text-theme">{{ ucfirst($blog->title) }}</h6>
                        <p class="text-muted small mb-0">{{ Str::limit($blog->description, 60) }}</p>
                        <small class="text-theme fw-semibold">{{ \Carbon\Carbon::parse($blog->publish_date)->format('d M, Y') }}</small>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection


<style>
    .container-custom {
        min-height: 80vh;
        background-color: #f5f6fa;
        padding: 30px;
        border-radius: 12px;
    }

    /* BLOG CARDS */
    .blog-card {
        border-radius: 12px;
        overflow: hidden;
        background: linear-gradient(135deg, #ffffff, #f0f2ff);
        box-shadow: 0 5px 15px rgba(0,0,0,0.05);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        cursor: pointer;
    }
    .blog-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 10px 25px rgba(0,0,0,0.15);
    }
    .blog-img {
        width: 100%;
        height: 150px; /* slightly smaller for sidebar */
        object-fit: cover;
        border-bottom: 1px solid #eee;
    }
    .blog-body {
        padding: 10px 15px;
    }
    .text-theme {
        color: #0B1061 !important;
    }
    .shadow-hover:hover {
        box-shadow: 0 12px 30px rgba(11,16,97,0.3);
    }

    /* Recent Blogs Sidebar */
    .recent-blogs-sidebar .blog-card {
        margin-bottom: 20px;
    }

    /* Pagination */
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


</style>

@push('scripts')
<script>
const fetchBlogsUrl = "{{ route('fetch_member_blogs') }}";
const assetBase = "{{ asset('') }}";
</script>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="{{ asset('assets/js/memebr_blogs/fetch_blogs.js') }}"></script>



@endpush
