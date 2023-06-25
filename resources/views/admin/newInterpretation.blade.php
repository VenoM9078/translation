@extends('admin.layout')

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
                    <form action="{{ route('admin.submitNewInterpretation') }}" accept-charset="utf-8" method="post"
                        enctype="multipart/form-data">
                        @csrf
                        @method('POST')
                        <div>
                            <label>Select User</label>
                            <div class="form-check mt-2">
                                <input id="radio-switch-1" class="form-check-input" type="radio" name="vertical_radio_button"
                                    value="vertical-radio-existing" onchange="toggleFields()" checked>
                                <label class="form-check-label" for="radio-switch-1">Existing</label>
                            </div>
                            <div class="form-check mt-2">
                                <input id="radio-switch-2" class="form-check-input" type="radio" name="vertical_radio_button"
                                    value="vertical-radio-new" onchange="toggleFields()">
                                <label class="form-check-label" for="radio-switch-2">New</label>
                            </div>
                        </div>
                        <div class="intro-x mt-4">
                            <div id="existing-user-select" class="w-full mb-4">
                                <select name="email_existing" required aria-placeholder="Select Existing User"
                                    data-placeholder="Select Existing User" class="tom-select w-full">
                                    <option value="Select Existing User" disabled selected>Select Existing User
                                    </option>
                                    @foreach (\App\Models\User::all() as $user)
                                    <option value="{{ $user->email }}">{{ $user->name }} - {{ $user->email }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                            <div id="new-user-fields" class="flex gap-2 mb-4" style="display: none;">
                                <div class="w-full">
                                    <label for="change-password-form-1" class="form-label">Full Name</label>
                                    <input id="change-password-form-1" type="text" class="form-control w-full" name="name"
                                        placeholder="Enter Customer's Full Name">
                                </div>
                                <div class="w-full">
                                    <label for="change-password-form-2" class="form-label">Email</label>
                                    <input id="change-password-form-2" name="email" type="email" class="form-control w-full"
                                        placeholder="Enter Customer's Email Address">
                                </div>
                            </div>
                            <div class="flex mt-2 mb-4 gap-2">
                                <div class="w-full">
                                    <label>Language</label>
                                    <div class="mt-1">
                                        <select name="language" data-placeholder="Select a language"
                                            class="tom-select w-full">
                                            <option value="Afrikaans">Afrikaans</option>
                                            <option value="Spanish">Spanish</option>
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

                                <div class=" w-full">
                                    <label>Date</label>
                                    <input type="date" id="language1" name="interpretationDate"
                                        class="intro-x login__input form-control py-3 px-4 block" required value="">
                                </div>
                            </div>
                            <div class="flex mt-2 mb-2 gap-2">
                                <div class="w-full">
                                    <label>Start Time</label>
                                    <input type="time" id="language2" name="start_time"
                                        class="intro-x w-full login__input form-control py-3 px-4 block mt-2" required
                                        value="">
                                </div>

                                <div class="w-full">
                                    <label>End Time</label>
                                    <input type="time" id="language2" name="end_time"
                                        class="intro-x w-full login__input form-control py-3 px-4 block mt-2" required
                                        value="">
                                </div>

                            </div>

                            <div class="mt-5 mb-5">
                                <div class="flex mt-2 mb-2 gap-2">

                                    <div class="mt-2 w-full">
                                        <label>Session Format</label>
                                        <select name="session_format" data-placeholder="Select Session Format"
                                            class="tom-select w-full">
                                            <option value="In-Person">In-Person</option>
                                            <option value="Video Conference">Video Conference</option>
                                        </select>
                                    </div>

                                    <div class="mt-2 w-full">
                                        <label>Address / Link</label>
                                        <select name="type" data-placeholder="Select Address/Link"
                                            class="tom-select w-full" id="selection">
                                            <option value="Address">Address</option>
                                            <option value="Link">Link</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="mt-5">
                                    <div id="address-input" style="display:none;">
                                        <label for="address">Address:</label>
                                        <input type="text" class="intro-x login__input form-control" id="address"
                                            name="address">
                                    </div>
                                    <div id="link-input" style="display:none;">
                                        <label for="link">Link:</label>
                                        <input type="text" class="intro-x login__input form-control " id="link"
                                            name="link">
                                    </div>
                                </div>

                                <div class="mt-5 mb-5">
                                    <label>Session Topics</label>
                                    <textarea name="session_topics"
                                        class="intro-x login__input form-control block h-20"></textarea>
                                </div>
                                <div class="mt-5 mb-5">
                                    <label>Message</label>
                                    <textarea name="message"
                                        class="intro-x login__input form-control block h-20"></textarea>
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
    $(document).ready(function() {
            if ($("#selection").val() == 'Address') {
                $('#address-input').show();
                $('#link-input').hide();
            }
            $('#selection').change(function() {
                console.log("here")
                if ($(this).val() == 'Address') {
                    $('#address-input').show();
                    $('#link-input').hide();
                } else if ($(this).val() == 'Link') {
                    $('#link-input').show();
                    $('#address-input').hide();
                }
            });
        });

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

        function toggleFields() {
            var existingUserSelect = document.getElementById("existing-user-select");
            var newUserFields = document.getElementById("new-user-fields");
            
            if (document.getElementById("radio-switch-1").checked) {
            existingUserSelect.style.display = "block";
            
            newUserFields.style.display = "none";
            } else {
            existingUserSelect.style.display = "none";
            newUserFields.style.display = "flex";
            
            }
        }
</script>
@endsection