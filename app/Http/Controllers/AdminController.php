<?php

namespace App\Http\Controllers;

use App\Enums\ContractorOrderEnum;
use App\Enums\LogActionsEnum;
use App\Enums\OrderStatusEnum;
use App\Enums\TranslationStatusEnum;
use App\Helpers\HelperClass;
use App\Mail\AdminNewInterpretation;
use App\Mail\adminOrderCreated;
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
use App\Mail\OrderCreated;
use App\Mail\OrderQuoteSent;
use App\Mail\orderToTranslator;
use App\Mail\paymentApproved;
use App\Mail\paymentRejected;
use App\Mail\QuoteSent;
use App\Mail\UserNewInterpretation;
use App\Mail\VerifyContractorMail;
use App\Models\Contractor;
use App\Models\ContractorOrder;
use App\Models\Institute;
use App\Models\InstituteMembers;
use App\Models\ProofReaderOrders;
use App\Models\VerifyContractor;
use Auth;
use Barryvdh\DomPDF\Facade as PDF;
use Carbon\Carbon;
use Illuminate\Auth\Events\Registered;
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
use Illuminate\Support\Facades\Hash;
use Nette\Utils\Paginator;
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
        // dd($order);
        $contractors = Contractor::all();
        return view('admin.edit-order', compact('order', 'contractors'));
    }

    public function submitTranslationFile(Request $request)
    {
        $uploadedFilePath = $request->input('translationFile');
        if (!$request->input('translationFile')) {
            return back()->with('message', 'Upload File!');
        }
        $existingTranslation = ContractorOrder::where('order_id', $request->order_id)->first();
        if ($existingTranslation) {
            $existingTranslation->file_name = $uploadedFilePath;
            $existingTranslation->save();
            HelperClass::storeContractorLog(
                Auth::user()->id,
                LogActionsEnum::ISADMIN,
                $existingTranslation->order_id,
                $existingTranslation->contractor_id,
                "Admin",
                0,
                "Translator",
                LogActionsEnum::UPLOADTRANSLATION,
                LogActionsEnum::ZEROTRANSLATIONSTATUS,
                LogActionsEnum::ZEROTRANSLATIONSTATUS,
                1,
                LogActionsEnum::ZEROTRANSLATIONSTATUS
            );

            return redirect()->route('admin.pending', ['page' => session('page'), 'limit' => session('limit')]);
        } else {

            $contractorOrder = new ContractorOrder();
            $contractorOrder->file_name = $uploadedFilePath;
            $contractorOrder->added_by_admin = 1;
            $contractorOrder->contractor_id = -1;
            $contractorOrder->total_payment = -1;
            $contractorOrder->is_accepted = 0;
            $contractorOrder->total_words = 0;
            $contractorOrder->rate = 0;
            $contractorOrder->order_id = $request->order_id;
            // $contractorOrder
            // dd($contractorOrder);
            // dd($contractorOrder);
            $contractorOrder->save();
            // $request->session()->forget('uploaded_translation_file');

            //fetch order with the order_id, then update the orders table column translationStatus to 1
            // $order = Order::find($contractorOrder->order_id);
            // $old_translation_status = $order->translation_status;
            // $order->translation_status = 1;
            // $order->save();

            HelperClass::storeContractorLog(
                Auth::user()->id,
                LogActionsEnum::ISADMIN,
                $contractorOrder->order_id,
                -1,
                "Admin",
                0,
                "Translator",
                LogActionsEnum::UPLOADTRANSLATION,
                LogActionsEnum::ZEROTRANSLATIONSTATUS,
                LogActionsEnum::ZEROTRANSLATIONSTATUS,
                1,
                LogActionsEnum::ZEROTRANSLATIONSTATUS
            );

            // $contractorName = Auth::guard('contractor')->user()->name;
            // $admins = Admin::all(['email']);
            // foreach ($admins as $admin) {
            // Mail::to($admin->email)->send(new NotifyAdminTranslationSubmissionContractor($contractorName, $contractorOrder, $order));
            // }
            return redirect()->route('admin.pending', ['page' => session('page'), 'limit' => session('limit')]);
        }
    }


    public function showProofReadPage($id)
    {
        $order = Order::where('id', $id)->first();
        return view('admin.submit-proof-read', compact('order'));
    }

    public function submitProofRead(Request $request)
    {

        if (!$request->proofReadFile) {
            return back()->with('message', 'Upload File!');
        }
        $proofReaderOrders = ProofReaderOrders::find($request->order_id);
        // dd($request->all());
        // dd($proofReaderOrders);
        if ($proofReaderOrders) {

            $proofReaderOrders->translation_status = TranslationStatusEnum::ACCEPTED; //completed
            $proofReaderOrders->file_name = $request->proofReadFile;
            $proofReaderOrders->feedback = $request->feedback;
            $proofReaderOrders->proof_read_due_date = Carbon::now()->addDays(7);
            $proofReaderOrders->save();

            $order = $proofReaderOrders->order;
            $order->proofread_status = OrderStatusEnum::COMPLETED;
            // $order->completed = OrderStatusEnum::COMPLETED;
            // $order->orderStatus = "Completed";
            $order->save();
            HelperClass::storeContractorLog(
                Auth::user()->id,
                LogActionsEnum::ISADMIN,
                $request->order_id,
                $proofReaderOrders->contractor_id,
                "Contractor",
                0,
                "Proof Reader",
                LogActionsEnum::UPLOADPROOFREAD,
                0,
                0,
                1,
                0,
                1 //Completed Proof Read Status
            );
        } else {
            $proofReaderOrders = new ProofReaderOrders();
            $proofReaderOrders->added_by_admin = 1;
            $proofReaderOrders->file_name = $request->proofReadFile;
            $proofReaderOrders->contractor_order_id = -1;
            $proofReaderOrders->contractor_id = -1;
            $proofReaderOrders->rate = 0;
            $proofReaderOrders->total_payment = 0;
            $proofReaderOrders->translation_status = TranslationStatusEnum::ACCEPTED; //completed
            $proofReaderOrders->message = $request->feedback;
            $proofReaderOrders->order_id = $request->order_id;
            $proofReaderOrders->save();

            $order = Order::where('id', $request->order_id)->first();
            $order->proofread_status = OrderStatusEnum::COMPLETED;
            $order->save();

            HelperClass::storeContractorLog(
                Auth::user()->id,
                LogActionsEnum::ISADMIN,
                $request->order_id,
                -1,
                "Contractor",
                0,
                "Proof Reader",
                LogActionsEnum::UPLOADPROOFREAD,
                0,
                0,
                1,
                0,
                1 //Completed Proof Read Status
            );
        }

        // $contractor = $proofReaderOrders->contractor;
        // $contractorName = $contractor->name;
        return redirect()->route('admin.pending', ['page' => session('page'), 'limit' => session('limit')]);

        // $admin = User::where('role', 'admin')->first();

        // Mail::to($admin->email)->send(new NotifyAdminProofReadSubmissionContractor($contractorName, $contractorOrder));

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
        // dd($request->order_id);
        $order = Order::where('id', $request->order_id)->first();
        // $order->worknumber = $order->worknumber;
        // dd($order);
        // dd($request->input('language1'));
        $order->language1 = $request->input('language1');
        $order->language2 = $request->input('language2');
        // $order->casemanager = $request->input('casemanager');
        // $order->amount = $request->input('amount');
        // $order->orderStatus = $request->input('orderStatus');

        $order->due_date = $request->input('due_date');
        // new fields
        $order->c_type = $request->input('c_type');
        $order->c_unit = $request->input('c_unit');
        $order->c_rate = $request->input('c_rate');
        $order->c_adjust = $request->input('c_adjust');
        $order->c_fee = $request->input('c_fee');
        $order->unit = $request->input('unit');
        $order->c_adjust_note = $request->input('c_adjust_note');
        $order->c_paid = $request->input('c_paid');
        $order->due_date = Carbon::now()->addDays(7);
        $order->save();
        // dd($order);

        return redirect()->route('admin.pending', ['page' => session('page'), 'limit' => session('limit')]);
    }

    public function viewContractor($id)
    {
        //fetch the contractor from this id
        $contractor = Contractor::find($id);
        $languages = ContractorLanguage::where('contractor_id', $contractor->id)->distinct()->get();
        return view('admin.view-contractor-info', compact('contractor', 'languages'));
    }

    public function viewInterpretationDetails($id)
    {
        $interpretation = Interpretation::where('id', $id)->firstOrFail();
        return view('admin.view-interpretation', compact('interpretation'));
    }

    public function copyInterpretationDetails($id)
    {
        $interpretation = Interpretation::where('id', $id)->firstOrFail();
        return view('admin.copy-interpretation', compact('interpretation'));
    }
    public function editInterpretation($id)
    {
        $interpretation = Interpretation::find($id);

        if ($interpretation) {
            return view('admin.editInterpretation', ['interpretation' => $interpretation]);
        }

        return redirect()->back()->with('error', 'Interpretation not found.');
    }

    public function assignProofReadTranslator($order)
    {
        $order = Order::find($order);
        $contractors = Contractor::all();
        $cOrder = ContractorOrder::where('order_id', $order->id)->first();
        // dd($cOrder);

        if (!isset($cOrder)) {
            $cOrder = ContractorOrder::emptyModel();
        }
        $pOrder = ProofReaderOrders::where('order_id', $order->id)->first();
        if (!isset($pOrder)) {
            $pOrder = ProofReaderOrders::emptyModel();
        }
        // dd($contractorOrder);
        return view('admin.assign-proofreader-translator', compact('order', 'contractors', 'cOrder', 'pOrder'));
    }

    public function uploadProofFile(Request $request)
    {
        if ($request->hasFile('proofReadFile')) {
            $file = $request->file('proofReadFile');
            $filePath = 'proofread_by_proofreader/';
            $filename = date('YmdHi') . $file->getClientOriginalName();

            if (!file_exists(public_path($filePath))) {
                mkdir(public_path($filePath), 0777, true);
            }

            $file->move($filePath, $filename);

            TemporaryFile::create([
                'filename' => $filename
            ]);

            return $filename;
        }

        return null;
    }

    public function uploadQuote(Request $request)
    {
        $filename = '';
        if ($request->hasFile('quoteFile')) {
            $file = $request->file('quoteFile');
            $filePath = 'quote-files/';

            // dd($file);

            $filename = date('YmdHi') . $file->getClientOriginalName();
            // $folder = uniqid() . '-' . now()->timestamp;
            // $file->move(public_path('documents'), $filename);
            //if the path does not exist, create it

            if (!file_exists(public_path($filePath))) {
                mkdir(public_path($filePath), 0777, true);
                $file->move($filePath, $filename);
            } else {
                $file->move($filePath, $filename);
            }

            TemporaryFile::create([
                'filename' => $filename
            ]);
        }

        return $filename;
    }
    public function uploadTranslationFile(Request $request)
    {
        $filename = '';
        if ($request->hasFile('translationFile')) {
            $file = $request->file('translationFile');
            $filePath = 'translations_by_contractors/';

            // dd($file);

            $filename = date('YmdHi') . $file->getClientOriginalName();
            // $folder = uniqid() . '-' . now()->timestamp;
            // $file->move(public_path('documents'), $filename);
            //if the path does not exist, create it

            if (!file_exists(public_path($filePath))) {
                mkdir(public_path($filePath), 0777, true);
                $file->move($filePath, $filename);
            } else {
                $file->move($filePath, $filename);
            }

            TemporaryFile::create([
                'filename' => $filename
            ]);
        }

        return $filename;
        // return response()->json(['filename' => $filename], 200);

    }


    public function submitAssignProofReadTranslator(Request $request)
    {

        // dd($request->all());
        if ($request->contractor_id) {
            $previousContractorOrder = ContractorOrder::where('order_id', $request->order_id)->select('contractor_id')->first();
            $contractorOrder = ContractorOrder::updateOrCreate(
                ['order_id' => $request->order_id],
                [
                    'order_id' => $request->order_id,
                    'contractor_id' => $request->contractor_id,
                    'is_accepted' => ContractorOrderEnum::PENDING,
                    'translator_adjust_note' => $request->translator_adjust_note,
                    'translator_paid' => $request->translator_paid,
                    'translation_type' => $request->translation_type,
                    'total_words' => $request->total_words,
                    'total_payment' => $request->total_payment,
                    'rate' => $request->rate,
                    'translation_due_date' => $request->translation_due_date,
                    'translator_unit' => $request->t_unit,
                    'message' => $request->message,
                    'translator_adjust' => $request->t_adjust
                ]
            );

            // Update translator default rate
            $translator = Contractor::where('id', $request->contractor_id)->first();
            $translator->translation_rate = $request->rate;
            $translator->save();

            $order = Order::find($request->order_id);
            $order->translation_sent = 1;
            $order->save();

            if (!isset($previousContractorOrder) || $previousContractorOrder->contractor_id != $request->contractor_id) {

                HelperClass::storeContractorLog(
                    Auth::user()->id,
                    LogActionsEnum::ISADMIN,
                    $order->id,
                    $request->contractor_id,
                    "Contractor",
                    "Admin",
                    "Translator",
                    LogActionsEnum::ASSIGNEDTRANSLATOR,
                    0,
                    1,
                    0
                );
                // $contractorOrder->save();
                $contractor = Contractor::where('id', $request->contractor_id)->firstOrFail();
                Mail::to($contractor->email)->send(new EmailContractor($contractorOrder));
            }
        }
        //Proof Read Assignment

        if ($request->p_contractor_id) {
            if (!$request->proofReadFile) {
                $proof_read_file = '';
            } else {
                $proof_read_file = $request->proofReadFile;
            }
            $previousProofReaderOrder = ProofReaderOrders::where('order_id', $request->order_id)->select('contractor_id')->first();
            $proofReaderOrder = ProofReaderOrders::updateOrCreate(
                ['order_id' => $request->order_id],
                // Search array
                [
                    // Update or create array
                    'contractor_order_id' => $contractorOrder->id ?? -1,
                    'contractor_id' => $request->p_contractor_id,
                    'is_accepted' => ContractorOrderEnum::PENDING,
                    'rate' => $request->p_rate ?? 0,
                    'total_payment' => $request->p_total_payment ?? 0,
                    'translation_status' => TranslationStatusEnum::PENDING,
                    'file_name' => $request->translationFile,
                    'file_uploaded_by_admin' => $request->translationFile,
                    'proof_read_due_date' => $request->proof_read_due_date,
                    'proofread_type' => $request->p_type,
                    'proof_read_paid' => $request->proof_read_paid,
                    'p_adjust' => $request->p_adjust,
                    'proof_read_adjust_note' => $request->p_adjust_note,
                    'p_unit' => $request->p_unit,
                    'message' => $request->p_message
                ]
            );
            // Update proofreader default rate
            $proofReader = Contractor::where('id',$request->p_contractor_id)->first();
            $proofReader->proofreader_rate = $request->p_rate;
            $proofReader->save();
            $order = Order::find($request->order_id);

            $order->proofread_sent = 1; //change status to 1 *asigned
            $order->save();
            if (!isset($previousProofReaderOrder) || $previousProofReaderOrder->contractor_id != $request->p_contractor_id) {

                HelperClass::storeContractorLog(
                    Auth::user()->id,
                    LogActionsEnum::ISADMIN,
                    $order->id,
                    $request->p_contractor_id,
                    "Contractor",
                    0,
                    "Proof Reader",
                    LogActionsEnum::ASSIGNEDPROOFREADER,
                    0,
                    0,
                    0,
                    0,
                    1
                );
                $contractor = Contractor::where('id', $request->p_contractor_id)->firstOrFail();
                if (env("IS_DEV") == 1) {
                    Mail::to($contractor->email)->send(new mailToProofReader($order, $proofReaderOrder, 'New Request! | Proof Read ', env("ADMIN_EMAIL_DEV")));
                } else {
                    Mail::to($contractor->email)->send(new mailToProofReader($order, $proofReaderOrder, 'New Request! | Proof Read ', env("ADMIN_EMAIL")));
                }
            }
        }
        return redirect()->back()->with('message', 'Assigned Successfully!');
    }

    public function trackOrder($id)
    {
        $order = Order::findOrFail($id);
        return view('utils.track-order', ['order' => $order]);
    }

    public function trackInterpretation($id)
    {
        $interpretation = Interpretation::findOrFail($id);
        return view('utils.track-interpretation', ['interpretation' => $interpretation]);
    }
    public function updateInterpretation(Request $request, $id)
    {
        $interpretation = Interpretation::find($id);
        $oldInt = $interpretation;
        if ($interpretation) {
            // Validation can be added as per your requirements.
            if ($request->input('is_reminder_on') == "1") {
                $request['is_reminder_on'] = 1;
            } elseif ($request->input('is_reminder_on') == "0") {
                $request['is_reminder_on'] = 0;
            }
            $int = $interpretation->update($request->all());
            $contractorInterpretation = $interpretation->contractorInterpretation;
            if (isset($contractorInterpretation)) {
                $contractorInterpretation->estimated_payment = $request->estimated_interpretation_rate;
                $contractorInterpretation->estimated_payment = $request->interpretation_rate;
                $contractorInterpretation->save();
            }
            // dd($oldInt,$interpretation);
            return redirect()->route('admin.ongoingInterpretations', ['page' => session('page'), 'limit' => session('limit')])->with('success', 'Interpretation updated successfully.');
        }

        return redirect()->route('admin.ongoingInterpretations',['page' => session('page'), 'limit' => session('limit')])->with('error', 'Interpretation not found.');
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
                $user->role_id = 2;
                $user->save();
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

    public function newTranslationOrder()
    {
        return view('admin.newOrder');
    }

    public function newInterpretation()
    {
        return view('admin.newInterpretation');
    }

    public function submitNewInterpretation(Request $request)
    {
        date_default_timezone_set('America/Los_Angeles'); // Set timezone to PST

        // Get the latest worknumber from the Interpretation model
        $latestWorkNumber = Interpretation::latest('worknumber')->first();

        $currentTime = date('ymdHis'); // YYMMDDHHMMSS format
        if (isset($latestWorkNumber->worknumber)) {
            $latestWorkNumber = $latestWorkNumber->worknumber;
            while ($latestWorkNumber == $currentTime) {
                // Delay by 1 second if the current time is equal to the latest work order
                sleep(1);
                $currentTime = date('ymdHis');
            }
        } else {
            $latestWorkNumber = "";
            $currentTime = date('ymdHis');
        }

        $worknumber = $currentTime;

        $vertical_radio_button = $request->input('vertical_radio_button');
        if ($vertical_radio_button == "vertical-radio-existing") {
            $verifyUser = User::where('email', $request->input('email_existing'))->first();
        } else {
            $verifyUser = User::where('email', $request->input('email'))->first();
        }

        $user = null;
        if (!isset($verifyUser)) {
            // Create a new user
            $newUser = User::create([
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'password' => Hash::make('password'), // Hash password for security
            ]);
            $user = $newUser;
        } else {
            $user = $verifyUser;
        }


        $interpretation = new Interpretation();
        $interpretation->worknumber = $worknumber;

        $interpretation->user_id = $user->id; // Add the newly created user's ID
        $interpretation->language = $request->language;
        $interpretation->interpretationDate = $request->interpretationDate;
        $interpretation->start_time = $request->start_time;
        $interpretation->end_time = $request->end_time;
        $interpretation->session_format = $request->session_format;
        if (isset($request->link)) {
            $interpretation->location = $request->link;
        } else if (isset($request->address)) {
            $interpretation->location = $request->address;
        } else {
            $interpretation->location = null;
        }
        $interpretation->session_topics = $request->session_topics;
        $interpretation->wantQuote = 0; // As per your requirement
        $interpretation->added_by_institute_user = 1; // As per your requirement
        $interpretation->invoiceSent = 1; // As per your requirement
        $interpretation->paymentStatus = 1; // As per your requirement
        $interpretation->message = $request->message;

        $interpretation->save();

        //storing interpretation
        HelperClass::storeOrderLog(
            LogActionsEnum::ISADMIN,
            Auth::user()->id,
            null,
            "Interpretation",
            "Admin",
            LogActionsEnum::CREATEDINTERPRETATION,
            LogActionsEnum::ZEROTRANSLATIONSTATUS,
            LogActionsEnum::ZEROTRANSLATIONSTATUS,
            LogActionsEnum::PAYMENTINCOMPLETEDNUMBER,
            LogActionsEnum::PAIDINTERPRETATION,
            LogActionsEnum::ZEROTRANSLATIONSTATUS,
            LogActionsEnum::ZEROTRANSLATIONSTATUS,
            0,
            0,
            0,
            0,
            LogActionsEnum::ISINTERPRETATION,
            LogActionsEnum::INCOMPLETEINTERPRETATION,
            $interpretation->id
        );

        //storing interpretation with paid status
        HelperClass::storeOrderLog(
            LogActionsEnum::ISADMIN,
            Auth::user()->id,
            null,
            "Interpretation",
            "Admin",
            LogActionsEnum::PAYMENTCOMPLETED,
            LogActionsEnum::ZEROTRANSLATIONSTATUS,
            LogActionsEnum::ZEROTRANSLATIONSTATUS,
            LogActionsEnum::PAYMENTINCOMPLETEDNUMBER,
            LogActionsEnum::PAIDINTERPRETATION,
            LogActionsEnum::ZEROTRANSLATIONSTATUS,
            LogActionsEnum::ZEROTRANSLATIONSTATUS,
            0,
            0,
            0,
            0,
            LogActionsEnum::ISINTERPRETATION,
            LogActionsEnum::INCOMPLETEINTERPRETATION,
            $interpretation->id
        );

        HelperClass::storeContractorLog(
            Auth::user()->id,
            LogActionsEnum::ISADMIN,
            0,
            0,
            "Interpretation",
            "Admin",
            "Interpreter",
            LogActionsEnum::ASSIGNEDINTERPRETER,
            null,
            null,
            0,
            null,
            null,
            0,
            0
        );
        HelperClass::storeInvoiceLogs(Auth::user()->id, LogActionsEnum::ISADMIN, null, "Invoice", "Admin", "Sent Invoice", 1, $interpretation->id);




        if (env("IS_DEV") == 1) {
            Mail::to('webpage@flowtranslate.com')->send(new AdminNewInterpretation($user, $interpretation, "Flow Translate - New Interpretation Request", env("ADMIN_EMAIL_DEV")));
            Mail::to($user->email)->send(new UserNewInterpretation($user, $interpretation, "Flow Translate - Your Interpretation Request", env("ADMIN_EMAIL_DEV")));
        } else {
            Mail::to('webpage@flowtranslate.com')->send(new AdminNewInterpretation($user, $interpretation, "Flow Translate - New Interpretation Request", env("ADMIN_EMAIL")));
            Mail::to($user->email)->send(new UserNewInterpretation($user, $interpretation, "Flow Translate - Your Interpretation Request", env("ADMIN_EMAIL")));
        }
        return redirect()->route('admin.ongoingInterpretations', ['page' => session('page'), 'limit' => session('limit')])
            ->with('message', 'Interpretation request submitted successfully.');
    }


    public function submitNewTranslationOrder(Request $request)
    {
        date_default_timezone_set('America/Los_Angeles'); // Set timezone to PST
        if (!$request->language1 || !$request->language2) {
            return redirect()->back()->with('status', 'Select language');
        }
        // Get the latest worknumber from the Order model
        $latestWorkNumber = Order::latest('worknumber')->first();
        $due_date = Carbon::now()->addDays(7);

        $currentTime = date('ymdHis'); // YYMMDDHHMMSS format
        if (isset($latestWorkNumber->worknumber)) {
            $latestWorkNumber = $latestWorkNumber->worknumber;
            while ($latestWorkNumber == $currentTime) {
                // Delay by 1 second if the current time is equal to the latest work order
                sleep(1);
                $currentTime = date('ymdHis');
            }
        } else {
            $latestWorkNumber = "";
            $currentTime = date('ymdHis');
        }

        $worknumber = $currentTime;
        $vertical_radio_button = $request->input('vertical_radio_button');
        if ($vertical_radio_button == "vertical-radio-existing") {
            $verifyUser = User::where('email', $request->input('email_existing'))->first();
        } else {
            $verifyUser = User::where('email', $request->input('email'))->first();
        }


        $user = null;
        if (!isset($verifyUser)) {

            // Create a new user
            $newUser = User::create([
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'password' => Hash::make('password'), // Hash password for security
            ]);
            $user = $newUser;
        } else {
            $user = $verifyUser;
        }

        // Create a new translation order on behalf of the new user
        $data = [
            'language1' => $request->input('language1'),
            'language2' => $request->input('language2'),
            'user_id' => $user->id,
            'worknumber' => $worknumber,
            'orderStatus' => 'Invoice Sent',
            'added_by_institute_user' => 0,
            'invoiceSent' => 1,
            'paymentStatus' => 1,
            'message' => $request->input('message'),
            'want_quote' => 0,
            'due_date' => $due_date,
            'unit' => $request->input('unit')
        ];

        $order = Order::create($data);

        if ($request->transFiles) {
            $files = $request->transFiles;
            foreach ($files as $file) {
                $filename = $file;
                OrderFiles::create([
                    'order_id' => $order->id,
                    'user_id' => $user->id,
                    'filename' => $filename
                ]);
            }

            HelperClass::storeOrderLog(
                LogActionsEnum::ISADMIN,
                Auth::user()->id,
                $order->id,
                "Order",
                Auth::user()->role_id,
                LogActionsEnum::NEWORDER,
                0,
                0,
                0,
                1,
                0,
                0,
                0,
                0,
                0,
                0
            );

            HelperClass::storeInvoiceLogs(Auth::user()->id, LogActionsEnum::ISADMIN, $order->id, "Invoice", "Admin", LogActionsEnum::INVOICESENT, 1);


            HelperClass::storeOrderLog(
                LogActionsEnum::ISADMIN,
                Auth::user()->id,
                $order->id,
                "Order",
                Auth::user()->role_id,
                LogActionsEnum::PAYMENTCOMPLETED,
                0,
                //old translation
                0, //new translation
                LogActionsEnum::PAYMENTINCOMPLETEDNUMBER,
                LogActionsEnum::PAYMENTCOMPLETEDNUMBER,
                0,
                0,
                0,
                0,
                0,
                0
            );

            if (env("IS_DEV") == 1) {
                Mail::mailer('dev')->to($user->email)->send(new OrderCreated($user, $order, "Flow Translate - Order Created", env("ADMIN_EMAIL_DEV")));
                Mail::mailer('dev')->to(env('ADMIN_EMAIL_DEV'))->send(new adminOrderCreated($user, $order, "Flow Translate - New Order Created", env("ADMIN_EMAIL_DEV")));
            } else {
                Mail::mailer('clients')->to($user->email)->send(new OrderCreated($user, $order, "Flow Translate - Order Created", env("ADMIN_EMAIL")));
                Mail::mailer('clients')->to('webpage@flowtranslate.com')->send(new adminOrderCreated($user, $order, "Flow Translate - New Order Created", env("ADMIN_EMAIL")));
            }

            return redirect()->route('admin.pending', ['page' => session('page'), 'limit' => session('limit')])->with('message', 'Translation Order placed successfully!');
        }

        return redirect()->back()->with('status', 'Attach Files!');
    }

    public function viewRegisterUser()
    {
        return view('admin.register-user');
    }



    public function registerUser(Request $request)
    {

        $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
        ]);

        $user = new User;
        $user->name = $request->name;
        $user->email = $request->email;
        // $user->phone = $request->phone;
        $user->password = bcrypt($request->password);
        $user->role_id = 0;
        $user->save();

        event(new Registered($user));

        return redirect()->route('admin.viewCustomers')->with('success', 'Customer created successfully');
    }

    public function viewRegisterContractor()
    {
        return view('admin.register-contractor');
    }

    public function registerContractor(Request $request)
    {

        $contractor = Contractor::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => bcrypt($request->input('password')),
        ]);

        $verifyContractor = VerifyContractor::create([
            'contractor_id' => $contractor->id,
            'token' => sha1(time())
        ]);

        Mail::to($contractor->email)->send(new VerifyContractorMail($contractor));

        return redirect()->route('admin.viewContractors')->with('success', 'Contractor has been created successfully');
    }

    public function uploadTranslationImage(Request $request)
    {
        if ($request->hasFile('transFiles')) {
            $files = $request->file('transFiles');

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
        return redirect()->route('admin.viewCustomers')->with('message', 'User deleted successfully');
    }


    public function viewCustomers()
    {
        $users = User::orderBy('created_at', 'desc')->paginate(10);
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

        $interpretation = Interpretation::where('id', $request->interpretation_id)->first();
        $interpretation->interpreter_adjust_note = $request->interpreter_adjust_note;
        $interpretation->interpreter_paid = $request->interpreter_paid;

        $interpretation->save();
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

        HelperClass::storeContractorLog(Auth::user()->id, LogActionsEnum::ISADMIN, null, $request->contractor_id, "Interpretation", "Admin", "Interpreter", LogActionsEnum::ASSIGNEDINTERPRETER, 0, 0, 0, 0, 0, 0, 0, $request->interpretation_id);
        $contractor = $contractorInterpretation->contractor;

        Mail::to($contractor->email)->send(new InformContractorOfRequest($contractorInterpretation));

        return redirect()->route('admin.ongoingInterpretations', ['page' => session('page'), 'limit' => session('limit')])->with('success', 'Interpretation assigned successfully!');
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

    public function getProofreaderRate(Request $request)
    {
        if (isset($request->id) && $request->id != null) {
            $contractor = Contractor::find($request->id);
            return response()->json(['proofreader_rate' => $contractor->proofreader_rate]);
        } else {
            return response()->json(['proofreader_rate' => 0]);
        }
    }


    public function showSubmitQuote($id)
    {
        $interpretation = Interpretation::findOrFail($id);

        return view('admin.submitQuote', compact('interpretation'));
    }

    public function showUploadFinalDoc($id)
    {
        $order = Order::where('id', $id)->first();
        return view('admin.final-doc-page', compact('order'));
    }

    public function showOrderSubmitQuote($id)
    {
        $order = Order::findOrFail($id);
        return view('admin.submitOrderQuote', compact('order'));
    }

    public function cancelOrder(Request $request)
    {
        $orderId = $request->input('order_id');

        // Fetch the order using the ID
        $order = Order::find($orderId);

        // Check if the order exists
        if ($order) {
            // Update the is_cancelled column to 1
            $order->is_cancelled = !$order->is_cancelled;
            $order->save();

            HelperClass::storeOrderLog(
                LogActionsEnum::ISADMIN,
                Auth::user()->id,
                $order->id,
                "Order",
                "Admin",
                LogActionsEnum::CANCELLEDORDER,
                LogActionsEnum::ZEROTRANSLATIONSTATUS,
                LogActionsEnum::ZEROTRANSLATIONSTATUS,
                LogActionsEnum::ZEROTRANSLATIONSTATUS,
                LogActionsEnum::ZEROTRANSLATIONSTATUS,
                LogActionsEnum::ZEROTRANSLATIONSTATUS,
                LogActionsEnum::ZEROTRANSLATIONSTATUS,
                LogActionsEnum::ZEROTRANSLATIONSTATUS,
                LogActionsEnum::ZEROTRANSLATIONSTATUS,
                LogActionsEnum::ZEROTRANSLATIONSTATUS,
                LogActionsEnum::ZEROTRANSLATIONSTATUS,
                0,
                0,
                null
            );
            // Redirect back with a success message
            return back()->with('success', 'Order cancelled successfully.');
        }

        // Redirect back with an error message if the order doesn't exist
        return back()->with('error', 'Order not found.');
    }


    public function cancelInterpretation(Request $request)
    {
        $interpretationId = $request->input('interpretation_id');

        // Fetch the interpretation using the ID
        $interpretation = Interpretation::find($interpretationId);

        // Check if the interpretation exists
        if ($interpretation) {
            // Update the is_cancelled column to 1
            $interpretation->is_cancelled = !$interpretation->is_cancelled;
            $interpretation->save();

            HelperClass::storeOrderLog(
                LogActionsEnum::ISADMIN,
                Auth::user()->id,
                null,
                "Interpretation",
                "Admin",
                LogActionsEnum::CANCELLEDINTERPRETATION,
                LogActionsEnum::ZEROTRANSLATIONSTATUS,
                LogActionsEnum::ZEROTRANSLATIONSTATUS,
                LogActionsEnum::ZEROTRANSLATIONSTATUS,
                LogActionsEnum::ZEROTRANSLATIONSTATUS,
                LogActionsEnum::ZEROTRANSLATIONSTATUS,
                LogActionsEnum::ZEROTRANSLATIONSTATUS,
                LogActionsEnum::ZEROTRANSLATIONSTATUS,
                LogActionsEnum::ZEROTRANSLATIONSTATUS,
                LogActionsEnum::ZEROTRANSLATIONSTATUS,
                LogActionsEnum::ZEROTRANSLATIONSTATUS,
                0,
                0,
                $interpretationId
            );
            // Redirect back with a success message
            return back()->with('success', 'Interpretation cancelled successfully.');
        }

        // Redirect back with an error message if the interpretation doesn't exist
        return back()->with('error', 'Interpretation not found.');
    }

    public function submitOrderQuote(Request $request)
    {

        $order = Order::find($request->order_id);
        $order->quote_price = $request->quote_price;
        $order->quote_description = $request->quote_description;
        if ($request->quoteFile) {
            $order->quote_filename = $request->quoteFile;
        }
        $order->is_order_quote_accepted = OrderStatusEnum::QUOTEPENDING;
        $order->save();

        HelperClass::storeOrderLog(
            LogActionsEnum::ISADMIN,
            Auth::user()->id,
            $order->id,
            "Order",
            "Admin",
            LogActionsEnum::QUOTESENT,
            LogActionsEnum::ZEROTRANSLATIONSTATUS,
            LogActionsEnum::ZEROTRANSLATIONSTATUS,
            LogActionsEnum::ZEROTRANSLATIONSTATUS,
            LogActionsEnum::ZEROTRANSLATIONSTATUS,
            LogActionsEnum::ZEROTRANSLATIONSTATUS,
            LogActionsEnum::ZEROTRANSLATIONSTATUS,
            LogActionsEnum::ZEROTRANSLATIONSTATUS,
            LogActionsEnum::ZEROTRANSLATIONSTATUS,
            LogActionsEnum::ZEROTRANSLATIONSTATUS,
            LogActionsEnum::ZEROTRANSLATIONSTATUS,
            0,
            0,
            null
        );
        // Send the email to the user
        Mail::to($order->user->email)->send(new OrderQuoteSent($order));
        return redirect()->route('admin.pending', ['page' => session('page'), 'limit' => session('limit')])->with('message', 'Quote has been sent successfully');
    }


    public function submitQuote(Request $request)
    {

        $interpretation = Interpretation::find($request->interpretation_id);
        $interpretation->quote_price = $request->quote_price;
        $interpretation->quote_description = $request->quote_description;
        if ($request->quoteFile) {
            $interpretation->quote_filename = $request->quoteFile;
        }
        $interpretation->is_quote_pending = OrderStatusEnum::QUOTEPENDING;
        // $interpretation->wantQuote = 2;
        $interpretation->save();

        HelperClass::storeOrderLog(
            LogActionsEnum::ISADMIN,
            Auth::user()->id,
            null,
            "Interpretation",
            "Admin",
            LogActionsEnum::QUOTESENT,
            LogActionsEnum::ZEROTRANSLATIONSTATUS,
            LogActionsEnum::ZEROTRANSLATIONSTATUS,
            LogActionsEnum::ZEROTRANSLATIONSTATUS,
            LogActionsEnum::ZEROTRANSLATIONSTATUS,
            LogActionsEnum::ZEROTRANSLATIONSTATUS,
            LogActionsEnum::ZEROTRANSLATIONSTATUS,
            LogActionsEnum::ZEROTRANSLATIONSTATUS,
            LogActionsEnum::ZEROTRANSLATIONSTATUS,
            LogActionsEnum::ZEROTRANSLATIONSTATUS,
            LogActionsEnum::ZEROTRANSLATIONSTATUS,
            1,
            0,
            $request->interpretation_id
        );
        // Send the email to the user
        Mail::to($interpretation->user->email)->send(new QuoteSent($interpretation));

        return redirect()->route('admin.ongoingInterpretations', ['page' => session('page'), 'limit' => session('limit')])->with('message', 'Quote has been sent successfully');
    }



    public function assignContractor(Request $request)
    {
        // dd($request->input('description'));
        // dd($request->input('amount'));
        $due_date = Carbon::now()->addDays(7);
        $contractorOrder = ContractorOrder::create([
            'order_id' => $request->order_id,
            'contractor_id' => $request->contractor_id,
            'is_accepted' => ContractorOrderEnum::PENDING,
            'total_words' => $request->total_words,
            'total_payment' => $request->total_payment,
            'rate' => $request->rate,
            'translation_due_date' => $due_date,
            'translation_type' => $request->translation_type,
            'message' => $request->message
        ]);
        $order = Order::find($request->order_id);
        $order->translation_sent = 1;
        $order->save();
        $contractorOrder->save();

        HelperClass::storeContractorLog(
            Auth::user()->id,
            LogActionsEnum::ISADMIN,
            $order->id,
            $request->contractor_id,
            "Contractor",
            0,
            "Translator",
            LogActionsEnum::ASSIGNEDTRANSLATOR,
            0,
            1,
            0
        );
        // $data = $request->all();
        $contractor = Contractor::where('id', $contractorOrder['contractor_id'])->firstOrFail();
        Mail::to($contractor->email)->send(new EmailContractor($contractorOrder));
        return redirect()->route('admin.pending', ['page' => session('page'), 'limit' => session('limit')]);
    }

    public function viewInvoice($id)
    {
        $invoice = Invoice::findOrFail($id);
        return view('admin.view-invoice', compact('invoice'));
    }
    public function pendingOrders(Request $request)
    {
        $recordsPerPage = $request->query('limit', 10); // Default to 10 if not provided
        $page = $request->input('page', 1); // Default to 1 if not provided
        $skip = ($page - 1) * $recordsPerPage;

        $pendingOrders = Order::orderByDesc('id')->skip($skip)->paginate($recordsPerPage);
        return view('admin.pendingOrders', compact('pendingOrders', 'recordsPerPage'))->with(['page' => session('page'), 'limit' => session('limit')]);
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
        return redirect()->route('admin.pending', ['page' => session('page'), 'limit' => session('limit')]);
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
            if (env("IS_DEV") == 1) {
                Mail::mailer('dev')->to($order->user->email)->send(new LatePaymentApproved("Flow Translate - Late Payment Approved", env("ADMIN_EMAIL_DEV")));
            } else {
                Mail::mailer('clients')->to($order->user->email)->send(new LatePaymentApproved("Flow Translate - Late Payment Approved", env("ADMIN_EMAIL")));
            }

            HelperClass::storeOrderLog(
                LogActionsEnum::ISADMIN,
                Auth::user()->id,
                $order->id,
                "Order",
                Auth::user()->role_id,
                LogActionsEnum::LATEPAYMENTCOMPLETED,
                0,
                //old translation
                0, //new translation
                LogActionsEnum::PAYMENTINCOMPLETEDNUMBER,
                LogActionsEnum::LATEPAYMENTCOMPLETEDNUMBER,
                0,
                0,
                0,
                0,
                0,
                0
            );

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

    public function downloadInterpretationQuoteFile($id)
    {
        //select only file_name;
        $filePath = '/quote-files/' . Interpretation::where(['id' => $id])->firstOrFail()->quote_filename;
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

    public function downloadQuoteFile($id)
    {
        //select only file_name;
        $filePath = '/quote-files/' . Order::where(['id' => $id])->firstOrFail()->quote_filename;
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
        if (env("IS_DEV") == 1) {
            Mail::mailer('dev')->to($order->user->email)->send(new paymentApproved("Flow Translate - Payment Approved", env("ADMIN_EMAIL_DEV")));
        } else {
            Mail::mailer('clients')->to($order->user->email)->send(new paymentApproved("Flow Translate - Payment Approved", env("ADMIN_EMAIL")));
        }

        return redirect()->route('admin.pending', ['page' => session('page'), 'limit' => session('limit')]);
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


        return redirect()->route('admin.pending', ['page' => session('page'), 'limit' => session('limit')]);
    }

    public function destroy($id)
    {
        $order = Order::findOrFail($id);

        if (!empty($order->files)) {
            OrderFiles::where('order_id', $order->id)->delete();
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

        return redirect()->route('admin.pending', ['page' => session('page'), 'limit' => session('limit')]);


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

        if (file_exists(public_path($filePath))) {
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

    public function showUploadTranslationFile($id)
    {
        $order = Order::where('id', $id)->first();
        return view('admin.submit-translation-file', compact('order'));
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

    public function submitFinalDoc(Request $request)
    {
        $validated = $request->validate([
            'order_id' => 'required|integer',
            'user_id' => 'required|integer',
            'email' => 'email|required'
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
        } else {
            return back()->with('message', 'Upload File!');
        }

        $validated['completed_file'] = $zipName2;
        if (isset($order->contractorOrder) && $order->contractorOrder->contractor_id != -1) {
            $validated['translation_id'] = $order->contractorOrder->contractor_id;
        } else {
            $validated['translation_id'] = -1;
        }
        if (isset($order->proofReaderOrder) && $order->proofReaderOrder->contractor_id != -1) {
            $validated['proofreader_id'] = $order->proofReaderOrder->contractor_id;
        } else {
            $validated['proofreader_id'] = -1;
        }
        $completedRequest = CompletedRequest::create($validated);

        Order::where('id', $order_id)->update([
            'orderStatus' => 'Completed',
            'completed' => 1,
            'translation_status' => TranslationStatusEnum::COMPLETED
        ]);

        HelperClass::storeOrderLog(
            1,
            Auth::user()->id,
            $order_id,
            "Order",
            "Admin",
            LogActionsEnum::ORDERCOMPLETED,
            0,
            1,
            0,
            1,
            0,
            0,
            0,
            1,
            0,
            1
        );

        if (env("IS_DEV") == 1) {
            Mail::mailer('dev')->to($email)->send(new mailOfCompletion($order, $zipName2, $emailTitle, env("ADMIN_EMAIL_DEV")));
        } else {
            Mail::mailer('clients')->to($email)->send(new mailOfCompletion($order, $zipName2, $emailTitle, env("ADMIN_EMAIL")));
        }
        //Send Invoice
        return redirect()->route('admin.pending', ['page' => session('page'), 'limit' => session('limit')]);
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

        Order::where('id', $order_id)->update([
            'orderStatus' => 'Completed',
            'completed' => 1,
            'translation_status' => TranslationStatusEnum::COMPLETED
        ]);

        HelperClass::storeOrderLog(
            1,
            Auth::user()->id,
            $order_id,
            "Order",
            "Admin",
            LogActionsEnum::ORDERCOMPLETED,
            0,
            1,
            0,
            1,
            0,
            0,
            0,
            1,
            0,
            1
        );

        if (env("IS_DEV") == 1) {
            Mail::mailer('dev')->to($email)->send(new mailOfCompletion($order, $zipName2, $emailTitle, env("ADMIN_EMAIL_DEV")));
        } else {
            Mail::mailer('clients')->to($email)->send(new mailOfCompletion($order, $zipName2, $emailTitle, env("ADMIN_EMAIL")));
        }
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

        // Mail::mailer('clients')->to($userMail)->send(new invoiceSent($user, $order, $doesInvoiceExist[0], "Flow Translate - New Invoice", "noiznixon98@gmail.com"));
        // Mail::to($email)->send(new mailOfCompletion($order, $zipName2));
        return redirect()->route('admin.pending', ['page' => session('page'), 'limit' => session('limit')]);
    }

    public function show($id)
    {
        $order = $orders = Order::with(['contractorOrder.contractor'])->where('id', $id)
            ->firstOrFail();
        return view('admin.show-order', compact('order'));
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

    public function ongoingInterpretations(Request $request)
    {
        $recordsPerPage = $request->query('limit', 10); // Default to 10 if not provided
        $page = $request->input('page', 1); // Default to 1 if not provided
        $skip = ($page - 1) * $recordsPerPage;
        $interpretations = Interpretation::orderByDesc('id')->skip($skip)->paginate($recordsPerPage);
        return view('admin.ongoingInterpretations', compact('interpretations', 'recordsPerPage'))->with(['page' => session('page'), 'limit' => session('limit')]);
    }

    public function viewCompletedInterpretations()
    {
        $interpretations = Interpretation::orderByDesc('created_at')->where('interpreter_completed', '=', 1)->get();
        return view('admin.completedInterpretations', compact('interpretations'));
    }
}