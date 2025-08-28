<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Panel')</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

    <!-- DataTables Bootstrap 5 -->
    <link href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" rel="stylesheet" />
    <link href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap5.min.css" rel="stylesheet" />
    <link href="https://cdn.datatables.net/searchpanes/2.2.0/css/searchPanes.bootstrap5.min.css" rel="stylesheet" />

    <!-- Font librry -->
    <!-- Google Fonts: Inter -->

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <!-- Swal Js -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- Custom CSS -->
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: 'Inter', sans-serif;
            background-color: #e3e3e3;
        }

        .topbar {
            position: fixed;
            top: 0;
            left: 0;
            height: 60px;
            width: 100%;
            background-color: #ffffff;
            border-bottom: 1px solid #ddd;
            z-index: 1000;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 20px;
        }

        .sidebar {
            position: fixed;
            top: 60px;
            left: 0;
            width: 220px;
            height: calc(100% - 60px);
            background-color: #0B1061;
            border-right: 1px solid #ddd;
            padding-top: 20px;
            transition: transform 0.3s ease;
            z-index: 999;
        }

        .sidebar a {
            padding: 10px 20px;
            display: block;
            color: #ffffff;
            text-decoration: none;
            border-radius: 6px;
            margin: 4px 10px;
            transition: background-color 0.4s ease; /* smooth only bg color */
        }

        .sidebar a:hover {
            background-color: rgba(255, 255, 255, 0.15); /* hover effect */
            color: #fff;
        }

        #mainContent {
            margin-left: 220px;
            padding: 100px 20px 20px 20px;
        }

        /* Responsive */
        @media (max-width: 991.98px) {
            .sidebar {
                transform: translateX(-100%);
            }

            .sidebar.active {
                transform: translateX(0);
            }

            #mainContent {
                margin-left: 0;
                padding-top: 100px;
            }
        }

        /* ==========================
           DataTable Styling
        ========================== */
        table.dataTable {
            border-collapse: collapse !important;
            width: 100% !important;
            margin-top: 1rem !important;
            border: 1px solid #e0e0e0 !important;
        }

        table.dataTable th {
            background: #0B1061;
            color: #fff;
            font-weight: 600;
            padding: 12px;
            text-align: left;
            border-bottom: 2px solid #dee2e6;
        }

        table.dataTable td {
            padding: 10px 12px;
            vertical-align: middle;
            border-bottom: 1px solid #f1f1f1;
            font-size: 14px;
            color: #444;
        }

        table.dataTable tbody tr:hover {
            background-color: #f9f9f9;
            transition: 0.2s ease-in-out;
        }

        /* Action button dropdown */
        .dropdown.actionbtn .dropdown-menu {
            min-width: 150px;
            padding: 0.5rem 0;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        }

        .dropdown.actionbtn .dropdown-item {
            display: flex;
            align-items: center;
            font-size: 14px;
            padding: 0px 0px;
            transition: 0.2s;
        }

        .dropdown.actionbtn .dropdown-item:hover {
            background-color: #f1f1f1;
        }

        /* Search box + filter row styling */
        #custom-searchPanes {
            background: #fff;
            padding: 1rem;
            border-radius: 10px;
            border: 1px solid #e5e5e5;
            margin-bottom: 1rem;
            box-shadow: 0 2px 8px rgba(0,0,0,0.05);
        }

        #custom-searchPanes input,
        #custom-searchPanes select {
            border-radius: 8px;
            font-size: 14px;
        }

        #custom-searchPanes .btn {
            border-radius: 8px;
            padding: 6px 14px;
        }

        /* Pagination styling */
        .dataTables_wrapper .dataTables_paginate .paginate_button {
            padding: 0px 0px;
            margin: 0 2px;
            border-radius: 6px;
            background: #ddd;
            border: 1px solid #ddd;
            color: #333 !important;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button.current {
            background: #007bff !important;
            color: #fff !important;
            border-color: #007bff;
        }

        .dataTables_wrapper .dataTables_info {
            font-size: 13px;
            color: #555;
        }

        /* Status badges */
        .badge-active {
            background-color: #28a745;
        }
        .badge-inactive {
            background-color: #6c757d;
        }
        .badge-draft {
            background-color: #ffc107;
            color: #000;
        }
        .badge-deleted {
            background-color: #dc3545;
        }

        .form-label 
        {
            font-size: 14px;     
            font-weight: 500;     
            color: #333;          
            margin-bottom: 4px;  
          
        }
        .form-control::placeholder 
        {
            font-size: 13px; 
            color: #777;     
            opacity: 1;      
        }
        .error-message
        {
            font-size: 14px;     
            font-weight: 500; 
        }
        .form-label.required::after {
            content: "*";
            color: #d32f2f;   /* light red shade */
            font-size: 0.85em; /* slightly smaller than label text */
            font-weight: normal; /* not bold */
        
        }
        #submitBtn
        {
            background-color: #0B1061;
            color: #ffffff;
        }
        .btn-add
        {
            background-color: #0B1061;
            color: #ffffff;
            border-radius: 8px;   /* rounded corners */
            padding: 6px 16px;    /* optional: better spacing */
            border: none; 
            text-decoration: none;
        }
        .form-label {
            font-size: 14px;     
            font-weight: 500;     
            color: #333;          
            margin-bottom: 4px;  
        }

        .form-label.required::after {
            content: " *";
            color: #d32f2f;     /* medium-dark red */
            font-size: 0.85em;  /* smaller than label */
            font-weight: normal;
        }

        .form-select {
            font-size: 13px;           /* font size */
            color: #0B1061;            /* text color */
            background-color: #fff;    /* dropdown background */
        
        }
        .form-select option {
            color: #0B1061;   /* text color of options */
            background-color: #fff; /* background of options */
        }
        /* Container for breadcrumb + form */
        .container-custom {
            max-width: 95%;
            margin: 0 auto;
        }

        /* Remove all default ol padding/margin */
        .breadcrumb {
            background-color: transparent;
            padding: 0;
            margin-bottom: 1rem;
            font-size: 13px;
            font-weight: 500;
            color: #0B1061;
        }

        /* Remove left margin/padding from ol and li to align with form */
        .breadcrumb ol {
            padding-left: 0;
            margin-left: 0;
        }

        .breadcrumb-item {
            padding: 0;   /* remove default li padding */
            margin: 0;    /* remove default li margin */
        }

        /* Links */
        .breadcrumb a {
            color: #0B1061;
            text-decoration: none;
        }

        .breadcrumb a:hover {
            text-decoration: underline;
        }

        /* Active item */
        .breadcrumb-item.active {
            color: #0B1061;
            font-weight: 600;
        }

        #members-table td,
        #members-table th {
            text-align: center;
            vertical-align: middle;
        }

        /* Smaller font for table header */
        #members-table thead th {
            font-size: 12px;  /* adjust as needed */
            font-weight: 500; /* optional: make header slightly bold */
        }

    </style>
