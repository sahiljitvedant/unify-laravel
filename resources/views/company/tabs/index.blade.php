@extends('layouts.app')

@section('title', 'Edit Member')

@section('content')
<div class="tab-wrapper">
  <div class="tabs">
    <button class="tab active" data-tab="home">22222</button>
    <button class="tab" data-tab="profile">Profile</button>
    <button class="tab" data-tab="settings">Settings</button>
  </div>

    <div class="tab-content" id="home">
        @include('company.tabs.home')
    </div>
    <div class="tab-content" id="profile" style="display: none;">
        @include('company.tabs.profile')
    </div>
    <div class="tab-content" id="settings" style="display: none;">
        @include('company.tabs.settings')
    </div>
</div>
<style>
   
    .tab-wrapper {
    max-width: 100%;
    width: 95%; /* take almost full width like multi-step form */
    background: #ffffff;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0px 4px 10px rgba(0,0,0,0.1);
    margin: 0 auto;
    background: #dee2e6;  /* same as .bg-light */
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
        padding: 12px;
        background: #e9ecef;
        color: #212529;
        border: none;
        border-radius: 6px;
        cursor: pointer;
        font-weight: 500;
        transition: all 0.3s ease;
    }

    .tab:hover {
        background: #dee2e6;
    }

    .tab.active {
        background: #0d6efd; /* Bootstrap primary */
        color: #fff;
    }

    /* Content box */
    .tab-content {
        background: #dee2e6;
        padding: 20px;
        border-radius: 6px;
        border: 1px solid #dee2e6;
        box-shadow: inset 0 1px 3px rgba(0,0,0,0.05);
    }
</style>

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