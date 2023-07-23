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
                Edit Order
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
                                value="{{ $order->user->name }}">
                        </div>
                        <div class="w-full">
                            <label for="order-form-2" class="form-label">Email</label>
                            <input id="order-form-2" type="text" class="form-control w-full" disabled
                                value="{{ $order->user->email }}">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="intro-y box lg:mt-5">
            <div class="flex items-center p-5 border-b border-slate-200/60 dark:border-darkmode-400">
                <h2 class="font-medium text-base mr-auto">
                    Order Details
                </h2>
            </div>
            <div id="vertical-form" class="p-5">
                <div class="preview">
                    <div>
                        <div class="grid grid-cols-1 gap-2 md:grid-cols-2">
                            <div class="flex mt-2 mb-2 gap-2">
                                <div class="w-full">
                                    <label for="order-form-1" class="form-label">WO#</label>
                                    <input id="order-form-1" type="text" class="form-control w-full" disabled
                                        value="{{ $order->worknumber }}">
                                </div>
                                <div class="w-full">
                                    <label for="order-form-19" class="form-label">Order Completed</label>
                                    <input id="order-form-19" type="text" class="form-control" disabled
                                        value="{{ $order->completed == 1 ? 'Yes' : 'No' }}">
                                </div>

                            </div>
                        </div>
                        <form action="{{ route('admin.edit-order-save') }}" accept-charset="utf-8" method="post"
                            enctype="multipart/form-data">
                            @csrf
                            @method('POST')
                            <div class="intro-x mt-4">
                                <div class="flex mt-2 mb-2 gap-2">
                                    <input type="hidden" name="order_id" value="{{ $order->id }}">
                                    <div class="w-full">
                                        <div class="mt-2">
                                            <label for="">Source Language</label>
                                            <select name="language1" data-placeholder="Select a language"
                                                class="tom-select w-full">
                                                <option value="{{ $order->language1 }}" selected>
                                                    {{ $order->language1 }}</option>
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
                                        <div class="mt-2">
                                            <label for="">Target Language</label>
                                            <select name="language2" data-placeholder="Select a language"
                                                class="tom-select w-full">
                                                <option value="{{ $order->language2 }}" selected>
                                                    {{ $order->language2 }}</option>
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
                                </div>

                                <label for="contractor_name mt-5">Contractor Name</label>
                                @if ($order->translationStatus == 1 && $order->contractorOrder->is_accepted == 1)
                                    <input type="text" name="contractor_name" disabled id="contractor_name"
                                        style="margin-bottom: 20px;"
                                        class="intro-x login__input form-control py-3 px-4 block mt-4"
                                        placeholder="Contractor Name"
                                        value="{{ isset($order->contractorOrder) && isset($order->contractorOrder->contractor) ? $order->contractorOrder->contractor->name : 'N/A' }}">
                                    {{-- <a href="{{ route('view-assign-proofreader', $order->id) }}" --}}
                                    {{-- class="mb-2 btn btn-primary">Re-Assign ProofReader</a> --}}
                                    <hr class="my-2 py-2">
                                @else
                                    <input type="text" name="contractor_name" disabled id="contractor_name"
                                        style="margin-bottom: 20px;"
                                        class="intro-x login__input form-control py-3 px-4 block mt-4"
                                        placeholder="Contractor Name"
                                        value="{{ isset($order->contractorOrder->contractor->name) ? $order->contractorOrder->contractor->name : 'N/A' }}">
                                    @if (isset($order->contractorOrder->contractor->name))
                                        {{-- <a href="{{ route('view-assign-contractor', $order->id) }}" --}}
                                        {{-- class="mb-2 btn btn-primary">Re-Assign Contractor</a> --}}
                                    @endif
                                @endif

                                <div class="flex mt-2 mb-2 gap-2">
                                    <div class="w-full">
                                        <label for="order-form-9" class="form-label">Invoice Sent</label>
                                        <input id="order-form-9" type="text" class="form-control" disabled
                                            value="{{ $order->invoiceSent == 1 ? 'Yes' : 'No' }}">
                                    </div>
                                    <div class="w-full">
                                        <label for="order-form-10" class="form-label">Is Evidence</label>
                                        <input id="order-form-10" type="text" class="form-control" disabled
                                            value="{{ $order->is_evidence == 1 ? 'Yes' : 'No' }}">
                                    </div>
                                </div>
                                <div class="w-full">
                                    <label for="order-form-11" class="form-label">Filename</label>
                                    <input id="order-form-11" type="text" class="form-control" disabled
                                        value="{{ $order->filename }}">
                                </div>
                                <div class="flex mt-2 mb-2 gap-2">
                                    <div class="w-full">
                                        <label for="order-form-12" class="form-label">Evidence Accepted</label>
                                        <input id="order-form-12" type="text" class="form-control" disabled
                                            value="{{ $order->evidence_accepted == 1 ? 'Yes' : 'No' }}">
                                    </div>

                                    <div class="w-full">
                                        <label for="order-form-13" class="form-label">Amount</label>
                                        <input id="order-form-13" type="text" class="form-control" disabled
                                            value="{{ $order->amount }}">
                                    </div>
                                </div>
                                <div class="flex mt-2 mb-2 gap-2">
                                    <div class="w-full col-md-6">
                                        <label for="order-form-14" class="form-label">Order Status</label>
                                        <input id="order-form-14" type="text" class="form-control" disabled
                                            value="{{ $order->orderStatus }}">
                                    </div>
                                    <div class="w-full col-md-6">
                                        <label for="order-form-15" class="form-label">Translation Sent</label>
                                        <input id="order-form-15" type="text" class="form-control" disabled
                                            value="{{ $order->translation_sent == 1 ? 'Yes' : 'No' }}">
                                    </div>
                                </div>
                                <div class="flex mt-2 mb-2 gap-3">
                                    <div class="w-full">
                                        <label for="order-form-16" class="form-label">Translation Status</label>
                                        <input id="order-form-16" type="text" class="form-control" disabled
                                            value="{{ $order->translation_status == 1 ? 'Completed' : 'Incomplete' }}">
                                    </div>
                                    <div class="w-full">
                                        <label for="order-form-17" class="form-label">Proofread Sent</label>
                                        <input id="order-form-17" type="text" class="form-control" disabled
                                            value="{{ $order->proofread_sent == 1 ? 'Yes' : 'No' }}">
                                    </div>
                                    <div class="w-full">
                                        <label for="order-form-18" class="form-label">Proofread Status</label>
                                        <input id="order-form-18" type="text" class="form-control" disabled
                                            value="{{ $order->proofread_status == 1 ? 'Completed' : 'Incomplete' }}">
                                    </div>
                                </div>
                                <div class="flex mt-2 mb-2 gap-2">

                                    <div class="w-full">
                                        <label for="order-form-20" class="form-label">Added by Institute User</label>
                                        <input id="order-form-20" type="text" class="form-control" disabled
                                            value="{{ $order->added_by_institute_user == 1 ? 'Yes' : 'No' }}">
                                    </div>

                                </div>
                                <div class="w-full">
                                    <label for="order-form-21" class="form-label">Message</label>
                                    <textarea id="order-form-21" type="text" class="form-control" disabled value="{{ $order->message }}">{{ $order->message }}</textarea>
                                </div>
                                <div class="flex gap-2 w-full">
                                    <div class="w-full mb-3 mt-3">
                                        <label for="order-form-22" class="form-label">Want Quote</label>
                                        <input id="order-form-22" type="text" class="form-control" disabled
                                            value="{{ $order->want_quote == 1 ? 'Yes' : 'No' }}">
                                    </div>
                                    <div class="w-full mb-3 mt-3">
                                        <label for="order-form-22" class="form-label">Due Date</label>
                                        <input id="order-form-22" type="date" name="due_date" class="form-control"
                                            value="{{ $order->due_date }}">
                                    </div>
                                </div>
                                <div class="flex gap-2 w-full">
                                    <div class="w-full">
                                        <label for="c_unit">Unit</label>
                                        <input type="number" id="unit" name="unit"
                                            class="intro-x login__input form-control py-3 px-4 block mt-4 mb-4"
                                            placeholder="Unit" value="{{ $order->unit }}">
                                    </div>
                                </div>
                                <div class="flex gap-2 w-full">

                                    <!-- C. Type field -->
                                    <div class="w-full">
                                        <label for="c_type">C. Type</label>
                                        <input type="text" id="c_type" name="c_type"
                                            class="intro-x login__input form-control py-3 px-4 block mt-4 mb-4"
                                            placeholder="C. Type" value="{{ $order->c_type }}">
                                    </div>

                                    <!-- C. Unit field -->
                                    <div class="w-full">
                                        <label for="c_unit">C. Unit</label>
                                        <input type="number" id="c_unit" name="c_unit"
                                            class="intro-x login__input form-control py-3 px-4 block mt-4 mb-4"
                                            placeholder="C. Unit" value="{{ $order->c_unit }}">
                                    </div>

                                </div>
                                <div class="flex gap-2 w-full">

                                    <!-- C. Rate field -->
                                    <div class="w-full">

                                        <label for="c_rate">C. Rate ($/W or $/P)</label>
                                        <input type="number" step="0.01" id="c_rate" name="c_rate"
                                            class="intro-x login__input form-control py-3 px-4 block mt-4 mb-4"
                                            placeholder="C. Rate ($/W or $/P)" value="{{ $order->c_rate }}">
                                    </div>
                                    <!-- C. Adjust field -->
                                    <div class="w-full">

                                        <label for="c_adjust">C. Adjust ($)</label>
                                        <input type="number" step="0.01" id="c_adjust" name="c_adjust"
                                            class="intro-x login__input form-control py-3 px-4 block mt-4 mb-4"
                                            placeholder="C. Adjust ($)" value="{{ $order->c_adjust }}">
                                    </div>
                                </div>

                                <div class="flex gap-2 w-full">

                                    <!-- C. Paid field -->
                                    <div class="w-full">
                                        <label for="c_paid">C. Paid</label>
                                        <select id="c_paid" name="c_paid"
                                            class="form-control py-3 px-4 block mt-4 mb-4">
                                            <option value="0" {{ $order->c_paid == 0 ? 'selected' : '' }}>No
                                            </option>
                                            <option value="1" {{ $order->c_paid == 1 ? 'selected' : '' }}>Yes
                                            </option>
                                        </select>
                                    </div>
                                    <!-- C. Fee field -->
                                    <div class="w-full">

                                        <label for="c_fee">C. Fee ($)</label>
                                        <input type="number" step="0.01" id="c_fee" name="c_fee"
                                            class="intro-x login__input form-control py-3 px-4 block mt-4 mb-4"
                                            placeholder="C. Fee ($)" value="{{ $order->c_fee }}">
                                    </div>
                                </div>
                                <!-- C. Adjust Note field -->
                                <label for="c_adjust_note">C. Adjust Note</label>
                                <textarea id="c_adjust_note" name="c_adjust_note" class="intro-x login__input form-control py-3 px-4 block mt-4 mb-4"
                                    placeholder="C. Adjust Note">{{ $order->c_adjust_note }}</textarea>


                            </div>
                            <div class="btn-group mt-5" role="group" aria-label="Basic example">
                                <button type="submit" class="btn btn-primary">Edit Order</button>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>

        @if (isset($order->contractorOrder))
            <div class="intro-y box lg:mt-5">
                <div class="flex items-center p-5 border-b border-slate-200/60 dark:border-darkmode-400">
                    <h2 class="font-medium text-base mr-auto">
                        Contractor Details
                    </h2>
                </div>
                <div class="p-5">
                    <div class="flex mt-2 mb-2 gap-2">
                        <div class="w-full">
                            <label for="order-form-4" class="form-label">Contractor Name</label>
                            <input id="order-form-4" type="text" class="form-control w-full" disabled
                                value="{{ $order->contractorOrder->contractor->name ?? '-' }}">
                        </div>
                        <div class="w-full">
                            <label for="order-form-5" class="form-label">Contractor Email</label>
                            <input id="order-form-5" type="text" class="form-control w-full" disabled
                                value="{{ $order->contractorOrder->contractor->email ?? '-' }}">
                        </div>
                    </div>
                    <div class="flex mt-2 mb-2 gap-2">
                        <div class="w-full">
                            <label for="order-form-6" class="form-label">SSN</label>
                            <input id="order-form-6" type="text" class="form-control" disabled
                                value="{{ $order->contractorOrder->contractor->SSN ?? '-' }}">
                        </div>
                        <div class="w-full">
                            <label for="order-form-7" class="form-label">Interpretation Rate</label>
                            <input id="order-form-7" type="text" class="form-control" disabled
                                value="${{ $order->contractorOrder->contractor->interpretation_rate ?? '0' }}">
                        </div>
                    </div>
                    <div class="flex mt-2 mb-2 gap-2">
                        <div class="w-full">
                            <label for="order-form-8" class="form-label">Translation Rate</label>
                            <input id="order-form-8" type="text" class="form-control" disabled
                                value="${{ $order->contractorOrder->contractor->translation_rate ?? '0' }}">
                        </div>
                        <div class="w-full">
                            <label for="order-form-9" class="form-label">Proofreader Rate</label>
                            <input id="order-form-9" type="text" class="form-control" disabled
                                value="${{ $order->contractorOrder->contractor->proofreader_rate ?? '0' }}">
                        </div>
                    </div>
                </div>
            </div>
        @endif

        {{-- @dd($order->invoice) --}}
        @if (isset($order->invoice) && $order->added_by_institute_user == 0)
            <div class="intro-y box lg:mt-5">
                <div class="flex items-center p-5 border-b border-slate-200/60 dark:border-darkmode-400">
                    <h2 class="font-medium text-base mr-auto">
                        Invoice Details
                    </h2>
                </div>
                <div class="p-5">
                    <div class="flex mt-2 mb-2 gap-2">
                        <div class="w-full">
                            <label for="order-form-10" class="form-label">Invoice Description</label>
                            <input id="order-form-10" type="text" class="form-control" disabled
                                value="{{ $order->invoice->description }}">
                        </div>
                        <div class="w-full">
                            <label for="order-form-11" class="form-label">Document Quantity</label>
                            <input id="order-form-11" type="text" class="form-control" disabled
                                value="{{ $order->invoice->docQuantity }}">
                        </div>
                        <div class="w-full">
                            <label for="order-form-12" class="form-label">Amount</label>
                            <input id="order-form-12" type="text" class="form-control" disabled
                                value="{{ $order->invoice->amount }}">
                        </div>
                    </div>
                </div>
            </div>
        @endif

    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk="
        crossorigin="anonymous"></script>
    <!-- add before </body> -->
    {{-- prod --}}
    <script
        src="https://www.paypal.com/sdk/js?client-id=Aa2jPGWCMLpswVVeE7IuImi64-45_hAD-gmbh7UY5KhmIUA2CAkaScbXWYjoTPNJiAzQWj_ya7wZNC6s&disable-funding=credit&components=buttons">
    </script>
    {{-- TODO:CHANGE Client id --}}
    {{-- <script
        src="https://www.paypal.com/sdk/js?client-id=AapYCwr7IL6pstdnEZ8a8Ugv_WMX3qBJflHAfrlFwye5D-7oB22i8Nrky2_AwRLLLTayYkhWS21uKygn&disable-funding=credit&components=buttons">
    </script> --}}

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

        $(document).ready(function() {
            function calculateFee() {
                var c_unit = parseFloat($('#c_unit').val()) || 0;
                var c_rate = parseFloat($('#c_rate').val()) || 0;
                var c_adjust = parseFloat($('#c_adjust').val()) || 0;
                var c_fee = c_unit * c_rate + c_adjust;
                $('#c_fee').val(c_fee.toFixed(2));
            }
            $('#c_unit, #c_rate, #c_adjust').change(calculateFee);
        });
    </script>
@endsection
