@extends('contractor.layout')

@section('content')
    <div class="col-span-12 mt-8">
        <div class="intro-y flex items-center h-10">
            <h2 class="text-lg font-medium truncate mr-5 mb-5">
                All Accepted Translations
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
                                                    @if ($translation->is_accepted == 1)
                                                        <a href="{{ route('contractor.downloadFiles', $translation->order_id) }}"
                                                            class="btn btn-warning mr-1 mb-2"> <i data-lucide="download"
                                                                class="w-5 h-5"></i> </a>
                                                    @endif
                                                </div>
                                            </td>
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
