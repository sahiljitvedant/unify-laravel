@extends('layouts.app')

@section('title', 'Enquiry List')

@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">
    <div id="loader">
        <img src="{{ asset('assets/img/logo.png') }}" alt="Loading..." class="loader-img">
    </div>
    <div class="container-custom">
        <!-- Breadcrumb -->
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('list_dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('list_enquiry') }}">Enquiry</a></li>
                <li class="breadcrumb-item" aria-current="page">List Enquiry</li>
            </ol>
        </nav>
        <div class="p-4 bg-light rounded shadow">
            <!-- Heading + Add Button -->
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-3 gap-2">
                <h4 class="mb-2 mb-md-0">List Enquiry</h4>
                <a href="{{ route('list_replied_enquiry') }}" class="btn-link">Show Replied Enquiry</a>
                <!-- <div class="d-flex flex-column align-items-start align-items-md-end gap-2">
                    <a href="{{ route('add_membership') }}" class="btn-add">Add Membership</a>
                    <a href="{{ route('list_deleted_membership') }}" class="btn-link">Show Deleted Membership</a>
                </div> -->
            </div>
            <div class="data-wrapper">
                <!-- Filters -->
                <div class="filters p-3">
                    <div class="row g-3">
                        <div class="col-md-3">
                            <input type="text" id="name" class="form-control" placeholder="Name">
                        </div>
                        <div class="col-md-3">
                            <input type="text" id="email" class="form-control" placeholder="Email">
                        </div>
                        <div class="col-md-3">
                            <input type="text" id="request_id" class="form-control" placeholder="Request ID">
                        </div>
                        <div class="col-md-2">
                            <button id="submitBtn" class="btn ">
                                <i class="bi bi-search"></i> 
                            </button>
                    
                            <button id="btnCancel" class="btn btn-secondary me-1 cncl_btn">
                                <i class="bi bi-x-circle"></i> 
                            </button>
                        </div>
                    </div>
                    
                </div>

                <!-- Separator -->
                <div class="separator"></div>

                <!-- Table -->
                <div class="table-responsive p-3">
                    <table class="table table-hover align-middle custom-table" id="members-table">
                        <thead >
                            <tr>
                                <th>
                                    <a href="#" class="sort-link" data-column="id">
                                        ID
                                        <span class="sort-icons">
                                            <i class="asc">▲</i>
                                            <i class="desc">▼</i>
                                        </span>
                                    </a>
                                </th>
                                <th>
                                    <a href="#" class="sort-link" data-column="name">
                                        Name
                                        <span class="sort-icons">
                                            <i class="asc">▲</i>
                                            <i class="desc">▼</i>
                                        </span>
                                    </a>
                                </th>
                                <th>
                                    <a href="#" class="sort-link" data-column="email">
                                        Email
                                        <span class="sort-icons">
                                            <i class="asc">▲</i>
                                            <i class="desc">▼</i>
                                        </span>
                                    </a>
                                </th>
                                <th>Message</th>
                                <th>
                                    <a href="#" class="sort-link" data-column="request_id">
                                        Request ID
                                        <span class="sort-icons">
                                            <i class="asc">▲</i>
                                            <i class="desc">▼</i>
                                        </span>
                                    </a>
                                </th>
                                <th>
                                    <a href="#" class="sort-link" data-column="created_at">
                                        Created At
                                        <span class="sort-icons">
                                            <i class="asc">▲</i>
                                            <i class="desc">▼</i>
                                        </span>
                                    </a>
                                </th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="membershipBody"></tbody>
                    </table>
                </div>


                <!-- Pagination -->
                <nav class="pb-3">
                    <ul class="pagination justify-content-center" id="pagination"></ul>
                </nav>
            </div>
        </div>
    </div>
    <!-- Reply Modal -->
    <div class="modal fade" id="replyModal" tabindex="-1" aria-labelledby="replyModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content rounded-4 shadow">
                <div class="modal-header">
                    <h5 class="modal-title" id="replyModalLabel">Reply to Enquiry</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <textarea id="replyMessage" class="form-control" rows="5" placeholder="Type your reply..."></textarea>
                </div>

                <div class="modal-footer">
                    
                    <button type="button" id="sendReplyBtn" class="btn">Send Reply</button>
                </div>
            </div>
        </div>
    </div>

@endsection

<style>
    /* Modal overall styling */
    #replyModal .modal-content {
        border: none;
        border-radius: 16px;
        background: #ffffff;
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15);
    }

    /* Header */
    #replyModal .modal-header {
        background:#0B1061;
        color: #fff;
        border-bottom: none;
        border-top-left-radius: 16px;
        border-top-right-radius: 16px;
        padding: 1rem 1.5rem;
    }

    #replyModal .modal-title {
        font-weight: 400;
        font-size: 16px;
        letter-spacing: 0.3px;
    }

    /* Close (X) button */
    #replyModal .btn-close {
        filter: brightness(0) invert(1);
        opacity: 0.9;
    }
    #replyModal .btn-close:hover {
        opacity: 1;
    }

    /* Body */
    #replyModal .modal-body {
        padding: 1.5rem;
        border-bottom: none; /* remove divider */
    }

    /* Textarea */
    #replyModal textarea#replyMessage {
        border-radius: 10px;
        border: 1px solid #dee2e6;
        transition: all 0.3s ease;
    }
    #replyModal textarea#replyMessage:focus {
        border-color: #0d6efd;
        box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.25);
    }

    /* Footer */
    #replyModal .modal-footer {
        border-top: none; /* remove bottom border line */
        padding: 1rem 1.5rem 1.5rem;
        justify-content: flex-end;
    }

    /* Buttons */
    #replyModal .btn {
        background-color: #0B1061;
        color: #fff;
        border: none;
        border-radius: 10px;
        padding: 0.5rem 1.25rem;
        font-weight: 400;
        transition: all 0.25s ease;
        transform: translateY(-1px);
    }

</style>
@push('scripts')
<script>
    const fetchEnquiry = "{{ route('fetch_enquiry') }}";
    const replyEnquiryTemplate = "{{ route('send_enquiry_reply', ':id') }}";
</script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="{{ asset('assets/js/enquiry/list_enquiry.js') }}"></script>

@endpush
