<?php

namespace App\Http\Controllers;

use App\Mail\orderToTranslator;
use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\Order;
use App\Models\OrderFiles;
use App\Models\TranslationRequest;
use Illuminate\Support\Facades\Mail;

use App\Models\User;
use File;
use ZipArchive;

class AdminController extends Controller
{
    public function index()
    {
        return view('admin.dashboard');
    }

    public function pendingOrders()
    {
        $orders = Order::all();
        return view('admin.pendingOrders', compact('orders'));
    }

    public function paidOrders()
    {
        $orders = Order::where(['paymentStatus' => 1])->get();
        return view('admin.paidOrders', compact('orders'));
    }

    public function downloadFiles(Order $order)
    {
        $orderFiles = $order->files;
        $fileArr = [];

        foreach ($orderFiles as $orderFile) {
            if (file_exists(public_path('documents/' . $orderFile->filename))) {
                $fileArr[] = public_path('documents/' . $orderFile->filename);
            }
        }

        $zip = new ZipArchive;

        $zipName = date('YmdHi') . $order->id . '.zip';
        // dd($zip->open(public_path($zipName), ZipArchive::CREATE) === TRUE);
        if ($zip->open(public_path('compressed/' . $zipName), ZipArchive::CREATE) === TRUE) {

            $files = $fileArr; //passing the above array

            foreach ($files as $key => $value) {
                $relativeNameInZipFile = basename($value);
                // dd($relativeNameInZipFile);
                $zip->addFile($value, $relativeNameInZipFile);
            }

            $zip->close();
        }

        return response()->download(public_path('compressed/' . $zipName));
    }

    public function destroy($id)
    {
        $order = Order::findOrFail($id);

        if (!empty($order->files)) {
            OrderFiles::where('order_id', $order->id)->delete();
        }
        $order->delete();

        return redirect()->route('admin.dashboard');
    }

    public function mailToTranslator($id)
    {
        $order = Order::findOrFail($id);

        return view('admin.mailToTranslator', compact('order'));
    }

    public function sendDocumentsToTranslator(Request $request)
    {
        $validated = $request->validate([
            'order_id' => 'required|integer',
            'translator_email' => 'email|required',
            'email_title' => 'required',
            'email_body' => 'required',
        ]);

        $translationRequest = TranslationRequest::create($validated);

        $translatorEmail = $translationRequest->translator_email;
        $order_id = $translationRequest->order_id;

        $order = Order::findOrFail($order_id);

        $orderFiles = $order->files;

        $fileArr = [];

        foreach ($orderFiles as $orderFile) {
            if (file_exists(public_path('documents/' . $orderFile->filename))) {
                $fileArr[] = public_path('documents/' . $orderFile->filename);
            }
        }

        $zip = new ZipArchive;

        $zipName = date('YmdHi') . $order->id . '.zip';
        // dd($zip->open(public_path($zipName), ZipArchive::CREATE) === TRUE);
        if ($zip->open(public_path('compressed/' . $zipName), ZipArchive::CREATE) === TRUE) {

            $files = $fileArr; //passing the above array

            foreach ($files as $key => $value) {
                $relativeNameInZipFile = basename($value);
                // dd($relativeNameInZipFile);
                $zip->addFile($value, $relativeNameInZipFile);
            }

            $zip->close();
        }

        Order::where('id', $order_id)->update(['orderStatus' => 'Sent to Translator']);

        Mail::to($translatorEmail)->send(new orderToTranslator($order, $zipName));
        return redirect()->route('admin.paidOrders');


        // $id = $request->input('user_id');
        // $order_id = $request->input('order_id');
        // $user = User::find($id);
        // $order = Order::find($order_id);
        // $userMail = $user->email;

        // $doesInvoiceExist = Invoice::where('user_id', $id)->where('order_id', $order_id);

        // if (empty($doesInvoiceExist)) {
        //     $invoice = Invoice::create($validated);

        //     $id = $request->input('user_id');
        //     $order_id = $request->input('order_id');
        //     $user = User::find($id);
        //     $order = Order::find($order_id);
        //     Order::where('id', $order_id)->update(['invoiceSent' => 1]);
        //     $userMail = $user->email;

        //     Mail::to($userMail)->send(new invoiceSent($user, $order, $invoice));
        //     return redirect()->route('invoice.index');
        // } else {
        //     return redirect()->route('invoice.index')->with('message', 'Invoice already exists for this order!');
        // }
    }
}
