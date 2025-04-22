@extends('layout.auth-layout')

@section('title', 'MMML - Successfully Registered')

@section('content')

    <div class="container text-center">
        <img src="{{asset('img/verified.png')}}" alt="" height="500px" width="500px">
        <h2>Registration Successful!</h2>
        <p>Your account has been successfully created.</p>
        <p>You can now log in and start using our services.</p>
        <a href="{{ route('login') }}" class="btn btn-primary mt-3">Go to Log In</a>
    </div>

@endsection