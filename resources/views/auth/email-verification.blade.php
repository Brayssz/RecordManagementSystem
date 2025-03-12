@extends('layout.auth-layout')

@section('title', 'MMML - Verification')

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
                <div class="login-userset">
                    <a href="index.html" class="login-logo logo-white">
                        <img src="img/logo.jpg" alt="">
                    </a>
                    <div class="login-userheading text-center">
                        @if ($errors->any())
                            @foreach ($errors->all() as $error)
                                <div class="alert alert-danger d-flex align-items-center" role="alert">
                                    <i class="feather-alert-octagon flex-shrink-0 me-2"></i>
                                    <div>
                                        {{ $error }}
                                    </div>
                                </div>
                            @endforeach
                        @endif

                        @if (session('status') == 'verification-link-sent')
                            <div class="alert alert-success d-flex align-items-center" role="alert">
                                <i class="feather-check-circle flex-shrink-0 me-2"></i>
                                <div>
                                    Verification link has been sent to your email address.
                                </div>
                            </div>
                        @endif

                        <h3>Verify Your Email</h3>
                        <form method="POST" action="{{ route('verify-email') }}">
                            @csrf
                            <div class="col-lg-12 col-md-12">
                                <div class="mb-3">
                                    <label class="form-label" for="email">Email Address</label>
                                    <input type="email" class="form-control" placeholder="Enter your email" id="email"
                                        name="email" value="{{ old('email') }}">
                                    <span class="text-danger" id="email_error"></span>
                                </div>
                            </div>
                            <h4 class="verfy-mail-content">We will send a link to your email. Please
                                follow the link inside to continue</h4>
                            <div class="form-login">
                                <button type="submit" class="btn btn-login">Send Email</button>
                            </div>
                        </form>
                    </div>
                    <div class="signinform text-center">
                        <h4>Didn't receive an email? <a href="javascript:void(0);" class="hover-a resend">Resend
                                Link</a></h4>
                    </div>
                </div>
            </div>
            <div class="my-4 d-flex justify-content-center align-items-center copyright-text">
                <p>Copyright &copy; 2025 MMML. All rights reserved</p>
            </div>
        </div>
    </div>

@endsection
