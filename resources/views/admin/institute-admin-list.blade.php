@extends('admin.layout')

@section('content')
<div class="intro-y col-span-12 flex flex-wrap sm:flex-nowrap items-center mt-4 mb-4">

</div>
<!-- BEGIN: Data List -->
<div class="col-span-12 mt-8">
    <div class="intro-y flex items-center h-10">
        <h2 class="text-lg font-medium truncate mr-5 mb-5">
            Institute Admin Requests
        </h2>
    </div>

    <div class="intro-y box">
        <div id="vertical-form" class="p-5">
            <div class="preview">
                <div>
                    <div class="overflow-x-auto">
                        <table id="myTable" class="table table-striped hover mt-10" style="width:100%">
                            <thead>
                                <tr>
                                    <th class="whitespace-nowrap text-center">Name</th>
                                    <th class="whitespace-nowrap text-center">Email</th>
                                    <th class="whitespace-nowrap text-center">Institute Name</th>
                                    <th class="whitespace-nowrap text-center">Passcode</th>
                                    <th class="whitespace-nowrap text-center">Status</th>
                                    <th class="whitespace-nowrap text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($institute as $key=> $iAdmin)
                                <tr>
                                    <td class="whitespace-nowrap">{{ $iAdmin->admin->name }}</td>
                                    <td class="whitespace-nowrap">{{ $iAdmin->admin->email }}</td>

                                    <td class="whitespace-nowrap">{{ $iAdmin->name }}</td>

                                    <td class="whitespace-nowrap">{{ $iAdmin->passcode }}</td>
                                    <td class="whitespace-nowrap">
                                        @if ($iAdmin->is_active == 0)
                                        <button class="btn btn-elevated-rounded-dark w-24 mr-1 mb-2">Pending</button>

                                        @else
                                        <button class="btn btn-elevated-rounded-dark w-24 mr-1 mb-2">Active</button>
                                        @endif
                                    </td>


                                    <td class="whitespace-nowrap">
                                        <div class="flex gap-2">
                                            @if ($iAdmin->is_active == 0)
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
                                            @else
                                            <div>
                                                <div class="text-center"> <a href="javascript:;" data-tw-toggle="modal"
                                                        data-tw-target="#institute-modal-delete-{{ $key }}"
                                                        class="btn btn-danger">Delete</a>
                                                </div>
                                            </div>
                                            @endif
                                        </div>
                                    </td>

                                    {{-- Modals --}}
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
                                                        <a href="{{ route('institute-admin.accept', $iAdmin->id) }}"
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
                                                        <a href="{{ route('institute-admin.decline', $iAdmin->id) }}"
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
<!-- END: Data List -->
<!-- END: Pagination -->
</div>
@endsection