@extends('admin.layout')

@section('content')
<div class="intro-y col-span-12 flex flex-wrap sm:flex-nowrap items-center mt-4 mb-4">

</div>
<div class="intro-y flex items-center h-10 mb-5 mt-2">
    <h2 class="text-lg font-medium truncate ml-2 mr-5">
        Completed Interpretations
    </h2>
</div>
<hr style="margin-bottom: 30px;">
<!-- BEGIN: Data List -->
<div class="intro-y box">
    <div id="vertical-form" class="p-5">
        <div class="preview">
            <div>
                <div class="overflow-x-auto">
                    <table id="myTable" class="table table-striped hover mt-10" style="width:100%">
                        <thead>
                            <tr>
                                <th class="whitespace-nowrap text-center">Work Number</th>
                                <th class="whitespace-nowrap text-center">Language</th>
                                <th class="whitespace-nowrap text-center">Interpretation Date</th>
                                <th class="whitespace-nowrap text-center">Start Time</th>
                                <th class="whitespace-nowrap text-center">End Time</th>
                                <th class="whitespace-nowrap text-center">Session Format</th>
                                <th class="whitespace-nowrap text-center">Interpreter Assigned</th>
                                <th class="whitespace-nowrap text-center">I.Rate</th>
                                <th class="whitespace-nowrap text-center">E.Payment</th>
                                <th class="whitespace-nowrap text-center">Created At</th>
                                <th style="width: 41.0469px;padding-left: 40px;padding-right: 40px;"
                                    class="whitespace-nowrap w-40 px-12">Feedback</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($interpretations as $interpretation)
                            <tr>
                                <td class="whitespace-nowrap">{{ $interpretation->worknumber }}</td>
                                <td class="whitespace-nowrap">{{ $interpretation->language }}</td>
                                <td class="whitespace-nowrap">{{ $interpretation->interpretationDate }}</td>
                                <td class="whitespace-nowrap">{{ $interpretation->start_time }}</td>
                                <td class="whitespace-nowrap">{{ $interpretation->end_time }}</td>

                                <td class="whitespace-nowrap">{{ $interpretation->session_format }}</td>
                                <td class="whitespace-nowrap">
                                    @if ($interpretation->interpreter_id === null)
                                    N/A
                                    @else
                                    {{ $interpretation->interpreter->name }}
                                    @endif
                                </td>
                                <td class="whitespace-nowrap">
                                    @if ($interpretation->interpreter_id === null ||
                                    $interpretation->contractorInterpretation->per_hour_rate == null)
                                    N/A
                                    @else
                                    ${{ $interpretation->contractorInterpretation->per_hour_rate }}
                                    @endif
                                </td>
                                <td class="whitespace-nowrap">
                                    @if ($interpretation->interpreter_id === null ||
                                    $interpretation->contractorInterpretation->estimated_payment == null)
                                    N/A
                                    @else
                                    ${{ $interpretation->contractorInterpretation->estimated_payment }}
                                    @endif
                                </td>
                                <td class="whitespace-nowrap">
                                    {{ $interpretation->created_at->timezone('America/Los_Angeles') }}
                                </td>
                                <td class="whitespace-nowrap">
                                    {{ $interpretation->feedback }}
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
@endsection