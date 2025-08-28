@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="container">
 This is Dashboard Page
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
        const fetchMembership = "{{ route('fetch_membership') }}";
        const deleteMembershipUrl = "{{ route('delete_membership', ':id') }}";
    </script>
    <script src="{{ asset('assets/js/gym_membership/list_membership.js') }}"></script>
@endpush
