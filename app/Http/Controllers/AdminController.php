<?php

namespace App\Http\Controllers;

use App\Mail\mailOfCompletion;
use App\Mail\mailToProofReader;
use App\Mail\orderToTranslator;
use App\Mail\paymentApproved;
use App\Mail\paymentRejected;
use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\CompletedRequest;
use App\Models\ContactAdmin;
use App\Models\Feedback;
use App\Models\FreeQuote;
use App\Models\Invoice;
use App\Models\Order;
use App\Models\OrderFiles;
use App\Models\ProofRequest;
use App\Models\TranslationRequest;
use Illuminate\Support\Facades\Mail;

use App\Models\User;
use File;
use ZipArchive;

class AdminController extends Controller
{
    public function index()
    {
        $orders = Order::all();
        $users = User::all();
        $unsent = count(Order::where(['invoiceSent' => 0])->get());
        $paymentPending = count(Order::where(['paymentStatus' => 0])->get());

        $invoices = Order::withSum('invoice','amount')->get();

        $sumAmount = 0;
        foreach($invoices as $invoice) {
            $sumAmount += $invoice->invoice_sum_amount;
        }

        return view('admin.dashboard', compact('orders','users', 'unsent', 'paymentPending', 'sumAmount'));
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

    public function downloadTranslatedFiles($id)
    {
        $order = Order::where('id',$id)->first();
        $order_id = $order->id;

        $completedRequest = CompletedRequest::where('order_id',$order_id)->first();

        $orderFiles = $completedRequest->completed_file;
       
        return response()->download(public_path('translated/' . $orderFiles));
    }

    public function downloadEvidence($id)
    {
        $order = Order::where('id',$id)->first();
        $order_id = $order->id;
        $filename = $order->filename;
       
        return response()->download(public_path('compressed/' . $filename));
    }

    public function approveEvidence($id) {

        $order = Order::where('id', $id)->first();
        $order->update(['evidence_accepted' => 1]);
        $order->update(['paymentStatus' => 1]);
        $order->update(['orderStatus' => 'Translation Pending']);


        Mail::to($order->user->email)->send(new paymentApproved());

        return redirect()->route('admin.pending');

    }


    public function rejectEvidence($id) {

        $order = Order::where('id', $id)->first();
        $order->update(['evidence_accepted' => 0]);
        $order->update(['is_evidence' => 0]);
        $order->update(['paymentStatus' => 0]);
        $order->update(['orderStatus' => 'Payment Pending']);

        Mail::to($order->user->email)->send(new paymentRejected());


        return redirect()->route('admin.pending');

    }

    public function destroy($id)
    {
        $order = Order::findOrFail($id);

        if (!empty($order->files)) {
            OrderFiles::where('order_id', $order->id)->delete();
        }

        if (!empty($order->invoice)) {
            Invoice::where('order_id', $order->id)->delete();
        }

        if ($order->translation_status == 1) {
            TranslationRequest::where('order_id', $order->id)->delete();
        }

        if ($order->proofread_status == 1) {
            ProofRequest::where('order_id', $order->id)->delete();
        }

        if ($order->completed == 1) {
            CompletedRequest::where('order_id', $order->id)->delete();
        }


        $order->delete();

        return redirect()->route('admin.dashboard');
    }

    public function mailToTranslator($id)
    {
        $order = Order::where('id',$id)->first();

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

        $order_id = $request->input('order_id');
        $email = $request->input('translator_email');
    

        $check = TranslationRequest::where([
            'order_id' => $order_id,
            'translator_email' => $email
        ]);

        if ($check->exists()) {
            $check->delete();
        }

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
        return redirect()->route('admin.pending');


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

    public function showTranslationRequests() {
        $translationRequests = TranslationRequest::all();

        return view('admin.showTransRequests', compact('translationRequests'));
    }

    public function showProofReadRequests() {
        $proofReadRequests = ProofRequest::all();

        return view('admin.showProofRequests', compact('proofReadRequests'));
    }

    public function changeTranslationRequestStatus($id) {
        $findRequest = TranslationRequest::where('order_id',$id)->first();
        $findOrder = Order::findOrFail($id);

        if ($findOrder->translation_status == 0) {
            $findOrder->update(['translation_status' => 1]);
        } else {
            $findOrder->update(['translation_status' => 0]);
        }

        if ($findRequest->translation_status == 0) {
            $findRequest->update(['translation_status' => 1]);
        } else {
            $findRequest->update(['translation_status' => 0]);
        }
        return redirect()->route('showTranslationRequests');

    }

    public function changeProofReadRequestStatus($id) {
        $ProofRequest = ProofRequest::where('order_id',$id)->first();
        $findOrder = Order::where('id',$id)->first();

        if ($findOrder->proofread_status == 0) {
            $findOrder->update(['proofread_status' => 1]);
        } else {
            $findOrder->update(['proofread_status' => 0]);
        }

        if ($ProofRequest->proofread_status == 0) {
            $ProofRequest->update(['proofread_status' => 1]);
        } else {
            $ProofRequest->update(['proofread_status' => 0]);
        }
        return redirect()->route('showProofReadRequests');
    }

    public function mailToProofReader($id) {
        $order = Order::where('id',$id)->first();

        return view('admin.mailToProofReader', compact('order'));
    }


    // Sending To Proofreader
    public function sendDocumentsToProofReader(Request $request) {
        $validated = $request->validate([
            'order_id' => 'required|integer',
            'proofreader_email' => 'email|required',
            'email_title' => 'required',
            'email_body' => 'required',
            'files' => 'required',
            'files.*' => 'mimes:docx,doc,png,jpg,pdf,txt'
        ]);

        $order_id = $request->input('order_id');
        $email = $request->input('proofreader_email');
    

        $check = ProofRequest::where([
            'order_id' => $order_id,
            'proofreader_email' => $email
        ]);

        if ($check->exists()) {
            $check->delete();
        }
        
        if ($request->hasFile('files')) {

            $files = $request->file('files');

            // dd($files);

            $fileArr2 = [];

            foreach ($files as $file) {

                $filename = date('YmdHi') . $file->getClientOriginalName();

                $file->move(public_path('documents'), $filename);
                $fileArr2[] = public_path('documents/' . $filename);
                
            }

            $zip2 = new ZipArchive;

            $zipName2 = 'prooffiles' . $order_id . '.zip';

            if ($zip2->open(public_path('compressed/' . $zipName2), ZipArchive::CREATE) === TRUE) {

                $files = $fileArr2; //passing the above array
    
                foreach ($files as $key => $value) {
                    $relativeNameInZipFile = basename($value);
                    // dd($relativeNameInZipFile);
                    $zip2->addFile($value, $relativeNameInZipFile);
                }
    
                $zip2->close();
            }
        }

        $validated['translated_files'] = $zipName2;

        $proofReaderRequest = ProofRequest::create($validated);

        $proofReaderEmail = $proofReaderRequest->proofreader_email;
        $order_id = $proofReaderRequest->order_id;

        $order = Order::where('id',$order_id)->first();

        

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

        Order::where('id', $order_id)->update(['orderStatus' => 'Sent to ProofReader']);

        Mail::to($proofReaderEmail)->send(new mailToProofReader($order, $zipName, $zipName2));
        return redirect()->route('showTranslationRequests');

    }


    public function viewCompletedOrders() {
        $orders = Order::where('completed',1)->get();

        return view('admin.completedOrders', compact('orders'));
    }

    public function mailOfCompletion($id) {
        $order = Order::where('id', $id)->first();

        return view('admin.sendMailOfCompletion', compact('order'));
    }

    // Mail to User for Completion 🙌

    public function sendDocumentsToUser(Request $request) {

        $validated = $request->validate([
            'order_id' => 'required|integer',
            'user_id' => 'required|integer',
            'translation_id' => 'required|integer',
            'proofreader_id' => 'required|integer',
            'email' => 'email|required',
            'email_title' => 'required',
            'email_body' => 'required',
            'files' => 'required',
            'files.*' => 'mimes:docx,doc,png,jpg,pdf,txt'
        ]);

        $order_id = $request->input('order_id');
        $email = $request->input('email');
    

        $check = CompletedRequest::where([
            'order_id' => $order_id,
            'email' => $email
        ]);

        if ($check->exists()) {
            $check->delete();
        }
        
        if ($request->hasFile('files')) {

            $files = $request->file('files');

            $fileArr2 = [];

            foreach ($files as $file) {

                $filename = date('YmdHi') . $file->getClientOriginalName();

                $file->move(public_path('documents'), $filename);
                $fileArr2[] = public_path('documents/' . $filename);
                
            }

            $zip2 = new ZipArchive;

            $zipName2 = 'completed_' . $order_id . '.zip';

            if ($zip2->open(public_path('translated/' . $zipName2), ZipArchive::CREATE) === TRUE) {

                $files = $fileArr2; //passing the above array
    
                foreach ($files as $key => $value) {
                    $relativeNameInZipFile = basename($value);
                    // dd($relativeNameInZipFile);
                    $zip2->addFile($value, $relativeNameInZipFile);
                }
    
                $zip2->close();
            }
        }

        $validated['completed_file'] = $zipName2;

        $completedRequest = CompletedRequest::create($validated);

        $order = Order::where('id',$order_id)->first();

        Order::where('id', $order_id)->update(['orderStatus' => 'Completed']);
        Order::where('id', $order_id)->update(['completed' => 1]);


        Mail::to($email)->send(new mailOfCompletion($order, $zipName2));
        return redirect()->route('completedOrders');
    }

    public function viewQuoteRequests() {
        $quotes = FreeQuote::all();

        return view('admin.viewQuoteRequests', compact('quotes'));
    }

    public function viewFeedback() {
        $feedbacks = Feedback::all();

        return view('admin.viewFeedback',compact('feedbacks'));
    }

    public function viewMessages() {
        $messages = ContactAdmin::all();

        return view('admin.viewMessages',compact('messages'));
    }

}
