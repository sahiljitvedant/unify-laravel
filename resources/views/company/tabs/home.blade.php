<form id="multiStepHomeForm" class="">
<div class="step" data-step="1">  
    <h5 class="mb-3">Company Details</h5>

    <div class="row mb-3">
        <div class="col-12 col-md-6 mb-3">
            <label class="form-label">Company Name</label>
            <input type="text" class="form-control" name="company_name" id="company_name" 
                   placeholder="Enter Company Name" 
                   value="{{ old('company_name', $member->company_name ?? '') }}">
            <div class="text-danger error-message" data-error-for="company_name"></div>
            <div class="text-danger error-message" data-error-for="company_name"></div>
        </div>

        <div class="col-12 col-md-6 mb-3">
            <label class="form-label">Company Mail Name</label>
            <input type="text" class="form-control" name="company_mailing_name" id="company_mailing_name" 
                   placeholder="Enter Mailing Name"
                   value="{{ old('company_mailing_name', $member->company_mailing_name ?? '') }}">
            <div class="text-danger error-message" data-error-for="company_mailing_name"></div>
        </div>
    </div>

    <div class="row mb-3">
        <div class="col-12 mb-3">
            <label class="form-label">Address</label>
            <textarea class="form-control" name="address" id="address" rows="2" placeholder="Enter Company Address">{{ old('address', $member->address ?? '') }}</textarea>
            <div class="text-danger error-message" data-error-for="address"></div>
        </div>
    </div>

    <div class="row mb-3">
        <div class="col-12 col-md-4 mb-3">
            <label class="form-label">Country</label>
            <select class="form-select" name="country" id="country">
                <option selected disabled>{{ __('global.select_option') }}</option>
                <option value="india" {{ old('country', $member->country ?? '') == 'india' ? 'selected' : '' }}>India</option>
                <option value="usa" {{ old('country', $member->country ?? '') == 'usa' ? 'selected' : '' }}>USA</option>
                <option value="uk" {{ old('country', $member->country ?? '') == 'uk' ? 'selected' : '' }}>UK</option>
            </select>
            <div class="text-danger error-message" data-error-for="country"></div>
        </div>
        <div class="col-12 col-md-4 mb-3">
            <label class="form-label">State</label>
            <select class="form-select" name="state" id="state">
                <option selected disabled>{{ __('global.select_option') }}</option>
                <option value="bihar" {{ old('state', $member->state ?? '') == 'bihar' ? 'selected' : '' }}>Bihar</option>
                <option value="maharashtra" {{ old('state', $member->state ?? '') == 'maharashtra' ? 'selected' : '' }}>Maharashtra</option>
                <option value="gujarat" {{ old('state', $member->state ?? '') == 'gujarat' ? 'selected' : '' }}>Gujarat</option>
            </select>
            <div class="text-danger error-message" data-error-for="state"></div>
        </div>
        <div class="col-12 col-md-4 mb-3">
            <label class="form-label">Pincode</label>
            <input type="number" class="form-control" name="pincode" id="pincode" 
                   placeholder="Enter Pincode"
                   value="{{ old('pincode', $member->pincode ?? '') }}">
            <div class="text-danger error-message" data-error-for="pincode"></div>
        </div>
    </div>

    <div class="row mb-3">
        <div class="col-12 col-md-4 mb-3">
            <label class="form-label">Phone No.</label>
            <input type="number" class="form-control" name="phone" id="phone" 
                   placeholder="Enter Phone Number"
                   value="{{ old('phone', $member->phone ?? '') }}">
            <div class="text-danger error-message" data-error-for="phone"></div>
        </div>
        <div class="col-12 col-md-4 mb-3">
            <label class="form-label">Mobile No.</label>
            <input type="text" class="form-control" name="mobile" id="mobile" 
                   placeholder="{{ __('global.mobile_placeholder') }}"
                   value="{{ old('mobile', $member->mobile ?? '') }}">
            <div class="text-danger error-message" data-error-for="mobile"></div>
        </div>
        <div class="col-12 col-md-4 mb-3">
            <label class="form-label">Fax No.</label>
            <input type="number" class="form-control" name="fax_no" id="fax_no" 
                   placeholder="Enter Fax Number"
                   value="{{ old('fax_no', $member->fax_no ?? '') }}">
            <div class="text-danger error-message" data-error-for="fax_no"></div>
        </div>
    </div>

    <div class="row mb-3">
        <div class="col-12 col-md-6 mb-3">
            <label class="form-label">Email</label>
            <input type="email" class="form-control" name="email" id="email" 
                   placeholder="Enter Company Email"
                   value="{{ old('email', $member->email ?? '') }}">
            <div class="text-danger error-message" data-error-for="email"></div>
        </div>
        <div class="col-12 col-md-6 mb-3">
            <label class="form-label">Website</label>
            <input type="text" class="form-control" name="website" id="website" 
                   placeholder="https://example.com"
                   value="{{ old('website', $member->website ?? '') }}">
            <div class="text-danger error-message" data-error-for="website"></div>
        </div>
    </div>
</div>
<div class="text-end mt-4">
    <button type="submit" class="btn btn-primary" id="submit_home">Submit</button>
</div>
</form>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
const submithome = "{{ route('update_home_profile', ['id' => $member->id]) }}";
</script>

<script src="{{ asset('assets/js/company/edit_home.js') }}"></script>
<script>
    document.addEventListener("DOMContentLoaded", function () 
    {
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