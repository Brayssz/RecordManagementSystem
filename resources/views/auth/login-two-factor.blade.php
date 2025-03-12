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
                    <div class="login-userheading">
                        <h3>Login With Your Email Address</h3>
                        <h4 class="verfy-mail-content">We sent a verification code to your email. Enter the code
                            from the email in the field below</h4>
                    </div>
                    <form id="otp-form" class="digit-group">
                        @csrf
                        <div class="wallet-add">
                            <div class="otp-box">
                                <div class="forms-block text-center">
                                    <input type="text" id="digit-1" maxlength="1" value=""
                                        oninput="moveToNext(this, 'digit-2')" onkeydown="moveToPrevious(event, this, 'digit-1')">
                                    <input type="text" id="digit-2" maxlength="1" value=""
                                        oninput="moveToNext(this, 'digit-3')" onkeydown="moveToPrevious(event, this, 'digit-1')">
                                    <input type="text" id="digit-3" maxlength="1" value=""
                                        oninput="moveToNext(this, 'digit-4')" onkeydown="moveToPrevious(event, this, 'digit-2')">
                                    <input type="text" id="digit-4" maxlength="1" value=""
                                        oninput="moveToNext(this, 'digit-5')" onkeydown="moveToPrevious(event, this, 'digit-3')">
                                    <input type="text" id="digit-5" maxlength="1" value=""
                                        oninput="moveToNext(this, 'digit-6')" onkeydown="moveToPrevious(event, this, 'digit-4')">
                                    <input type="text" id="digit-6" maxlength="1" value=""
                                        onkeydown="moveToPrevious(event, this, 'digit-5')">
                                </div>

                                <script>
                                    function moveToNext(current, nextFieldID) {
                                        if (current.value.length >= current.maxLength) {
                                            document.getElementById(nextFieldID).focus();
                                        }
                                    }

                                    function moveToPrevious(event, current, previousFieldID) {
                                        if (event.key === "Backspace" && current.value.length === 0) {
                                            document.getElementById(previousFieldID).focus();
                                        }
                                    }
                                </script>
                            </div>
                        </div>
                        <div class="Otp-expire text-center">
                            <p id="otp-timer">Otp will expire in 05:00</p>
                        </div>
                        <div class="form-login mt-4">
                            <button type="submit" class="btn btn-login">Verify My Account</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="my-4 d-flex justify-content-center align-items-center copyright-text">
                <p>Copyright &copy; 2025 MMML. All rights reserved</p>
            </div>
        </div>
    </div>

@endsection
@push('scripts')
    <script>
        $(document).ready(function() {
            $('#otp-form').on('submit', function(e) {
                e.preventDefault();

                var otp = '';
                for (var i = 1; i <= 6; i++) {
                    otp += $('#digit-' + i).val();
                }

                $.ajax({
                    url: '{{ url('/verify-login-otp') }}',
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        otp: otp
                    },
                    success: function(response) {
                        // window.location.href = '{{ url('/dashboard') }}';
                        console.log(response);
                    },
                    error: function(xhr) {
                        console.log(xhr);
                        messageAlert("Error", xhr.responseJSON.message);
                    }
                });
            });

            var timer = 300; 
            var interval = setInterval(function() {
                var minutes = Math.floor(timer / 60);
                var seconds = timer % 60;
                seconds = seconds < 10 ? '0' + seconds : seconds;
                $('#otp-timer').text('Otp will expire in ' + minutes + ':' + seconds);
                timer--;

                if (timer < 0) {
                    clearInterval(interval);
                    $('#otp-timer').text('Otp has expired');
                }
            }, 1000);
        });
    </script>
@endpush
