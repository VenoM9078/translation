@extends('admin.layout')

@section('content')
    <link href="https://unpkg.com/filepond/dist/filepond.css" rel="stylesheet" />

    <script src="https://unpkg.com/filepond-plugin-file-encode/dist/filepond-plugin-file-encode.js"></script>
    <script src="https://unpkg.com/filepond-plugin-file-validate-size/dist/filepond-plugin-file-validate-size.js"></script>
    <script src="https://unpkg.com/filepond/dist/filepond.js"></script>

    <div class="col-span-12 mt-8">
        <div class="intro-y flex items-center h-10">
            <h2 class="text-lg font-medium truncate mr-5">
                Upload Proof | WO#: {{ $order->worknumber }}
            </h2>
        </div>

        @if ($message = Session::get('message'))
            <div class="alert alert-success mt-3 p-2">
                <p>{{ $message }}</p>
            </div>
        @endif

        <div class="intro-y box">
            <div id="vertical-form" class="p-5">
                <div class="preview">
                    <div>
                        <form action="{{ route('admin.submit-proof-read') }}" accept-charset="utf-8" method="post"
                            enctype="multipart/form-data">
                            @csrf
                            @method('POST')
                            <input type="hidden" name="order_id" value="{{ $order->id }}">
                            <label for="">Upload Proofread document</label>
                            <input type="file" id="multipleFiles" class="filepond mt-2" name="proofReadFile"
                                data-max-file-size="10MB" />
                            <label for="">Enter message</label>
                            <textarea name="feedback" class="mt-2 form-control" rows="3" placeholder="Type message (optional)"></textarea>
                            <div class="btn-group mt-4" role="group" aria-label="Basic example">
                                <button type="submit" id="uploadBtn" class="btn btn-primary">Upload Files for
                                    Proof Read</button>
                            </div>

                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk="
        crossorigin="anonymous"></script>

    <script>
        FilePond.registerPlugin(
            FilePondPluginFileEncode,
            FilePondPluginFileValidateSize
        );

        FilePond.create(
            document.querySelector('#multipleFiles')
        );

        FilePond.setOptions({
            server: {
                url: '/admin/upload-proof',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            }
        });
    </script>
@endsection
