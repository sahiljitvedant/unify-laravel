@extends('layouts.app')

@section('content')
<div class="container">
<!-- Tabs Navigation -->
<ul class="nav nav-tabs mb-0" id="tabMenu">
    <li class="nav-item">
        <a class="nav-link active" href="#" data-tab="tab1">Tab 1</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="#" data-tab="tab2">Tab 2</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="#" data-tab="tab3">Tab 3</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="#" data-tab="tab4">Tab 4</a>
    </li>
</ul>

<!-- Square Box (Tab Content Area) -->
<div id="tabContent" class="p-4 border border-top-0 rounded-bottom bg-light" style="min-height: 250px;">
    Loading...
</div>

</div>
@endsection

@push('scripts')
<script>
$(function () {

    function loadTab(tab) {
        console.log("Loading tab:", tab);

        $.ajax({
            url: `/tabs/${tab}`,
            method: 'GET',
            success: function (data) {
                // Fill square box with content
                $('#tabContent').html(data);

                // Switch active tab manually
                $('#tabMenu .nav-link').removeClass('active');
                $(`#tabMenu .nav-link[data-tab="${tab}"]`).addClass('active');
            },
            error: function () {
                $('#tabContent').html('<p class="text-danger">Failed to load tab content.</p>');
            }
        });
    }

    // Click handler
    $('#tabMenu .nav-link').on('click', function (e) {
        e.preventDefault();
        let tab = $(this).data('tab');
        loadTab(tab);
    });

    // Load default tab
    loadTab('tab1');
});
</script>
@endpush
