<?php

namespace App\Http\Controllers;

use App\Enums\ContractorOrderEnum;
use App\Enums\TranslationStatusEnum;
use App\Mail\EmailContractor;
use App\Mail\InformContractorOfRequest;
use App\Mail\InstituteAccepted;
use App\Mail\InstituteDeclined;
use App\Mail\invoiceSent;
use App\Mail\LatePaymentApproved;
use App\Mail\LatePaymentRejected;
use App\Mail\mailOfCompletion;
use App\Mail\mailToProofReader;
use App\Mail\NotifiyInstituteAdminMail;
use App\Mail\orderToTranslator;
use App\Mail\paymentApproved;
use App\Mail\paymentRejected;
use App\Mail\QuoteSent;
use App\Models\Contractor;
use App\Models\ContractorOrder;
use App\Models\Institute;
use App\Models\InstituteMembers;
use App\Models\ProofReaderOrders;
use Barryvdh\DomPDF\Facade as PDF;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\CompletedRequest;
use App\Models\ContactAdmin;
use App\Models\ContractorInterpretation;
use App\Models\ContractorLanguage;
use App\Models\Feedback;
use App\Models\FreeQuote;
use App\Models\Interpretation;
use App\Models\Invoice;
use App\Models\Order;
use App\Models\OrderFiles;
use App\Models\ProofRequest;
use App\Models\TemporaryFile;
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

    public function viewAssignContractor($orderID)
    {
        $order = Order::find($orderID);
        $contractors = Contractor::all();
        return view('admin.assign-translator', compact('order', 'contractors'));
    }

    public function viewEditOrder($orderID)
    {
        $order = Order::find($orderID);
        $contractors = Contractor::all();
        return view('admin.edit-order', compact('order', 'contractors'));
    }

    public function deleteInterpretation($id)
    {
        $interpretation = Interpretation::find($id);

        if ($interpretation) {
            $interpretation->delete();
            return redirect()->back()->with('success', 'Interpretation deleted successfully.');
        }

        return redirect()->back()->with('error', 'Interpretation not found.');
    }

    public function editOrder(Request $request)
    {
        $order = Order::find($request->input('order_id'));
        $order->worknumber = $request->input('worknumber');
        $order->language1 = $request->input('language1');
        $order->language2 = $request->input('language2');
        $order->casemanager = $request->input('casemanager');
        $order->amount = $request->input('amount');
        $order->orderStatus = $request->input('orderStatus');
        $order->save();

        return redirect()->route('admin.dashboard');
    }

    public function viewContractor($id)
    {
        //fetch the contractor from this id
        $contractor = Contractor::find($id);
        $languages = ContractorLanguage::where('contractor_id', $contractor->id)->distinct()->get();
        return view('admin.view-contractor-info', compact('contractor', 'languages'));
    }

    public function editInterpretation($id)
    {
        $interpretation = Interpretation::find($id);

        if ($interpretation) {
            return view('admin.editInterpretation', ['interpretation' => $interpretation]);
        }

        return redirect()->back()->with('error', 'Interpretation not found.');
    }

    public function updateInterpretation(Request $request, $id)
    {
        $interpretation = Interpretation::find($id);

        if ($interpretation) {
            // Validation can be added as per your requirements.
            $interpretation->update($request->all());
            return redirect()->route('admin.ongoingInterpretations')->with('success', 'Interpretation updated successfully.');
        }

        return redirect()->route('admin.ongoingInterpretations')->with('error', 'Interpretation not found.');
    }

    public function updateContractor(Request $request)
    {
        $id = $request->input('contractor_id');
        $contractor = Contractor::findOrFail($id);

        // Update basic fields
        $contractor->name = $request->input('name');
        $contractor->phonenumber = $request->input('phonenumber');
        $contractor->address = $request->input('address');
        $contractor->email = $request->input('email');

        $contractor->interpretation_rate = $request->input('interpretation_rate');
        $contractor->translation_rate = $request->input('translation_rate');
        $contractor->proofreader_rate = $request->input('proofreader_rate');

        // Update password if provided
        $password = $request->input('password');
        if (!empty($password)) {
            $contractor->password = bcrypt($password);
        }

        // Save the contractor
        $contractor->save();

        // Delete previous translator languages
        $contractor->languages()->where('is_translator', 1)->delete();

        // Insert new translator languages
        $translatorLanguages = $request->input('translator_languages', []);
        foreach ($translatorLanguages as $language) {
            $contractor->languages()->create([
                'language' => $language,
                'is_translator' => 1,
            ]);
        }

        // Delete previous interpreter languages
        $contractor->languages()->where('is_interpreter', 1)->delete();

        // Insert new interpreter languages
        $interpreterLanguages = $request->input('interpreter_languages', []);
        foreach ($interpreterLanguages as $language) {
            $contractor->languages()->create([
                'language' => $language,
                'is_interpreter' => 1,
            ]);
        }

        // Delete previous proofreader languages
        $contractor->languages()->where('is_proofreader', 1)->delete();

        // Insert new proofreader languages
        $proofreaderLanguages = $request->input('proofreader_languages', []);
        foreach ($proofreaderLanguages as $language) {
            $contractor->languages()->create([
                'language' => $language,
                'is_proofreader' => 1,
            ]);
        }

        // Redirect or return a response
        return redirect()->back()->with('success', 'Contractor updated successfully.');
    }

    public function viewInstituteAdminPending()
    {
        $institute = Institute::all();
        // dd($institute[0]->admin);
        return view('admin.institute-admin-list', compact('institute'));
    }

    public function acceptInstituteAdmin($id)
    {
        $institute = Institute::find($id);
        $institute_member = new InstituteMembers();
        // Check if institute exists
        if ($institute) {
            // Update the is_active field
            $institute->is_active = 1;
            $institute->save();

            // Get the user from the managed_by field
            $user = User::find($institute->managed_by);

            // Check if user exists
            if ($user) {
                // Attach the user to the institute in the pivot table
                $institute_member->user_id = $institute->managed_by;
                $institute_member->institute_id = $institute->id;
                $institute_member->save();


                // Send email to the user and authenticated user
                Mail::to($user->email)->send(new InstituteAccepted($user, $institute));

                return back()->with('success', 'Success.');
            } else {
                // Handle situation where user doesn't exist
            }
        } else {
            // Handle situation where institute doesn't exist
        }
    }

    public function declineInstituteAdmin($id)
    {
        $institute = Institute::find($id);

        if ($institute) {
            $user = User::find($institute->managed_by);

            if ($user) {
                Mail::to($user->email)->send(new InstituteDeclined($user, $institute));
            }

            $institute->delete();

            return back()->with('success', 'Institute declined successfully.');
        } else {
            // Handle situation where institute doesn't exist
        }
    }

    public function deleteInstitute($id)
    {
        $institute = Institute::find($id);

        if ($institute) {
            // Fetch the institute members
            $instituteMembers = $institute->members;

            // Set all member's role_id to 0
            foreach ($instituteMembers as $member) {
                $user = User::find($member->user_id);
                if ($user) {
                    $user->role_id = 0;
                    $user->save();
                }
            }

            // Delete rows from pivot table
            $institute->members()->detach();

            // Delete the institute
            $institute->delete();

            return back()->with('success', 'Institute deleted successfully.');
        } else {
            // Handle situation where institute doesn't exist
        }
    }


    public function deleteContractor($id)
    {
        // Find the contractor by its ID
        $contractor = Contractor::find($id);

        // If contractor exists
        if ($contractor) {
            // Delete the contractor
            $contractor->delete();

            // Redirect to the previous page with success message
            return back()->with('success', 'Contractor deleted successfully.');
        }

        // If contractor does not exist, redirect back with an error message
        return back()->with('error', 'Contractor not found.');
    }

    public function editContractor($id)
    {
        // Find the contractor by its ID
        $contractor = Contractor::find($id);
        $languages = ContractorLanguage::where('contractor_id', $id)->distinct()->get();

        // dd($languages);

        // If contractor exists
        if ($contractor) {
            // Return the edit contractor view with the contractor
            return view('admin.editContractor', compact('contractor', 'languages'));
        }

        // If contractor does not exist, redirect back with an error message
        return back()->with('error', 'Contractor not found.');
    }

    public function viewContractors()
    {
        $contractors = Contractor::with('languages')->get();

        return view('admin.viewContractors', compact('contractors'));
    }

    public function viewUser($id)
    {
        $user = User::findOrFail($id);

        // Pass $user to your viewUser view
        return view('admin.viewUser', ['user' => $user]);
    }

    public function editUser($id)
    {
        $user = User::findOrFail($id);

        // Pass $user to your editUser view
        return view('admin.editUser', ['user' => $user]);
    }

    public function updateUser(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $user->name = $request->input('name');
        $user->email = $request->input('email');

        $user->save();

        return redirect()->route('admin.viewCustomers');
    }


    public function deleteUser($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        // Redirect back to the users list with a success message
        return redirect()->route('admin.users')->with('message', 'User deleted successfully');
    }


    public function viewCustomers()
    {
        $users = User::all();

        return view('admin.viewCustomers', compact('users'));
    }

    public function viewAssignInterpreter($interpreterID)
    {
        $interpretation = Interpretation::find($interpreterID);
        $contractors = Contractor::all();
        // dd($interpretation);
        return view('admin.assign-interpreter', compact('interpretation', 'contractors'));
    }

    public function viewReAssignInterpreter($interpreterID)
    {
        $interpretation = Interpretation::find($interpreterID);
        $contractors = Contractor::all();
        // dd($interpretation);
        return view('admin.re-assign-interpreter', compact('interpretation', 'contractors'));
    }
    public function assignInterpreter(Request $request)
    {
        // First check if a record already exists for the given interpretation and contractor
        $existingAssignment = ContractorInterpretation::where('interpretation_id', $request->interpretation_id)
            ->first();

        // If it exists, delete it
        if ($existingAssignment) {
            $existingAssignment->delete();
        }

        $contractorInterpretation = new ContractorInterpretation();
        $contractorInterpretation->contractor_id = $request->contractor_id;
        $contractorInterpretation->interpretation_id = $request->interpretation_id;
        $contractorInterpretation->is_accepted = 0;
        $contractorInterpretation->description = $request->description;
        $contractorInterpretation->per_hour_rate = $request->per_hour_rate;
        $contractorInterpretation->estimated_payment = $request->estimated_payment;

        $contractorInterpretation->save();

        $contractor = $contractorInterpretation->contractor;

        Mail::to($contractor->email)->send(new InformContractorOfRequest($contractorInterpretation));

        return redirect()->route('admin.ongoingInterpretations')->with('success', 'Interpretation assigned successfully!');
    }

    public function getContractorRate(Request $request)
    {
        $contractor = Contractor::find($request->id);
        return response()->json(['interpretation_rate' => $contractor->interpretation_rate]);
    }

    public function getTranslatorRate(Request $request)
    {
        if (isset($request->id) && $request->id != null) {
            $contractor = Contractor::find($request->id);
            return response()->json(['translation_rate' => $contractor->translation_rate]);
        } else {
            return response()->json(['translation_rate' => 0]);
        }
    }

    public function showSubmitQuote($id)
    {
        $interpretation = Interpretation::findOrFail($id);

        return view('admin.submitQuote', compact('interpretation'));
    }

    public function submitQuote(Request $request)
    {

        $interpretation = Interpretation::find($request->interpretation_id);
        $interpretation->quote_price = $request->quote_price;
        $interpretation->quote_description = $request->quote_description;
        $interpretation->wantQuote = 2;
        $interpretation->save();

        // Send the email to the user
        Mail::to($interpretation->user->email)->send(new QuoteSent($interpretation));

        return redirect()->route('admin.ongoingInterpretations')->with('message', 'Quote has been sent successfully');
    }



    public function assignContractor(Request $request)
    {
        // dd($request->input('description'));
        // dd($request->input('amount'));
        $contractorOrder = ContractorOrder::create([
            'order_id' => $request->order_id,
            'contractor_id' => $request->contractor_id,
            'is_accepted' => ContractorOrderEnum::PENDING,
            'total_words' => $request->total_words,
            'total_payment' => $request->total_payment,
            'rate' => $request->rate
        ]);
        $order = Order::find($request->order_id);
        $order->translation_sent = 1;
        $order->save();
        $contractorOrder->save();
        // $data = $request->all();
        $contractor = Contractor::where('id', $contractorOrder['contractor_id'])->firstOrFail();
        Mail::to($contractor->email)->send(new EmailContractor($contractorOrder));
        return redirect()->route('admin.dashboard');
    }

    public function pendingOrders()
    {
        $orders = Order::with(['contractorOrder.contractor'])
            ->orderByDesc('created_at')
            ->where('orderStatus', '!=', 'Cancelled')
            ->get();
        // dd($orders);
        return view('admin.pendingOrders', compact('orders'));
    }

    public function viewAssignProofReader($orderID)
    {
        $order = Order::find($orderID);
        $contractors = Contractor::all();
        return view('admin.assign-proof-reader', compact('order', 'contractors'));
    }

    public function assignProofReader(Request $request)
    {
        $existingAssignment = ProofReaderOrders::where('order_id', $request->order_id)
            ->first();
        // If it exists, delete it
        if ($existingAssignment) {
            $existingAssignment->delete();
        }
        $contractor_order_id = ContractorOrder::where('order_id', $request->order_id)->where('is_accepted', 1)->first();
        // dd($contractor_order_id);
        $proofReaderOrder = ProofReaderOrders::create([
            'order_id' => $request->order_id,
            'contractor_id' => $request->contractor_id,
            'is_accepted' => ContractorOrderEnum::PENDING,
            'rate' => $request->rate,
            'total_payment' => $request->total_payment,
            'translation_status' => TranslationStatusEnum::PENDING,
            'contractor_order_id' => $contractor_order_id->id
        ]);
        $order = Order::find($request->order_id);

        $order->proofread_sent = 1; //change status to 1 *asigned
        $order->save();
        // $proofReaderOrder->save();
        $contractor = Contractor::where('id', $proofReaderOrder['contractor_id'])->firstOrFail();

        Mail::to($contractor->email)->send(new mailToProofReader($order, $proofReaderOrder, 'New Request! | Proof Read ', "webpage@flowtranslate.com"));
        return redirect()->route('admin.pending');
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

    public function downloadTranslationFile($id)
    {
        //select only file_name;
        $filePath = '/translations_by_contractors/' . ContractorOrder::where(['order_id' => $id])->firstOrFail()->file_name;
        $file = "";
        // $file = public_path() . '/uploads/' . $filePath;
        // dd($filePath, file_exists($filePath));
        if (public_path() . file_exists($filePath)) {
            $file = public_path($filePath);
        }
        $zip = new ZipArchive;
        $zipName = date('YmdHi') . $id . '.zip';

        if ($zip->open(public_path('compressed/' . $zipName), ZipArchive::CREATE) === TRUE) {
            $relativeNameInZipFile = basename($file);
            // dd($file, $relativeNameInZipFile);
            $zip->addFile($file, $relativeNameInZipFile);

            $zip->close();
        }
        return response()->download($file);
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

        $order->orderStatus = 'Cancelled';
        $order->save();
        // $order->delete();

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

    public function downloadProofreadFile($id)
    {
        //select only file_name;
        $filePath = '/proofread_by_proofreader/' . ProofReaderOrders::where(['order_id' => $id])->firstOrFail()->file_name;
        $file = "";

        if (public_path() . file_exists($filePath)) {
            $file = public_path($filePath);
        }
        $zip = new ZipArchive;
        $zipName = date('YmdHi') . $id . '.zip';

        if ($zip->open(public_path('compressed/' . $zipName), ZipArchive::CREATE) === TRUE) {
            $relativeNameInZipFile = basename($file);
            // dd($file, $relativeNameInZipFile);
            $zip->addFile($file, $relativeNameInZipFile);

            $zip->close();
        }
        return response()->download($file);
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

    public function uploadImage(Request $request)
    {
        if ($request->hasFile('files')) {
            $files = $request->file('files');

            // dd($files);

            foreach ($files as $file) {

                $filename = date('YmdHi') . $file->getClientOriginalName();
                // $folder = uniqid() . '-' . now()->timestamp;
                // $file->move(public_path('documents'), $filename);
                $file->move('documents/', $filename);

                TemporaryFile::create([
                    'filename' => $filename
                ]);

                return $filename;
            }
        }
    }

    // Mail to User for Completion 🙌

    public function sendDocumentsToUser(Request $request)
    {
        // dd($request->input('files'));
        $validated = $request->validate([
            'order_id' => 'required|integer',
            'user_id' => 'required|integer',
            'translation_id' => 'required|integer',
            'proofreader_id' => 'integer',
            'email' => 'email|required',
            'email_title' => 'required',
            'email_body' => 'required'
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

        $order = Order::where('id', $order_id)->first();


        if ($request->input('files')) {

            $files = $request->input('files');

            $fileArr2 = [];

            foreach ($files as $file) {

                $filename = $file;

                // $file->move(public_path('documents'), $filename);
                $fileArr2[] = public_path('documents/' . $filename);
            }

            if ($order->paymentStatus == 2) {
                $pdf = app('dompdf.wrapper');
                $invoice = Invoice::findOrFail($order->invoice->id);
                // dd($invoice);
                $data = [
                    'data' => $invoice
                ];
                // dd($data['data']->description);
                $pdf = $pdf->loadView('pdf.invoice-pdf', $data);
                // dd($pdf);
                $randomDigits = mt_rand(1111, 9999);
                $fileName = "invoice_" . $randomDigits . ".pdf";
                $path = public_path('documents/' . $fileName);
                // $pdf->path_to_pdf = $path;
                $pdf->save($path);


                $fileArr2[] = $path;
            }

            $zip2 = new ZipArchive;

            $zipName2 = 'completed_' . $order_id . '.zip';

            if ($zip2->open(public_path('translated/' . $zipName2), ZipArchive::CREATE) === TRUE) {

                $files = $fileArr2; //passing the above array
                // dd($files);
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

        Order::where('id', $order_id)->update(['orderStatus' => 'Completed']);
        Order::where('id', $order_id)->update(['completed' => 1]);

        Mail::mailer('clients')->to($email)->send(new mailOfCompletion($order, $zipName2, $emailTitle, "info@flowtranslate.com"));

        //Send Invoice

        // $validated = $request->validate([
        //     'description' => 'required|max:255',
        //     'docQuantity' => 'required',
        //     'amount' => 'required|integer',
        //     'user_id' => 'required|integer',
        //     'order_id' => 'required|integer'
        // ]);

        // $id = $request->input('user_id');
        // $order_id = $request->input('order_id');
        // $user = User::find($id);
        // $order = Order::find($order_id);
        // $userMail = $user->email;

        // $doesInvoiceExist = Invoice::where('order_id', $order_id)->get();

        // Mail::mailer('clients')->to($userMail)->send(new invoiceSent($user, $order, $doesInvoiceExist[0], "Flow Translate - New Invoice", "info@flowtranslate.com"));
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

    public function ongoingInterpretations()
    {
        $interpretations = Interpretation::orderByDesc('created_at')->where('interpreter_completed', '=', 0)->get();
        return view('admin.ongoingInterpretations', compact('interpretations'));
    }

    public function viewCompletedInterpretations()
    {
        $interpretations = Interpretation::orderByDesc('created_at')->where('interpreter_completed', '=', 1)->get();
        return view('admin.completedInterpretations', compact('interpretations'));
    }
}
