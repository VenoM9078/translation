@extends('admin.layout')

@section('content')
<div class="intro-y col-span-12 flex flex-wrap sm:flex-nowrap items-center mt-4 mb-4">

</div>
<!-- BEGIN: Data List -->
<div class="col-span-12 mt-8">
    <div class="intro-y flex items-center h-10">
        <h2 class="text-lg font-medium truncate mr-5 mb-5">
            All Contractors
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
                                    <th class="whitespace-nowrap text-center">Address</th>
                                    <th class="whitespace-nowrap text-center">Phone Number</th>
                                    <th class="whitespace-nowrap text-center">SSN</th>
                                    <th class="whitespace-nowrap text-center">T.Languages</th>
                                    <th class="whitespace-nowrap text-center">T.Rate (per Word)</th>
                                    <th class="whitespace-nowrap text-center">P.Languages</th>
                                    <th class="whitespace-nowrap text-center">P.Rate</th>
                                    <th class="whitespace-nowrap text-center">I.Languages</th>
                                    <th class="whitespace-nowrap text-center">I.Rate (per Hour)</th>
                                    <th class="whitespace-nowrap text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($contractors as $contractor)
                                <tr>
                                    <td class="whitespace-nowrap">{{ $contractor->name }}</td>
                                    <td class="whitespace-nowrap">{{ $contractor->email }}</td>
                                    <td class="whitespace-nowrap">{{ $contractor->address }}</td>
                                    <td class="whitespace-nowrap">{{ $contractor->phonenumber }}</td>
                                    <td class="whitespace-nowrap">{{ $contractor->SSN }}</td>
                                    <td class="whitespace-nowrap">{{ implode(", ",
                                        $contractor->languages->where('is_translator',
                                        1)->pluck('language')->toArray()) }}</td>
                                    <td class="whitespace-nowrap">${{ $contractor->translation_rate }}</td>
                                    <td class="whitespace-nowrap">{{ implode(", ",
                                        $contractor->languages->where('is_proofreader',
                                        1)->pluck('language')->toArray()) }}</td>
                                    <td class="whitespace-nowrap">${{ $contractor->proofreader_rate }}</td>
                                    <td class="whitespace-nowrap">{{ implode(", ",
                                        $contractor->languages->where('is_interpreter',
                                        1)->pluck('language')->toArray()) }}</td>
                                    <td class="whitespace-nowrap">${{ $contractor->interpretation_rate }}</td>
                                    <td class="whitespace-nowrap">
                                        <!-- Your Action buttons here -->
                                        <a href="{{ route('admin.editContractor', $contractor->id) }}"
                                            class="btn btn-warning mr-1 mb-2">Edit</a>
                                        <a href="{{ route('admin.deleteContractor', $contractor->id) }}"
                                            class="btn btn-danger mr-1 mb-2">Delete</a>
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
<!-- END: Data List -->
<!-- END: Pagination -->
</div>
@endsection