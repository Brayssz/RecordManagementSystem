<!-- filepath: g:\Project\RecordManagementSystem\resources\views\auth\register.blade.php -->
@extends('layout.auth-layout')

@section('title', 'MMML - Applicant Registration')

@section('content')
    <div class="account-content">
        <div class="login-wrapper login-new">
            <div class="login-content user-login">
                <div class="login-logo">
                    <img src="img/logo.jpg" alt="img">
                    <a href="index.html" class="login-logo logo-white">
                        <img src="img/logo.jpg" alt="">
                    </a>
                </div>
                <form method="POST" action="{{ route('register') }}" class="w-50">
                    @csrf
                    <div class="login-userset">
                        <div class="login-userheading">
                            <h3>Applicant Registration</h3>
                            <h4>Create New Account</h4>
                        </div>

                        <div class="card-body">
                            <div class="new-employee-field">
                                <div class="card-title-head">
                                    <h6><span><i data-feather="info" class="feather-edit"></i></span>Personal Information
                                    </h6>
                                </div>
                                <div class="row">
                                    <div class="col-lg-4 col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label" for="first_name">First Name</label>
                                            <input type="text" class="form-control" placeholder="Enter first name"
                                                id="first_name" name="first_name" value="{{ old('first_name') }}" autofocus
                                                autocomplete="first_name">
                                            @error('first_name')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-lg-4 col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label" for="middle_name">Middle Name</label>
                                            <input type="text" class="form-control" placeholder="Enter middle name"
                                                id="middle_name" name="middle_name" value="{{ old('middle_name') }}"
                                                autofocus autocomplete="middle_name">
                                            @error('middle_name')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-lg-4 col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label" for="last_name">Last Name</label>
                                            <input type="text" class="form-control" placeholder="Enter last name"
                                                id="last_name" name="last_name" value="{{ old('last_name') }}" autofocus
                                                autocomplete="last_name">
                                            @error('last_name')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-lg-4 col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label" for="gender">Gender</label>
                                            <select class="form-select" id="gender" name="gender"
                                                value="{{ old('gender') }}" autofocus autocomplete="gender">
                                                <option value="">Choose</option>
                                                <option value="Male">Male</option>
                                                <option value="Female">Female</option>
                                                <option value="Others">Others</option>
                                            </select>
                                            @error('gender')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-lg-4 col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label" for="email">Email</label>
                                            <input type="email" class="form-control" placeholder="e.g., name@mail.com"
                                                id="email" name="email" value="{{ old('email') }}" autofocus
                                                autocomplete="email">
                                            @error('email')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-lg-4 col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label" for="contact_number">Contact Number</label>
                                            <input type="text" class="form-control phMobile not_pass"
                                                placeholder="e.g., +63 999 999 9999" id="contact_number"
                                                name="contact_number" value="{{ old('contact_number') }}" autofocus
                                                autocomplete="contact_number">
                                            @error('contact_number')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-lg-4 col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label" for="date_of_birth">Date of Birth</label>
                                            <input type="date" class="form-control" id="date_of_birth"
                                                name="date_of_birth" value="{{ old('date_of_birth') }}" autofocus
                                                autocomplete="date_of_birth">
                                            @error('date_of_birth')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-lg-4 col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label" for="region">Region</label>
                                            <input type="text" class="form-control" id="region" name="region"
                                                value="{{ old('region') }}" autofocus autocomplete="region"
                                                placeholder="Enter your region">
                                            @error('region')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-lg-4 col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label" for="province">Province</label>
                                            <input type="text" class="form-control" id="province" name="province"
                                                value="{{ old('province') }}" autofocus autocomplete="province"
                                                placeholder="Enter your province">
                                            @error('province')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-lg-4 col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label" for="municipality">Municipality</label>
                                            <input type="text" class="form-control" id="municipality"
                                                name="municipality" value="{{ old('municipality') }}" autofocus
                                                autocomplete="municipality" placeholder="Enter your municipality">
                                            @error('municipality')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-lg-4 col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label" for="barangay">Barangay</label>
                                            <input type="text" class="form-control" id="barangay" name="barangay"
                                                value="{{ old('barangay') }}" autofocus autocomplete="barangay"
                                                placeholder="Enter your barangay">
                                            @error('barangay')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-lg-4 col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label" for="street">Street</label>
                                            <input type="text" class="form-control" id="street" name="street"
                                                value="{{ old('street') }}" autofocus autocomplete="street"
                                                placeholder="Enter your street">
                                            @error('street')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-lg-4 col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label" for="postal_code">Postal Code</label>
                                            <input type="text" class="form-control" id="postal_code"
                                                name="postal_code" value="{{ old('postal_code') }}" autofocus
                                                autocomplete="postal_code" placeholder="Enter your postal code">
                                            @error('postal_code')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-lg-4 col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label" for="citizenship">Citizenship</label>
                                            <input type="text" class="form-control" id="citizenship"
                                                name="citizenship" value="{{ old('citizenship') }}" autofocus
                                                autocomplete="citizenship" placeholder="Enter your citizenship">
                                            @error('citizenship')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-lg-4 col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label" for="marital_status">Marital Status</label>
                                            <input type="text" class="form-control" id="marital_status"
                                                name="marital_status" value="{{ old('marital_status') }}" autofocus
                                                autocomplete="marital_status" placeholder="Enter your marital status">
                                            @error('marital_status')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="pass-info">
                                <div class="card-title-head">
                                    <h6><span><i data-feather="info" class="feather-edit"></i></span>Password</h6>
                                </div>
                                <div class="row">
                                    <div class="col-lg-4 col-md-6">
                                        <div class="input-blocks mb-md-0 mb-sm-3">
                                            <label for="password">Password</label>
                                            <div class="pass-group">
                                                <input type="password" class="pass-input" id="password" name="password"
                                                    autocomplete="new-password" placeholder="Enter your password">
                                                <span class="fas toggle-password fa-eye-slash"></span>
                                            </div>
                                            @error('password')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-6">
                                        <div class="input-blocks mb-0">
                                            <label for="password_confirmation">Confirm Password</label>
                                            <div class="pass-group">
                                                <input type="password" class="pass-inputa" id="password_confirmation"
                                                    name="password_confirmation" autocomplete="new-password"
                                                    placeholder="Confirm your password">
                                                <span class="fas toggle-passworda fa-eye-slash"></span>
                                            </div>
                                            @error('password_confirmation')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-check mt-4">
                                <input class="form-check-input" type="checkbox" id="terms" name="terms"
                                    {{ old('terms') ? 'checked' : '' }}>
                                <label class="form-check-label" for="terms">
                                    I agree to the <a href="#" data-bs-toggle="modal" data-bs-target="#terms-modal">Terms and Conditions</a>
                                </label>
                                @error('terms')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-login mt-5">
                            <button type="submit" class="btn btn-login">Sign Up</button>
                        </div>
                        <div class="signinform">
                            <h4>Already have an account? <a href="{{ route('login') }}" class="hover-a">Sign In
                                    Instead</a></h4>
                        </div>
                    </div>
                </form>
            </div>
            <div class="my-4 d-flex justify-content-center align-items-center copyright-text">
                <p>Copyright &copy; 2023 MNNL. All rights reserved.</p>
            </div>
        </div>
    </div>
    <div class="modal fade" id="terms-modal" wire:ignore.self>
        <div class="modal-dialog modal-dialog-centered modal-lg custom-modal-two">
            <div class="modal-content">
                <div class="page-wrapper-new p-0">
                    <div class="content">
                        <div class="modal-header border-0 custom-modal-header">
                            <div class="page-title">
                                <h4>Terms and Conditions</h4>
                            </div>
                            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="terms-content px-5">
                                
                                <p>By creating an account with <strong>MMML Recruitment Agency</strong>, you agree to the following terms:</p>
                        
                                <h6>1. Acceptance of Terms</h6>
                                <p>You must read and agree to these Terms before proceeding with registration.</p>
                        
                                <h6>2. Eligibility</h6>
                                <p>- You must be at least 18 years old or meet the minimum employment age.<br>
                                   - All information provided must be accurate and truthful.<br>
                                   - This platform must be used only for job application purposes.</p>
                        
                                <h6>3. Use of Personal Information</h6>
                                <p>- Your personal data will be stored and processed as outlined in our <strong>Privacy Policy</strong>.<br>
                                   - Your profile may be shared with potential employers.<br>
                                   - We may contact you regarding job opportunities and updates.</p>
                        
                                <h6>4. Application and Approval</h6>
                                <p>- Submission of an application does not guarantee job placement.<br>
                                   - Additional documents may be required upon approval.</p>
                        
                                <h6>5. User Responsibilities</h6>
                                <p>- Keep your login credentials confidential.<br>
                                   - Provide truthful and up-to-date information.<br>
                                   - Do not misuse the platform.</p>
                        
                                <h6>6. Termination of Account</h6>
                                <p>We reserve the right to suspend or terminate accounts that violate these terms.</p>
                        
                                <h6>7. Changes to Terms</h6>
                                <p>We may update these Terms at any time. Continued use implies acceptance.</p>
                        
                                <h6>8. Contact Us</h6>
                                <p>📧 support@mmmlrecruitment.com<br>
                                   📞 +63 999 999 9999</p>
                            </div>
                        
                            <div class="modal-footer-btn mb-4 mt-0">
                                <button type="button" class="btn btn-cancel me-2" data-bs-dismiss="modal">Cancel</button>
                                <button type="button" class="btn bg-primary btn-agree-terms" data-bs-dismiss="modal">Agree</button>
                            </div>
                        </div>
                        
                       
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
@push('scripts')
    <script>
        $(document).ready(function() {

            $('.btn-agree-terms').on('click', function() {
                $('#terms').prop('checked', true);
            });
        });
    </script>
@endpush
