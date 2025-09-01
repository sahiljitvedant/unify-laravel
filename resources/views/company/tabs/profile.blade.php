<form id="multiStepForm" class="">

<div class="step" data-step="2">
    {{-- Financial Year & Books Begin --}}
    <div class="row g-3 mt-2">
        <div class="col-md-6 col-12">
            <label class="form-label">Financial Year Begins From</label>
            <input type="date" class="form-control"
                name="financial_year" id="financial_year"
                value="{{ old('financial_year', $member->financial_year) }}">
            <div class="text-danger error-message" data-error-for="financial_year"></div>
        </div>

        <div class="col-md-6 col-12">
            <label class="form-label">Books Begin From</label>
            <input type="date" class="form-control"
                name="books_begin" id="books_begin"
                value="{{ old('books_begin', $member->books_begin) }}">
            <div class="text-danger error-message" data-error-for="books_begin"></div>
        </div>
    </div>

    {{-- Password & Confirm Password --}}
    <div class="row g-3 mt-2">
        <div class="col-md-6 col-12">
            <label class="form-label">Password</label>
            <div class="input-group">
                <input type="password" class="form-control"
                    name="password" id="password"
                    placeholder="Leave blank to keep existing">
                <button type="button" class="btn btn-outline-secondary toggle-password" data-target="#password">
                    <i class="bi bi-eye"></i>
                </button>
            </div>
            <div class="text-danger error-message" data-error-for="password"></div>
        </div>

        <div class="col-md-6 col-12">
            <label class="form-label">Confirm Password</label>
            <div class="input-group">
                <input type="password" class="form-control"
                    name="confirm_password" id="confirm_password"
                    placeholder="Leave blank to keep existing">
                <button type="button" class="btn btn-outline-secondary toggle-password" data-target="#confirm_password">
                    <i class="bi bi-eye"></i>
                </button>
            </div>
            <div class="text-danger error-message" data-error-for="confirm_password"></div>
        </div>
    </div>

    {{-- Security Control Dropdown --}}
    <div class="row g-3 mt-2">
        <div class="col-md-6 col-12">
            <label class="form-label">Use Security Control</label>
            <select class="form-select" name="use_security" id="use_security">
                <option value="no" {{ old('use_security', $member->use_security) == 'no' ? 'selected' : '' }}>No</option>
                <option value="yes" {{ old('use_security', $member->use_security) == 'yes' ? 'selected' : '' }}>Yes</option>
            </select>
        </div>
    </div>

    {{-- Conditional Security Password Fields --}}
    <div class="row g-3 mt-2 {{ old('use_security', $member->use_security) == 'yes' ? '' : 'd-none' }}" id="securityFields">
        <div class="col-md-6 col-12">
            <label class="form-label">Security Password</label>
            <div class="input-group">
                <input type="password" class="form-control"
                    name="security_password" id="security_password"
                    placeholder="Leave blank to keep existing">
                <button type="button" class="btn btn-outline-secondary toggle-password" data-target="#security_password">
                    <i class="bi bi-eye"></i>
                </button>
            </div>
            <div class="text-danger error-message" data-error-for="security_password"></div>
        </div>

        <div class="col-md-6 col-12">
            <label class="form-label">Confirm Security Password</label>
            <div class="input-group">
                <input type="password" class="form-control"
                    name="confirm_security_password" id="confirm_security_password"
                    placeholder="Leave blank to keep existing">
                <button type="button" class="btn btn-outline-secondary toggle-password" data-target="#confirm_security_password">
                    <i class="bi bi-eye"></i>
                </button>
            </div>
            <div class="text-danger error-message" data-error-for="confirm_security_password"></div>
        </div>
    </div>
</div>

<div class="text-end mt-4">
    <button type="submit" class="btn btn-primary" id="submitBtn">Submit</button>
</div>
</form>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
const submitcompany_2 = "{{ route('update_company_profile', ['id' => $member->id]) }}";
</script>

<script src="{{ asset('assets/js/company/edit_company.js') }}"></script>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        // Toggle password visibility
        document.querySelectorAll(".toggle-password").forEach(btn => {
            btn.addEventListener("click", function () {
                const target = document.querySelector(this.getAttribute("data-target"));
                if (target.type === "password") {
                    target.type = "text";
                    this.innerHTML = '<i class="bi bi-eye-slash"></i>';
                } else {
                    target.type = "password";
                    this.innerHTML = '<i class="bi bi-eye"></i>';
                }
            });
        });

        // Show/hide security fields
        document.getElementById("use_security").addEventListener("change", function () {
            const fields = document.getElementById("securityFields");
            if (this.value === "yes") {
                fields.classList.remove("d-none");
            } else {
                fields.classList.add("d-none");
            }
        });
    });
</script>