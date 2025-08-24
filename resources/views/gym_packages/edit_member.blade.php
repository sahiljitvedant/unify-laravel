@extends('layouts.app')

@section('content')
<div class="container">
    <!-- Tabs Navigation -->
    <ul class="nav nav-tabs" id="tabMenu">
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

    <!-- Tab Content -->
    <div id="tabContent" class="p-4 border border-top-0">
        Loading...
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    // function to load tab content
    function loadTab(tab) {
        $.get(`/tabs/${tab}`, function(data) {
            $('#tabContent').html(data);
            $('#tabMenu .nav-link').removeClass('active');
            $(`#tabMenu .nav-link[data-tab="${tab}"]`).addClass('active');
        });
    }

    // handle click
    $('#tabMenu .nav-link').on('click', function(e) {
        e.preventDefault();
        let tab = $(this).data('tab');
        loadTab(tab);
    });

    // load default (tab1)
    let defaultTab = "{{ request('tab', 'tab1') }}";
    loadTab(defaultTab);
});
</script>
@endpush
