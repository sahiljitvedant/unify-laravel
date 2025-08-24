@extends('layouts.app')

@section('title', 'Members List')

@section('content')
<div class="container">
    <h2 class="mb-4">Members</h2>

    <table class="table table-bordered" id="members-table" style="width:100%">
        <thead>
        <tr>
            <th>ID</th>
            <th>Membership Type</th>
            <th>Joining Date</th>
            <th>Expiry Date</th>
            <th>Amount Paid</th>
            <th>Payment Method</th>
            <th>Trainer Assigned</th>
            <th>Action</th>
        </tr>
        </thead>
        <tbody></tbody>
    </table>
</div>
@endsection

@push('scripts')
    {{-- jQuery & DataTables (Bootstrap 5) --}}
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

    <script>
    $(document).ready(function () {
        let table = $('#members-table').DataTable({
            processing: true,
            serverSide: true,

            // === NORMAL AJAX WITH SUCCESS/ERROR ===
            ajax: function (requestData, callback) {
                $.ajax({
                    url: "{{ route('fetch_member_list') }}",
                    type: "GET",
                    data: requestData, // pass draw/start/length/search/order etc.

                    success: function (json) {
                        // If backend failed to include required keys, fail gracefully
                        if (!json || typeof json.data === 'undefined') {
                            console.warn('Unexpected JSON shape. Fallback to empty data.');
                            return callback({
                                draw: requestData.draw || 1,
                                recordsTotal: 0,
                                recordsFiltered: 0,
                                data: []
                            });
                        }
                        // Hand over to DataTables
                        callback(json);
                    },

                    error: function (xhr) {
                        console.error('❌ Error loading members:', xhr.status, xhr.responseText);
                        // Return an empty dataset so the loader stops
                        callback({
                            draw: requestData.draw || 1,
                            recordsTotal: 0,
                            recordsFiltered: 0,
                            data: []
                        });
                        // Optional user notice
                        alert('Something went wrong while fetching members.');
                    }
                });
            },

            columns: [
                { data: 'id',               name: 'id' },
                { data: 'membership_type',  name: 'membership_type' },
                { data: 'joining_date',     name: 'joining_date' },
                { data: 'expiry_date',      name: 'expiry_date' },
                { data: 'amount_paid',      name: 'amount_paid' },
                { data: 'payment_method',   name: 'payment_method' },
                { data: 'trainer_assigned', name: 'trainer_assigned' },
                { data: 'action',           name: 'action', orderable: false, searchable: false },
            ],

            language: {
                emptyTable:  "🚫 No members found",
                processing:  "⏳ Loading members..."
            },

            // optional: nicer UX
            pageLength: 10,
            responsive: true
        });
    });
    </script>
@endpush
