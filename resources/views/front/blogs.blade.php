@extends('front.app')
@section('title', 'Blogs')
@section('content')
<section id="blogs-section" class="blogs-section py-5">
    <div class="container">
        <div class="row">
            <!-- Main Blog Cards -->
            <div class="col-lg-8">
                <div class="blogs-grid">
                    @foreach($blogs as $blog)
                        <div class="blog-card">
                            <img src="{{ $blog->blog_image ?? 'https://images.unsplash.com/photo-1605296867424-35fc25c9212a?w=600' }}" alt="{{ $blog->blog_title }}">
                            <div class="blog-content">
                                <span class="blog-date">{{ \Carbon\Carbon::parse($blog->publish_date)->format('d M') }}</span>
                                <h3 class="blog-title">{{ \Illuminate\Support\Str::words($blog->blog_title, 10, '...') }}</h3>
                                <p>{{ \Illuminate\Support\Str::words($blog->description, 20, '...') }}</p>
                                <div class="text-end">
                                <a href="{{ route('blogs_read_more', ['id' => encrypt($blog->id)]) }}" class="btn-read">
                                    Read More
                                </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>


            <!-- Sidebar Recent Posts -->
            <div class="col-lg-4">
                <div class="recent-posts-card p-3" style="background-color: #f2f2f2; border-radius: 10px;">
                    <h4 class="sidebar-title">Recent Posts</h4>
                    <div class="recent-posts-card p-3" style="background-color: #f2f2f2; border-radius: 10px;">

                        <div class="recent-posts">
                            @foreach($recent_blogs as $recent)
                            <div class="recent-post">
                                <img src="{{ $recent->blog_image ?? 'https://images.unsplash.com/photo-1605296867424-35fc25c9212a?w=100' }}" 
                                    alt="{{ $recent->blog_title }}">
                                <div>
                                    <h5><a href="{{ route('blogs_read_more', ['id' => encrypt($recent->id)]) }}">
                                        {{ \Illuminate\Support\Str::words($recent->blog_title, 10, '...') }}
                                    </a></h5>
                                    <p class="text-muted small mb-0 blog_desc">
    {{ \Illuminate\Support\Str::words(strip_tags(html_entity_decode($blog->description)), 20, '...') }}
</p>

                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</section>
@endsection

<style>
.blogs-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 20px;
   
}

.blog-card {
    background: #f2f2f2;
    border-radius: 12px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    overflow: hidden;
    transition: transform 0.3s ease;
}

.blog-card:hover {
    transform: translateY(-5px);
}

.blog-card img {
    width: 100%;
    height: 200px;
    object-fit: cover;
}

.blog-content {
    padding: 15px 20px;
}

.blog-date {
    font-size: 0.85rem;
    color: #888;
}

.blog-title {
    font-size: 1.25rem;
    margin: 5px 0 10px 0;
    color: #0B1061;
}

.blog-content p {
    font-size: 0.95rem;
    color: #555;
}

.btn-read {
    display: inline-block;
    margin-top: 10px;
    color: #0B1061;
    font-weight: 600;
    text-decoration: none;
}

.btn-read:hover {
    text-decoration: underline;
}

/* Sidebar */
.sidebar-title {
    font-size: 1.25rem;
    margin-bottom: 15px;
    color: #0B1061;
}

.recent-posts {
    display: flex;
    flex-direction: column;
    gap: 15px;
}

.recent-post {
    display: flex;
    align-items: center;
    gap: 10px;
}

.recent-post img {
    width: 60px;
    height: 60px;
    object-fit: cover;
    border-radius: 6px;
}

.recent-post h5 {
    font-size: 1rem;
    margin: 0;
}

.recent-post h5 a {
    text-decoration: none;
    color: #0B1061;
}

.recent-post h5 a:hover {
    text-decoration: underline;
}

/* Responsive */
@media (max-width: 992px) {
    .blogs-grid {
        grid-template-columns: 1fr;
    }
}

@media (max-width: 576px) {
    .recent-posts {
        flex-direction: column;
    }
}

/* Hide Recent Posts on screens smaller than 1024px */
@media (max-width: 768px) {
    .recent-posts-card {
        display: none;
    }
}

</style>
