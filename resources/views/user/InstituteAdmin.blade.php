@extends('user.layout')

@section('content')
<div class="col-span-12 mt-8">
    <div class="intro-y flex items-center h-10">
        <h2 class="text-lg font-medium truncate mr-5 mb-5">
            {{ $user->institute_managed->name }} - Members
        </h2>
    </div>

    @if ($message = Session::get('message'))
    <div class="alert alert-success mt-3">
        <p>{{ $message }}</p>
    </div>
    @endif

    <div class="intro-y box">
        <div id="vertical-form" class="p-5">
            <div class="preview">
                <div>
                    <div class="overflow-x-auto">
                        <table id="myTable" class="table table-striped hover mt-10" style="width:100%">
                            <thead>
                                <tr>
                                    <th class="whitespace-nowrap text-center">Full Name</th>
                                    <th class="whitespace-nowrap text-center">Email</th>
                                    <th class="whitespace-nowrap text-center">Join Date</th>
                                    <th class="whitespace-nowrap text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($instituteUsers as $key => $user)
                                <tr>
                                    <td class="whitespace-nowrap">{{ $user->name }}</td>
                                    <td class="whitespace-nowrap">{{ $user->email }}</td>

                                    <td class="whitespace-nowrap">
                                        {{ App\Helpers\HelperClass::convertDateToCurrentTimeZone($user->created_at,
                                        request()->ip()) }}
                                    </td>


                                    <td class="whitespace-nowrap">
                                        <div class="flex gap-2">
                                            @if ($user->id != $institute->manager->id)
                                            <div>
                                                <div class="text-center"> <a href="javascript:;" data-tw-toggle="modal"
                                                        data-tw-target="#institute-modal-delete-{{ $key }}"
                                                        class="btn btn-danger">Remove Member</a>
                                                </div>
                                            </div>
                                            @else
                                            <div>
                                                <div class="text-center"> <button disabled class="btn btn-danger">Remove
                                                        Member</a>
                                                </div>
                                            </div>
                                            @endif
                                        </div>
                                    </td>



                                    <!-- BEGIN: Modal Content -->
                                    <div id="institute-modal-delete-{{ $key }}" class="modal" tabindex="-1"
                                        aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-body p-0">
                                                    <div class="p-5 text-center"> <i data-lucide="x-circle"
                                                            class="w-16 h-16 text-danger mx-auto mt-3"></i>
                                                        <div class="text-3xl mt-5">Are you sure?</div>
                                                        <div class="text-slate-500 mt-2">Rejecting will delete this
                                                            request from your Dashboard and notify the user of your
                                                            actions.</div>
                                                    </div>
                                                    <div class="px-5 pb-8 text-center inline-flex items-stretch"
                                                        style="text-align: center;margin: auto !important;width: 100%;position: relative;justify-content: center;">
                                                        <form action="{{ route('institute.delete', $user->id) }}"
                                                            method="POST">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit"
                                                                class="btn btn-danger w-24 mr-1 self-center">
                                                                I'm Sure
                                                            </button>
                                                        </form>
                                                        <button type="button" data-tw-dismiss="modal"
                                                            class="btn btn-outline-secondary w-24 mr-1">Cancel</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div> <!-- END: Modal Content -->
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>



                </div>
            </div>

        </div>
    </div>


</div>

