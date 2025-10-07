@extends('members.layouts.app')

@section('title', 'Edit Member')

@section('content')

<div class="tab-wrapper">
  <div class="tabs">
    <button class="tab active" data-tab="home">Profile</button>
    <button class="tab" data-tab="profile">Membership</button>
    <button class="tab" data-tab="settings">Fitness Goals</button>
    <button class="tab" data-tab="preferance">Preferance</button>
  </div>

    <div class="tab-content" id="home">
        @include('tabs.home')
    </div>
    <div class="tab-content" id="profile" style="display: none;">
        @include('tabs.profile')
    </div>
    <div class="tab-content" id="settings" style="display: none;">
        @include('tabs.settings')
    </div>
    <div class="tab-content" id="preferance" style="display: none;">
        @include('tabs.preferance')
    </div>

</div>
<script>
    const tabs = document.querySelectorAll(".tab");
    const contents = document.querySelectorAll(".tab-content");
    tabs.forEach((tab) => 
    {
        tab.addEventListener("click", () => 
        {
            tabs.forEach((t) => t.classList.remove("active"));
            tab.classList.add("active");

            const selected = tab.getAttribute("data-tab");
            contents.forEach((c) => {
            c.style.display = c.id === selected ? "block" : "none";
            });
        });
    });
</script>

@endsection
<style>
    body {
        display: block !important;   /* stop flex centering */
        padding: 0;                  /* let your layout handle spacing */
        color: #212529;
    }

    .tab-wrapper {
    max-width: 100%;
    width: 95%; /* take almost full width like multi-step form */
       padding: 20px;
    border-radius: 8px;
    box-shadow: 0px 4px 10px rgba(0,0,0,0.1);
    margin: 0 auto;
    background: #f5f6fa;  /* same as .bg-light */
    padding: 1.5rem;      /* same as p-4 */
    border-radius: 0.375rem; /* same as .rounded */
    box-shadow: 0 0.5rem 1rem rgba(0,0,0,0.15); /* same as .shadow */
    }

    /* Tabs container */
    .tabs {
        display: flex;
        gap: 10px;
        margin-bottom: 20px;
    }

    /* Tab buttons */
    .tab {
        flex: 1;
        padding: 5px;
        background: #dee2e6;
        color: #000;
        border: none;
        border-radius: 6px;
        cursor: pointer;
        font-weight: 400;
        font-size:12px;
        transition: all 0.3s ease;
    }

    .tab:hover {
        background: #dee2e6;
    }

    .tab.active {
        background: #0B1061; /* Bootstrap primary */
        color: #f2f2f2;
    }

    /* Content box */
    .tab-content {
        background: #f2f2f2;
        padding: 20px;
        border-radius: 6px;
        border: 1px solid #dee2e6;
        box-shadow: inset 0 1px 3px rgba(0,0,0,0.05);
    }
</style>

