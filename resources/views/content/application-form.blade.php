@extends('layout.app-layout')

@section('title', 'Application Form')

@section('content')

    @livewire('content.application-form', ['job_id' => $job_id])

@endsection