<div class="col-span-12 mt-8">
    <div class="intro-y flex items-center h-10">
        <h2 class="text-lg font-medium truncate mr-5 mb-5">
            Join Requests </h2>
    </div>


    <div class="intro-y box">
        <div id="vertical-form" class="p-5">
            <div class="preview">
                <div>
                    <div class="overflow-x-auto">
                        <table id="myTable" class="table table-striped hover mt-10" style="width:100%">
                            <thead>
                                <tr>
                                    <th class="whitespace-nowrap">Full Name</th>
                                    <th class="whitespace-nowrap">Email</th>
                                    <th class="whitespace-nowrap">Request Date</th>
                                    <th class="whitespace-nowrap">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($instituteRequests as $key => $request)
                                <tr>
                                    <td class="whitespace-nowrap">{{ $request->user->name }}</td>
                                    <td class="whitespace-nowrap">{{ $request->user->email }}</td>
                                    <td class="whitespace-nowrap">{{
                                        App\Helpers\HelperClass::convertDateToCurrentTimeZone($request->created_at,
                                        request()->ip()) }}</td>
                                    <td class="whitespace-nowrap">
                                        <div class="flex gap-2">
                                            <div>
                                                <div class="text-center"> <a href="javascript:;" data-tw-toggle="modal"
                                                        data-tw-target="#translation-modal-accept-{{ $key }}"
                                                        class="btn btn-success">Accept</a>
                                                </div>
                                            </div>
                                            <div>
                                                <div class="text-center"> <a href="javascript:;" data-tw-toggle="modal"
                                                        data-tw-target="#translation-modal-reject-{{ $key }}"
                                                        class="btn btn-danger">Reject</a>
                                                </div>
                                            </div>
                                        </div>
                                    </td>

                                    <div id="translation-modal-accept-{{ $key }}" class="modal" tabindex="-1"
                                        aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-body p-0">
                                                    <div class="p-5 text-center"><svg xmlns="http://www.w3.org/2000/svg"
                                                            width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                            stroke="currentColor" stroke-width="2"
                                                            stroke-linecap="round" stroke-linejoin="round"
                                                            icon-name="check-circle" data-lucide="check-circle"
                                                            class="lucide lucide-check-circle w-16 h-16 text-success mx-auto mt-3">
                                                            <path d="M22 11.08V12a10 10 0 11-5.93-9.14"></path>
                                                            <polyline points="22 4 12 14.01 9 11.01"></polyline>
                                                        </svg>
                                                        <div class="text-3xl mt-5">Are you sure?</div>
                                                        <div class="text-slate-500 mt-2">Your action will advance
                                                            this
                                                            request and notify the user of your agreement!</div>
                                                    </div>
                                                    <div class="px-5 pb-8 text-center inline-flex items-stretch"
                                                        style="text-align: center;margin: auto !important;width: 100%;position: relative;justify-content: center;">
                                                        <a href="{{ route('institute-admin.accept', $request->id) }}"
                                                            class="btn btn-success text-white w-24 mr-1 self-center">
                                                            I'm Sure</a>
                                                        <button type="button" data-tw-dismiss="modal"
                                                            class="btn btn-outline-secondary w-24 mr-1">Cancel</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div> <!-- END: Modal Content -->

                                    <!-- BEGIN: Modal Content -->
                                    <div id="translation-modal-reject-{{ $key }}" class="modal" tabindex="-1"
                                        aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-body p-0">
                                                    <div class="p-5 text-center"> <i data-lucide="x-circle"
                                                            class="w-16 h-16 text-danger mx-auto mt-3"></i>
                                                        <div class="text-3xl mt-5">Are you sure?</div>
                                                        <div class="text-slate-500 mt-2">Rejecting will delete this
                                                            request from your Dashboard and notify the user of your
                                                            actions.</div>
                                                    </div>
                                                    <div class="px-5 pb-8 text-center inline-flex items-stretch"
                                                        style="text-align: center;margin: auto !important;width: 100%;position: relative;justify-content: center;">
                                                        <a href="{{ route('institute-admin.decline', $request->id) }}"
                                                            class="btn btn-danger w-24 mr-1 self-center">
                                                            I'm Sure</a>
                                                        <button type="button" data-tw-dismiss="modal"
                                                            class="btn btn-outline-secondary w-24 mr-1">Cancel</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div> <!-- END: Modal Content -->
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>



                </div>
            </div>

        </div>
    </div>


</div>


<script>
    let button = document.querySelector('#uniqueModal');

        button.addEventListener('click', function() {
            let value = button.value;

            console.log(value);
        })
</script>
@endsection