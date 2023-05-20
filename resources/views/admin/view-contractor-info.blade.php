@extends('admin.layout')

@section('content')
    <div class="intro-y col-span-12 mt-4">
        <div class="intro-y box">
            <div class="flex flex-col sm:flex-row items-center p-5 border-b border-slate-200/60 dark:border-darkmode-400">
                <h2 class="font-medium text-base mr-auto">
                    View Contractor
                </h2>
            </div>
            <div id="vertical-form" class="p-5">
                <form>
                    <div class="preview">
                        <div class="mb-3">
                            <label>Name</label>
                            <input type="text" name="name" required disabled
                                class="intro-x login__input form-control py-3 px-4 block mt-1" placeholder="Enter Name"
                                value="{{ $contractor->name }}">
                        </div>
                        <div class="mb-3">
                            <label>Phone Number</label>
                            <input type="text" name="phonenumber" disabled
                                class="intro-x login__input form-control py-3 px-4 block mt-1"
                                placeholder="Enter Phone Number" value="{{ $contractor->phonenumber }}">
                        </div>
                        <div class="mb-3">
                            <label>Address</label>
                            <input type="text" name="address" disabled
                                class="intro-x login__input form-control py-3 px-4 block mt-1" placeholder="Enter Address"
                                value="{{ $contractor->address }}">
                        </div>
                        <div class="mb-3">
                            <label>Email</label>
                            <input type="email" name="email" required disabled
                                class="intro-x login__input form-control py-3 px-4 block mt-1" placeholder="Enter Email"
                                value="{{ $contractor->email }}">
                        </div>
                        <div class="mt-3">
                            <div class="container mt-8">
                                <ul class="nav nav-boxed-tabs" role="tablist">
                                    <li id="translator-tab" class="nav-item flex-1" role="presentation">
                                        <button class="nav-link w-full py-2 active" data-tw-toggle="pill"
                                            data-tw-target="#translator" type="button" role="tab"
                                            aria-controls="translator" aria-selected="true" >Translator</button>
                                    </li>
                                    <li id="interpreter-tab" class="nav-item flex-1" role="presentation">
                                        <button class="nav-link w-full py-2" data-tw-toggle="pill"
                                            data-tw-target="#interpreter" type="button" role="tab"
                                            aria-controls="interpreter" aria-selected="false" >Interpreter</button>
                                    </li>
                                    <li id="proofreader-tab" class="nav-item flex-1" role="presentation">
                                        <button class="nav-link w-full py-2" data-tw-toggle="pill"
                                            data-tw-target="#proofreader" type="button" role="tab"
                                            aria-controls="proofreader" aria-selected="false" >Proofreader</button>
                                    </li>
                                </ul>
                                <div class="tab-content mt-5">
                                    <div id="translator" class="tab-pane leading-relaxed active" role="tabpanel"
                                        aria-labelledby="translator-tab">
                                        <div class="mb-3">
                                            <label for="">Choose Translation Languages</label>
                                            <select name="translator_languages[]" aria-placeholder="Choose your Languages"
                                                data-placeholder="Select your favorite languages" class="tom-select w-full"
                                                multiple disabled>
                                                @foreach ($languages as $language)
                                                    @if ($language->is_translator == 1)
                                                        <option value="{{ $language->language }}" selected>
                                                            {{ $language->language }}
                                                        </option>
                                                    @endif
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="mt-3">
                                            <label for="">Choose Translation Rate (per Word)</label>
                                            <input type="number" name="translation_rate" disabled
                                                class="intro-x login__input form-control py-3 px-4 block mt-4"
                                                placeholder="Per Word Rate" value="{{ $contractor->translation_rate }}">
                                        </div>
                                    </div>
                                    <div id="interpreter" class="tab-pane leading-relaxed" role="tabpanel"
                                        aria-labelledby="interpreter-tab">
                                        <div class="mb-3">
                                            <label for="">Choose Interpretation Languages</label>
                                            <select name="interpreter_languages[]" aria-placeholder="Choose your Languages"
                                                data-placeholder="Select your favorite languages" class="tom-select w-full"
                                                multiple disabled>
                                                @foreach ($languages as $language)
                                                    @if ($language->is_interpreter == 1)
                                                        <option value="{{ $language->language }}" selected>
                                                            {{ $language->language }}
                                                        </option>
                                                    @endif
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="mt-3">
                                            <label for="">Choose Interpretation Rate (per Hour)</label>
                                            <input type="number" name="interpretation_rate" disabled
                                                class="intro-x login__input form-control py-3 px-4 block mt-4"
                                                placeholder="Per Hour Rate"
                                                value="{{ $contractor->interpretation_rate }}">
                                        </div>
                                    </div>
                                    <div id="proofreader" class="tab-pane leading-relaxed" role="tabpanel"
                                        aria-labelledby="proofreader-tab">
                                        <div class="mb-3">
                                            <label for="">Choose Proofreading Languages</label>
                                            <select name="proofreader_languages[]"
                                                aria-placeholder="Choose your Languages"
                                                data-placeholder="Select your favorite languages"
                                                class="tom-select w-full" multiple disabled>
                                                @foreach ($languages as $language)
                                                    @if ($language->is_proofreader == 1)
                                                        <option value="{{ $language->language }}" selected>
                                                            {{ $language->language }}
                                                        </option>
                                                    @endif
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="mt-3">
                                            <label for="">Choose Proofreading Rate</label>
                                            <input type="number" name="proofreader_rate" disabled
                                                class="intro-x login__input form-control py-3 px-4 block mt-4"
                                                placeholder="Rate" value="{{ $contractor->proofreader_rate }}">
                                        </div>
                                    </div>
                                </div>

                            </div>

                        </div>
                        <a href="{{ route('admin.viewContractors') }}" class="btn btn-primary mt-5">Back</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
