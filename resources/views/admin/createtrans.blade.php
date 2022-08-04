@extends('admin.layout')

@section('content')
<div class="intro-y col-span-12 mt-4">
    <!-- BEGIN: Vertical Form -->
    <div class="intro-y box">
        <div class="flex flex-col sm:flex-row items-center p-5 border-b border-slate-200/60 dark:border-darkmode-400">
            <h2 class="font-medium text-base mr-auto">
               Add New Translator
            </h2>
            
        </div>
        <div id="vertical-form" class="p-5">
            <form action="{{ route('translator.store') }}" method="post">
                @csrf
                @method('POST')
            <div class="preview">
                <div>
                    <div class="intro-x mt-4">
                        <input type="text" name="name" class="intro-x login__input form-control py-3 px-4 block" placeholder="Name">
                        <input type="email" name="email" class="intro-x login__input form-control py-3 px-4 block mt-4" placeholder="Email">
                        <input type="password" name="password" class="intro-x login__input form-control py-3 px-4 block mt-4" placeholder="Password">
                        
                        
                    </div>
                </div>
                <button type="submit" class="btn btn-primary mt-5">Add Translator</button>
            </div>
        </form>
           
        </div>
    </div>
</div>
@endsection