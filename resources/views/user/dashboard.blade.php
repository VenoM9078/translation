@extends('user.layout')

@section('content')
    <div class="col-span-12 mt-8">
        <div class="intro-y flex items-center h-10">
            <h2 class="text-lg font-medium truncate mr-5">
                User Dashboard - Overview
            </h2>
        </div>
        {{-- @dd(Auth::user()) --}}
        @if (Auth::user()->is_inst_message_seen == 0)
            @if (count(Auth::user()->user_requests) < 1 && !isset(Auth::user()->institute[0]))
                <div class="alert alert-danger show mb-2" role="alert">
                    <div class="flex items-center">
                        <div class="font-medium text-lg">Your institute administrator rejected your application. However you
                            can still use our service as an Individual User.</div>
                        <div class="text-xs bg-white px-1 rounded-md text-slate-700 ml-auto">New</div>
                    </div>
                </div>
            @elseif(count(Auth::user()->user_requests) < 1 && isset(Auth::user()->institute[0]))
                <div class="alert alert-success show mb-2" role="alert">
                    <div class="flex items-center">
                        <div class="font-medium text-lg">You have successfully registered as Institute User.</div>
                        <div class="text-xs bg-white px-1 rounded-md text-slate-700 ml-auto">New</div>
                    </div>
                </div>
            @endif
        @endif
        @if (Auth::user()->institute_managed && Auth::user()->institute_managed->is_active == 0)
            <div class="alert alert-warning show mb-2" role="alert">
                <div class="flex items-center">
                    <div class="font-medium text-lg">Your Institute Creation Request is Pending!</div>
                    <div class="text-xs bg-white px-1 rounded-md text-slate-700 ml-auto">New</div>
                </div>
                <div class="mt-3">Thank you for signing up with us! We see that you requested to create an Institute by
                    the
                    name
                    of {{ Auth::user()->institute_managed->name }}. Your request is pending and we'll let you know when its
                    status changes!</div>
            </div>
        @endif
        @if (Auth::user()->role_id == 0 && Auth::user()->failed_inst_user == 1)
            <div class="alert alert-warning show mb-2" role="alert">
                <div class="flex items-center">
                    <div class="font-medium text-lg">Alert!</div>
                    <div class="text-xs bg-white px-1 rounded-md text-slate-700 ml-auto">New</div>
                </div>
                <div class="mt-3">Your institute does not have an account with Flow Translate, please discuss with your
                    administrator to set up one with Flow Translate. Now you are registered as individual user.</div>
            </div>
        @endif
        @if (Auth::user()->role_id == 0 && Auth::user()->invalid_passcode_inst_user == 1)
            <div class="alert alert-warning show mb-2" role="alert">
                <div class="flex items-center">
                    <div class="font-medium text-lg">Alert!</div>
                    <div class="text-xs bg-white px-1 rounded-md text-slate-700 ml-auto">New</div>
                </div>
                <div class="mt-3">Your institute passcode is incorrect. To have access to your institute account, please
                    contact <b> {{ $instituteAdmin->name }} ({{ $instituteAdmin->email }}) </b> to obtain your Institute
                    Passcode. Now you are registered as individual user.</div>
            </div>
        @endif
        @if (count(Auth::user()->user_requests) > 0)
            <div class="alert alert-warning show mb-2" role="alert">
                <div class="flex items-center">
                    <div class="font-medium text-lg">Your Institute Join Request is Pending!</div>
                    <div class="text-xs bg-white px-1 rounded-md text-slate-700 ml-auto">New</div>
                </div>
                <div class="mt-3">
                    Thank you for signing up with us! We see that you requested to join an institute. <br><br>

                    <span class="font-bold">Institute Name:</span>
                    @foreach (Auth::user()->user_requests as $request)
                        {{ $request->institute->name }}
                    @endforeach
                    <br><br>Your request is pending and we'll let you know when its
                    status changes!
                </div>

            </div>
        @endif

        <div class="grid grid-cols-12 gap-6 mt-5">
            <div class="col-span-12 sm:col-span-6 xl:col-span-3 intro-y">
                <div class="report-box zoom-in">
                    <div class="box p-5">
                        <div class="flex">
                            <i data-lucide="user" class="report-box__icon text-pending"></i>
                            <div class="ml-auto">
                            </div>
                        </div>


                        <div class="text-3xl font-medium leading-8 mt-6">{{ Auth::user()->name }}</div>
                        <div class="text-base text-slate-500 mt-1">Welcome</div>
                    </div>
                </div>
            </div>
            <div class="col-span-12 sm:col-span-6 xl:col-span-3 intro-y">
                <div class="report-box zoom-in">
                    <div class="box p-5">
                        <div class="flex">
                            <i data-lucide="shopping-cart" class="report-box__icon text-primary"></i>
                            <div class="ml-auto">
                            </div>
                        </div>
                        <div class="text-3xl font-medium leading-8 mt-6">{{ count(Auth::user()->orders) }}</div>
                        <div class="text-base text-slate-500 mt-1">Translation Orders</div>
                    </div>
                </div>
            </div>

            <div class="col-span-12 sm:col-span-6 xl:col-span-3 intro-y">
                <div class="report-box zoom-in">
                    <div class="box p-5">
                        <div class="flex">
                            <i data-lucide="monitor" class="report-box__icon text-warning"></i>
                            <div class="ml-auto">
                            </div>
                        </div>
                        <div class="text-3xl font-medium leading-8 mt-6">{{ count(Auth::user()->interpretations) }}</div>
                        <div class="text-base text-slate-500 mt-1">Interpretations</div>
                    </div>
                </div>
            </div>
            @if (Auth::user()->role_id == 1)
                <div class="col-span-12 sm:col-span-6 xl:col-span-3 intro-y">
                    <div class="report-box zoom-in">
                        <div class="box p-5">
                            <div class="flex">
                                <i data-lucide="user" class="report-box__icon text-success"></i>
                                <div class="ml-auto">
                                </div>
                            </div>
                            <div class="text-3xl font-medium leading-8 mt-6">
                                @foreach (Auth::user()->institute as $institute)
                                    {{ $institute->name }}
                                @endforeach
                            </div>
                            <div class="text-base text-slate-500 mt-1">Institute</div>
                        </div>
                    </div>
                </div>
            @elseif(Auth::user()->role_id == 2)
                <div class="col-span-12 sm:col-span-6 xl:col-span-3 intro-y">
                    <div class="report-box zoom-in">
                        <div class="box p-5">
                            <div class="flex">
                                <i data-lucide="user" class="report-box__icon text-success"></i>
                                <div class="ml-auto">
                                </div>
                            </div>
                            <div class="text-3xl font-medium leading-8 mt-6">
                                {{ Auth::user()->institute_managed->name }}
                            </div>
                            <div class="text-base text-slate-500 mt-1">Institute</div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection