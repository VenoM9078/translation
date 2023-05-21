@extends('admin.layout')

@section('content')
<div class="intro-y col-span-12 mt-4">
    <div class="intro-y box">
        <div class="flex flex-col sm:flex-row items-center p-5 border-b border-slate-200/60 dark:border-darkmode-400">
            <h2 class="font-medium text-base mr-auto">
                Edit User
            </h2>
        </div>
        <div id="vertical-form" class="p-5">
            <form action="{{ route('admin.updateUser', $user->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="preview">
                    <div class="mb-3">
                        <label>Name</label>
                        <input type="text" name="name" required
                            class="intro-x login__input form-control py-3 px-4 block mt-1" placeholder="Enter Name"
                            value="{{ $user->name }}">
                    </div>
                    <div class="mb-3">
                        <label>Email</label>
                        <input type="email" name="email" required
                            class="intro-x login__input form-control py-3 px-4 block mt-1" placeholder="Enter Email"
                            value="{{ $user->email }}">
                    </div>
                    <button type="submit" class="btn btn-primary mt-5">Update</button>
                    <a href="{{ route('admin.viewCustomers') }}" class="btn btn-secondary mt-5">Back</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection