@extends('admin.layout')

@section('content')
<div class="intro-y col-span-12 mt-4">
    <!-- BEGIN: Vertical Form -->
    <div class="intro-y box">
        <div class="flex flex-col sm:flex-row items-center p-5 border-b border-slate-200/60 dark:border-darkmode-400">
            <h2 class="font-medium text-base mr-auto">
               Edit "{{ $translator->name }}" Translator
            </h2>
            
        </div>
        <div id="vertical-form" class="p-5">
            <form action="{{ route('translator.update', $translator->id) }}" method="post">
                @csrf
                @method('PUT')
            <div class="preview">
                <div>
                    <div class="intro-x mt-4">
                        <input required type="text" name="name" class="intro-x login__input form-control py-3 px-4 block" value="{{ $translator->name }}">
                        <input required type="email" name="email" class="intro-x login__input form-control py-3 px-4 block mt-4" value="{{ $translator->email }}">
                        <input required type="password" name="password" class="intro-x login__input form-control py-3 px-4 block mt-4" placeholder="Password">
                        
                        
                    </div>
                </div>
                <button type="submit" class="btn btn-primary mt-5">Edit Translator</button>
            </div>
        </form>
           
        </div>
    </div>
@endsection