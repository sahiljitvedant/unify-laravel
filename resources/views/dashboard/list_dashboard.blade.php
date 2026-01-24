@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="container-custom">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('list_dashboard') }}">Dashboard</a></li>
              
                <li class="breadcrumb-item" aria-current="page">List Dashboard</li>
            </ol>
        </nav>
    <div class="p-4 bg-light rounded shadow">
        <div class="row g-3">
            <!-- Card 1 -->
            <div class="col-md-4">
                <div class="card shadow-sm border-0 rounded-3 h-100 card-hover" >
                    <div class="card-body d-flex flex-column p-4">
                    <div>
                        <h5 class="card-title text-start fw-bold mb-2">
                        <i class="bi bi-people text-icon me-2 fs-4"></i>
            
                        <span class="fs-3 counter" data-target="{{ $activeHeaders }}">0</span>
                        </h5>
                        <p class="card-text text-muted text-start mb-0">Active Headers</p>
                    </div>
                    <div class="mt-auto d-flex justify-content-end">
                        <a href="{{ route('list_headers') }}" 
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
                        <span class="fs-3 counter" data-target="{{ $membership }}">0</span>
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
        <div class="row mt-4 align-items-stretch">
            <!-- Bar Chart -->
            <div class="col-md-6 d-flex  py-2">
                <div class="card shadow-sm border-0 rounded-3 w-100">
                    <div class="card-body d-flex flex-column">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h5 class="card-title mb-0">Members Joined Per Month</h5>

                            <!-- Year Dropdown -->
                            <form method="GET" action="{{ route('list_dashboard') }}">
                                <select name="year" class="form-control" onchange="this.form.submit()">
                                    @foreach($years as $year)
                                        <option value="{{ $year }}" {{ $year == $selectedYear ? 'selected' : '' }}>
                                            {{ $year }}
                                        </option>
                                    @endforeach
                                </select>
                            </form>
                        </div>
                        <!-- Chart wrapper grows full height -->
                        <div class="flex-grow-1 d-flex align-items-end">
                            <canvas id="membersChart" class="w-100 h-100"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Pie Chart -->
            <div class="col-md-6 d-flex  py-2">
                <div class="card shadow-sm border-0 rounded-3 w-100">
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title mb-3">Membership Type Distribution</h5>
                        <div class="flex-grow-1 d-flex align-items-center">
                            <canvas id="membershipPieChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card shadow-sm rounded-3">
            <div class="card-body">
                <h5 class="card-title mb-3">List of Members(Pending Payment)</h5>
                <div class="data-wrapper">
                    <!-- Table -->
                    <div class="table-responsive p-3">
                        <table class="table table-hover align-middle custom-table" id="members-table">
                            <thead>
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
                                            Members Name
                                            <span class="sort-icons">
                                                <i class="asc">▲</i>
                                                <i class="desc">▼</i>
                                            </span>
                                        </a>
                                    </th>
                                    <!-- <th>
                                        <a href="#" class="sort-link" data-column="duration_in_days">
                                            Email
                                            <span class="sort-icons">
                                                <i class="asc">▲</i>
                                                <i class="desc">▼</i>
                                            </span>
                                        </a>
                                    </th> -->
                                    <th>
                                        <a href="#" class="sort-link" data-column="email">
                                            Email
                                            <span class="sort-icons">
                                                <i class="asc">▲</i>
                                                <i class="desc">▼</i>
                                            </span>
                                        </a>
                                    </th>
                                    <th>Membership Type</th>
                                    <th>
                                        <a href="#" class="sort-link" data-column="price">
                                            Total Fees
                                            <span class="sort-icons">
                                                <i class="asc">▲</i>
                                                <i class="desc">▼</i>
                                            </span>
                                        </a>
                                    </th>
                                    <th>
                                        <a href="#" class="sort-link" data-column="amount_paid">
                                            Fees Paid
                                            <span class="sort-icons">
                                                <i class="asc">▲</i>
                                                <i class="desc">▼</i>
                                            </span>
                                        </a>
                                    </th>
                                    <th>
                                        <a href="#" class="sort-link" data-column="fees_pending">
                                            Fees Pending
                                            <span class="sort-icons">
                                                <i class="asc">▲</i>
                                                <i class="desc">▼</i>
                                            </span>
                                        </a>
                                    </th>
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
    </div>
</div>

@endsection
@push('scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

    <script>
        const fetchMembership = "{{ route('fetch_member_list_pending_payment') }}";
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
   
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function()
        {
            // ---- Bar Chart ----
            const ctx = document.getElementById('membersChart').getContext('2d');
            new Chart(ctx, 
            {
                type: 'bar',
                data: {
                    labels: {!! json_encode($labels) !!},
                    datasets: [{
                        label: 'Members Joined',
                        data: {!! json_encode($values) !!},
                        backgroundColor: '#0b1061',
                        borderRadius: 6
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false, // ✅ allows canvas to fill parent height
                    plugins: {
                        legend: { display: false },
                        tooltip: { enabled: false }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: { stepSize: 1 }
                        },
                        x: {
                            grid: { drawTicks: false }
                        }
                    }
                }
            });


            // ---- Pie Chart ----
            const ctxPie = document.getElementById('membershipPieChart').getContext('2d');
            new Chart(ctxPie, 
            {
                type: 'pie',
                data: {
                    labels: {!! json_encode($membershipLabels) !!}, 
                    datasets: [{
                        data: {!! json_encode($membershipValues) !!}, 
                        backgroundColor: ['#4e73df', '#1cc88a', '#5f64b1', '#af6878', '#36b9cc'],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: { position: 'bottom' },
                        tooltip: { enabled: true }
                    }
                }
            });
        });
    </script>
    <script src="{{ asset('assets/js/dashboard/list_dashboard.js') }}"></script>
 
@endpush
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


