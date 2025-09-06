@extends('front.app')

@section('content')
<section id="about-contact" class="about-contact">
<h2 class="section-title">Blogs</h2>
    <div class="about-container">
        <div class="blogs-grid mt-1">
            <div class="class-item">
                <img src="https://images.unsplash.com/photo-1605296867424-35fc25c9212a?w=600" alt="Yoga">
                <h3>Yoga</h3>
                <p>Improve flexibility, balance, and mental focus with our yoga sessions.</p>
                <a href="{{ route('blogs_read_more') }}" class="btn-read">Read More
                <i class="bi bi-arrow-right fs-5 ms-1 align-middle"></i>
                </a>
            </div>
            <div class="class-item">
                <img src="https://images.unsplash.com/photo-1605296867424-35fc25c9212a?w=600" alt="Cardio">
                <h3>Cardio</h3>
                <p>Boost your heart health and stamina with our intensive cardio workouts.</p>
                <a href="{{ route('blogs_read_more') }}" class="btn-read">Read More
                <i class="bi bi-arrow-right fs-5 ms-1 align-middle"></i>
                </a>
            </div>
            <div class="class-item">
                <img src="https://images.unsplash.com/photo-1605296867424-35fc25c9212a?w=600" alt="Crossfit">
                <h3>CrossFit</h3>
                <p>Challenge yourself with high-intensity CrossFit exercises for full-body strength.</p>
                <a href="{{ route('blogs_read_more') }}" class="btn-read">Read More
                <i class="bi bi-arrow-right fs-5 ms-1 align-middle"></i>
                </a>
            </div>
            <!-- Add more cards here -->
        </div>
        <div class="blogs-grid mt-1">
            <div class="class-item">
                <img src="https://images.unsplash.com/photo-1605296867424-35fc25c9212a?w=600" alt="Yoga">
                <h3>Yoga</h3>
                <p>Improve flexibility, balance, and mental focus with our yoga sessions.</p>
                <a href="{{ route('blogs_read_more') }}" class="btn-read">Read More
                <i class="bi bi-arrow-right fs-5 ms-1 align-middle"></i>
                </a>
            </div>
            <div class="class-item">
                <img src="https://images.unsplash.com/photo-1605296867424-35fc25c9212a?w=600" alt="Cardio">
                <h3>Cardio</h3>
                <p>Boost your heart health and stamina with our intensive cardio workouts.</p>
                <a href="{{ route('blogs_read_more') }}" class="btn-read">Read More
                <i class="bi bi-arrow-right fs-5 ms-1 align-middle"></i>
                </a>
            </div>
            <div class="class-item">
                <img src="https://images.unsplash.com/photo-1605296867424-35fc25c9212a?w=600" alt="Crossfit">
                <h3>CrossFit</h3>
                <p>Challenge yourself with high-intensity CrossFit exercises for full-body strength.</p>
                <a href="{{ route('blogs_read_more') }}" class="btn-read">Read More
                <i class="bi bi-arrow-right fs-5 ms-1 align-middle"></i>
                </a>
            </div>
            <!-- Add more cards here -->
        </div>
    </div>
</section>
@endsection
<style>
    .blogs-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr); /* 3 cards per row */
        gap: 20px; /* space between cards */
    }

    .class-item {
        background: #fff;
        border-radius: 12px;
        padding: 20px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        text-align: center;
        transition: transform 0.3s ease;
    }

    .class-item:hover {
        transform: translateY(-5px);
    }

    .class-item img {
        width: 100%;
        height: 200px;
        object-fit: cover;
        border-radius: 10px;
        margin-bottom: 15px;
    }

    /* Responsive (mobile: 1 per row, tablet: 2 per row) */
    @media (max-width: 992px) {
        .blogs-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }
    @media (max-width: 576px) {
        .blogs-grid {
            grid-template-columns: 1fr;
        }
    }
    #about-contact {
        padding: 60px 20px;  
        min-height: auto;     
        display: block;      
    }

    #about-contact {
        padding: 60px 20px;  
        min-height: auto;   
        display: block;     
    }
    .section-title {
        text-align: center;   /* centers title horizontally */
        font-size: 2.5rem;
        font-weight: 700;
        margin-bottom: 30px;
        color: #0B1061;
    }
</style>