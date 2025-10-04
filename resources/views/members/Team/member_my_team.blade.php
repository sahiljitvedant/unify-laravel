@extends('members.layouts.app')

@section('title', 'My Team')

@section('content')
<div id="loader">
    <img src="{{ asset('assets/img/logo.png') }}" alt="Loading..." class="loader-img">
</div>

<div class="container-custom py-4">
    <div class="container">
        <!-- Heading + Search Filter -->
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-3 gap-2">
            <h4 class="mb-2 mb-md-0">My Team</h4>
            <div class="d-flex gap-2">
                <input type="text" id="searchName" class="form-control" placeholder="Search Name">
      
                <button id="btnSearch" class="btn ">
                    <i class="bi bi-search"></i> 
                </button>
        
                <button id="btnCancel" class="btn btn-secondary me-1 cncl_btn">
                    <i class="bi bi-x-circle"></i> 
                </button>
            </div>
        </div>

        
            <div class="row g-3" id="membersContainer">
                {{-- Cards will load here via JS --}}
            </div>
        
    </div>
</div>
@endsection
<style>
    .container-custom {
    min-height: 80vh;
    background-color: #f5f6fa;
    padding: 20px;
    border-radius: 12px;
}

.search-input {
    min-width: 200px;
    border-radius: 50px;
    padding: 8px 16px;
    border: 1px solid #ccc;
}

#membersContainer .card {
    display: flex;
    flex-direction: column;
    align-items: center; /* centers the image & name */
    background-color: #f2f2f2;
    border-radius: 15px;
    box-shadow: 0 6px 15px rgba(0,0,0,0.1);
    padding: 20px 10px;
    transition: transform 0.2s, box-shadow 0.2s;
}

#membersContainer .card img {
    border-radius: 50%;
    border: 1px solid #0B1061;
}


#membersContainer .card:hover {
    transform: translateY(-5px);
    /* box-shadow: 0 10px 25px rgba(0,0,0,0.15); */
}

#membersContainer .card h6 {
    margin-top: 10px;
    font-weight: 400;
    color: #000;
    font-size: 12px;
}

.btn-primary {
    background-color: #0B1061;
    border-radius: 50px;
    padding: 6px 18px;
    border: none;
}

.btn-primary:hover {
    background-color: #090d4a;
}

.btn-secondary {
    border-radius: 50px;
    padding: 6px 18px;
}

</style>
@push('scripts')
<script>
    const userMyTeamRoute = "{{ route('fetch_member_my_team') }}";
    window.assetBase = "{{ asset('') }}";
   
</script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="{{ asset('assets/js/my_team/my_team.js') }}"></script>
<script>

</script>
@endpush
