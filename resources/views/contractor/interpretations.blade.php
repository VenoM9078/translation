@extends('contractor.layout')

@section('content')
<div class="col-span-12 mt-8">
    <div class="intro-y flex items-center h-10">
        <h2 class="text-lg font-medium truncate mr-5 mb-5">
            On-Going Interpretations
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
                                    <th class="whitespace-nowrap">Worknumber</th>
                                    <th class="whitespace-nowrap">Topic</th>
                                    <th class="whitespace-nowrap">Language</th>
                                    <th class="whitespace-nowrap">Interpretation Date</th>
                                    <th>Start Time</th>
                                    <th>End Time</th>
                                    <th class="whitespace-nowrap">Session Format</th>
                                    <th class="whitespace-nowrap">Address/Link</th>
                                    <th class="whitespace-nowrap">Per Hour Rate</th>
                                    <th class="whitespace-nowrap">Estimated Payment</th>
                                    <th class="whitespace-nowrap">Possible Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($interpretations as $interpretation)
                                <tr>
                                    <td class="whitespace-nowrap">{{ $interpretation->interpretation->worknumber }}</td>
                                    <td class="whitespace-nowrap">{{ $interpretation->interpretation->session_topics }}
                                    </td>
                                    <td class="whitespace-nowrap">{{ $interpretation->interpretation->language }}</td>
                                    <td class="whitespace-nowrap">{{ $interpretation->interpretation->interpretationDate
                                        }}</td>
                                    <td class="whitespace-nowrap">{{ $interpretation->interpretation->start_time }}</td>
                                    <td class="whitespace-nowrap">{{ $interpretation->interpretation->end_time }}</td>
                                    <td class="whitespace-nowrap">{{ $interpretation->interpretation->session_format }}
                                    </td>
                                    <td class="whitespace-nowrap">{{ $interpretation->interpretation->location }}
                                    </td>
                                    <td class="whitespace-nowrap">${{ $interpretation->per_hour_rate }}</td>
                                    <td class="whitespace-nowrap">${{ $interpretation->estimated_payment }}</td>
                                    <td class="whitespace-nowrap">
                                        <a href="{{ route('reportToAdmin', $interpretation->id) }}"
                                            class="btn btn-warning mr-1 mb-2">Report</a>
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
    <script>
        let button = document.querySelector('#uniqueModal');

        button.addEventListener('click', function() {
            let value = button.value;

            console.log(value);
        })
    </script>
    @endsection