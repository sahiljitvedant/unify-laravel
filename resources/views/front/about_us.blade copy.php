@extends('front.app')

@section('content')
    <!-- ABOUT US INFO SECTION -->

    <section id="about-contact" class="about-contact py-5" style="background:#f9f9f9;">
        <div class="container">
            <div class="row g-4">
                <!-- Contact Info -->
                <div class="col-md-6">
                    <div class="contact-card p-4 shadow rounded" style="background:#fff;">
                        <h2 class="mb-4" style="color: #0B1061;">Get in Touch</h2>
                        <p><strong>Address:</strong> Fitness Club, FC Road, Pune, Maharashtra, India</p>
                        <p><strong>Phone:</strong> +91 98765 43210</p>
                        <p><strong>Email:</strong> support@fitnessclub.com</p>
                        <p><strong>Hours:</strong> Mon – Sat: 6:00 AM – 10:00 PM</p>
                    </div>
                </div>

                <!-- Google Map -->
                <div class="col-md-6">
                    <div class="ratio ratio-16x9 shadow rounded">
                        <iframe 
                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3783.339948926727!2d73.84296771489123!3d18.5167260874091!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3bc2c07c61e9bb8f%3A0xbee72d1c8e0f5f9c!2sFergusson%20College%20Rd%2C%20Shivajinagar%2C%20Pune%2C%20Maharashtra%20411004!5e0!3m2!1sen!2sin!4v1674123456789!5m2!1sen!2sin" 
                            style="border:0;" 
                            allowfullscreen 
                            loading="lazy">
                        </iframe>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
