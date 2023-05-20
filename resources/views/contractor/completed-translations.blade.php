@extends('contractor.layout')

@section('content')
    <link href="https://unpkg.com/filepond/dist/filepond.css" rel="stylesheet" />
    <link href="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.css" rel="stylesheet" />
    <script src="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.js"></script>
    <script src="https://unpkg.com/filepond-plugin-file-encode/dist/filepond-plugin-file-encode.js"></script>
    <script src="https://unpkg.com/filepond-plugin-file-validate-size/dist/filepond-plugin-file-validate-size.js"></script>
    <script src="https://unpkg.com/filepond-plugin-image-exif-orientation/dist/filepond-plugin-image-exif-orientation.js">
    </script>
    <script src="https://unpkg.com/filepond/dist/filepond.js"></script>
    <div class="col-span-12 mt-8">
        <div class="intro-y flex items-center h-10">
            <h2 class="text-lg font-medium truncate mr-5 mb-5">
                On-Going Translations
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
                                        <th class="whitespace-nowrap">Order WorkNumber</th>
                                        <th class="whitespace-nowrap">Amount</th>
                                        <th class="whitespace-nowrap">Order By</th>
                                        <th class="whitespace-nowrap">Language</th>
                                        <th class="whitespace-nowrap">Rate Accepted</th>
                                        <th>Created At</th>
                                        <th class="whitespace-nowrap">Status</th>
                                        <th class="whitespace-nowrap">Possible Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($translations as $key => $translation)
                                        <tr>
                                            <td class="whitespace-nowrap">{{ $translation->order->worknumber }}</td>
                                            <td class="whitespace-nowrap">${{ $translation->total_payment }}</td>
                                            <td class="whitespace-nowrap">{{ $translation->order->user->name }}</td>
                                            <td class="whitespace-nowrap">{{ $translation->order->language1 }}</td>
                                            <td class="whitespace-nowrap">${{ $translation->order->contractorOrder->rate }}
                                            </td>

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
                                                        <!-- BEGIN: Modal Toggle -->
                                                        <div class="text-center"> 
                                                            <a href="{{ route('contractor.view-submit-translation', $translation->id) }}"
                                                                class="btn btn-primary">
                                                                <i data-lucide="upload" class="w-5 h-5"
                                                                    title="Upload for Submission"></i>
                                                            </a>
                                                        </div> <!-- END: Modal Toggle -->
                                                    @endif
                                                </div>
                                            </td>
                                            <!-- BEGIN: Modal Content -->
                                            {{-- <div id="upload-modal-preview-{{ $key }}" class="modal"
                                                tabindex="-1" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-body p-0">
                                                            <div class="row">
                                                                <div class="col-12">
                                                                    <div class="p-5 text-center"> <i data-lucide="info"
                                                                            class="w-16 h-8 text-danger mx-auto mt-3"></i>
                                                                        <div class="text-3xl mt-5">Upload Translation</div>
                                                                    </div>
                                                                    <div class=" text-center "
                                                                        style="text-align: center;margin: auto !important;width: 100%;position: relative;justify-content: center;">
                                                                        <form
                                                                            action="{{ route('contractor.upload-translation') }}"
                                                                            method="post" enctype="multipart/form-data"
                                                                            accept-charset="utf-8">
                                                                            @csrf
                                                                            @method('POST')
                                                                            <input type="hidden" name="contractor_order_id"
                                                                                value="{{ $translation->id }}">
                                                                            <div class="col-span-12 p-2 sm:col-span-12">
                                                                                <input type="file"
                                                                                    id="fp-translationFile-{{$key}}" class="filepond fp-translationFile"
                                                                                    name="translationFile[]" multiple data-max-files="1" 
                                                                                    data-max-file-size="10MB" />
                                                                                <button type="submit"
                                                                                    class="btn btn-success w-24">Submit</button>
                                                                            </div>
                                                                            <!-- END: Modal Toggle -->
                                                                        </form>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div> <!-- END: Modal Content --> --}}
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
        FilePond.registerPlugin(

            // encodes the file as base64 data
            FilePondPluginFileEncode,

            // validates the size of the file
            FilePondPluginFileValidateSize,

            // corrects mobile image orientation
            FilePondPluginImageExifOrientation,

            // previews dropped images
            FilePondPluginImagePreview
        );

        // Select the file input and use create() to turn it into a pond
        FilePond.create(
            document.querySelector('.fp-translationFile')
        );

        FilePond.setOptions({
            server: {
                process: {
                    url: '/contractor/translationUpload',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                }
            }
        });
    </script>
@endsection
