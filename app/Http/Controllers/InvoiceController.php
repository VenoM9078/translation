<?php

namespace App\Http\Controllers;

use App\Enums\LogActionsEnum;
use App\Helpers\HelperClass;
use App\Mail\invoiceSent;
use App\Models\Invoice;
use App\Models\Order;
use App\Models\User;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $invoices = Invoice::all();

        return view('admin.invoices', compact('invoices'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    public function customInvoice($id)
    {
        $order = Order::findOrFail($id);
        // $order = $order::with('user')->get();

        if ($order) {
            return view('admin.createInvoice', compact('order'));
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'description' => 'required|max:255',
            'docQuantity' => 'required',
            'amount' => 'required|integer',
            'user_id' => 'required|integer',
            'order_id' => 'required|integer'
        ]);

        $id = $request->input('user_id');
        $order_id = $request->input('order_id');
        $user = User::find($id);
        $order = Order::find($order_id);
        $userMail = $user->email;

        $doesInvoiceExist = Invoice::where('order_id', $order_id)->exists();

        if (empty($doesInvoiceExist)) {
            $invoice = Invoice::create($validated);

            $id = $request->input('user_id');
            $order_id = $request->input('order_id');
            $user = User::find($id);
            $order = Order::find($order_id);
            Order::where('id', $order_id)->update(['invoiceSent' => 1]);
            Order::where('id', $order_id)->update(['orderStatus' => 'Payment Pending']);
            Order::where('id', $order_id)->update(['amount' => $invoice->amount]);
            $userMail = $user->email;

            HelperClass::storeInvoiceLogs(Auth::user()->id, LogActionsEnum::ISADMIN, $order_id, "Invoice", "Admin", LogActionsEnum::INVOICESENT, LogActionsEnum::INVOICESENTNUMBER, null);

            if(env("IS_DEV") == 1){
                Mail::mailer('dev')->to($userMail)->send(new invoiceSent($user, $order, $invoice, "Flow Translate - New Invoice", env("ADMIN_EMAIL_DEV")));
            } else {
                Mail::mailer('clients')->to($userMail)->send(new invoiceSent($user, $order, $invoice, "Flow Translate - New Invoice", env("ADMIN_EMAIL")));
            }

            // Mail::to($userMail)->send(new invoiceSent($user, $order, $invoice));
            return redirect()->route('invoice.index');
        } else {
            return redirect()->route('invoice.index')->with('message', 'Invoice already exists for this order!');
        }
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $invoice = Invoice::findOrFail($id);

        return view('admin.editinvoice', compact('invoice'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $invoice = Invoice::findOrFail($id);

        $invoice->update($request->all());

        return redirect()->route('invoice.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $invoice = Invoice::findOrFail($id);

        $order = $invoice->order;

        $order->update(['invoiceSent' => 0]);

        $invoice->delete();

        return redirect()->route('invoice.index')->with('message', 'Invoice deleted!');
    }
}