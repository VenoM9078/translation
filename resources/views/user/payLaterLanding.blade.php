@extends('user.layout')

@section('content')


<div class="error-page flex flex-col lg:flex-row items-center justify-center h-screen text-center lg:text-left">
    <div class="-intro-x lg:mr-20">
        <img class="h-48 lg:h-auto" src="{{ asset('dist/images/illustration.svg') }}">
    </div>
    <div class="mt-10 lg:mt-0">
        <div class="intro-x text-8xl font-medium">Request Submitted.</div>
        <div class="intro-x text-xl lg:text-3xl font-medium mt-5">Your deferred payment request has been submitted!
        </div>
        <div class="intro-x text-lg mt-3">Our team will examine your request and get back to you as soon as possible!
        </div>
        <a href="{{ route('user.index') }}"
            class="intro-x btn py-3 px-4 dark:border-darkmode-400 dark:text-slate-800 mt-10">Back to Dashboard</a>
    </div>
</div>


@endsection