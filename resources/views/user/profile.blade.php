@extends('user.layout')

@section('content')
<div class="col-span-12">
    <!-- BEGIN: Change Password -->
    <div class="intro-y box lg:mt-5">
        <div class="flex items-center p-5 border-b border-slate-200/60 dark:border-darkmode-400">
            <h2 class="font-medium text-base mr-auto">
                Profile Information
            </h2>
        </div>
        <div class="p-5">
            <form action="{{ route('user.updateProfile', $user->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="flex flex-wrap gap-2 w-full">
                    <div class="w-full">
                        <label for="change-password-form-1" class="form-label">Full Name</label>
                        <input id="change-password-form-1" type="text" class="form-control w-full" name="name"
                            value="{{$user->name}}">
                    </div>
                    <div class="w-full">
                        <label for="change-password-form-2" class="form-label">Email</label>
                        <input id="change-password-form-2" type="text" class="form-control w-full" disabled
                            value="{{$user->email}}">
                    </div>
                    <div class="w-full mt-3">
                        <label for="change-password-form-3" class="form-label">Phone Number</label>
                        <input autocomplete="false" id="change-password-form-3" type="text" class="form-control"
                            name="phone" value="{{$user->phone}}">
                    </div>
                    <div class="w-full mt-3">
                        <label for="change-password-form-4" class="form-label">New Password</label>
                        <input autocomplete="false" id="change-password-form-4" type="password" class="form-control"
                            name="password" placeholder="(Leave Empty if do not want to change)">
                    </div>
                    <div class="w-full mt-3">
                        <label for="change-password-form-4" class="form-label">User Status</label>
                        <input autocomplete="false" id="status-form-4" type="text" disabled class="form-control"
                        name="role" placeholder="{{($user->role_id == 0) ? 'Individual' : (($user->role_id == 1) ? 'Institute User' : 'Institute Admin') }}">
                    </div>
                </div>
                <button type="submit" class="btn btn-primary mt-4">Update Profile</button>
            </form>
        </div>
    </div>

    @if(count($user->institute) > 0)
    <div class="intro-y box lg:mt-5">
        <div class="flex items-center p-5 border-b border-slate-200/60 dark:border-darkmode-400">
            <h2 class="font-medium text-base mr-auto">
                Institute Information
            </h2>
        </div>
        <div class="p-5">
            <form action="{{ route('user.updateInstitute', $user->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="flex flex-wrap gap-2 w-full">
                    @if($user->role_id == 1)
                    <div class="w-full">
                        <label for="change-password-form-1" class="form-label">Institute Name</label>
                        @if(isset($user->institute_managed))
                        <input id="change-password-form-1" type="text" class="form-control" name="name"
                            value="{{$user->institute[0]->name}}" disabled>
                        @else
                        <input id="change-password-form-1" type="text" class="form-control" name="name"
                            value="N/A">
                        @endif
                    </div>
                    @elseif($user->role_id == 2)
                    <div class="w-full">
                        <label for="change-password-form-1" class="form-label">Institute Name</label>
                        @if(isset($user->institute_managed))
                        <input id="change-password-form-1" type="text" class="form-control" name="name"
                            value="{{$user->institute_managed[0]->name}}">
                        @else
                            <input id="change-password-form-1" type="text" class="form-control" name="name"
                            value="N/A">
                        @endif
                    </div>

                    <div class="w-full">
                        <label for="change-password-form-2" class="form-label">Institute Passcode</label>
                        @if(isset($user->institute_managed))
                        <input id="change-password-form-2" name="passcode" type="text" class="form-control"
                            value="{{$user->institute_managed->passcode}}">
                        @else
                        <input id="change-password-form-2" name="passcode" type="text" class="form-control"
                            value="--">
                        @endif
                    </div>
                    @endif

                </div>
                @if($user->role_id == 2)
                <button type="submit" class="btn btn-primary mt-4">Update Institute</button>
                @endif
            </form>
        </div>
    </div>
    @endif
    <!-- END: Change Password -->
</div>
@endsection