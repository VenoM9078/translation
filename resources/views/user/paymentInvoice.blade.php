@extends('user.layout')

@section('content')
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.css" />

    <div class="col-span-12 mt-8">
        <div class="intro-y flex items-center h-10">
            <h2 class="text-lg font-medium truncate mr-5 mb-5">
                Viewing Invoice for Worknumber: {{ $order->worknumber }}
            </h2>

        </div>

        <!-- BEGIN: Top Bar -->

        <!-- END: Top Bar -->
        {{-- <div class="intro-y flex flex-col sm:flex-row items-center mt-8">
        <h2 class="text-lg font-medium mr-auto">
            Invoice Layout
        </h2>
        <div class="w-full sm:w-auto flex mt-4 sm:mt-0">
            <button class="btn btn-primary shadow-md mr-2">Print</button>
            <div class="dropdown ml-auto sm:ml-0">
                <button class="dropdown-toggle btn px-2 box" aria-expanded="false" data-tw-toggle="dropdown">
                    <span class="w-5 h-5 flex items-center justify-center"> <i class="w-4 h-4" data-lucide="plus"></i>
                    </span>
                </button>
                <div class="dropdown-menu w-40">
                    <div class="dropdown-content">
                        <a href="" class="dropdown-item"> <i data-lucide="file" class="w-4 h-4 mr-2"></i> Export Word
                        </a>
                        <a href="" class="dropdown-item"> <i data-lucide="file" class="w-4 h-4 mr-2"></i> Export PDF
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}
        <!-- BEGIN: Invoice -->
        <div class="intro-y box overflow-hidden mt-5">
            <div class="flex flex-col lg:flex-row pt-10 px-5 sm:px-20 sm:pt-20 lg:pb-20 text-center sm:text-left">
                <div class="font-semibold text-primary text-3xl">Invoice</div>
                <div class="mt-20 lg:mt-0 lg:ml-auto lg:text-right">
                    <div class="text-xl text-primary font-medium">FlowTranslate</div>
                    <div class="mt-1">webpage@flowtranslate.com</div>
                    <div class="mt-1">650-229-4621</div>
                </div>
            </div>
            <div class="flex flex-col lg:flex-row border-b px-5 sm:px-20 pt-10 pb-10 sm:pb-20 text-center sm:text-left">
                <div>
                    <div class="text-base text-slate-500">Client Details</div>
                    <div class="text-lg font-medium text-primary mt-2">{{ $order->user->name }}</div>
                    <div class="mt-1">{{ $order->user->email }}</div>
                </div>
                <div class="mt-10 lg:mt-0 lg:ml-auto lg:text-right">
                    {{-- <div class="text-base text-slate-500">Work Number</div> --}}
                    {{-- <div class="text-lg text-primary font-medium mt-2">{{ $orderWork = $order->worknumber }}</div> --}}

                    <div class="text-lg text-pending font-medium mt-2">Created At:
                        {{ $order->created_at->timezone('America/Los_Angeles') }}</div>
                </div>
            </div>
            <div class="px-5 sm:px-16 py-10 sm:py-20">
                <div class="overflow-x-auto">
                    <table class="table">
                        <thead>
                            <tr>
                                <th class="border-b-2 dark:border-darkmode-400 whitespace-nowrap">DESCRIPTION</th>
                                {{-- <th class="border-b-2 dark:border-darkmode-400 text-right whitespace-nowrap">QTY</th>
                            --}}
                                <th class="border-b-2 dark:border-darkmode-400 text-right whitespace-nowrap">PRICE</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="border-b dark:border-darkmode-400">
                                    {{-- <div class="font-medium whitespace-nowrap">{{ $description }} </div> --}}
                                    <div class="text-slate-500 text-sm mt-0.5 whitespace-nowrap">Languages:
                                        {{ $order->language1 }}, {{ $order->language2 }}</div>
                                </td>
                                {{-- <td class="text-right border-b dark:border-darkmode-400 w-32">10
                            </td> --}}
                                <td class="text-right border-b dark:border-darkmode-400 w-32">$35</td>
                            </tr>
                            {{-- <tr>
                            <td class="border-b dark:border-darkmode-400">
                                <div class="font-medium whitespace-nowrap">PayPal Transaction Fee</div>
                                <div class="text-slate-500 text-sm mt-0.5 whitespace-nowrap">*Mandatory fee if you are
                                    paying through PayPal</div>
                            </td>
                            <td class="text-right border-b dark:border-darkmode-400 w-32">-</td>
                            <td class="text-right border-b dark:border-darkmode-400 w-32">$3.50</td>
                        </tr> --}}
                        </tbody>
                    </table>
                </div>
            </div>
            @if ($order->paymentStatus == 0)
                <div class="px-5 sm:px-20 pb-10 sm:pb-20 flex flex-col-reverse sm:flex-row">
                    <form action="" method="post"></form>
                    <div class="text-center sm:text-left mt-10 sm:mt-0">
                        <div class="text-base text-slate-500 mb-3">Choose Payment Method</div>
                        <a href="{{ route('provideProof', $order->id) }}" class="btn btn-primary">Already Paid?
                            Provide
                            Proof</a>
                        {{-- <div class="text-center"> --}}

                        <a href="javascript:;" data-tw-toggle="modal" data-tw-target="#header-footer-modal-preview-2"
                            style="background-color: purple;" class="text-white btn">View Bank Details</a>

                        {{--
                </div> --}}
                        {{-- <a href="{{ route('payLater',$order->id) }}" class="btn btn-pending">Pay Later</a> --}}

                        <div id="header-footer-modal-preview-2" class="modal" tabindex="-1" aria-hidden="true">

                            <div class="modal-dialog">
                                <form action="{{ route('payLater') }}" method="post">
                                    @csrf
                                    @method('POST')
                                    <div class="modal-content">
                                        <!-- BEGIN: Modal Header -->
                                        <div class="modal-header">
                                            <h2 class="font-medium text-base mr-auto">Bank Details</h2>

                                        </div> <!-- END: Modal Header -->
                                        <!-- BEGIN: Modal Body -->

                                        {{-- Check to: Flow Translations
                                Bank of America
                                Checking Account No.3251 0717 1449
                                Routing Number: 121000358 --}}

                                        <div class="modal-body grid grid-cols-12 gap-4 gap-y-3">
                                            <div class="col-span-12 sm:col-span-12">
                                                <label for="modal-form-1" class="form-label">Name</label>
                                                <input id="modal-form-1" type="text" disabled class="form-control mb-5"
                                                    value="Flow Translations">

                                                <label for="modal-form-1" class="form-label">Bank Name</label>
                                                <input id="modal-form-1" type="text" disabled class="form-control mb-5"
                                                    value="Bank of America">

                                                <label for="modal-form-1" class="form-label">Checking Account No.</label>
                                                <input id="modal-form-1" type="text" disabled class="form-control mb-5"
                                                    value="3251 0717 1449">

                                                <label for="modal-form-1" class="form-label">Routing Number</label>
                                                <input id="modal-form-1" type="text" disabled class="form-control mb-5"
                                                    value="121000358">
                                            </div>

                                        </div> <!-- END: Modal Body -->
                                        <!-- BEGIN: Modal Footer -->
                                        <div class="modal-footer"> <button type="button" data-tw-dismiss="modal"
                                                class="btn btn-outline-secondary w-20 mr-1">Cancel</button>
                                            {{-- <button type="submit" class="btn btn-primary w-40">Submit Request</button> --}}
                                        </div> <!-- END: Modal Footer -->
                                    </div>
                                </form>
                            </div>

                        </div> <!-- END: Modal Content -->

                        <div id="header-footer-modal-preview" class="modal" tabindex="-1" aria-hidden="true">

                            {{-- <div class="modal-dialog">
                        <form action="{{ route('payLater') }}" method="post">
                            @csrf
                            @method('POST')
                            <div class="modal-content">
                                <!-- BEGIN: Modal Header -->
                                <div class="modal-header">
                                    <h2 class="font-medium text-base mr-auto">Pay Later</h2>

                                </div> <!-- END: Modal Header -->
                                <!-- BEGIN: Modal Body -->
                                <div class="modal-body grid grid-cols-12 gap-4 gap-y-3">
                                    <div class="col-span-12 sm:col-span-12">
                                        <input type="hidden" name="order_id" value="{{ $order->id }}">
                                        <label for="modal-form-1" class="form-label">Code</label>
                                        <input id="modal-form-1" type="text" name="payLaterCode" required
                                            class="form-control" placeholder="Enter Code that helps us recognize you">
                                    </div>

                                </div> <!-- END: Modal Body -->
                                <!-- BEGIN: Modal Footer -->
                                <div class="modal-footer"> <button type="button" data-tw-dismiss="modal"
                                        class="btn btn-outline-secondary w-20 mr-1">Cancel</button>
                                    <button type="submit" class="btn btn-primary w-40">Submit Request</button>
                                </div> <!-- END: Modal Footer -->
                            </div>
                        </form>
                    </div> --}}

                        </div> <!-- END: Modal Content -->

                        <hr class="side-nav__devider my-6">
                        </hr>

                        <div id="paypal-button-container"></div>

                        <hr class="side-nav__devider my-6">
                        </hr>

                        {{-- <div class="text-center text-base text-danger mb-3">Paying through PayPal? PayPal Transaction Fee
                    ($3.50)<br> must be paid along with the charged amount in the Invoice.</div> --}}


                    </div>
                    <div class="text-center sm:text-right sm:ml-auto">
                        <div class="text-base text-slate-500">Total Amount</div>
                        <div class="text-xl text-primary font-medium mt-2">$35</div>
                        <div class="mt-1">All Internal Charges Included</div>
                    </div>
                </div>
            @else
                <div class="px-5 sm:px-20 pb-10 sm:pb-20 flex flex-col-reverse sm:flex-row">
                    <form action="" method="post"></form>
                    <div class="text-center sm:text-left mt-10 sm:mt-0">
                        <div class="text-base text-slate-500 mb-3">Already Paid!</div>
                    </div>
                </div>
            @endif
        </div>
        <!-- END: Invoice -->


    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk="
        crossorigin="anonymous"></script>
    <script type="text/javascript" src="//cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
    {{-- 
    DEV CLIENT ID 
    AapYCwr7IL6pstdnEZ8a8Ugv_WMX3qBJflHAfrlFwye5D-7oB22i8Nrky2_AwRLLLTayYkhWS21uKygn
    PROD CLIENT ID
    Aa2jPGWCMLpswVVeE7IuImi64-45_hAD-gmbh7UY5KhmIUA2CAkaScbXWYjoTPNJiAzQWj_ya7wZNC6s
    --}}
    <script
        src="https://www.paypal.com/sdk/js?client-id=AapYCwr7IL6pstdnEZ8a8Ugv_WMX3qBJflHAfrlFwye5D-7oB22i8Nrky2_AwRLLLTayYkhWS21uKygn&disable-funding=credit&components=buttons">
    </script>
    {{-- TODO: CHANGE Client id --}}

    {{-- <script
    src="https://www.paypal.com/sdk/js?client-id=AapYCwr7IL6pstdnEZ8a8Ugv_WMX3qBJflHAfrlFwye5D-7oB22i8Nrky2_AwRLLLTayYkhWS21uKygn&components=buttons">
</script> --}}

    <script>
        amount = 35;
        order = 4
        order_id = <?php echo json_encode($order->id); ?>;

        console.log(amount);

        paypal.Buttons({
            // Sets up the transaction when a payment button is clicked
            createOrder: (data, actions) => {
                return actions.order.create({
                    purchase_units: [{
                        amount: {
                            value: amount // Can also reference a variable or function
                        }
                    }]
                });
            },
            // Finalize the transaction after payer approval
            onApprove: (data, actions) => {

                return actions.order.capture().then(function(orderData) {
                    // Successful capture! For dev/demo purposes:
                    console.log('Capture result', orderData, JSON.stringify(orderData, null, 2));
                    const transaction = orderData.purchase_units[0].payments.captures[0];


                    alert('Thank you for the payment! Your order is now being processed.');
                    // When ready to go live, remove the alert and show a success message within this page. For example:
                    // const element = document.getElementById('paypal-button-container');
                    // element.innerHTML = '<h3>Thank you for your payment!</h3>';
                    actions.redirect("{{ route('thankyou', $order->id) }}");

                });
            }
        }).render('#paypal-button-container');
    </script>
@endsection
