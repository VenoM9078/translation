@extends('admin.layout')

@section('content')
<div class="intro-y col-span-12 flex flex-wrap sm:flex-nowrap items-center mt-4 mb-4">

</div>
<!-- BEGIN: Data List -->
<div class="col-span-12 mt-8">
    <div class="intro-y flex items-center h-10">
        <h2 class="text-lg font-medium truncate mr-5 mb-5">
            All Customers
        </h2>
    </div>

    <div class="intro-y box">
        <div id="vertical-form" class="p-5">
            <div class="preview">
                <div>
                    <div class="overflow-x-auto">
                        <!-- Your other HTML code here -->

                        <table id="myTable" class="table table-striped hover mt-10" style="width:100%">
                            <thead>
                                <tr>
                                    <th class="whitespace-nowrap text-center">Name</th>
                                    <th class="whitespace-nowrap text-center">Email</th>
                                    <th class="whitespace-nowrap text-center">Orders Count</th>
                                    <th class="whitespace-nowrap text-center">Institute Name</th>
                                    <th class="whitespace-nowrap text-center">Institute Account</th>
                                    <th class="whitespace-nowrap text-center">Institute Admin</th>
                                    <th class="whitespace-nowrap text-center">Interpretations Count</th>
                                    <th class="whitespace-nowrap text-center">Created At</th>
                                    <th class="whitespace-nowrap text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($users as $user)
                                <tr>
                                    <td class="whitespace-nowrap">{{ $user->name }}</td>
                                    <td class="whitespace-nowrap">{{ $user->email }}</td>
                                    <td class="whitespace-nowrap">{{ $user->orders()->count() }}</td>
                                    @if(isset($user->institute) && $user->institute != null && count($user->institute) >
                                    0)
                                    <td class="whitespace-nowrap">{{ $user->institute[0]->name }}</td>
                                    @else
                                    <td class="whitespace-nowrap">--</td>
                                    @endif
                                    @if($user->role_id == 1 || $user->role_id == 2)
                                    <td class="whitespace-nowrap">Yes</td>
                                    @else
                                    <td class="whitespace-nowrap">No</td>
                                    @endif
                                    @if( $user->role_id == 2)
                                    <td class="whitespace-nowrap">Yes</td>
                                    @else
                                    <td class="whitespace-nowrap">No</td>
                                    @endif
                                    <td class="whitespace-nowrap">{{ $user->interpretations()->count() }}</td>
                                    <td class="whitespace-nowrap">
                                        {{ App\Helpers\HelperClass::convertDateToCurrentTimeZone($user->created_at,
                                        request()->ip()) }}
                                    </td>
                                    <td class="whitespace-nowrap">
                                        <div class="flex gap-1 items-center">
                                            <a href="{{ route('admin.viewUser', $user->id) }}"
                                                class="btn btn-primary mr-1 mb-2">View</a>
                                            <a href="{{ route('admin.editUser', $user->id) }}"
                                                class="btn btn-warning mr-1 mb-2">Edit</a>
                                            <form action="{{ route('admin.deleteUser', $user->id) }}" method="post">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger mr-1 mb-2">Delete</a>
                                            </form>
                                        </div>
                                    </td>
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