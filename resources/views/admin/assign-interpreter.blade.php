@extends('admin.layout')

@section('content')
<div class="intro-y col-span-12 mt-4">
    <!-- BEGIN: Vertical Form -->
    <div class="intro-y box">
        <div class="flex flex-col sm:flex-row items-center p-5 border-b border-slate-200/60 dark:border-darkmode-400">
            <h2 class="font-medium text-base mr-auto">
                Assigning Interpreter for {{ $interpretation->user->name }}'s Interpretation Order
            </h2>

        </div>
        <div id="vertical-form" class="p-5">
            <form action="{{ route('assign-interpreter') }}" method="post">
                @csrf
                @method('POST')
                <div class="preview">
                    <div>
                        <div class="intro-x mt-4">
                            <input type="hidden" name="interpretation_id" value="{{ $interpretation->id }}">
                            <div class="mb-3">
                                <label>Enter Description of Interpretation</label>
                                <textarea type="text" name="description" required
                                    class="intro-x login__input form-control py-3 px-4 block mt-1"
                                    placeholder="Enter Interpretation Description" value=""></textarea>
                            </div>
                            <div class="mt-3 mb-3">
                                <label>Enter Fee</label>
                                <input type="number" required name="amount"
                                    class="intro-x login__input form-control py-3 px-4 block mt-1"
                                    placeholder="Enter Fee (in dollars)" value="">
                            </div>
                            <div class="mt-3">
                                <label>Select Contractor</label>
                                <select data-placeholder="Select a language" name="contractor_id" required
                                    class="tom-select w-full mt-2">

                                    @foreach ($contractors as $contractor)
                                    <option value="{{ $contractor->id }}">{{ $contractor->name }}
                                        ({{ $contractor->email }})
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <input type="submit" class="btn btn-primary mt-5" value="Assign Interpretation">
                </div>
            </form>

        </div>
    </div>
</div>
@endsection