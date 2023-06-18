@extends('admin.layout')

@section('content')
<script src="https://code.jquery.com/jquery-3.7.0.min.js"
    integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g=" crossorigin="anonymous"></script>
<div class="intro-y col-span-12 mt-4">
    <!-- BEGIN: Vertical Form -->
    <div class="intro-y box">
        <div class="flex flex-col sm:flex-row items-center p-5 border-b border-slate-200/60 dark:border-darkmode-400">
            <h2 class="font-medium text-base mr-auto">
                Create New Contractor
            </h2>

        </div>
        <div id="vertical-form" class="p-5">
            <form action="{{ route('submit-register-contractor') }}" method="post">
                @csrf
                @method('POST')
                <div class="preview">
                    <div>
                        <div class="intro-x mt-4">
                            <input type="hidden" name="role_id" value="0">
                            <div class="mb-3">
                                <label>Enter Name</label>
                                <input type="text" name="name" required
                                    class="intro-x login__input form-control py-3 px-4 block mt-1"
                                    placeholder="Enter Name">
                            </div>

                            <div class="mt-3">
                                <label>Enter Email</label>
                                <input type="email" name="email" required
                                    class="intro-x login__input form-control py-3 px-4 block mt-1"
                                    placeholder="Enter Email">
                            </div>

                            {{-- <div class="mt-3">
                                <label>Enter Phone</label>
                                <input type="tel" name="phone" required
                                    class="intro-x login__input form-control py-3 px-4 block mt-1"
                                    placeholder="Enter Phone">
                            </div> --}}

                            <div class="mt-3">
                                <label>Enter Password</label>
                                <input type="password" minlength="6" name="password" required
                                    class="intro-x login__input form-control py-3 px-4 block mt-1"
                                    placeholder="Enter Password">
                            </div>

                        </div>
                    </div>
                    <input type="submit" class="btn btn-primary mt-5" value="Create Contractor">
                </div>
            </form>
        </div>
    </div>
</div>
@endsection