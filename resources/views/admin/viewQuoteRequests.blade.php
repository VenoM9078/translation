@extends('admin.layout')

@section('content')
<div class="intro-y col-span-12 flex flex-wrap sm:flex-nowrap items-center mt-4 mb-4">

</div>
<div class="intro-y flex items-center h-10 mb-5 mt-2">
    <h2 class="text-lg font-medium truncate ml-2 mr-5">
        Quote Requests
    </h2>
    <div class="text-center"> <a href="javascript:;" data-tw-toggle="modal" data-tw-target="#delete-modal-preview"
            class="btn btn-danger">Delete</a>
    </div>
    <div id="delete-modal-preview" class="modal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body p-0">
                    <div class="p-5 text-center"> <i data-lucide="x-circle"
                            class="w-16 h-16 text-danger mx-auto mt-3"></i>
                        <div class="text-3xl mt-5">Are you sure?</div>
                        <div class="text-slate-500 mt-2">Do you really want to delete all quotes? <br>This process
                            cannot
                            be undone.</div>
                    </div>
                    <div class="px-5 pb-8 text-center inline-flex items-stretch"
                        style="text-align: center;margin: auto !important;width: 100%;position: relative;justify-content: center;">
                        <button type=" button" data-tw-dismiss="modal"
                            class="btn btn-outline-secondary w-24 mr-1 self-center">
                            Cancel</button>
                        <form action="{{ route('deleteAllQuotes') }}" method="post">
                            @csrf
                            @method('POST')
                            <button type="submit" class="btn btn-danger w-24">Delete</button>
                            <!-- END: Modal Toggle -->
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
<hr>
<!-- BEGIN: Data List -->

@if ($message = Session::get('message'))
<div class="alert alert-success mt-3 mb-3">
    <p>{{ $message }}</p>
</div>
@endif
<div class="intro-y box">
    <div id="vertical-form" class="p-5">
        <div class="preview">
            <div>
                <div class="overflow-x-auto">
                    <table id="myTable" class="table table-striped" style="width:100%">
                        <thead>
                            <tr>
                                <th class="whitespace-nowrap">Name</th>
                                <th class="whitespace-nowrap">Email</th>
                                <th class="whitespace-nowrap">Message</th>

                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($quotes as $quote)

                            <tr>
                                <td class="whitespace-nowrap">{{ $quote->name }}</td>
                                <td class="whitespace-nowrap">{{ $quote->email }}</td>
                                <td class="whitespace-nowrap">{{ $quote->message }}</td>

                            </tr>

                            @endforeach
                        </tbody>
                    </table>


                </div>
            </div>
        </div>
    </div>
</div>
@endsection