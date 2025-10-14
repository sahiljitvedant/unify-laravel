@extends('members.layouts.app')

@section('title', 'Blogs')

@section('content')
<div id="loader" style="display:none;">
    <img src="{{ asset('assets/img/logo.png') }}" alt="Loading..." class="loader-img">
</div>

<div class="container-custom py-4">
    <div class="container">
        <div class="row">
            <!-- LEFT: All Blogs -->
            <div class="col-lg-8 blog_padding">
                <div class="row g-4">
                <h4 class="mb-3 text-theme fw-bold">All Blogs</h4>
                </div>
            
                <div class="row g-4" id="blogsContainer"></div>

                <!-- Pagination -->
                <nav>
                    <ul class="pagination justify-content-center mt-4" id="paginationLinks"></ul>
                </nav>
            </div>

            <!-- RIGHT: Recent Blogs Sidebar -->
            <div class="col-lg-4 blog_padding">
                <div class="row g-4">
                    <h4 class="mb-3 text-theme fw-bold">Member Choice</h4>
                </div>
                <div class="recent-blogs-sidebar position-sticky" style="top: 20px;">
                    @foreach($latestBlogs as $blog)
                        <div class="blog-card shadow-hover mb-4">
                            <a href="{{ route('member_blogs_details', $blog->id) }}" class="text-decoration-none">
                                <img src="{{ asset($blog->blog_image ?? 'assets/img/download.png') }}" class="blog-img" alt="{{ $blog->blog_title }}">
                                <div class="blog-body">
                                    <h6 class="fw-bold text-theme blog_title">{{ ucfirst($blog->blog_title) }}</h6>
                                    <p class="text-muted small mb-0 blog_desc">{{ Str::limit($blog->description, 60) }}</p>
                                    <small class="text-theme fw-semibold blog_date">{{ \Carbon\Carbon::parse($blog->publish_date)->format('d M, Y') }}</small>
                                </div>
                            </a>
                        </div>
                    @endforeach

                </div>
            </div>

        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
const fetchBlogsUrl = "{{ route('fetch_member_blogs') }}";
const assetBase = "{{ asset('') }}";
</script>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="{{ asset('assets/js/memebr_blogs/fetch_blogs.js') }}"></script>
@endpush
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
        height: 150px;
        object-fit: cover;
        border-bottom: 1px solid #eee;
    }
    .blog-body {
        padding: 10px 15px;
        background: #c7c7c7
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

  
    @media (max-width: 768px) 
    {
        .blog_padding {
            padding-left: 1px !important;  /* slightly more for mobile if needed */
            padding-right: 1px !important;
        }
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
        .blog_date,.blog_desc,.blog_title
        {
            font-size:12px !important;
        }
    }
    @media (max-width: 991px) {
        .row {
            display: flex;
            flex-direction: column-reverse; /* swaps order */
        }

        /* Optional: center headings on mobile */
        .row h4 {
            text-align: center;
        }

        /* Ensure proper spacing between sections */
        .col-lg-8,
        .col-lg-4 {
            margin-bottom: 20px;
        }
    }

</style>


