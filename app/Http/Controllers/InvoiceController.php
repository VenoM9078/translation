<?php

namespace App\Http\Controllers;

use App\Mail\invoiceSent;
use App\Models\Invoice;
use App\Models\Order;
use App\Models\User;
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
            'docQuantity' => 'required|integer',
            'amount' => 'required|integer',
            'user_id' => 'required|integer',
            'order_id' => 'required|integer'
        ]);

        $id = $request->input('user_id');
        $order_id = $request->input('order_id');
        $user = User::find($id);
        $order = Order::find($order_id);
        $userMail = $user->email;

        $doesInvoiceExist = Invoice::where('user_id', $id)->where('order_id', $order_id);

        if (empty($doesInvoiceExist)) {
            $invoice = Invoice::create($validated);

            $id = $request->input('user_id');
            $order_id = $request->input('order_id');
            $user = User::find($id);
            $order = Order::find($order_id);
            Order::where('id', $order_id)->update(['invoiceSent' => 1]);
            $userMail = $user->email;

            Mail::to($userMail)->send(new invoiceSent($user, $order, $invoice));
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
        //
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
        //
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

        $invoice->delete();

        return redirect()->route('invoice.index')->with('message', 'Invoice deleted!');
    }
}
