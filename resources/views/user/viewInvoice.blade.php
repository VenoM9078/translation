@extends('user.layout')

@section('content')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.css"/>

<div class="col-span-12 mt-8">
    <div class="intro-y flex items-center h-10">
        <h2 class="text-lg font-medium truncate mr-5 mb-5">
            Viewing Invoice for Worknumber: {{ $invoice->order->worknumber }}
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
                        <span class="w-5 h-5 flex items-center justify-center"> <i class="w-4 h-4" data-lucide="plus"></i> </span>
                    </button>
                    <div class="dropdown-menu w-40">
                        <div class="dropdown-content">
                            <a href="" class="dropdown-item"> <i data-lucide="file" class="w-4 h-4 mr-2"></i> Export Word </a>
                            <a href="" class="dropdown-item"> <i data-lucide="file" class="w-4 h-4 mr-2"></i> Export PDF </a>
                        </div>
                    </div>
                </div>
            </div>
        </div> --}}
        <!-- BEGIN: Invoice -->
        <div class="intro-y box overflow-hidden mt-5">
            <div class="flex flex-col lg:flex-row pt-10 px-5 sm:px-20 sm:pt-20 lg:pb-20 text-center sm:text-left">
                <div class="font-semibold text-primary text-3xl">INVOICE</div>
                <div class="mt-20 lg:mt-0 lg:ml-auto lg:text-right">
                    <div class="text-xl text-primary font-medium">FlowTranslate</div>
                    <div class="mt-1">info@flowtranslate.com</div>
                    <div class="mt-1">650-229-4621</div>
                </div>
            </div>
            <div class="flex flex-col lg:flex-row border-b px-5 sm:px-20 pt-10 pb-10 sm:pb-20 text-center sm:text-left">
                <div>
                    <div class="text-base text-slate-500">Client Details</div>
                    <div class="text-lg font-medium text-primary mt-2">{{ $invoice->order->user->name }}</div>
                    <div class="mt-1">{{ $invoice->order->user->email }}</div>
                </div>
                <div class="mt-10 lg:mt-0 lg:ml-auto lg:text-right">
                    <div class="text-base text-slate-500">Created At</div>
                    {{ $amount = $invoice->amount }}
                       {{$orderWork = $invoice->order->worknumber }} 
                    
                    <div class="text-lg text-primary font-medium mt-2">{{ $invoice->created_at }}</div>
                </div>
            </div>
            <div class="px-5 sm:px-16 py-10 sm:py-20">
                <div class="overflow-x-auto">
                    <table class="table">
                        <thead>
                            <tr>
                                <th class="border-b-2 dark:border-darkmode-400 whitespace-nowrap">DESCRIPTION</th>
                                <th class="border-b-2 dark:border-darkmode-400 text-right whitespace-nowrap">PAGES</th>
                                <th class="border-b-2 dark:border-darkmode-400 text-right whitespace-nowrap">PRICE</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="border-b dark:border-darkmode-400">
                                    <div class="font-medium whitespace-nowrap">{{ $invoice->description}} </div>
                                    <div class="text-slate-500 text-sm mt-0.5 whitespace-nowrap">Languages: {{ $invoice->order->language1 }}, {{ $invoice->order->language2 }}</div>
                                </td>
                                <td class="text-right border-b dark:border-darkmode-400 w-32">{{ $invoice->docQuantity }}</td>
                                <td class="text-right border-b dark:border-darkmode-400 w-32">${{ $invoice->amount }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            @if ($invoice->order->paymentStatus == 0)
        
            <div class="px-5 sm:px-20 pb-10 sm:pb-20 flex flex-col-reverse sm:flex-row">
                <form action="" method="post"></form>
                <div class="text-center sm:text-left mt-10 sm:mt-0">
                    <div class="text-base text-slate-500 mb-3">Choose Payment Method</div>
                    <div id="paypal-button-container"></div>
                </div>
                <div class="text-center sm:text-right sm:ml-auto">
                    <div class="text-base text-slate-500">Total Amount</div>
                    <div class="text-xl text-primary font-medium mt-2">${{ $invoice->amount }}</div>
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
<script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous" ></script>
<script type="text/javascript" src="//cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
<script src="https://www.paypal.com/sdk/js?client-id=AelIqxA4G5IZP9g1te3EnFyeBn4QNgRJOfhLQZ6Kl0JT5SJzsE1g0rsZgK_VLsujCZQ3_YZvdeocwplq&components=buttons"></script>
<script>

    amount = <?php echo json_encode($amount); ?>;
    order = <?php echo json_encode($orderWork); ?>;
    order_id = <?php echo json_encode($invoice->order_id); ?>;

    console.log(amount);

    paypal.Buttons({
        // Sets up the transaction when a payment button is clicked
        createOrder: (data, actions) => {
          return actions.order.create({
            purchase_units: [{
              amount: {
                value: `${amount}` // Can also reference a variable or function
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

           
            alert(`Transaction ${order}: ${transaction.id}\n\nSee console for all available details`);
            // When ready to go live, remove the alert and show a success message within this page. For example:
            // const element = document.getElementById('paypal-button-container');
            // element.innerHTML = '<h3>Thank you for your payment!</h3>';
            console.log({{ $invoice->order_id }})
           actions.redirect("{{ route('thankyou', $invoice->order_id) }}");

           
            
          });
        }
      }).render('#paypal-button-container');
</script>
@endsection