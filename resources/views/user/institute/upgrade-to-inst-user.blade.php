@extends('user.layout')

@section('content')
    <div class="col-span-12 mt-8">
        <div class="intro-y flex items-center h-10">
            <h2 class="text-lg font-medium truncate mr-5">
                Upgrade to Institute User
            </h2>
        </div>

        @if ($message = Session::get('message'))
            <div class="alert alert-success mt-3 mb-3">
                <p>{{ $message }}</p>
            </div>
        @endif
        <!-- Display error message if any -->
        @if (isset($error))
            <div class="alert alert-danger mt-3 mb-1">
                <ul>
                    <li>{{ $error }}</li>
                </ul>
            </div>
        @endif
        {{-- @dd($error) --}}
        <!-- Display success message if any -->
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8 col-md-10">
                    <div class="intro-y box mt-5">
                        <div class="p-5">
                            <form action="{{ route('user.upgrade-inst-user') }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="form-group">
                                    <input required type="text" name="institute_passcode" class="form-control py-3 px-4"
                                        placeholder="Enter Institute's Passcode Here">
                                </div>



                                <div class="mt-2 form-group">
                                    <button type="submit" class="btn btn-primary btn-block">Upgrade</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection
