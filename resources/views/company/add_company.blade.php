@extends('layouts.app')

@section('title', 'Add Member')

@section('content')
<form id="multiStepForm" class="p-4 bg-light rounded shadow" 
      style="max-width: 100%; width: 95%; margin: 0 auto;">

    <div class="progressbar d-flex justify-content-center align-items-center mb-4">
        <div class="circle active" data-step="1">1</div>
        <div class="line"></div>
        <div class="circle" data-step="2">2</div>
        <div class="line"></div>
        <div class="circle" data-step="3">3</div>
    </div>
    <!-- Step 1 -->
    <div class="step" data-step="1">  
        <h5 class="mb-3">Company Details</h5>

        <div class="row mb-3">
            <div class="col-12 col-md-6 mb-3">
                <label class="form-label">Company Name</label>
                <input type="text" class="form-control" name="company_name" id="company_name" placeholder="Enter Company Name">
                <div class="text-danger error-message" data-error-for="company_name"></div>
            </div>

            <div class="col-12 col-md-6 mb-3">
                <label class="form-label">Company Mail Name</label>
                <input type="text" class="form-control" name="company_mailing_name" id="company_mailing_name" placeholder="Enter Mailing Name">
                <div class="text-danger error-message" data-error-for="company_mailing_name"></div>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-12 mb-3">
                <label class="form-label">Address</label>
                <textarea class="form-control" name="address" id="address" rows="2" placeholder="Enter Company Address"></textarea>
                <div class="text-danger error-message" data-error-for="address"></div>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-12 col-md-4 mb-3">
                <label class="form-label">Country</label>
                <select class="form-select" name="country" id="country">
                    <option selected disabled>{{ __('global.select_option') }}</option>
                    <option value="india">India</option>
                    <option value="usa">USA</option>
                    <option value="uk">UK</option>
                </select>
                <div class="text-danger error-message" data-error-for="country"></div>
            </div>
            <div class="col-12 col-md-4 mb-3">
                <label class="form-label">State</label>
                <select class="form-select" name="state" id="state">
                    <option selected disabled>{{ __('global.select_option') }}</option>
                    <option value="bihar">Bihar</option>
                    <option value="maharashtra">Maharashtra</option>
                    <option value="gujarat">Gujarat</option>
                </select>
                <div class="text-danger error-message" data-error-for="state"></div>
            </div>
            <div class="col-12 col-md-4 mb-3">
                <label class="form-label">Pincode</label>
                <input type="number" class="form-control" name="pincode" id="pincode" placeholder="Enter Pincode">
                <div class="text-danger error-message" data-error-for="pincode"></div>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-12 col-md-4 mb-3">
                <label class="form-label">Phone No.</label>
                <input type="number" class="form-control" name="phone" id="phone" placeholder="Enter Phone Number">
                <div class="text-danger error-message" data-error-for="phone"></div>
            </div>
            <div class="col-12 col-md-4 mb-3">
                <label class="form-label">Mobile No.</label>
                <input type="text" class="form-control" name="mobile" id="mobile" placeholder="{{ __('global.mobile_placeholder') }}">
                <div class="text-danger error-message" data-error-for="mobile"></div>
            </div>
            <div class="col-12 col-md-4 mb-3">
                <label class="form-label">Fax No.</label>
                <input type="number" class="form-control" name="fax_no" id="fax_no" placeholder="Enter Fax Number">
                <div class="text-danger error-message" data-error-for="fax_no"></div>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-12 col-md-6 mb-3">
                <label class="form-label">Email</label>
                <input type="email" class="form-control" name="email" id="email" placeholder="Enter Company Email">
                <div class="text-danger error-message" data-error-for="email"></div>
            </div>
            <div class="col-12 col-md-6 mb-3">
                <label class="form-label">Website</label>
                <input type="text" class="form-control" name="website" id="website" placeholder="https://example.com">
                <div class="text-danger error-message" data-error-for="website"></div>
            </div>
        </div>
    </div>

    <!-- Step 2 -->
    <div class="step d-none" data-step="2">
       
        {{-- New Financial Year & Books Begin --}}
        <div class="row g-3 mt-2">
            <div class="col-md-6 col-12">
                <label class="form-label">Financial Year Begins From</label>
                <input type="date" class="form-control" name="financial_year" id="financial_year">
                <div class="text-danger error-message" data-error-for="financial_year"></div>
            </div>

            <div class="col-md-6 col-12">
                <label class="form-label">Books Begin From</label>
                <input type="date" class="form-control" name="books_begin" id="books_begin">
                <div class="text-danger error-message" data-error-for="books_begin"></div>
            </div>
        </div>

        {{-- Password & Confirm Password --}}
        <div class="row g-3 mt-2">
            <div class="col-md-6 col-12">
                <label class="form-label">Password</label>
                <div class="input-group">
                    <input type="password" class="form-control" name="password" id="password">
                    <button type="button" class="btn btn-outline-secondary toggle-password" data-target="#password">
                        <i class="bi bi-eye"></i>
                    </button>
                </div>
                <div class="text-danger error-message" data-error-for="password"></div>
            </div>

            <div class="col-md-6 col-12">
                <label class="form-label">Confirm Password</label>
                <div class="input-group">
                    <input type="password" class="form-control" name="confirm_password" id="confirm_password">
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
                    <option value="no" selected>No</option>
                    <option value="yes">Yes</option>
                </select>
            </div>
        </div>

        {{-- Conditional Security Password Fields --}}
        <div class="row g-3 mt-2 d-none" id="securityFields">
            <div class="col-md-6 col-12">
                <label class="form-label">Security Password</label>
                <div class="input-group">
                    <input type="password" class="form-control" name="security_password" id="security_password">
                    <button type="button" class="btn btn-outline-secondary toggle-password" data-target="#security_password">
                        <i class="bi bi-eye"></i>
                    </button>
                </div>
                <div class="text-danger error-message" data-error-for="security_password"></div>
            </div>

            <div class="col-md-6 col-12">
                <label class="form-label">Confirm Security Password</label>
                <div class="input-group">
                    <input type="password" class="form-control" name="confirm_security_password" id="confirm_security_password">
                    <button type="button" class="btn btn-outline-secondary toggle-password" data-target="#confirm_security_password">
                        <i class="bi bi-eye"></i>
                    </button>
                </div>
                <div class="text-danger error-message" data-error-for="confirm_security_password"></div>
            </div>
        </div>
    </div>

    <!-- Step 3 -->
    <div class="step d-none" data-step="3">
        <div class="row g-3 mt-2">
            <div class="col-md-6 col-12">
                <label class="form-label">Base Currency</label>
                <input type="text" class="form-control" value="Rs" disabled>
            </div>
            <div class="col-md-6 col-12">
                <label class="form-label">Formal Name</label>
                <input type="text" class="form-control" value="INR" disabled>
            </div>

            <div class="col-md-6 col-12">
                <label class="form-label">Suffix Symbol to Amount</label>
                <select class="form-select" name="suffix_symbol">
                    <option value="yes">Yes</option>
                    <option value="no" selected>No</option>
                </select>
            </div>
            <div class="col-md-6 col-12">
                <label class="form-label">Add Space Between Amount and Symbol</label>
                <select class="form-select" name="space_between">
                    <option value="yes">Yes</option>
                    <option value="no" selected>No</option>
                </select>
            </div>

            <div class="col-md-6 col-12">
                <label class="form-label">Show Amount in Millions</label>
                <select class="form-select" name="show_in_millions">
                    <option value="yes">Yes</option>
                    <option value="no" selected>No</option>
                </select>
            </div>
            <div class="col-md-6 col-12">
                <label class="form-label">Number of Decimal Places</label>
                <input type="number" class="form-control" name="decimal_places" min="0" max="6" value="2">
            </div>

            <div class="col-md-6 col-12">
                <label class="form-label">Word Representing Amount After Decimal</label>
                <input type="text" class="form-control" value="Paise" disabled>
            </div>
            <div class="col-md-6 col-12">
                <label class="form-label">No. of Decimal Places for Amount in Words</label>
                <input type="number" class="form-control" value="2" disabled>
            </div>
        </div>
    </div>

    <!-- Navigation Buttons -->
    <div class="d-flex justify-content-between mt-3">
        <!-- Prev Button (left) -->
        <button type="button" id="prevBtn" class="btn btn-secondary rounded-pill">Prev</button>

        <!-- Next/Submit Button (right) -->
        <button type="button" id="nextBtn" class="btn btn-secondary rounded-pill">Next</button>

        <button type="submit" id="submitBtn" class="btn btn-success rounded-pill">Submit</button>
    </div>
