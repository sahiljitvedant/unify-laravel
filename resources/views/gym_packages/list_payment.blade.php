@extends('layouts.app')

@section('title', 'Payment List')

@section('content')
<div class="container-custom">
    <div class="p-4 bg-light rounded shadow">
        <div class="row g-3">
        <div class="col-md-4">
            <div class="mb-3">
                <label class="form-label">Select User</label>
                <select class="form-control select2-small" id="user_id" name="user_id">
                    <option selected disabled>Select User</option>
                    @foreach ($users as $user)
                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        </div>
    </div>

    <!-- Loader -->
    <div id="loader" style="display:none;">
        <img src="{{ asset('assets/img/logo.png') }}" alt="Loading..." class="loader-img">
    </div>

    <!-- Payment Table -->
    <div class="p-4 bg-light rounded shadow mt-3" id="payment-container" style="display:none;">
        <!-- Heading + Add Button -->
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-3 gap-2">
            <h4 class="mb-2 mb-md-0">List Payment</h4>
            <div class="d-flex flex-column align-items-start align-items-md-end gap-2">
                <a href="#" id="addPaymentBtn" class="btn-add">Add Payment</a>
            </div>
        </div>

        <!-- Filters -->
        <div class="filters p-3">
            <div class="row g-3">
                <div class="col-md-3">
                    <select class="form-control" id="filterMembership">
                        <option selected value="">Select Membership</option>
                        @foreach($membership as $m)
                            <option value="{{ $m->id }}">{{ $m->membership_name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <button id="submitBtn" class="btn"><i class="bi bi-search"></i></button>
                    <button id="btnCancel" class="btn btn-secondary me-1 cncl_btn"><i class="bi bi-x-circle"></i></button>
                </div>
            </div>
            
        </div>

        <div class="separator"></div>

        <!-- Table -->
        <div class="table-responsive p-3">
            <table class="table table-hover align-middle custom-table" id="members-table">
                <thead>
                    <tr>
                        <th class="sort-link" data-column="id">ID <span class="sort-icons"><i class="asc">▲</i><i class="desc">▼</i></span></th>
                        <th class="sort-link" data-column="membership_name">Membership Name <span class="sort-icons"><i class="asc">▲</i><i class="desc">▼</i></span></th>
                        <th>Amount Paid</th>
                        <th>Discount</th>
                        <th>Total Amount Paid</th>
                        <th>Remaining</th>
                        <th>Paid By</th>
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
@endsection
@push('scripts')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    let fetchMemberPaymentUrl = "{{ route('fetch_member_payment', ':id') }}";
    $('#user_id').select2({
        placeholder: "Select User",
        allowClear: true,
        width: '100%',
        templateSelection: function(state) {
            if (!state.id) { return state.text; }
            return $('<span style="font-size:12px;">' + state.text + '</span>');
        },
        templateResult: function(state) {
            if (!state.id) { return state.text; }
            return $('<span style="font-size:12px;">' + state.text + '</span>');
        }
    });
    $('.select2-small').each(function(){
        let container = $(this).next('.select2-container');
        container.find('.select2-selection--single').css({
            'height':'28px',
            'line-height':'28px',
            'font-size':'12px'
        });
        container.find('.select2-selection__arrow').css({
            'height':'28px',
            'line-height':'28px'
        });
    });
</script>
<script src="{{ asset('assets/js/gym_package/member_payment.js') }}"></script>
@endpush
@push('styles')
<style>
    .btn-add {
        background-color: #0B1061;
        color: #fff;
        border-radius: 8px;
        padding: 6px 16px;
        border: none;
        text-decoration: none;
        font-size: 14px;
    }
    .btn-add:hover { background-color: #090d4a; }
    th a { color: inherit; text-decoration: none; }


    /* Force font size and height for Select2 with custom class */
    .select2-container.select2-small .select2-selection--single {
        height: 22px !important;          /* total height */
        line-height: 22px !important;     /* vertical alignment */
        font-size: 12px !important;       /* font size */
    }

    .select2-container.select2-small .select2-selection__rendered {
        line-height: 22px !important;
        font-size: 12px !important;
        padding: 0 5px !important;        /* adjust horizontal spacing */
    }

    .select2-container.select2-small .select2-selection__arrow {
        height: 22px !important;          /* arrow height matches container */
    }

    .select2-container.select2-small .select2-selection__placeholder {
        font-size: 12px !important;       /* placeholder text size */
        line-height: 22px !important;
    }

</style>
@endpush