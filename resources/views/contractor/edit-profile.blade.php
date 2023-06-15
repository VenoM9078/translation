@extends('contractor.layout')

@section('content')
    <div class="intro-y col-span-12 mt-4">
        <div class="intro-y box">
            <div class="flex flex-col sm:flex-row items-center p-5 border-b border-slate-200/60 dark:border-darkmode-400">
                <h2 class="font-medium text-base mr-auto">
                    Edit Profile
                </h2>
            </div>
            @if (session('status'))
                <div class="alert alert-success mt-3 mb-3">
                    <p>{{ session('status') }}</p>
                </div>
            @endif
            <div id="vertical-form" class="p-5">
                <form action="{{ route('contractor.edit-profile-submit') }}" method="post">
                    @csrf
                    @method('POST')
                    <div class="preview">
                        <input type="hidden" name="contractor_id" value="{{ Auth::user()->id }}">
                        <div class="mb-3">
                            <label>Name</label>
                            <input type="text" name="name" readonly 
                                class="intro-x login__input form-control py-3 px-4 block mt-1" placeholder="Enter Name"
                                value="{{ Auth::user()->name }}">
                        </div>
                        <div class="mb-3">
                            <label>Phone Number</label>
                            <input type="text" name="phonenumber"
                                class="intro-x login__input form-control py-3 px-4 block mt-1"
                                placeholder="Enter Phone Number" value="{{ Auth::user()->phonenumber }}">
                        </div>
                        <div class="mb-3">
                            <label>Address</label>
                            <input type="text" name="address"
                                class="intro-x login__input form-control py-3 px-4 block mt-1" placeholder="Enter Address"
                                value="{{ Auth::user()->address }}">
                        </div>
                        <div class="mb-3">
                            <label>Email</label>
                            <input type="email" name="email" disabled
                                class="intro-x login__input form-control py-3 px-4 block mt-1" placeholder="Enter Email"
                                value="{{ Auth::user()->email }}">
                        </div>
                        <div class="mb-3">
                            <label>Password</label>
                            <input type="password" name="password"
                                class="intro-x login__input form-control py-3 px-4 block mt-1"
                                placeholder="Enter Password (Don't fill it if you don't want to change the password)"
                                value="">
                        </div>
                          <div class="mt-3">
                            <label>Education 1</label>
                            <input type="text" name="education_1"
                                class="intro-x login__input form-control py-3 px-4 block mt-1"
                                placeholder="Enter your education"
                                value="{{ Auth::user()->education_1 }}">
                        </div>
                         <div class="mt-3">
                            <label>Education 2</label>
                            <input type="text" name="education_2"
                                class="intro-x login__input form-control py-3 px-4 block mt-1"
                                placeholder="Enter your education"
                               value="{{ Auth::user()->education_2 }}">
                        </div>
                         <div class="mt-3">
                            <label>Education 3</label>
                            <input type="text" name="education_3"
                                class="intro-x login__input form-control py-3 px-4 block mt-1"
                                placeholder="Enter your education"
                                 value="{{ Auth::user()->education_3 }}">
                        </div>
                         <div class="mt-3">
                            <label>Certification</label>
                            <input type="text" name="certification"
                                class="intro-x login__input form-control py-3 px-4 block mt-1"
                                placeholder="Enter your certification"
                                value="{{ Auth::user()->certification }}">
                        </div>
                         <div class="mt-3">
                            <label>Years of Experience</label>
                            <input type="number" name="years_of_experience"
                                class="intro-x login__input form-control py-3 px-4 block mt-1"
                                placeholder="Enter your years of experience"
                               value="{{ Auth::user()->years_of_experience }}">
                        </div>
                        <div class="mt-3">
                            <div class="container mt-8">
                                <ul class="nav nav-boxed-tabs" role="tablist">
                                    <li id="translator-tab" class="nav-item flex-1" role="presentation">
                                        <button class="nav-link w-full py-2 active" data-tw-toggle="pill"
                                            data-tw-target="#translator" type="button" role="tab"
                                            aria-controls="translator" aria-selected="true">Translator</button>
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
                                {{-- @dd($languages) --}}
                                <div class="tab-content mt-5">
                                    <div id="translator" class="tab-pane leading-relaxed active" role="tabpanel"
                                        aria-labelledby="translator-tab">
                                        <div class="mb-3">
                                            <label for="">Choose Translation Languages</label>
                                            <select name="translator_languages[]" aria-placeholder="Choose your Languages"
                                                data-placeholder="Select your favorite languages" class="tom-select w-full"
                                                multiple>
                                                @foreach ($languages as $language)
                                                    @if ($language->is_translator == 1)
                                                        <option value="{{ $language->language }}" selected>
                                                            {{ $language->language }}
                                                        </option>
                                                    @endif
                                                @endforeach
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
                                        {{-- <div class="mt-3">
                                            <label for="">Choose Translation Rate (per Word)</label>
                                            <input type="number" name="translation_rate"
                                                class="intro-x login__input form-control py-3 px-4 block mt-4"
                                                placeholder="Per Word Rate" value="{{ Auth::user()->translation_rate }}">
                                        </div> --}}

                                    </div>
                                    <div id="interpreter" class="tab-pane leading-relaxed" role="tabpanel"
                                        aria-labelledby="interpreter-tab">
                                        <div class="mb-3">
                                            <label for="">Choose Interpretation Languages</label>
                                            <select name="interpreter_languages[]"
                                                aria-placeholder="Choose your Languages"
                                                data-placeholder="Select your favorite languages"
                                                class="tom-select w-full" multiple>
                                                @foreach ($languages as $language)
                                                    @if ($language->is_interpreter == 1)
                                                        <option value="{{ $language->language }}" selected>
                                                            {{ $language->language }}
                                                        </option>
                                                    @endif
                                                @endforeach
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
                                        {{-- <div class="mt-3">
                                            <label for="">Choose Interpretation Rate (per Hour)</label>
                                            <input type="number" name="interpretation_rate"
                                                class="intro-x login__input form-control py-3 px-4 block mt-4"
                                                placeholder="Per Hour Rate"
                                                value="{{ Auth::user()->interpretation_rate }}">
                                        </div> --}}
                                    </div>
                                    <div id="proofreader" class="tab-pane leading-relaxed" role="tabpanel"
                                        aria-labelledby="proofreader-tab">
                                        <div class="mb-3">
                                            <label for="">Choose Proofreading Languages</label>
                                            <select name="proofreader_languages[]"
                                                aria-placeholder="Choose your Languages"
                                                data-placeholder="Select your favorite languages"
                                                class="tom-select w-full" multiple>
                                                @foreach ($languages as $language)
                                                    @if ($language->is_proofreader == 1)
                                                        <option value="{{ $language->language }}" selected>
                                                            {{ $language->language }}
                                                        </option>
                                                    @endif
                                                @endforeach
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
                                        {{-- <div class="mt-3">
                                            <label for="">Choose Proofreading Rate</label>
                                            <input type="number" name="proofreader_rate"
                                                class="intro-x login__input form-control py-3 px-4 block mt-4"
                                                placeholder="Rate" value="{{ Auth::user()->proofreader_rate }}">
                                        </div> --}}
                                    </div>
                                </div>

                            </div>

                        </div>
                       
                        <input type="submit" class="btn btn-primary mt-5" value="Update Contractor">
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
