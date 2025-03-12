@extends('layout.auth-layout')

@section('title', 'MMML - Reset Password')

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
                <form method="POST" action="{{ route('password-reset') }}">
                    @csrf
                    <input type="hidden" name="token" value="{{ $token }}">
                    <input type="hidden" name="email" value="{{ $email }}">
                    <div class="login-userset">
                        <div class="login-userheading">
                            <h3>Reset password?</h3>
                            <h4>Enter New Password & Confirm Password to get inside</h4>
                        </div>
                        <div class="form-login">
                            <label>New Password</label>
                            <div class="pass-group">
                                <input type="password" class="pass-input" name="password" required>
                                <span class="fas toggle-password fa-eye-slash"></span>
                            </div>
                        </div>
                        <div class="form-login">
                            <label>Confirm New Password</label>
                            <div class="pass-group">
                                <input type="password" class="pass-input" name="password_confirmation" required>
                                <span class="fas toggle-password fa-eye-slash"></span>
                            </div>
                        </div>
                        <div class="form-login">
                            <button type="submit" class="btn btn-login">Change Password</button>
                        </div>
                        <div class="signinform text-center">
                            <h4>Return to <a href="{{ route('login') }}" class="hover-a"> login </a></h4>
                        </div>
                    </div>
                </form>
            </div>
            <div class="my-4 d-flex justify-content-center align-items-center copyright-text">
                <p>Copyright &copy; 2025  MMML. All rights reserved</p>
            </div>
        </div>
    </div>
@endsection