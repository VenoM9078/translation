@extends('user.layout')

@section('content')
    <div class="col-span-12 mt-8">
        <div class="intro-y flex items-center h-10">
            <h2 class="text-lg font-medium truncate mr-5">
                Edit Interpretation
            </h2>
        </div>

        @if ($message = Session::get('message'))
            <div class="alert alert-success mt-3">
                <p>{{ $message }}</p>
            </div>
        @endif

        <div class="intro-y box lg:mt-5">
            <div class="flex items-center p-5 border-b border-slate-200/60 dark:border-darkmode-400">
                <h2 class="font-medium text-base mr-auto">
                    Customer Details
                </h2>
            </div>
            <div class="p-5">
                <div class="grid grid-cols-1 gap-2 md:grid-cols-2">
                    <div class="flex mt-2 mb-2 gap-2">
                        <div class="w-full">
                            <label for="order-form-1" class="form-label">Username</label>
                            <input id="order-form-1" type="text" class="form-control w-full" disabled
                                value="{{ $interpretation->user->name }}">
                        </div>
                        <div class="w-full">
                            <label for="order-form-2" class="form-label">Email</label>
                            <input id="order-form-2" type="text" class="form-control w-full" disabled
                                value="{{ $interpretation->user->email }}">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="intro-y box lg:mt-5">
            <div class="flex items-center p-5 border-b border-slate-200/60 dark:border-darkmode-400">
                <h2 class="font-medium text-base mr-auto">
                    Interpretation Details
                </h2>
            </div>
            <div id="vertical-form" class="p-5">
                <div class="preview">
                    <div>
                        <div class="flex mt-2 mb-2 gap-2">
                            <div class="w-full">
                                <label for="order-form-1" class="form-label">WO#</label>
                                <input id="order-form-1" type="text" class="form-control w-full" disabled
                                    value="{{ $interpretation->worknumber }}">
                            </div>
                            <div class="w-full">
                                <label for="order-form-2" class="form-label">Language</label>
                                <input id="order-form-2" type="text" class="form-control w-full" disabled
                                    value="{{ $interpretation->language }}">
                            </div>
                        </div>
                        <form action="{{ route('user.interpretation.update', $interpretation->id) }}" method="post"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <!-- Add more fields here as per your requirement -->
                            <div class="intro-x mt-4">
                                <input type="hidden" name="interpretation_id" value="{{ $interpretation->id }}">

                                <div class="flex mt-2 mb-2 gap-2">
                                    <div class="w-full">
                                        <label for="">Enter Interpretation Date</label>
                                        <input type="date" name="interpretationDate" class="form-control w-full"
                                            value="{{ $interpretation->interpretationDate }}" required>
                                    </div>
                                    <div class="w-full">
                                        <label for="">Enter Start Time</label>
                                        <input type="time" name="start_time" class="form-control w-full"
                                            value="{{ $interpretation->start_time }}" required>
                                    </div>

                                    <div class="w-full">
                                        <label for="">Enter End Time</label>
                                        <input type="time" name="end_time" class="form-control w-full"
                                            value="{{ $interpretation->end_time }}" required>
                                    </div>
                                </div>
                                <div class="flex mt-2 mb-2 gap-2">
                                    <div class="w-full">

                                        <div class="mt-5">
                                            <label for="">Select Location</label>
                                            <input type="text" name="location" class="form-control w-full"
                                                value="{{ $interpretation->location }}" required>
                                        </div>
                                    </div>

                                    <div class="w-full">
                                        <div class="mt-5">
                                            <label for="">Enter Language</label>
                                            <select name="language" data-placeholder="Select a language"
                                                class="tom-select w-full">
                                                <option value="{{ $interpretation->language }}" selected>
                                                    {{ $interpretation->language }}</option>
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


                                    <div class="w-full">

                                        <div class="mt-5">
                                            <label for="">Enter Session Format</label>
                                            <select name="session_format" data-placeholder="Select Session Format"
                                                class="tom-select w-full">
                                                <option value="In-Person"
                                                    {{ $interpretation->session_format == 'In-Person' ? 'selected' : '' }}>
                                                    In-Person
                                                </option>
                                                <option value="Virtual Call"
                                                    {{ $interpretation->session_format == 'Virtual Call' ? 'selected' : '' }}>
                                                    Virtual Call</option>
                                            </select>
                                        </div>
                                    </div>

                                </div>
                                <div class="flex mt-5 mb-2 gap-2">
                                    <div class="w-full">
                                        <label for="order-form-11" class="form-label">Want Quote</label>
                                        <input id="order-form-11" type="text" class="form-control w-full" disabled
                                            value="{{ $interpretation->wantQuote == 1 ? 'Yes' : 'No' }}">
                                    </div>
                                    <div class="w-full">
                                        <label for="order-form-12" class="form-label">Quote Price</label>
                                        <input id="order-form-12" type="text" class="form-control w-full" disabled
                                            value="{{ $interpretation->quote_price }}">
                                    </div>

                                    <div class="w-full">
                                        <label for="order-form-14" class="form-label">Invoice Sent</label>
                                        <input id="order-form-14" type="text" class="form-control w-full" disabled
                                            value="{{ $interpretation->invoiceSent == 1 ? 'Yes' : 'No' }}">
                                    </div>
                                </div>
                                <div class="w-full">
                                    <label for="order-form-13" class="form-label">Quote Description</label>
                                    <textarea id="order-form-13" type="text" class="form-control w-full" disabled
                                        value="{{ $interpretation->quote_description }}">{{ $interpretation->quote_description }}</textarea>
                                </div>
                                <div class="flex mt-5 mb-2 gap-2">
                                    <div class="w-full">
                                        <label for="order-form-14" class="form-label">Invoice Sent</label>
                                        <input id="order-form-14" type="text" class="form-control w-full" disabled
                                            value="{{ $interpretation->invoiceSent == 1 ? 'Yes' : 'No' }}">
                                    </div>
                                    <div class="w-full">
                                        <label for="order-form-15" class="form-label">Payment Status</label>
                                        <input id="order-form-15" type="text" class="form-control w-full" disabled
                                            value="{{ $interpretation->paymentStatus == 1 ? 'Paid' : 'Not Paid' }}">
                                    </div>
                                </div>
                                <div class="flex mt-5 mb-2 gap-2">
                                    <div class="w-full">
                                        <label for="order-form-17" class="form-label">Interpreter Completed</label>
                                        <input id="order-form-17" type="text" class="form-control w-full" disabled
                                            value="{{ $interpretation->interpreter_completed == 1 ? 'Yes' : 'No' }}">
                                    </div>
                                    <div class="w-full">
                                        <label for="order-form-18" class="form-label">Feedback</label>
                                        <input id="order-form-18" type="text" class="form-control w-full" disabled
                                            value="{{ $interpretation->feedback }}">
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary mt-5">Update Interpretation</button>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
