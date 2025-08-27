@extends('layouts.app')

@section('title', 'Members List')

@section('content')
<div class="container">
    <!-- Heading + Add Button -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 gap-2">
        <h4 class="mb-0">Membership</h4>
        <a href="" class="btn-add">Add Membership</a>
    </div>

    <!-- Table -->
    <div class="table-responsive">
        <table class="table table-bordered" id="members-table" style="width:100%">
            <thead class="table-light">
                <tr>
                    <th>ID</th>
                    <th>Membership Name</th>
                    <th>Duration(in Days)</th>
                    <th>Price</th>
                    <th>Trainer Included</th>
                    <th>Is Active</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
    </div>
</div>
@endsection

@push('styles')
<style>
    .btn-add {
        background-color: #0B1061;
        color: #ffffff;
        border-radius: 8px;
        padding: 6px 16px;
        border: none;
        text-decoration: none;
        font-size: 14px;
    }

    .btn-add:hover {
        background-color: #090d4a;
    }
    .table-responsive {
    overflow-x: auto;
}

#members-table {
    width: 100% !important;
    table-layout: auto; /* allows columns to shrink */
    font-size: 14px; /* optional: smaller text for better fit */
}

#members-table thead th {
    font-size: 13px; /* smaller header text */
    text-align: center; /* optional: center headers */
}
</style>
@endpush

@push('scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

    <script>
    $(document).ready(function () {
        $('#members-table').DataTable({
            processing: true,
            serverSide: true,
            searching: false,
            ajax: "{{ route('fetch_membership') }}",

            columns: [
                { data: 'id', name: 'id' },
                { data: 'membership_name', name: 'membership_name' },
                { data: 'duration_in_days', name: 'duration_in_days' },
                { data: 'price', name: 'price' },
                { data: 'trainer_included', name: 'trainer_included' },
                { 
                    data: 'is_active', 
                    render: function(data) {
                        return data == 1 ? 'Yes' : 'No';
                    }
                },
                { data: 'action', orderable: false, searchable: false },
            ],

            order: [[0, 'desc']],
            pageLength: 10,
            responsive: true,
            autoWidth: false
            
        });
    });
    </script>
@endpush
