<?php

namespace App\Http\Controllers;

use App\Mail\invoiceSent;
use App\Mail\LatePaymentApproved;
use App\Mail\LatePaymentRejected;
use App\Mail\mailOfCompletion;
use App\Mail\mailToProofReader;
use App\Mail\orderToTranslator;
use App\Mail\paymentApproved;
use App\Mail\paymentRejected;
use Barryvdh\DomPDF\Facade as PDF;
use Carbon\Carbon;
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

        $invoices = Order::withSum('invoice', 'amount')->get();

        $sumAmount = 0;
        foreach ($invoices as $invoice) {
            $sumAmount += $invoice->invoice_sum_amount;
        }

        return view('admin.dashboard', compact('orders', 'users', 'unsent', 'paymentPending', 'sumAmount'));
    }

    public function pendingOrders()
    {
        $orders = Order::orderByDesc('created_at')->get();
        return view('admin.pendingOrders', compact('orders'));
    }

    public function paidOrders()
    {
        $orders = Order::where(['paymentStatus' => 1])->get();
        return view('admin.paidOrders', compact('orders'));
    }

    public function deleteAllQuotes()
    {
        $allQuotes = FreeQuote::all();

        if (empty($allQuotes)) {
            return redirect()->back();
        } else {
            FreeQuote::truncate();
            return redirect()->back();
        }
    }

    public function deleteAllContacts()
    {
        $contacts = ContactAdmin::all();

        if (empty($contacts)) {
            return redirect()->back();
        } else {
            ContactAdmin::truncate();
            return redirect()->back();
        }
    }


    public function manageLatePay(Request $request)
    {
        $id = $request->order_id;
        $choice = $request->choice;

        $order = Order::find($id);

        // dd($order->user);

        if ($choice == 1) {
            $order->update(['paymentStatus' => 2, 'orderStatus' => 'Translation Pending', 'paymentLaterApproved' => 1]);
            // Mail::to($order->user->email)->send(new LatePaymentApproved());
            Mail::mailer('clients')->to($order->user->email)->send(new LatePaymentApproved("Flow Translate - Late Payment Approved", "info@flowtranslate.com"));

            return redirect()->back();
        } else if ($choice == 0) {
            $order->update(['paymentStatus' => 0, 'orderStatus' => 'Payment Pending', 'paymentLaterApproved' => 0]);

            Mail::mailer('clients')->to($order->user->email)->send(new LatePaymentRejected("Flow Translate - Late Payment Approved", "info@flowtranslate.com"));
        }
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
        $order = Order::where('id', $id)->first();
        $order_id = $order->id;

        $completedRequest = CompletedRequest::where('order_id', $order_id)->first();

        $orderFiles = $completedRequest->completed_file;

        return response()->download(public_path('translated/' . $orderFiles));
    }

    public function downloadEvidence($id)
    {
        $order = Order::where('id', $id)->first();
        $order_id = $order->id;
        $filename = $order->filename;

        return response()->download(public_path('compressed/' . $filename));
    }

    public function approveEvidence($id)
    {

        $order = Order::where('id', $id)->first();
        $order->update(['evidence_accepted' => 1]);
        $order->update(['paymentStatus' => 1]);
        $order->update(['orderStatus' => 'Translation Pending']);


        // Mail::to($order->user->email)->send(new paymentApproved());
        Mail::mailer('clients')->to($order->user->email)->send(new paymentApproved("Flow Translate - Payment Approved", "info@flowtranslate.com"));

        return redirect()->route('admin.pending');
    }


    public function rejectEvidence($id)
    {

        $order = Order::where('id', $id)->first();
        $order->update(['evidence_accepted' => 0]);
        $order->update(['is_evidence' => 0]);
        $order->update(['paymentStatus' => 0]);
        $order->update(['orderStatus' => 'Payment Pending']);

        // Mail::to($order->user->email)->send(new paymentRejected());
        Mail::mailer('clients')->to($order->user->email)->send(new paymentRejected("Flow Translate - Payment Rejected", "info@flowtranslate.com"));


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

        if ($order->translation_status == 1 || $order->translation_sent == 1) {
            TranslationRequest::where('order_id', $order->id)->delete();
        }

        if ($order->proofread_status == 1 || $order->proofread_sent == 1) {
            ProofRequest::where('order_id', $order->id)->delete();
        }

        if ($order->completed == 1) {
            CompletedRequest::where('order_id', $order->id)->delete();
        }

        if (!empty($order->feedback)) {
            Feedback::where('order_id', $order->id)->delete();
        }

        $order->delete();

        return redirect()->back();
    }

    public function mailToTranslator($id)
    {
        $order = Order::where('id', $id)->first();

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
        $emailTitle = $request->input('email_title');

        $check = TranslationRequest::where([
            'order_id' => $order_id
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
        // dd($emailTitle);
        Order::where('id', $order_id)->update(['orderStatus' => 'Sent to Translator', 'translation_sent' => 1]);

        Mail::mailer('webpage')->to($translatorEmail)->send(new orderToTranslator($order, $zipName, $emailTitle, "webpage@flowtranslate.com"));

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

    public function showTranslationRequests()
    {
        $translationRequests = TranslationRequest::orderByDesc('created_at')->get();

        return view('admin.showTransRequests', compact('translationRequests'));
    }

    public function showProofReadRequests()
    {
        $proofReadRequests = ProofRequest::orderByDesc('created_at')->get();

        return view('admin.showProofRequests', compact('proofReadRequests'));
    }

    public function changeTranslationRequestStatus($id)
    {
        $findRequest = TranslationRequest::where('order_id', $id)->first();
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

    public function changeProofReadRequestStatus($id)
    {
        $ProofRequest = ProofRequest::where('order_id', $id)->first();
        $findOrder = Order::where('id', $id)->first();

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

    public function mailToProofReader($id)
    {
        $order = Order::where('id', $id)->first();

        return view('admin.mailToProofReader', compact('order'));
    }


    // Sending To Proofreader
    public function sendDocumentsToProofReader(Request $request)
    {
        // dd($request);
        $validated = $request->validate([
            'order_id' => 'integer',
            'proofreader_email' => 'email',
            'email_title' => 'string',
            'email_body' => 'string'
        ]);

        $order_id = $request->input('order_id');
        $email = $request->input('proofreader_email');
        $emailTitle = $request->input('email_title');

        $check = ProofRequest::where([
            'order_id' => $order_id
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

        $order = Order::where('id', $order_id)->first();



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

        Order::where('id', $order_id)->update(['orderStatus' => 'Sent to ProofReader', 'proofread_sent' => 1]);
        Mail::mailer('webpage')->to($proofReaderEmail)->send(new mailToProofReader($order, $zipName, $zipName2, $emailTitle, "webpage@flowtranslate.com"));

        // Mail::to($proofReaderEmail)->send(new mailToProofReader($order, $zipName, $zipName2));
        return redirect()->route('showTranslationRequests');
    }


    public function viewCompletedOrders()
    {
        $orders = Order::where('completed', 1)->get();

        return view('admin.completedOrders', compact('orders'));
    }

    public function mailOfCompletion($id)
    {
        $order = Order::where('id', $id)->first();

        return view('admin.sendMailOfCompletion', compact('order'));
    }

    // Mail to User for Completion 🙌

    public function sendDocumentsToUser(Request $request)
    {

        $validated = $request->validate([
            'order_id' => 'required|integer',
            'user_id' => 'required|integer',
            'translation_id' => 'required|integer',
            'proofreader_id' => 'integer',
            'email' => 'email|required',
            'email_title' => 'required',
            'email_body' => 'required',
            'files' => 'required',
            'files.*' => 'mimes:docx,doc,png,jpg,pdf,txt'
        ]);

        $order_id = $request->input('order_id');
        $email = $request->input('email');
        $emailTitle = $request->input('email_title');

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

        $order = Order::where('id', $order_id)->first();

        Order::where('id', $order_id)->update(['orderStatus' => 'Completed']);
        Order::where('id', $order_id)->update(['completed' => 1]);

        Mail::mailer('clients')->to($email)->send(new mailOfCompletion($order, $zipName2, $emailTitle, "info@flowtranslate.com"));

        //Send Invoice

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

        $doesInvoiceExist = Invoice::where('order_id', $order_id)->get();

        Mail::mailer('clients')->to($userMail)->send(new invoiceSent($user, $order, $doesInvoiceExist[0], "Flow Translate - New Invoice", "info@flowtranslate.com"));
        // Mail::to($email)->send(new mailOfCompletion($order, $zipName2));
        return redirect()->route('completedOrders');
    }

    public function generatePDFInvoice($invoiceID)
    {
        $users = User::get();
        $pdf = app('dompdf.wrapper');
        $invoice = Invoice::findOrFail($invoiceID);
        $data = [
            'data' => $invoice
        ];
        // dd($data['data']->description);
        $pdf = $pdf->loadView('pdf.invoice-pdf', $data);
        $fileName = "invoice_" . Carbon::now() . ".pdf";
        return $pdf->download($fileName);
    }

    public function viewQuoteRequests()
    {
        $quotes = FreeQuote::all();

        return view('admin.viewQuoteRequests', compact('quotes'));
    }

    public function viewFeedback()
    {
        $feedbacks = Feedback::all();

        return view('admin.viewFeedback', compact('feedbacks'));
    }

    public function viewMessages()
    {
        $messages = ContactAdmin::all();

        return view('admin.viewMessages', compact('messages'));
    }
}
