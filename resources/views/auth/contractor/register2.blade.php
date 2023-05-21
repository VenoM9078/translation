<!DOCTYPE html>

<html lang="en" class="light">
<!-- BEGIN: Head -->

<head>
    <meta charset="utf-8">
    <link href="{{ url('dist/images/logo.svg') }}" rel="shortcut icon">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Contractor Register</title>
    <!-- BEGIN: CSS Assets-->
    <link rel="stylesheet" href="{{ url('dist/css/app.css') }}" />
    <!-- END: CSS Assets-->
</head>
<!-- END: Head -->

<body class="login">
    <div class="container sm:px-10">
        <div class="block xl:grid grid-cols-2 gap-4">
            <!-- BEGIN: Register Info -->
            <div class="hidden xl:flex flex-col min-h-screen">
                <a href="" class="-intro-x flex items-center pt-5">
                    <img class="w-6" src="{{ url('dist/images/logo.svg') }}">
                    <span class="text-white text-lg ml-3"> FlowTranslate </span>
                </a>
                <div class="my-auto">
                    <img alt="Midone - HTML Admin Template" class="-intro-x w-1/2 -mt-16"
                        src="{{ url('dist/images/illustration.svg') }}">
                    <div class="-intro-x text-white font-medium text-4xl leading-tight mt-10">
                        A few more clicks to
                        <br>
                        sign up to your account.
                    </div>
                    <div class="-intro-x mt-5 text-lg text-white text-opacity-70 dark:text-slate-400">Manage all your
                        customers in one place</div>
                </div>
            </div>
            <!-- END: Register Info -->
            <!-- BEGIN: Register Form -->
            <div class="flex py-5 xl:py-0 my-10 xl:my-0">
                <div
                    class="my-auto mx-auto xl:ml-20 bg-white dark:bg-darkmode-600 xl:bg-transparent px-5 sm:px-8 py-8 xl:p-0 rounded-md shadow-md xl:shadow-none w-full sm:w-3/4 lg:w-2/4 xl:w-auto">
                    <h2 class="intro-x font-bold text-2xl xl:text-3xl text-center xl:text-left">
                        Contractor Sign Up
                    </h2>
                    <div class="intro-x mt-2 text-slate-400 dark:text-slate-400 xl:hidden text-center">A few more clicks
                        to sign up to your account. Manage all your e-commerce accounts in one place</div>
                    @if($errors->any())
                    <div class="alert alert-danger mt-3 mb-3">
                        <ul>
                            @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif
                    <div class="intro-x w-full grid grid-cols-12 gap-4 h-1 mt-3">
                        <div class="col-span-6 h-full rounded bg-success"></div>
                        <div class="col-span-6 h-full rounded bg-success"></div>
                    </div>
                    <form action="{{ route('contractor.register') }}" method="post">
                        @csrf
                        @method('POST')
                        <div class="intro-x mt-8">
                            <input type="hidden" name="name" class="intro-x login__input form-control py-3 px-4 block"
                                value={{$name}}>
                            <input type="hidden" name="email"
                                class="intro-x login__input form-control py-3 px-4 block mt-4" value="{{$email}}">
                            <div><input type="hidden" name="password"
                                    class="intro-x login__input form-control py-3 px-4 block mt-4" value={{$password}}>
                                <input type="hidden" name="password2"
                                    class="intro-x login__input form-control py-3 px-4 block mt-4" value={{$password2}}>
                            </div>

                        </div>

                        <div class="intro-x mt-4">
                            <input type="text" name="address" class="intro-x login__input form-control py-3 px-4 block"
                                placeholder="Address">
                            <input type="text" name="phonenumber"
                                class="intro-x login__input form-control py-3 px-4 block mt-4"
                                placeholder="Phone Number">
                            <input type="text" name="SSN" class="intro-x login__input form-control py-3 px-4 block mt-4"
                                placeholder="Tax Payer ID i.e SSN / EIN">

                        </div>

                        <div class="container mt-8">
                            <ul class="nav nav-boxed-tabs" role="tablist">
                                <li id="translator-tab" class="nav-item flex-1" role="presentation">
                                    <button class="nav-link w-full py-2 active" data-tw-toggle="pill"
                                        data-tw-target="#translator" type="button" role="tab" aria-controls="translator"
                                        aria-selected="true">Translator</button>
                                </li>
                                <li id="interpreter-tab" class="nav-item flex-1" role="presentation">
                                    <button class="nav-link w-full py-2" data-tw-toggle="pill"
                                        data-tw-target="#interpreter" type="button" role="tab"
                                        aria-controls="interpreter" aria-selected="false">Interpreter</button>
                                </li>
                                <li id="proofreader-tab" class="nav-item flex-1" role="presentation">
                                    <button class="nav-link w-full py-2" data-tw-toggle="pill"
                                        data-tw-target="#proofreader" type="button" role="tab"
                                        aria-controls="proofreader" aria-selected="false">Proofreader</button>
                                </li>
                            </ul>
                            <div class="tab-content mt-5">
                                <div id="translator" class="tab-pane leading-relaxed active" role="tabpanel"
                                    aria-labelledby="translator-tab">
                                    <div class="mb-3">
                                        <label for="">Choose Translation Languages</label>
                                        <select name="translator_languages[]" aria-placeholder="Choose your Languages"
                                            data-placeholder="Select your favorite languages" class="tom-select w-full"
                                            multiple>
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
                                    <div class="mt-3">
                                        <label for="">Choose Translation Rate (per Word)</label>
                                        <input type="number" name="translator_rate"
                                            class="intro-x login__input form-control py-3 px-4 block mt-4"
                                            placeholder="Per Word Rate">
                                    </div>

                                </div>
                                <div id="interpreter" class="tab-pane leading-relaxed" role="tabpanel"
                                    aria-labelledby="interpreter-tab">
                                    <div class="mb-3">
                                        <label for="">Choose Interpretation Languages</label>
                                        <select name="interpreter_languages[]" aria-placeholder="Choose your Languages"
                                            data-placeholder="Select your favorite languages" class="tom-select w-full"
                                            multiple>
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
                                    <div class="mt-3">
                                        <label for="">Choose Interpretation Rate (per Hour)</label>
                                        <input type="number" name="interpreter_rate"
                                            class="intro-x login__input form-control py-3 px-4 block mt-4"
                                            placeholder="Per Hour Rate">
                                    </div>
                                </div>
                                <div id="proofreader" class="tab-pane leading-relaxed" role="tabpanel"
                                    aria-labelledby="proofreader-tab">
                                    <div class="mb-3">
                                        <label for="">Choose Proofreading Languages</label>
                                        <select name="proofreader_languages[]" aria-placeholder="Choose your Languages"
                                            data-placeholder="Select your favorite languages" class="tom-select w-full"
                                            multiple>
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
                                    <div class="mt-3">
                                        <label for="">Choose Proofreading Rate</label>
                                        <input type="number" name="proofreader_rate"
                                            class="intro-x login__input form-control py-3 px-4 block mt-4"
                                            placeholder="Rate">
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="intro-x mt-5 xl:mt-8 text-center xl:text-left">
                            <button type="submit"
                                class="btn btn-primary py-3 px-4 w-full xl:w-32 xl:mr-3 align-top">Register</button>
                            <a href="{{ route('contractor.register') }}"
                                class="btn btn-outline-secondary py-3 px-4 w-full xl:w-32 mt-3 xl:mt-0 align-top">Sign
                                in</a>



                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- END: Register Form -->
    </div>


    <!-- BEGIN: JS Assets-->
    <script src="{{ url('dist/js/app.js') }}"></script>
    <!-- END: JS Assets-->
</body>

</html>