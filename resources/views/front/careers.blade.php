@extends('front.app')

@section('title', 'Careers')

@section('content')

<section id="careers" class="careers-section py-5">
    <div class="container">

        <div class="text-center mb-5">
            <h2 class="careers-title">We Are Hiring</h2>
            <p class="careers-subtitle">Join our team and grow with us</p>
            <div class="title-underline"></div>
        </div>

        <div class="row g-4 justify-content-center">
            @forelse($careers as $career)
                <div class="col-xl-3 col-lg-4 col-md-6">
                    <div class="career-card">

                        <h5 class="career-title">{{ $career->designation }}</h5>

                        <span class="career-location">
                            <i class="bi bi-geo-alt-fill"></i> {{ $career->location }}
                        </span>

                        <div class="career-details">
                            <p><strong>Years Required:</strong> {{ $career->years_of_experience }}+</p>
                            <p><strong>Vacancies:</strong> {{ $career->vacancies }}</p>
                            <p><strong>Work Type:</strong> {{ strtoupper($career->work_type) }}</p>
                        </div>

                        <button type="button" class="career-btn openCareerModal"
                            data-designation="{{ $career->designation }}"
                            data-location="{{ $career->location }}"
                            data-years="{{ $career->years_of_experience }}"
                            data-vacancies="{{ $career->vacancies }}"
                            data-type="{{ strtoupper($career->work_type) }}"
                            data-start="{{ \Carbon\Carbon::parse($career->application_start_date)->format('d M Y') }}"
                            data-end="{{ \Carbon\Carbon::parse($career->application_end_date)->format('d M Y') }}"
                            data-description="{{ $career->job_description }}">
                            View Details
                        </button>

                    </div>
                </div>
            @empty
                <div class="text-center mt-5">
                    <h5 class="text-muted">No openings available right now</h5>
                </div>
            @endforelse
        </div>

    </div>
</section>


<!-- ================= CAREER MODAL ================= -->
<div class="modal fade" id="careerModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content career-modal">

            <div class="modal-header">
                <div>
                    <h4 class="modal-title" id="careerDesignation"></h4>
                    <small>Job Opening Details</small>
                </div>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">

                <div class="row g-3 mb-3">

                    <div class="col-md-6">
                        <div class="info-box">
                            <div>
                                <p class="info-title"><i class="bi bi-geo-alt-fill"></i> Location</p>
                                <span id="careerLocation"></span>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="info-box">
                            <div>
                                <p class="info-title"><i class="bi bi-award-fill"></i> Years Required</p>
                                <span id="careerYears"></span>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="info-box">
                            <div>
                                <p class="info-title"><i class="bi bi-people-fill"></i> Vacancies</p>
                                <span id="careerVacancies"></span>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="info-box">
                            <div>
                                <p class="info-title"><i class="bi bi-building"></i> Work Type</p>
                                <span id="careerType"></span>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="info-box">
                            <div>
                                <p class="info-title"><i class="bi bi-calendar-event"></i> Application Period</p>
                                <span><span id="careerStart"></span> → <span id="careerEnd"></span></span>
                            </div>
                        </div>
                    </div>

                </div>

                <hr>

                <h6 class="fw-bold mb-2">Job Description</h6>
                <div id="careerDescription" class="career-description-box"></div>

                <div class="apply-box mt-4 text-center">
                    <h6>Want to apply?</h6>
                    <p>
                        Send your resume at  
                        <a href="mailto:hr@brainstartech.com">hr@brainstartech.com</a>
                    </p>
                </div>

            </div>
        </div>
    </div>
</div>

@endsection

{{-- ================= FULL CSS ================= --}}
<style>
.careers-section { background: var(--theme-color); }

.careers-title { font-weight: 700; color: var(--sidebar_color); }
.careers-subtitle { color: #666; font-size: var(--front_font_size); }

.title-underline {
    width: 60px;
    height: 3px;
    background: var(--sidebar_color);
    margin: 12px auto 0;
    border-radius: 5px;
}

.career-card {
    background: #fff;
    border-radius: 12px;
    padding: 25px;
    text-align: center;
    border: 1px solid rgba(0,0,0,0.06);
    box-shadow: 0 6px 18px rgba(0,0,0,0.06);
    transition: 0.3s ease;
}

.career-card:hover {
    transform: translateY(-6px);
    box-shadow: 0 14px 32px rgba(0,0,0,0.12);
}

.career-title {
    font-size: 18px;
    font-weight: 600;
    margin-bottom: 10px;
}

.career-location {
    display: inline-block;
    font-size: 13px;
    background: rgba(0,0,0,0.05);
    padding: 6px 12px;
    border-radius: 20px;
    margin-bottom: 15px;
}

.career-details {
    font-size: 14px;
    margin-bottom: 18px;
    color: #555;
}

.career-btn {
    background: var(--sidebar_color);
    color: #fff;
    padding: 8px 26px;
    border-radius: 25px;
    border: none;
    cursor: pointer;
}

.career-modal .modal-header {
    background: var(--sidebar_color);
    color: #fff;
}

.info-box {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 14px;
    background: #f9f9f9;
    border-radius: 10px;
}

.info-box i {
    font-size: 20px;
    color: var(--sidebar_color);
}

.career-description-box {
    background: #f9f9f9;
    padding: 15px;
    border-radius: 8px;
    line-height: 1.7;
}
/* Modal Header */
.career-modal .modal-header {
    background: var(--sidebar_color);
    color: #fff;
}

/* Info Boxes inside modal */
.info-box {
    padding: 14px;
    background: var(--theme-color);
    border-radius: 10px;
}

/* Heading + Icon inline */
.info-title {
    font-weight: 600;
    color: var(--sidebar_color);
    margin-bottom: 4px;
}

.info-title i {
    margin-right: 6px;
}

/* Description */
.career-description-box {
    background: var(--theme-color);
    padding: 15px;
    border-radius: 8px;
    line-height: 1.7;
}

/* Apply section */
.apply-box h6 {
    color: var(--sidebar_color);
    font-weight: 600;
}

</style>


@push('scripts')
<script>
$(document).on('click', '.openCareerModal', function () {

    $('#careerDesignation').text($(this).data('designation'));
    $('#careerLocation').text($(this).data('location'));
    $('#careerYears').text($(this).data('years') + " Years");
    $('#careerVacancies').text($(this).data('vacancies'));
    $('#careerType').text($(this).data('type'));
    $('#careerStart').text($(this).data('start'));
    $('#careerEnd').text($(this).data('end'));
    $('#careerDescription').html($(this).data('description'));

    let modal = new bootstrap.Modal(document.getElementById('careerModal'));
    modal.show();
});
</script>
@endpush