</head>

<body>
    @php
        $hideSidebarRoutes = ['login_get', 'register_get', 'access_denied'];
    @endphp

    @if (!in_array(Route::currentRouteName(), $hideSidebarRoutes))
        <!-- Header -->
        <div class="topbar">
            <button id="menuToggle" class="btn btn-outline-secondary d-lg-none">
                <i class="fas fa-bars"></i>
            </button>
            <span class="fw-bold">Admin Dashboard</span>
        </div>

        <!-- Sidebar -->
        <div id="sidebar" class="sidebar d-lg-block">
            <a href="{{ route('list_dashboard') }}">
            
                <i class="fas fa-home me-2"></i>
                Dashboard
            </a>
            <a href="{{ route('list_member') }}"><i class="fas fa-users me-2"></i>Members</a>
            <a class="d-flex justify-content-between align-items-center" 
            data-bs-toggle="collapse" 
            href="#modulesDropdown" 
            role="button" 
            aria-expanded="false" 
            aria-controls="modulesDropdown">
            <span><i class="fas fa-layer-group me-2"></i>Modules</span><i class="fas fa-chevron-down small"></i>
            </a>
            <div class="collapse ps-4" id="modulesDropdown">
                <a href="{{ route('list_membership') }}" class="d-block py-1">
                    <i class="fas fa-id-card me-2"></i>Membership
                </a>
                <a href="#" class="d-block py-1">
                    <i class="fas fa-user-tie me-2"></i>Trainer
                </a>
            </div>

            <a href="#"><i class="fas fa-cogs me-2"></i>Settings</a>
            <a href="{{ route('logout') }}">
                <i class="fas fa-sign-out-alt me-2"></i>Logout
            </a>
        </div>
    @endif
    <!-- Main Content -->
    <div id="mainContent"  class="{{ in_array(Route::currentRouteName(), $hideSidebarRoutes) ? 'no-sidebar' : '' }}">
        @yield('content')
    </div>

    <!-- Bootstrap Bundle JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Toggle Sidebar -->
    <script>
        const menuToggle = document.getElementById('menuToggle');
        const sidebar = document.getElementById('sidebar');

        menuToggle.addEventListener('click', () => {
            sidebar.classList.toggle('active');
        });
    </script>
    @stack('scripts')
</body>
</html>
<style>
    .no-sidebar {
    margin-left: 0 !important;
    padding: 100px 20px 20px 20px !important;
    max-width: 500px;
    margin: 100px auto 0 auto !important;
}

</style>
