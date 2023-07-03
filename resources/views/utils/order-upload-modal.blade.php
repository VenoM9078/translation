<div id="upload-modal-preview-{{ $key }}" class="modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <!-- BEGIN: Modal Header -->
            <div class="modal-header">
                <h2 class="font-medium text-base mr-auto">
                    Upload Document
                </h2>

            </div> <!-- END: Modal Header -->
            <!-- BEGIN: Modal Body -->
            <div class="modal-body">
                {{-- Quote --}}
                <ul class="">
                    <div class="flex justify-center items-center w-full gap-4">
                        <li class="">
                            <a href="{{ route('admin.showOrderSubmitQuote', $order->id) }}" class="mr-1">
                                <label for="hosting-small"
                                    class="inline-flex items-center justify-between w-full p-5 text-gray-500 bg-white border border-gray-200 rounded-lg cursor-pointer hover:text-gray-300  dark:peer-checked:text-blue-500 peer-checked:border-blue-600 peer-checked:text-blue-600 hover:text-gray-600 hover:bg-gray-100 dark:text-gray-400 dark:bg-gray-800 ">
                                    <div class="block">
                                        <div class="w-full text-lg font-semibold">Upload Quote</div>
                                    </div>
                                    <svg aria-hidden="true" class="w-6 h-6 ml-3" fill="currentColor" viewBox="0 0 20 20"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd"
                                            d="M12.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-2.293-2.293a1 1 0 010-1.414z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                </label>
                            </a>
                        </li>
                        <li class="">
                            <a href="{{ route('show-final-upload-page', $order->id) }}" title="Upload Final Document"
                                class="">
                                <input type="radio" id="hosting-big" name="hosting" value="hosting-big"
                                    class="hidden peer">
                                <label for="hosting-big"
                                    class="inline-flex items-center justify-between w-full p-5 text-gray-500 bg-white border border-gray-200 rounded-lg cursor-pointer dark:peer-checked:text-blue-500 peer-checked:border-blue-600 peer-checked:text-blue-600 hover:text-gray-600 hover:bg-gray-100">
                                    <div class="block">
                                        <div class="w-full text-lg font-semibold"> Upload Final Document</div>
                                        {{-- <div class="w-full">Good for large websites</div> --}}
                                    </div>
                                    <svg aria-hidden="true" class="w-6 h-6 ml-3" fill="currentColor" viewBox="0 0 20 20"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd"
                                            d="M12.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-2.293-2.293a1 1 0 010-1.414z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                </label>
                            </a>
                        </li>
                    </div>
                    <div class="flex justify-center mt-4  w-full gap-4 items-center">
                        <li class="">
                            <a href="{{ route('admin.showOrderSubmitQuote', $order->id) }}"
                                title="Upload Translated Document" class="mr-1">
                                <label for="hosting-small"
                                    class="inline-flex items-center justify-between w-full p-5 text-gray-500 bg-white border border-gray-200 rounded-lg cursor-pointer dark:peer-checked:text-blue-500 peer-checked:border-blue-600 peer-checked:text-blue-600 hover:text-gray-600 hover:bg-gray-100 ">
                                    <div class="block">
                                        <div class="w-full text-lg font-semibold">Upload Translated Document</div>
                                    </div>
                                    <svg aria-hidden="true" class="w-6 h-6 ml-3" fill="currentColor" viewBox="0 0 20 20"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd"
                                            d="M12.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-2.293-2.293a1 1 0 010-1.414z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                </label>
                            </a>
                        </li>
                        <li class="">
                            <a href="{{ route('show-final-upload-page', $order->id) }}" title="Upload ProofRead Document"
                                class="">
                                <input type="radio" id="hosting-big" name="hosting" value="hosting-big"
                                    class="hidden peer">
                                <label for="hosting-big"
                                    class="inline-flex items-center justify-between w-full p-5 text-gray-500 bg-white border border-gray-200 rounded-lg cursor-pointer dark:peer-checked:text-blue-500 peer-checked:border-blue-600 peer-checked:text-blue-600 hover:text-gray-600 hover:bg-gray-100 ">
                                    <div class="block">
                                        <div class="w-full text-lg font-semibold"> Upload ProofRead Document</div>
                                        {{-- <div class="w-full">Good for large websites</div> --}}
                                    </div>
                                    <svg aria-hidden="true" class="w-6 h-6 ml-3" fill="currentColor" viewBox="0 0 20 20"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd"
                                            d="M12.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-2.293-2.293a1 1 0 010-1.414z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                </label>
                            </a>
                        </li>
                    </div>
                </ul>
            </div> <!-- END: Modal Body -->
            <!-- BEGIN: Modal Footer -->
            <div class="modal-footer"> <button type="button" data-tw-dismiss="modal"
                    class="btn btn-outline-secondary w-20 mr-1">Cancel</button>
            </div> <!-- END: Modal Footer -->
        </div>
    </div>
</div> <!-- END: Modal Content -->
