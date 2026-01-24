@extends('layouts.app')

@section('title', 'Theme Settings')

@section('content')
<div class="container-custom">

    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('list_dashboard') }}">Dashboard</a>
            </li>
            <li class="breadcrumb-item active">Theme Settings</li>
        </ol>
    </nav>

    <form id="theme_form" class="p-4 bg-light rounded shadow">

        <h4 class="mb-4">Theme Settings</h4>

        <div class="row g-3">
            <div class="col-md-4">
                <label class="form-label required">Theme Color 1(Sidebar)</label>
                <input type="color"
                       class="form-control form-control-color"
                       name="sidebar_color"
                       value="{{ $theme->sidebar_color ?? '#0b1061' }}">
                <div class="text-danger error-message" data-error-for="sidebar_color"></div>
            </div>

            <div class="col-md-4">
                <label class="form-label required">Theme Color 2(Main Section)</label>
                <input type="color"
                       class="form-control form-control-color"
                       name="theme_color"
                       value="{{ $theme->theme_color ?? '#0b1061' }}">
                <div class="text-danger error-message" data-error-for="theme_color"></div>
            </div>

           

            <div class="col-md-4">
                <label class="form-label required">Theme Color 3</label>
                <input type="color"
                       class="form-control form-control-color"
                       name="sidebar_light"
                       value="{{ $theme->sidebar_light ?? '#edf5f0' }}">
                <div class="text-danger error-message" data-error-for="sidebar_light"></div>
            </div>
            <div class="col-md-4">
                <label class="form-label required">Black Color</label>
                <input type="color"
                       class="form-control form-control-color"
                       name="black_color"
                       value="{{ $theme->black_color ?? '#000000' }}">
                <div class="text-danger error-message" data-error-for="black_color"></div>
            </div>

            <div class="col-md-4">
                <label class="form-label required">White Color</label>
                <input type="color"
                       class="form-control form-control-color"
                       name="other_color_fff"
                       value="{{ $theme->other_color_fff ?? '#ffffff' }}">
                <div class="text-danger error-message" data-error-for="other_color_fff"></div>
            </div>

            <div class="col-md-4">
                <label class="form-label required">Font Size</label>
                <input type="text"
                       class="form-control"
                       name="font_size"
                       placeholder="e.g. 14px"
                       value="{{ $theme->font_size ?? '14px' }}" readonly>
                <div class="text-danger error-message" data-error-for="font_size"></div>
            </div>

            <div class="col-md-4">
                <label class="form-label required">Small Font Size</label>
                <input type="text"
                       class="form-control"
                       name="font_size_10px"
                       placeholder="e.g. 10px"
                       value="{{ $theme->font_size_10px ?? '10px' }}" readonly>
                <div class="text-danger error-message" data-error-for="font_size_10px" ></div>
            </div>

            

        </div>

        <!-- Submit -->
        <div class="text-end mt-4">
            <button type="submit" class="btn" id="submitBtn">
                Save Theme
            </button>
        </div>

    </form>
</div>
@endsection
<style>
    input[readonly] {
    background-color: #f5f7fa;
    cursor: not-allowed;
}
</style>

@push('scripts')
<script>
    const submitThemeUrl = "{{ route('theme.update') }}";
</script>
<script src="{{ asset('assets/js/theme/theme.js') }}"></script>
@endpush
