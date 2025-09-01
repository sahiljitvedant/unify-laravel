@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="container">
  Welcome Back, Admin
 <div class="container mt-4">
  <div class="row g-3">
    <!-- Card 1 -->
    <div class="col-md-4">
        <div class="card shadow-sm border-0 rounded-3 h-100 card-hover">
            <div class="card-body d-flex flex-column p-4">
            <div>
                <h5 class="card-title text-start fw-bold mb-2">
                <i class="bi bi-people text-icon me-2 fs-4"></i>
       
                <span class="fs-3 counter" data-target="{{ $members }}">0</span>
                </h5>
                <p class="card-text text-muted text-start mb-0">Current Members</p>
            </div>
            <div class="mt-auto d-flex justify-content-end">
                <a href="{{ route('list_member') }}" 
                class="d-inline-flex align-items-center justify-content-center rounded-circle shadow-sm text-icon"
                style="width: 36px; height: 36px; background-color: #f0f4ff;">
                <i class="bi bi-box-arrow-up-right fs-5"></i>
                </a>
            </div>
            </div>
        </div>
    </div>

    <!-- Card 2 -->
    <div class="col-md-4">
        <div class="card shadow-sm border-0 rounded-3 h-100 card-hover">
            <div class="card-body d-flex flex-column p-4">
            <div>
                <h5 class="card-title text-start fw-bold mb-2">
                <i class="bi bi-book text-icon me-2 fs-4"></i>
                <span class="fs-3 counter" data-target="{{ $memebership }}">0</span>
                </h5>
                <p class="card-text text-muted text-start mb-0">Membership Count</p>
            </div>
            <div class="mt-auto d-flex justify-content-end">
                <a href="{{ route('list_membership') }}" 
                class="d-inline-flex align-items-center justify-content-center rounded-circle shadow-sm text-icon"
                style="width: 36px; height: 36px; background-color: #f0f4ff;">
                <i class="bi bi-box-arrow-up-right fs-5"></i>
                </a>
            </div>
            </div>
        </div>
    </div>

    <!-- Card 3 -->
    <div class="col-md-4">
        <div class="card shadow-sm border-0 rounded-3 h-100 card-hover">
            <div class="card-body d-flex flex-column p-4">
            <div>
                <h5 class="card-title text-start fw-bold mb-2">
                <i class="bi bi-person-plus me-2 fs-4"></i>
                <span class="fs-3 counter" data-target="{{ $trainer }}">0</span>
                </h5>
                <p class="card-text text-muted text-start mb-0">Active Trainers</p>
            </div>
            <div class="mt-auto d-flex justify-content-end">
                <a href="{{ route('list_trainer') }}" 
                class="d-inline-flex align-items-center justify-content-center rounded-circle shadow-sm text-icon"
                style="width: 36px; height: 36px; background-color: #f0f4ff;">
                <i class="bi bi-box-arrow-up-right fs-5"></i>
                </a>
            </div>
            </div>
        </div>
    </div>
  </div>
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
        const fetchMembership = "{{ route('fetch_membership') }}";
        const deleteMembershipUrl = "{{ route('delete_membership', ':id') }}";
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", () => {
        const counters = document.querySelectorAll(".counter");

        counters.forEach(counter => 
        {
            const target = +counter.getAttribute("data-target");
            const direction = counter.getAttribute("data-direction") || "up";
            let count = direction === "down" ? target * 2 : 0; // start higher for down
            const speed = 30;

            const updateCount = () => {
            if (direction === "up") {
                if (count < target) {
                count += Math.ceil(target / 50);
                if (count > target) count = target;
                counter.textContent = count;
                setTimeout(updateCount, speed);
                }
            } else if (direction === "down") {
                if (count > target) {
                count -= Math.ceil(target / 50);
                if (count < target) count = target;
                counter.textContent = count;
                setTimeout(updateCount, speed);
                }
            }
            };

            updateCount();
        });
        });

    </script>
    <script src="{{ asset('assets/js/gym_membership/list_membership.js') }}"></script>
@endpush
