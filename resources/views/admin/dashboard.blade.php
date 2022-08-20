@extends('admin.layout')

@section('content')
<div class="col-span-12 mt-8">
    <div class="intro-y flex items-center h-10">
        <h2 class="text-lg font-medium truncate mr-5">
            Admin Dashboard - Overview
        </h2>
    </div>
    <div class="grid grid-cols-12 gap-6 mt-5">
        <div class="col-span-12 sm:col-span-6 xl:col-span-3 intro-y">
            <div class="report-box zoom-in">
                <div class="box p-5">
                    <div class="flex">
                        <i data-lucide="shopping-cart" class="report-box__icon text-primary"></i> 
                        <div class="ml-auto">
                        </div>
                    </div>
                    <div class="text-3xl font-medium leading-8 mt-6">{{ count($orders) }}</div>
                    <div class="text-base text-slate-500 mt-1">Total Orders</div>
                </div>
            </div>
        </div>
        <div class="col-span-12 sm:col-span-6 xl:col-span-3 intro-y">
            <div class="report-box zoom-in">
                <div class="box p-5">
                    <div class="flex">
                        <i data-lucide="credit-card" class="report-box__icon text-pending"></i> 
                        <div class="ml-auto">
                        </div>
                    </div>
                    

                    <div class="text-3xl font-medium leading-8 mt-6">${{ $sumAmount }}</div>
                    <div class="text-base text-slate-500 mt-1">Total Revenue</div>
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
                    <div class="text-3xl font-medium leading-8 mt-6">{{ $paymentPending }}</div>
                    <div class="text-base text-slate-500 mt-1">Pending Payments</div>
                </div>
            </div>
        </div>
        <div class="col-span-12 sm:col-span-6 xl:col-span-3 intro-y">
            <div class="report-box zoom-in">
                <div class="box p-5">
                    <div class="flex">
                        <i data-lucide="user" class="report-box__icon text-success"></i> 
                        <div class="ml-auto">
                        </div>
                    </div>
                    <div class="text-3xl font-medium leading-8 mt-6">{{ count($users) }}</div>
                    <div class="text-base text-slate-500 mt-1">Registered Users</div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection