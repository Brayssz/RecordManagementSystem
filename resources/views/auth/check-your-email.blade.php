@extends('layout.auth-layout')

@section('title', 'MMML - Verification')

@section('content')

    <div class="container text-center">
        <img src="{{asset('img/sent_mail.png')}}" alt="" height="500px" width="500px">
        <h2>Thank you for registering!</h2>
        <p>We've sent a verification email to your inbox.</p>
        <p>Please click the link in that email to complete your registration.</p>
    </div>

@endsection