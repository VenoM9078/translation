@extends('admin.layout')

@section('content')
<div class="intro-y col-span-12 flex flex-wrap sm:flex-nowrap items-center mt-4 mb-4">

</div>
<!-- BEGIN: User Info -->

<div class="intro-y col-span-12 mt-4">
    <div class="intro-y box">
        <div class="flex flex-col sm:flex-row items-center p-5 border-b border-slate-200/60 dark:border-darkmode-400">
            <h2 class="font-medium text-base mr-auto">
                Basic Information
            </h2>
        </div>
        <div id="vertical-form" class="p-5">
            <form>
                <div class="preview">
                    <div class="mb-3">
                        <label>Name</label>
                        <input type="text" name="name" required disabled
                            class="intro-x login__input form-control py-3 px-4 block mt-1" placeholder="Enter Name"
                            value="{{ $user->name }}">
                    </div>
                    <div class="mb-3">
                        <label>Email</label>
                        <input type="text" name="phonenumber" disabled
                            class="intro-x login__input form-control py-3 px-4 block mt-1"
                            placeholder="Enter Phone Number" value="{{ $user->email }}">
                    </div>


                    {{-- <a href="{{ route('admin.viewContractors') }}" class="btn btn-primary mt-5">Back</a> --}}
                </div>
            </form>

            <a href="{{ route('admin.viewCustomers') }}" class="btn btn-primary mt-5">Back</a>
        </div>
    </div>
</div>
<!-- END: User Info -->
@endsection