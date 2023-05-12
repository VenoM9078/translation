@extends('contractor.layout')

@section('content')
    <div class="col-span-12 mt-8">
        <div class="intro-y flex items-center h-10">
            <h2 class="text-lg font-medium truncate mr-5 mb-5">
                Translation Requests
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
                            <table id="myTable" class="table table-striped hover" style="width:100%">
                                <thead>
                                    <tr>
                                        <th class="whitespace-nowrap">Description</th>
                                        <th class="whitespace-nowrap">Amount</th>
                                        <th>Created At</th>
                                        <th class="whitespace-nowrap">Status</th>
                                        <th class="whitespace-nowrap">Possible Action</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($translations as $key => $translation)
                                        <tr>
                                            <td class="whitespace-nowrap">{{ $translation->description }}</td>
                                            <td class="whitespace-nowrap">${{ $translation->amount }}</td>

                                            <td class="whitespace-nowrap">
                                                {{ $translation->created_at->timezone('America/Los_Angeles') }}</td>
                                            <td class="whitespace-nowrap">
                                                {{ $translation->is_accepted == 1 ? 'Accepted' : 'Pending' }}
                                            </td>
                                            <td class="whitespace-nowrap">
                                                <div class="flex gap-2">
                                                    @if ($translation->is_accepted == 0)
                                                        {{-- create a modal popup --}}
                                                        <!-- Trigger button for modal -->
                                                        <div class="text-center"> <a href="javascript:;"
                                                                data-tw-toggle="modal"
                                                                data-tw-target="#offer-modal-preview{{ $key }}"
                                                                class="btn btn-warning">Details</a>
                                                        </div> <!-- END: Modal Toggle -->
                                                    @endif
                                                </div>
                                            </td>
                                            <!-- BEGIN: Modal Content -->
                                            <div id="offer-modal-preview{{ $key }}" class="modal" tabindex="-1"
                                                aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-body p-0">
                                                            <div class="p-5 text-center"> <i data-lucide="x-circle"
                                                                    class="w-16 h-16 text-danger mx-auto mt-3"></i>
                                                                <div class="text-3xl mt-5">Translation Offer</div>
                                                                <div class="text-slate-500 mt-2">Do you want to
                                                                    accept
                                                                    this
                                                                    order?</div>
                                                            </div>
                                                            <div class="px-5 pb-8 text-center inline-flex items-stretch"
                                                                style="text-align: center;margin: auto !important;width: 100%;position: relative;justify-content: center;">
                                                                <a href="{{ route('contractor.accept', ['order' => $translation->id]) }}"
                                                                    class="btn btn-outline-success w-24 mr-1 self-center">
                                                                    Accept</a>
                                                                <a href="{{ route('contractor.decline', ['order' => $translation->id]) }}"
                                                                    class="btn btn-outline-danger w-24 mr-1 self-center">
                                                                    Decline</a>
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
