@extends('admin.layout')

@section('content')
    <div class="intro-y col-span-12 flex flex-wrap sm:flex-nowrap items-center mt-4 mb-4">

    </div>
    <!-- BEGIN: Data List -->
    <div class="col-span-12 mt-8">
        <div class="intro-y flex justify-between items-center mb-4 h-10">
            <h2 class="text-lg font-medium truncate mr-5">
                All Customers
            </h2>
            <div class="text-right">
                <a href="{{ route('register-user') }}" class="btn btn-primary">New</a>
            </div>
        </div>
        @if (session('success'))
            <div class="alert alert-success" role="alert">
                <span class="badge bg-success">{{ session('success') }}</span>
            </div>
        @endif
        <div class="intro-y box">
            <div id="vertical-form" class="p-5">
                <div class="preview">
                    <div>
                        <div class="overflow-x-auto">
                            <!-- Your other HTML code here -->

                            <table id="myTable" class="table table-striped hover mt-10" style="width:100%">
                                <thead>
                                    <tr>
                                        <th class="whitespace-nowrap text-center">Action</th>
                                        <th class="whitespace-nowrap text-center">Name</th>
                                        <th class="whitespace-nowrap text-center">Email</th>
                                        <th class="whitespace-nowrap text-center">Status</th>
                                        <th class="whitespace-nowrap text-center">Orders Count</th>
                                        <th class="whitespace-nowrap text-center">Institute Name</th>
                                        <th class="whitespace-nowrap text-center">Institute Account</th>
                                        <th class="whitespace-nowrap text-center">Institute Admin</th>
                                        <th class="whitespace-nowrap text-center">Institute Passcode</th>
                                        <th class="whitespace-nowrap text-center">Institute Status</th>
                                        <th class="whitespace-nowrap text-center">Interpretations Count</th>
                                        <th class="whitespace-nowrap text-center">Created At</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($users as $key => $user)
                                        <tr>
                                            <td class="whitespace-nowrap">
                                                <div class="flex gap-1 items-center">
                                                    <a href="{{ route('admin.viewUser', $user->id) }}"
                                                        class="btn btn-primary mr-1 mb-2">View</a>
                                                    <a href="{{ route('admin.editUser', $user->id) }}"
                                                        class="btn btn-warning mr-1 mb-2">Edit</a>
                                                    <div class="text-center">
                                                        <button class="btn btn-danger mr-1 mb-2" data-tw-toggle="modal"
                                                            data-tw-target="#user-modal-delete-{{ $key }}">
                                                            Delete
                                                        </button>
                                                    </div>

                                                    {{-- </div> --}}
                                                    {{-- <div class="flex gap-2"> --}}
                                                    @if (isset($user->institute) && $user->institute != null && count($user->institute) > 0)
                                                        @if ($user->institute[0]->is_active == 0)
                                                            <div>
                                                                <div class="text-center mr-1 mb-2"> <a href="javascript:;"
                                                                        data-tw-toggle="modal"
                                                                        data-tw-target="#translation-modal-accept-{{ $key }}"
                                                                        class="btn btn-success">Accept</a>
                                                                </div>
                                                            </div>
                                                            <div>
                                                                <div class="text-center mr-1 mb-2"> <a href="javascript:;"
                                                                        data-tw-toggle="modal"
                                                                        data-tw-target="#translation-modal-reject-{{ $key }}"
                                                                        class="btn btn-danger">Reject</a>
                                                                </div>
                                                            </div>
                                                        @elseif($user->institute[0]->is_active == 1)
                                                            <div>
                                                                <div class="text-center mr-1 mb-2"> <a href="javascript:;"
                                                                        data-tw-toggle="modal"
                                                                        data-tw-target="#institute-modal-delete-{{ $key }}"
                                                                        class="btn btn-danger">Delete Institute</a>
                                                                </div>
                                                            </div>
                                                        @endif
                                                    @elseif(isset($user->institute_managed) && $user->institute_managed != null)
                                                        @if ($user->institute_managed->is_active == 0)
                                                            <div>
                                                                <div class="text-center mr-1 mb-2"> <a href="javascript:;"
                                                                        data-tw-toggle="modal"
                                                                        data-tw-target="#translation-modal-accept-{{ $key }}"
                                                                        class="btn btn-success">Accept</a>
                                                                </div>
                                                            </div>
                                                            <div>
                                                                <div class="text-center mr-1 mb-2"> <a href="javascript:;"
                                                                        data-tw-toggle="modal"
                                                                        data-tw-target="#translation-modal-reject-{{ $key }}"
                                                                        class="btn btn-danger">Reject</a>
                                                                </div>
                                                            </div>
                                                        @elseif($user->institute_managed->is_active == 1)
                                                            <div>
                                                                <div class="text-center mr-1 mb-2"> <a href="javascript:;"
                                                                        data-tw-toggle="modal"
                                                                        data-tw-target="#institute-modal-delete-{{ $key }}"
                                                                        class="btn btn-danger">Delete Institute</a>
                                                                </div>
                                                            </div>
                                                        @endif
                                                    @endif
                                                </div>
                                            </td>
                                            <td class="whitespace-nowrap">{{ $user->name }}</td>
                                            <td class="whitespace-nowrap">{{ $user->email }}</td>
                                            <td class="whitespace-nowrap">
                                                {{ $user->email_verified_at != null ? 'Verified' : 'Not Verified' }}</td>
                                            <td class="whitespace-nowrap">{{ $user->orders()->count() }}</td>
                                            @if (isset($user->institute) && $user->institute != null && count($user->institute) > 0)
                                                <td class="whitespace-nowrap">{{ $user->institute[0]->name }}</td>
                                            @else
                                                <td class="whitespace-nowrap">--</td>
                                            @endif
                                            @if ($user->role_id == 1 || $user->role_id == 2)
                                                <td class="whitespace-nowrap">Yes</td>
                                            @else
                                                <td class="whitespace-nowrap">No</td>
                                            @endif
                                            @if ($user->role_id == 2)
                                                <td class="whitespace-nowrap">Yes</td>
                                            @else
                                                <td class="whitespace-nowrap">No</td>
                                            @endif
                                            @if (isset($user->institute) && $user->institute != null && count($user->institute) > 0)
                                                <td class="whitespace-nowrap">{{ $user->institute[0]->passcode }}</td>
                                            @else
                                                <td class="whitespace-nowrap">--</td>
                                            @endif
                                            @if (isset($user->institute) && $user->institute != null && count($user->institute) > 0)
                                                <td class="whitespace-nowrap">
                                                    @if ($user->institute[0]->is_active == 1)
                                                        <button
                                                            class="btn btn-elevated-rounded-dark w-24 mr-1 mb-2">Active</button>
                                                    @else
                                                        <button
                                                            class="btn btn-elevated-rounded-dark w-24 mr-1 mb-2">Pending</button>
                                                    @endif

                                                </td>
                                            @elseif(isset($user->institute_managed) && $user->institute_managed != null)
                                                <td class="whitespace-nowrap">
                                                    @if ($user->institute_managed->is_active == 1)
                                                        <button
                                                            class="btn btn-elevated-rounded-dark w-24 mr-1 mb-2">Active</button>
                                                    @else
                                                        <button
                                                            class="btn btn-elevated-rounded-dark w-24 mr-1 mb-2">Pending</button>
                                                    @endif

                                                </td>
                                            @else
                                                <td class="whitespace-nowrap">--</td>
                                            @endif
                                            <td class="whitespace-nowrap">{{ $user->interpretations()->count() }}</td>
                                            <td class="whitespace-nowrap">
                                                {{ App\Helpers\HelperClass::convertDateToCurrentTimeZone($user->created_at, request()->ip()) }}
                                            </td>


                                            <!-- BEGIN: Modal User Content -->
                                            <div id="user-modal-delete-{{ $key }}" class="modal" tabindex="-1"
                                                aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-body p-0">
                                                            <div class="p-5 text-center"> <i data-lucide="x-circle"
                                                                    class="w-16 h-16 text-danger mx-auto mt-3"></i>
                                                                <div class="text-3xl mt-5">Are you sure?</div>
                                                                <div class="text-slate-500 mt-2">Delete the user will
                                                                    delete
                                                                    all of his Orders and Interpretations</div>
                                                            </div>
                                                            <div class="px-5 pb-8 text-center inline-flex items-stretch"
                                                                style="text-align: center;margin: auto !important;width: 100%;position: relative;justify-content: center;">
                                                                {{-- @if (isset($user->institute) && $user->institute != null)
                                                        --}}
                                                                <form action="{{ route('admin.deleteUser', $user->id) }}"
                                                                    method="post">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button type="submit"
                                                                        class="btn btn-danger w-24 mr-1">Delete</a>
                                                                </form>
                                                                <button type="button" data-tw-dismiss="modal"
                                                                    class="btn btn-outline-secondary w-24 mr-1">Cancel</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div> <!-- END: Modal Content -->
                                            @if (isset($user->institute) && $user->institute != null && count($user->institute) > 0)
                                                {{-- Modals --}}
                                                <div id="translation-modal-accept-{{ $key }}" class="modal"
                                                    tabindex="-1" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-body p-0">
                                                                <div class="p-5 text-center"><svg
                                                                        xmlns="http://www.w3.org/2000/svg" width="24"
                                                                        height="24" viewBox="0 0 24 24" fill="none"
                                                                        stroke="currentColor" stroke-width="2"
                                                                        stroke-linecap="round" stroke-linejoin="round"
                                                                        icon-name="check-circle"
                                                                        data-lucide="check-circle"
                                                                        class="lucide lucide-check-circle w-16 h-16 text-success mx-auto mt-3">
                                                                        <path d="M22 11.08V12a10 10 0 11-5.93-9.14"></path>
                                                                        <polyline points="22 4 12 14.01 9 11.01">
                                                                        </polyline>
                                                                    </svg>
                                                                    <div class="text-3xl mt-5">Are you sure?</div>
                                                                    <div class="text-slate-500 mt-2">Your action will
                                                                        advance
                                                                        this
                                                                        request and notify the user of your agreement!</div>
                                                                </div>
                                                                <div class="px-5 pb-8 text-center inline-flex items-stretch"
                                                                    style="text-align: center;margin: auto !important;width: 100%;position: relative;justify-content: center;">
                                                                    {{-- @if (isset($user->institute) && $user->institute != null)
                                                        --}}
                                                                    <a href="{{ route('institute-admin-accept', $user->institute[0]->id) }}"
                                                                        class="btn btn-success text-white w-24 mr-1 self-center">
                                                                        I'm Sure</a>
                                                                    {{-- @elseif((isset($user->institute_managed) &&
                                                        $user->institute_managed != null))
                                                        <a href="{{ route('institute-admin-accept', $user->institute_managed->id) }}"
                                                            class="btn btn-success text-white w-24 mr-1 self-center">
                                                            I'm Sure</a> --}}
                                                                    {{-- @endif --}}
                                                                    <button type="button" data-tw-dismiss="modal"
                                                                        class="btn btn-outline-secondary w-24 mr-1">Cancel</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div> <!-- END: Modal Content -->

                                                <!-- BEGIN: Modal Content -->
                                                <div id="translation-modal-reject-{{ $key }}" class="modal"
                                                    tabindex="-1" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-body p-0">
                                                                <div class="p-5 text-center"> <i data-lucide="x-circle"
                                                                        class="w-16 h-16 text-danger mx-auto mt-3"></i>
                                                                    <div class="text-3xl mt-5">Are you sure?</div>
                                                                    <div class="text-slate-500 mt-2">Rejecting will delete
                                                                        this
                                                                        request from your Dashboard and notify the user of
                                                                        your
                                                                        actions.</div>
                                                                </div>
                                                                <div class="px-5 pb-8 text-center inline-flex items-stretch"
                                                                    style="text-align: center;margin: auto !important;width: 100%;position: relative;justify-content: center;">
                                                                    {{-- @if (isset($user->institute) && $user->institute != null)
                                                        --}}
                                                                    <a href="{{ route('institute-admin-decline', $user->institute[0]->id) }}"
                                                                        class="btn btn-danger w-24 mr-1 self-center">
                                                                        I'm Sure</a>
                                                                    {{-- @elseif((isset($user->institute_managed) &&
                                                        $user->institute_managed != null))
                                                        <a href="{{ route('institute-admin-decline', $user->institute_managed->id) }}"
                                                            class="btn btn-danger w-24 mr-1 self-center">
                                                            I'm Sure</a> --}}
                                                                    {{-- @endif --}}
                                                                    <button type="button" data-tw-dismiss="modal"
                                                                        class="btn btn-outline-secondary w-24 mr-1">Cancel</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div> <!-- END: Modal Content -->

                                                <!-- BEGIN: Modal Content -->
                                                <div id="institute-modal-delete-{{ $key }}" class="modal"
                                                    tabindex="-1" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-body p-0">
                                                                <div class="p-5 text-center"> <i data-lucide="x-circle"
                                                                        class="w-16 h-16 text-danger mx-auto mt-3"></i>
                                                                    <div class="text-3xl mt-5">Are you sure?</div>
                                                                    <div class="text-slate-500 mt-2">Rejecting will delete
                                                                        this
                                                                        request from your Dashboard and notify the user of
                                                                        your
                                                                        actions.</div>
                                                                </div>
                                                                <div class="px-5 pb-8 text-center inline-flex items-stretch"
                                                                    style="text-align: center;margin: auto !important;width: 100%;position: relative;justify-content: center;">
                                                                    <form {{-- @if (isset($user->institute) && $user->institute != null) --}}
                                                                        action="{{ route('institute.delete', $user->institute[0]->id) }}"
                                                                        {{-- @endif --}} method="POST">
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
                                            @elseif(isset($user->institute_managed) && $user->institute_managed != null)
                                                {{-- Modals --}}
                                                <div id="translation-modal-accept-{{ $key }}" class="modal"
                                                    tabindex="-1" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-body p-0">
                                                                <div class="p-5 text-center"><svg
                                                                        xmlns="http://www.w3.org/2000/svg" width="24"
                                                                        height="24" viewBox="0 0 24 24" fill="none"
                                                                        stroke="currentColor" stroke-width="2"
                                                                        stroke-linecap="round" stroke-linejoin="round"
                                                                        icon-name="check-circle"
                                                                        data-lucide="check-circle"
                                                                        class="lucide lucide-check-circle w-16 h-16 text-success mx-auto mt-3">
                                                                        <path d="M22 11.08V12a10 10 0 11-5.93-9.14"></path>
                                                                        <polyline points="22 4 12 14.01 9 11.01">
                                                                        </polyline>
                                                                    </svg>
                                                                    <div class="text-3xl mt-5">Are you sure?</div>
                                                                    <div class="text-slate-500 mt-2">Your action will
                                                                        advance
                                                                        this
                                                                        request and notify the user of your agreement!</div>
                                                                </div>
                                                                <div class="px-5 pb-8 text-center inline-flex items-stretch"
                                                                    style="text-align: center;margin: auto !important;width: 100%;position: relative;justify-content: center;">
                                                                    {{-- @if (isset($user->institute) && $user->institute != null)
                                                        --}}
                                                                    <a href="{{ route('institute-admin-accept', $user->institute_managed->id) }}"
                                                                        class="btn btn-success text-white w-24 mr-1 self-center">
                                                                        I'm Sure</a>
                                                                    {{-- @elseif((isset($user->institute_managed) &&
                                                        $user->institute_managed != null))
                                                        <a href="{{ route('institute-admin-accept', $user->institute_managed->id) }}"
                                                            class="btn btn-success text-white w-24 mr-1 self-center">
                                                            I'm Sure</a> --}}
                                                                    {{-- @endif --}}
                                                                    <button type="button" data-tw-dismiss="modal"
                                                                        class="btn btn-outline-secondary w-24 mr-1">Cancel</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div> <!-- END: Modal Content -->

                                                <!-- BEGIN: Modal Content -->
                                                <div id="translation-modal-reject-{{ $key }}" class="modal"
                                                    tabindex="-1" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-body p-0">
                                                                <div class="p-5 text-center"> <i data-lucide="x-circle"
                                                                        class="w-16 h-16 text-danger mx-auto mt-3"></i>
                                                                    <div class="text-3xl mt-5">Are you sure?</div>
                                                                    <div class="text-slate-500 mt-2">Rejecting will delete
                                                                        this
                                                                        request from your Dashboard and notify the user of
                                                                        your
                                                                        actions.</div>
                                                                </div>
                                                                <div class="px-5 pb-8 text-center inline-flex items-stretch"
                                                                    style="text-align: center;margin: auto !important;width: 100%;position: relative;justify-content: center;">
                                                                    {{-- @if (isset($user->institute) && $user->institute != null)
                                                        --}}
                                                                    <a href="{{ route('institute-admin-decline', $user->institute_managed->id) }}"
                                                                        class="btn btn-danger w-24 mr-1 self-center">
                                                                        I'm Sure</a>
                                                                    {{-- @elseif((isset($user->institute_managed) &&
                                                        $user->institute_managed != null))
                                                        <a href="{{ route('institute-admin-decline', $user->institute_managed->id) }}"
                                                            class="btn btn-danger w-24 mr-1 self-center">
                                                            I'm Sure</a> --}}
                                                                    {{-- @endif --}}
                                                                    <button type="button" data-tw-dismiss="modal"
                                                                        class="btn btn-outline-secondary w-24 mr-1">Cancel</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div> <!-- END: Modal Content -->

                                                <!-- BEGIN: Modal Content -->
                                                <div id="institute-modal-delete-{{ $key }}" class="modal"
                                                    tabindex="-1" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-body p-0">
                                                                <div class="p-5 text-center"> <i data-lucide="x-circle"
                                                                        class="w-16 h-16 text-danger mx-auto mt-3"></i>
                                                                    <div class="text-3xl mt-5">Are you sure?</div>
                                                                    <div class="text-slate-500 mt-2">Rejecting will delete
                                                                        this
                                                                        request from your Dashboard and notify the user of
                                                                        your
                                                                        actions.</div>
                                                                </div>
                                                                <div class="px-5 pb-8 text-center inline-flex items-stretch"
                                                                    style="text-align: center;margin: auto !important;width: 100%;position: relative;justify-content: center;">
                                                                    <form {{-- @if (isset($user->institute) && $user->institute != null) --}}
                                                                        action="{{ route('institute.delete', $user->institute_managed->id) }}"
                                                                        {{-- @endif --}} method="POST">
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
                                            @endif
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>

                            <!-- Your other HTML code here -->
                        </div>



                    </div>
                </div>

            </div>
        </div>


    </div>
    <!-- END: Data List -->
    <!-- END: Pagination -->
    </div>
@endsection