</form>

<!-- Include jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
const addCompany = "{{ route('create_company') }}";
</script>

<script src="{{ asset('assets/js/company/add_company.js') }}"></script>

<script>
    function showStep(step) 
    {
        $('.step').addClass('d-none');
        $(`.step[data-step="${step}"]`).removeClass('d-none');

        // Prev button
        if (step === 1) {
            $('#prevBtn').css('visibility', 'hidden');
        } else {
            $('#prevBtn').css('visibility', 'visible');
        }

        // Next / Submit button
        if (step === totalSteps) {
            $('#nextBtn').hide();
            $('#submitBtn').show();
        } else {
            $('#nextBtn').show();
            $('#submitBtn').hide();
        }

        // 🔹 Update stepper indicators
        $('.circle').removeClass('active completed');
        $('.line').removeClass('active');

        $('.circle').each(function () {
            const s = $(this).data('step');
            if (s < step) {
                $(this).addClass('completed');
                $(this).next('.line').addClass('active');
            } else if (s === step) {
                $(this).addClass('active');
            }
        });
    }
</script>
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
@endsection

<style>
.progressbar {
    display: flex;
    justify-content: center;
    align-items: center;
}
.circle {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    background: #ddd;
    color: #000;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: bold;
}
.circle.active {
    background: #0B1061;  /* Bootstrap primary blue */
    color: #fff;
}
.circle.completed {
    background: #28a745; /* green */
    color: #fff;
}
.line {
    flex: 1;
    height: 4px;
    background: #ddd;
}
.line.active {
    background: #28a745; /* green */
}
</style>