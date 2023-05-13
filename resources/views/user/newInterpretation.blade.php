@extends('user.layout')

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
        <h2 class="text-lg font-medium truncate mr-5">
            Interpretation Center
        </h2>
    </div>

    @if ($message = Session::get('message'))
    <div class="alert alert-success mt-3 mb-3">
        <p>{{ $message }}</p>
    </div>
    @endif

    <div class="intro-y box">
        <div id="vertical-form" class="p-5">
            <div class="preview">
                <div>
                    <form action="{{ route('newInterpretation') }}" accept-charset="utf-8" method="post"
                        enctype="multipart/form-data">
                        @csrf
                        @method('POST')
                        <div class="intro-x mt-4">


                            <div>
                                <label>Select Language</label>
                                <div class="mt-2">
                                    <select name="language" data-placeholder="Select a language"
                                        class="tom-select w-full">
                                        <option value="Afrikaans">Afrikaans</option>
                                        <option value="Albanian">Albanian</option>
                                        <option value="Amharic">Amharic</option>
                                        <option value="Arabic">Arabic</option>
                                        <option value="Aragonese">Aragonese</option>
                                        <option value="Armenian">Armenian</option>
                                        <option value="Asturian">Asturian</option>
                                        <option value="Azerbaijani">Azerbaijani</option>
                                        <option value="Basque">Basque</option>
                                        <option value="Belarusian">Belarusian</option>
                                        <option value="Bengali">Bengali</option>
                                        <option value="Bosnian">Bosnian</option>
                                        <option value="Breton">Breton</option>
                                        <option value="Bulgarian">Bulgarian</option>
                                        <option value="Catalan">Catalan</option>
                                        <option value="Central Kurdish">Central Kurdish</option>
                                        <option value="Chinese">Chinese</option>
                                        <option value="Chinese (Hong Kong)">Chinese (Hong Kong)</option>
                                        <option value="Chinese (Simplified)">Chinese (Simplified)</option>
                                        <option value="Chinese (Traditional)">Chinese (Traditional)</option>
                                        <option value="Corsican">Corsican</option>
                                        <option value="Croatian">Croatian</option>
                                        <option value="Czech">Czech</option>
                                        <option value="Danish">Danish</option>
                                        <option value="Dutch">Dutch</option>
                                        <option value="English">English</option>
                                        <option value="English (Australia)">English (Australia)</option>
                                        <option value="English (Canada)">English (Canada)</option>
                                        <option value="English (India)">English (India)</option>
                                        <option value="English (New Zealand)">English (New Zealand)</option>
                                        <option value="English (South Africa)">English (South Africa)</option>
                                        <option value="English (United Kingdom)">English (United Kingdom)</option>
                                        <option value="English (United States)">English (United States)</option>
                                        <option value="Esperanto">Esperanto</option>
                                        <option value="Estonian">Estonian</option>
                                        <option value="Faroese">Faroese</option>
                                        <option value="Filipino">Filipino</option>
                                        <option value="Finnish">Finnish</option>
                                        <option value="French">French</option>
                                        <option value="French (Canada)">French (Canada)</option>
                                        <option value="French (France)">French (France)</option>
                                        <option value="French (Switzerland)">French (Switzerland)</option>
                                        <option value="Galician">Galician</option>
                                        <option value="Georgian">Georgian</option>
                                        <option value="German">German</option>
                                        <option value="German (Austria)">German (Austria)</option>
                                        <option value="German (Germany)">German (Germany)</option>
                                        <option value="German (Liechtenstein)">German (Liechtenstein)</option>
                                        <option value="German (Switzerland)">German (Switzerland)</option>
                                        <option value="Greek">Greek</option>
                                        <option value="Guarani">Guarani</option>
                                        <option value="Gujarati">Gujarati</option>
                                        <option value="Hausa">Hausa</option>
                                        <option value="Hawaiian">Hawaiian</option>
                                        <option value="Hebrew">Hebrew</option>
                                        <option value="Hindi">Hindi</option>
                                        <option value="Hungarian">Hungarian</option>
                                        <option value="Icelandic">Icelandic</option>
                                        <option value="Indonesian">Indonesian</option>
                                        <option value="Interlingua">Interlingua</option>
                                        <option value="Irish">Irish</option>
                                        <option value="Italian">Italian</option>
                                        <option value="Italian (Italy)">Italian (Italy)</option>
                                        <option value="Italian (Switzerland)">Italian (Switzerland)</option>
                                        <option value="Japanese">Japanese</option>
                                        <option value="Kannada">Kannada</option>
                                        <option value="Kazakh">Kazakh</option>
                                        <option value="Khmer">Khmer</option>
                                        <option value="Korean">Korean</option>
                                        <option value="Kurdish">Kurdish</option>
                                        <option value="Kyrgyz">Kyrgyz</option>
                                        <option value="Lao">Lao</option>
                                        <option value="Latin">Latin</option>
                                        <option value="Latvian">Latvian</option>
                                        <option value="Lingala">Lingala</option>
                                        <option value="Lithuanian">Lithuanian</option>
                                        <option value="Macedonian">Macedonian</option>
                                        <option value="Malay">Malay</option>
                                        <option value="Malayalam">Malayalam</option>
                                        <option value="Maltese">Maltese</option>
                                        <option value="Marathi">Marathi</option>
                                        <option value="Mongolian">Mongolian</option>
                                        <option value="Nepali">Nepali</option>
                                        <option value="Norwegian">Norwegian</option>
                                        <option value="Norwegian Bokmål">Norwegian Bokmål</option>
                                        <option value="Norwegian Nynorsk">Norwegian Nynorsk</option>
                                        <option value="Occitan">Occitan</option>
                                        <option value="Oriya">Oriya</option>
                                        <option value="Oromo">Oromo</option>
                                        <option value="Pashto">Pashto</option>
                                        <option value="Persian">Persian</option>
                                        <option value="Polish">Polish</option>
                                        <option value="Portuguese">Portuguese</option>
                                        <option value="Portuguese (Brazil)">Portuguese (Brazil)</option>
                                        <option value="Portuguese (Portugal)">Portuguese (Portugal)</option>
                                        <option value="Punjabi">Punjabi</option>
                                        <option value="Quechua">Quechua</option>
                                        <option value="Romanian">Romanian</option>
                                    </select>
                                </div>
                            </div>

                            <div class="mt-5 mb-5">
                                <label>Select Date</label>
                                <input type="date" id="language1" name="interpretationDate"
                                    class="intro-x login__input form-control py-3 px-4 block" required value="">
                            </div>
                            <div class="flex mt-2 mb-2 gap-2">
                                <div class="w-full">
                                    <label>Start Time</label>
                                    <input type="time" id="language2" name="start_time"
                                        class="intro-x w-full login__input form-control py-3 px-4 block mt-4" required
                                        value="">
                                </div>

                                <div class="w-full">
                                    <label>End Time</label>
                                    <input type="time" id="language2" name="end_time"
                                        class="intro-x w-full login__input form-control py-3 px-4 block mt-4" required
                                        value="">
                                </div>

                            </div>

                            <div class="mt-5 mb-5">
                                <label>Session Format</label>
                                <div class="mt-2">
                                    <select name="session_format" data-placeholder="Select Session Format"
                                        class="tom-select w-full">
                                        <option value="In-Person">In-Person</option>
                                        <option value="Virtual Call">Virtual Call</option>
                                    </select>
                                </div>

                                <div class="mt-5 mb-5">
                                    <label>Address / Link</label>
                                    <input type="text" id="language1" name="location"
                                        class="intro-x login__input form-control py-3 px-4 block" required value="">
                                </div>

                                <div class="mt-5 mb-5">
                                    <label>Session Topics</label>
                                    <textarea name="session_topics"
                                        class="intro-x login__input form-control block h-20"></textarea>
                                </div>

                                <div class="flex mt-5 ">
                                    <div class="form-check form-switch mb-4">
                                        <input
                                            class="form-check-input appearance-none w-9 border-md justify-start border p-2 -ml-10 rounded-full float-left h-5 align-top bg-white bg-no-repeat bg-contain bg-gray-300 focus:outline-none cursor-pointer shadow-sm"
                                            type="checkbox" role="switch" id="flexSwitchCheckDefault" name="wantQuote">
                                        <label class="form-check-label inline-block text-black"
                                            for="flexSwitchCheckDefault">Need a Quote?</label>
                                        <br>
                                        <hr>
                                    </div>
                                </div>

                            </div>

                            <div class="btn-group mt-5" role="group" aria-label="Basic example">

                                <button type="submit" id="uploadBtn" class="btn btn-primary">Submit Request for
                                    Interpretation</button>
                            </div>

                    </form>
                </div>
            </div>

        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk="
    crossorigin="anonymous"></script>
<!-- add before </body> -->
{{-- TODO:CHANGE Client id --}}
<script
    src="https://www.paypal.com/sdk/js?client-id=AapYCwr7IL6pstdnEZ8a8Ugv_WMX3qBJflHAfrlFwye5D-7oB22i8Nrky2_AwRLLLTayYkhWS21uKygn&disable-funding=credit&components=buttons">
</script>

<script>
    if ($("#flexSwitchCheckDefault").is(':checked') == false) {
            $("#paypal-button-container").hide();
        } else {
            $("#paypal-button-container").show();
        }
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
            document.querySelector('#multipleFiles')
        );

        FilePond.setOptions({
            server: {
                url: '/upload',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            }
        });


        order = 4
</script>
@endsection