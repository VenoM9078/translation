<?php

namespace App\Http\Controllers;

use App\Enums\InstituteRequestEnum;
use App\Enums\LogActionsEnum;
use App\Enums\OrderStatusEnum;
use App\Helpers\HelperClass;
use App\Mail\AdminInterpretationPaymentReceived;
use App\Mail\AdminNewInterpretation;
use App\Mail\adminOrderCreated;
use App\Mail\AdminPaymentReceived;
use App\Mail\CustomerPaymentReceived;
use App\Mail\InstituteRequestAccepted;
use App\Mail\InstituteRequestDeclined;
use App\Mail\NotifyAdminQuote;
use App\Mail\OrderQuoteSent;
use App\Mail\UserRequestMail;
use App\Models\Admin;
use App\Models\Contractor;
use App\Models\ContractorOrder;
use App\Models\Institute;
use App\Models\InstituteMembers;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Interpretation;
use App\Models\Order;
use App\Models\OrderFiles;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use App\Models\Invoice;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

use App\Mail\OrderCreated;
use App\Mail\UserInterpretationPaymentReceived;
use App\Mail\UserNewInterpretation;
use App\Models\CompletedRequest;
use App\Models\Feedback;
use App\Models\InstituteUserRequests;
use App\Models\TemporaryFile;
use Illuminate\Support\Facades\Mail;

use File;
use Illuminate\Http\File as HttpFile;
use Illuminate\Support\Facades\Hash;
use phpDocumentor\Reflection\Types\Null_;
use ZipArchive;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $email = Auth::user()->email;
        $domain = substr(strrchr($email, "@"), 1);
        $instituteAdmin = User::where('email', 'like', '%' . $domain)->where('role_id', 2)->first();
        return view('user.dashboard', compact('instituteAdmin'));
    }
    public function viewUpgradeInstituteUser()
    {
        return view('user.institute.upgrade-to-inst-user');
    }

    public function viewUpgradeInstituteAdmin()
    {
        return view('user.institute.upgrade-to-inst-admin');
    }


    public function upgradeInstituteAdmin(Request $request)
    {
        // Validate the request
        $request->validate([
            'institute_name' => 'required|string|max:255',
            'institute_passcode' => 'required|string|max:255',
        ]);

        // Get the domain of the currently logged in user
        $userEmailDomain = substr(strrchr(Auth::user()->email, "@"), 1);

        // Find institutes with the same passcode
        $samePasscodeInstitutes = Institute::where('passcode', $request->institute_passcode)->get();

        // Check if any of these institutes have a manager with the same email domain
        foreach ($samePasscodeInstitutes as $institute) {
            $manager = User::find($institute->managed_by);
            $managerEmailDomain = substr(strrchr($manager->email, "@"), 1);

            if ($managerEmailDomain === $userEmailDomain) {
                return view('user.institute.upgrade-to-inst-admin')->with('error', 'This passcode is already in use by an institute with the same manager email domain.');
            }
        }

        // Create the institute
        $institute = Institute::create([
            'name' => $request->institute_name,
            'passcode' => $request->institute_passcode,
            'managed_by' => Auth::user()->id,
            'is_active' => InstituteRequestEnum::PENDING
        ]);
        return redirect()->route('user.index');
        // return view('user.institute.upgrade-to-inst-admin')->withSuccess('Institute Request has been sent to FlowTranslate Admin');
    }
    public function upgradeInstituteUser(Request $request)
    {
        $passcode = $request->input('institute_passcode');

        $institute = Institute::where('passcode', $passcode)->first();
        if (!$institute) {
            return view('user.institute.upgrade-to-inst-user')->with('error', 'Invalid passcode');
        }

        $manager = User::find($institute->managed_by);

        $managerEmailDomain = substr(strrchr($manager->email, "@"), 1);
        $userEmailDomain = substr(strrchr($request->user()->email, "@"), 1);

        if ($managerEmailDomain !== $userEmailDomain) {
            return view('user.institute.upgrade-to-inst-user')->with('error', 'Email domain does not match with the institute admin');
        }

        InstituteUserRequests::create([
            'user_id' => $request->user()->id,
            'institute_id' => $institute->id,
        ]);

        // Send an email to the institute manager about the new request
        Mail::to($manager->email)->send(new UserRequestMail($request->user(), $institute));

        return view('user.institute.upgrade-to-inst-user')->with('success', 'Request to upgrade has been submitted successfully');
    }


    public function newOrder()
    {
        return view('user.new-order');
    }

    public function newInterpretation()
    {
        return view('user.newInterpretation');
    }

    public function viewInterpretationDetails($id)
    {
        $interpretation = Interpretation::where('id', $id)->firstOrFail();
        return view('user.view-interpretation', compact('interpretation'));
    }

    public function copyInterpretationDetails($id)
    {
        $interpretation = Interpretation::where('id', $id)->firstOrFail();
        return view('user.copy-interpretation', compact('interpretation'));
    }
    public function myinterpretations(Request $request)
    {
        $user = Auth::user();
        $recordsPerPage = $request->query('limit', 10); // Default to 10 if not provided
        $page = $request->input('page', 1); // Default to 1 if not provided
        $skip = ($page - 1) * $recordsPerPage;
        if ($user->role_id == 0 || $user->role_id == 1) {
            $interpretations = Interpretation::where('user_id', $user->id)->orderBy('id', 'desc')->skip($skip)->paginate($recordsPerPage);
        } else {
            $members = Auth::user()->institute_managed->members;
            $user_ids = [];
            foreach ($members as $member) {
                // if($member->id != Auth::user()->id){
                $user_ids[] = $member->id;
                // }
            }
            $user_ids = array_unique($user_ids);
            $interpretations = Interpretation::whereIn('user_id', $user_ids)->skip($skip)->paginate($recordsPerPage);
        }

        return view('user.viewMyInterpretations', compact('user', 'interpretations', 'recordsPerPage'))->with(['page' => session('page'), 'limit' => session('limit')]);
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

    public function downloadTranslationFile($id)
    {
        //select only file_name;
        $filePath = '/translations_by_contractors/' . ContractorOrder::where(['order_id' => $id])->firstOrFail()->file_name;
        $file = "";

        if (public_path() . file_exists($filePath)) {
            $file = public_path($filePath);
        }
        $zip = new ZipArchive;
        $zipName = date('ymdHis') . $id . '.zip';

        if ($zip->open(public_path('compressed/' . $zipName), ZipArchive::CREATE) === TRUE) {
            $relativeNameInZipFile = basename($file);
            // dd($file, $relativeNameInZipFile);
            $zip->addFile($file, $relativeNameInZipFile);

            $zip->close();
        }
        return response()->download($file);
    }
    public function uploadImage(Request $request)
    {
        if ($request->hasFile('transFiles')) {
            $files = $request->file('transFiles');

            // dd($files);
            $prefix = "_C_";
            foreach ($files as $file) {

                $filename = date('ymdHis') . $prefix . $file->getClientOriginalName();
                // $folder = uniqid() . '-' . now()->timestamp;
                // $file->move(public_path('documents'), $filename);
                $file->move('documents/', $filename);

                TemporaryFile::create([
                    'filename' => $filename
                ]);
                // dd($filename);
                return $filename;
            }
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
        $userID = Auth::id();
        // dd($request->all());
        date_default_timezone_set('America/Los_Angeles'); // Set timezone to PST

        // Get the latest worknumber from the Interpretation model
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
        $isInstitute = 0;
        $paymentStatus = 0;
        $invoiceSent = 0;
        $wantQuote = $request->input('want_quote');

        if ($wantQuote == "" || $wantQuote == NULL) {
            $wantQuote = 0;
        }

        if (Auth::user()->role_id == 1 || Auth::user()->role_id == 2) {
            $isInstitute = 1;
            $paymentStatus = 1;
            $invoiceSent = 1;
        }

        if ($request->input("isPayNow") == "on") {
            $data = [
                'language1' => $request->input('language1'),
                'language2' => $request->input('language2'),
                'access_code' => $request->input('access_code'),
                'casemanager' => $request->input('casemanager'),
                'user_id' => $userID,
                'worknumber' => $worknumber,
                'amount' => 35,
                'invoiceSent' => 1,
                'orderStatus' => 'Completed',
                'added_by_institute_user' => $isInstitute,
                'paymentStatus' => $paymentStatus,
                'message' => $request->input('message'),
                'want_quote' => $wantQuote,
                'due_date' => $due_date,
            ];
        } else {
            $data = [
                'language1' => $request->input('language1'),
                'language2' => $request->input('language2'),
                'access_code' => $request->input('access_code'),
                'casemanager' => $request->input('casemanager'),
                'user_id' => $userID,
                'worknumber' => $worknumber,
                'added_by_institute_user' => $isInstitute,
                'invoiceSent' => $invoiceSent,
                'paymentStatus' => $paymentStatus,
                'message' => $request->input('message'),
                'want_quote' => $wantQuote,
                'due_date' => $due_date,
            ];
        }


        //Store Order Log
        $order = Order::create($data);

        if ($request->input("isPayNow") == "on") {
            HelperClass::storeInvoiceLogs($userID, 0, $order->id, "Invoice", "Individual User", LogActionsEnum::INVOICESENT, 1);
        }

        HelperClass::storeOrderLog(
            LogActionsEnum::NOTADMIN,
            $userID,
            $order->id,
            "Order",
            Auth::user()->role_id,
            LogActionsEnum::NEWORDER,
            0,
            0,
            0,
            $paymentStatus,
            0,
            0,
            0,
            0,
            0,
            0
        );

        if (Auth::user()->role_id == 1 || Auth::user()->role_id == 2) {
            HelperClass::storeOrderLog(
                LogActionsEnum::NOTADMIN,
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
        }
        if ($request->input('want_quote') == "1") //wants quote
        {
            HelperClass::storeOrderLog(
                LogActionsEnum::NOTADMIN,
                Auth::user()->id,
                $order->id,
                "Order",
                "User",
                LogActionsEnum::QUOTEREQUESTED,
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
        }
        if ($request->transFiles) {

            $files = $request->transFiles;
            // dd($files = $request->file('files'));

            // dd($files);

            foreach ($files as $file) {

                // $temporaryFile = TemporaryFile::where('folder', $file)->first();
                $filename = $file;


                // dd($filename);
                // $moving = File::move(public_path('documents/tmp/' . $filename), public_path('documents'));
                $completion = OrderFiles::create([
                    'order_id' => $order->id,
                    'user_id' => $userID,
                    'filename' => $filename
                ]);
            }

            // dd($completion);
            $user = Auth::user();

            $email = $user->email;

            if (env("IS_DEV") == 1) {
                Mail::mailer('dev')->to($email)->send(new OrderCreated($user, $order, "Flow Translate - Order Created", env("ADMIN_EMAIL_DEV")));
                Mail::mailer('dev')->to('webpage@flowtranslate.com')->send(new adminOrderCreated($user, $order, "Flow Translate - New Order Created", env("ADMIN_EMAIL_DEV")));
            } else {
                Mail::mailer('clients')->to($email)->send(new OrderCreated($user, $order, "Flow Translate - Order Created", env("ADMIN_EMAIL")));
                Mail::mailer('clients')->to('webpage@flowtranslate.com')->send(new adminOrderCreated($user, $order, "Flow Translate - New Order Created", env("ADMIN_EMAIL")));
            }
            if (Auth::user()->role_id == 0) {

                if ($request->input("isPayNow") == "on") {
                    // If 'Pay Now' is checked. Proceed to create invoice.
                    $id = $request->input('user_id');

                    $data = [
                        'description' => "" . $request->input('language1') . ', ' . $request->input('language2') . "",
                        'docQuantity' => 1,
                        'amount' => 35,
                        'user_id' => $user->id,
                        'order_id' => $order->id
                    ];
                    Invoice::create($data);

                    return view('user.enterPaymentAmount', compact('order'));
                }
            }

            // Mail::to($email)->send(new OrderCreated($user, $order));
            // Mail::to('webpage@flowtranslate.com')->send(new adminOrderCreated($user, $order));


            return redirect()->route('myorders', ['page' => session('page'), 'limit' => session('limit')])->with('message', 'Translation Order placed successfully!');
        }
        return redirect()->back()->with('status', 'Attach Files!');
        // redirect()->back();
    }

    public function showPayAnyTimePage($id)
    {
        $order = Order::find($id);

        return view('user.enterPaymentAmount', compact('order'));
    }

    public function showPayAnyTimePageInterpretation($id)
    {
        $interpretation = Interpretation::find($id);

        return view('user.enterPaymentAmountInterpretation', compact('interpretation'));
    }

    public function proceedToPayAnyTime(Request $request)
    {
        // Retrieve the order_id and amount from the request
        $order_id = $request->input('order_id');
        $amount = $request->input('amount');

        // Find the order with the given order_id
        $order = Order::find($order_id);

        // Check if the order was found
        if (!$order) {
            return redirect()->back()->with('message', 'Order not found');
        }

        // Redirect to a new page with the order passed to it
        return view('user.payAnyTimeInvoice', compact('order', 'amount'));
    }

    public function proceedToPayNowInterpretation(Request $request)
    {
        // Retrieve the order_id and amount from the request
        $interpretation_id = $request->input('interpretation_id');
        $amount = $request->input('amount');

        // Find the order with the given order_id
        $interpretation = Interpretation::find($interpretation_id);

        // Check if the order was found
        if (!$interpretation) {
            return redirect()->back()->with('message', 'Interpretation not found');
        }

        // Redirect to a new page with the order passed to it
        return view('user.interpretationPayAnyTime', compact('interpretation', 'amount'));
    }

    public function proceedToPayNow(Request $request)
    {
        // Retrieve the order_id and amount from the request
        $order_id = $request->input('order_id');
        $amount = $request->input('amount');
        // dd($amount);
        if ($amount == null) {
            return redirect()->back()->with('error', 'Enter amount');
        }
        // Find the order with the given order_id
        $order = Order::find($order_id);

        // Check if the order was found
        if (!$order) {
            return redirect()->back()->with('message', 'Order not found');
        }

        // Update the order's invoice with the given amount
        // Assuming the order has a related invoice and the relationship is named 'invoice'


        // Redirect to a new page with the order passed to it
        return view('user.paymentInvoice', compact('order', 'amount'));
    }



    public function viewPayment($orderid)
    {
        $order = Order::where('id', $orderid);

        return view('viewPayment', compact('order'));
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

            // Redirect back with a success message
            return back()->with('success', 'Order cancelled successfully.');
        }

        // Redirect back with an error message if the order doesn't exist
        return back()->with('error', 'Order not found.');
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
        $zipName = date('ymdHis') . $id . '.zip';

        if ($zip->open(public_path('compressed/' . $zipName), ZipArchive::CREATE) === TRUE) {
            $relativeNameInZipFile = basename($file);
            // dd($file, $relativeNameInZipFile);
            $zip->addFile($file, $relativeNameInZipFile);

            $zip->close();
        }
        return response()->download($file);
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

            // Redirect back with a success message
            return back()->with('success', 'Interpretation cancelled successfully.');
        }

        // Redirect back with an error message if the interpretation doesn't exist
        return back()->with('error', 'Interpretation not found.');
    }

    public function updateInterpretation(Request $request, $id)
    {
        $interpretation = Interpretation::find($id);
        $oldInt = $interpretation;
        if ($interpretation) {
            // Validation can be added as per your requirements.
            $interpretation->update($request->all());
            // dd($oldInt,$interpretation);
            return redirect()->route('myinterpretations', ['page' => session('page'), 'limit' => session('limit')])->with('success', 'Interpretation updated successfully.');
        }

        return redirect()->route('myinterpretations', ['page' => session('page'), 'limit' => session('limit')])->with('error', 'Interpretation not found.');
    }

    public function editOrder(Request $request)
    {

        $order = Order::where('id', $request->order_id)->first();

        $order->language1 = $request->input('language1');
        $order->language2 = $request->input('language2');

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

        return redirect()->route('myorders', ['page' => session('page'), 'limit' => session('limit')]);
    }

    public function viewEditOrder($orderID)
    {
        $order = Order::find($orderID);
        // dd($order);
        $contractors = Contractor::all();
        return view('user.edit-order', compact('order', 'contractors'));
    }

    public function editInterpretation($id)
    {
        $interpretation = Interpretation::find($id);

        if ($interpretation) {
            return view('user.editInterpretation', ['interpretation' => $interpretation]);
        }

        return redirect()->back()->with('error', 'Interpretation not found.');
    }

    public function approveQuote($id)
    {
        $order = Order::where('id', $id)->first();
        $order->is_order_quote_accepted = OrderStatusEnum::QUOTEACCEPTED;
        $order->want_quote = 2;
        $order->save();
        HelperClass::storeOrderLog(
            LogActionsEnum::NOTADMIN,
            Auth::user()->id,
            $order->id,
            "Order",
            "User",
            LogActionsEnum::QUOTEAPPROVED,
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
        $admins = Admin::all();
        if (env("IS_DEV") == 1) {
            $fromEmail = env("ADMIN_EMAIL_DEV");
        } else {
            $fromEmail = env("ADMIN_EMAIL");
        }
        foreach ($admins as $admin) {
            Mail::to($admin->email)->send(new NotifyAdminQuote($order, 1, $fromEmail));
        }
        Mail::to($order->user->email)->send(new OrderQuoteSent($order));
        return redirect()->route('myorders', ['page' => session('page'), 'limit' => session('limit')]);
    }

    public function approveIntQuote($id)
    {
        $interpretation = Interpretation::where('id', $id)->first();
        $interpretation->is_quote_pending = OrderStatusEnum::QUOTEACCEPTED;
        $interpretation->wantQuote = 2;
        $interpretation->save();
        HelperClass::storeOrderLog(
            LogActionsEnum::NOTADMIN,
            Auth::user()->id,
            null,
            "Interpretation",
            "User",
            LogActionsEnum::QUOTEAPPROVED,
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
            LogActionsEnum::ISINTERPRETATION,
            0,
            $id
        );
        // Send the email to the user
        $admins = Admin::all();
        if (env("IS_DEV") == 1) {
            $fromEmail = env("ADMIN_EMAIL_DEV");
        } else {
            $fromEmail = env("ADMIN_EMAIL");
        }
        foreach ($admins as $admin) {
            Mail::to($admin->email)->send(new NotifyAdminQuote($interpretation, 1, $fromEmail));
        }
        // Mail::to($interpretation->user->email)->send(new OrderQuoteSent($interpretation));
        return redirect()->route('myorders', ['page' => session('page'), 'limit' => session('limit')]);
    }

    public function disapproveQuote($id)
    {
        $order = Order::where('id', $id)->first();
        $order->is_order_quote_accepted = OrderStatusEnum::QUOTEREJECTED;
        $order->want_quote = 1;
        $order->save();
        HelperClass::storeOrderLog(
            LogActionsEnum::NOTADMIN,
            Auth::user()->id,
            $order->id,
            "Order",
            "User",
            LogActionsEnum::QUOTEDISAPPROVED,
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
        $admins = Admin::all();
        $fromEmail = "";
        if (env("IS_DEV") == 1) {
            $fromEmail = env("ADMIN_EMAIL_DEV");
        } else {
            $fromEmail = env("ADMIN_EMAIL");
        }
        foreach ($admins as $admin) {
            Mail::to($admin->email)->send(new NotifyAdminQuote($order, 0, $fromEmail));
        }
        Mail::to($order->user->email)->send(new OrderQuoteSent($order));
        return redirect()->route('myorders', ['page' => session('page'), 'limit' => session('limit')]);
    }

    public function disapproveIntQuote($id)
    {
        $interpretation = Interpretation::where('id', $id)->first();
        $interpretation->is_quote_pending = OrderStatusEnum::QUOTEREJECTED;
        $interpretation->wantQuote = 1; //back to pending
        $interpretation->save();
        HelperClass::storeOrderLog(
            LogActionsEnum::NOTADMIN,
            Auth::user()->id,
            null,
            "Interpretation",
            "User",
            LogActionsEnum::QUOTEDISAPPROVED,
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
            LogActionsEnum::ISINTERPRETATION,
            0,
            $id
        );
        // Send the email to the user
        $admins = Admin::all();
        if (env("IS_DEV") == 1) {
            $fromEmail = env("ADMIN_EMAIL_DEV");
        } else {
            $fromEmail = env("ADMIN_EMAIL");
        }
        foreach ($admins as $admin) {
            Mail::to($admin->email)->send(new NotifyAdminQuote($interpretation, 1, $fromEmail));
        }
        // Mail::to($interpretation->user->email)->send(new OrderQuoteSent($interpretation));
        return redirect()->route('myorders', ['page' => session('page'), 'limit' => session('limit')]);
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
        $zipName = date('ymdHis') . $id . '.zip';

        if ($zip->open(public_path('compressed/' . $zipName), ZipArchive::CREATE) === TRUE) {
            $relativeNameInZipFile = basename($file);
            // dd($file, $relativeNameInZipFile);
            $zip->addFile($file, $relativeNameInZipFile);

            $zip->close();
        }
        return response()->download($file);
    }


    public function myorders(Request $request)
    {
        $user = Auth::user();
        $recordsPerPage = $request->query('limit', 10); // Default to 10 if not provided
        $page = $request->input('page', 1); // Default to 1 if not provided
        $skip = ($page - 1) * $recordsPerPage;
        if ($user->role_id == 0 || $user->role_id == 1) {

            $orders = Order::where('user_id', $user->id)->orderByDesc('created_at')->skip($skip)->paginate($recordsPerPage);
            $interpretations = Interpretation::where('user_id', $user->id)->orderByDesc('created_at')->get();
            return view('user.myorders', compact('user', 'orders'))->with(['page' => session('page'), 'limit' => session('limit')]);
        } else if ($user->role_id == 2) {
            // Get all the institutes managed by this user
            $institutes = Institute::where('managed_by', $user->id)->get();
            // Collect all the user IDs associated with these institutes
            $user_ids = [];
            foreach ($institutes as $institute) {
                $members = $institute->members()->get();
                foreach ($members as $member) {
                    $user_ids[] = $member->id;
                }
            }
            $user_ids = array_unique($user_ids); // Remove duplicates
            // dd($user_ids);
            // Get all orders made by these users


            $orders = Order::whereIn('user_id', $user_ids)->orderByDesc('created_at')->skip($skip)->paginate($recordsPerPage);
            // $orders = Order::whereIn('user_id', $user_ids)->orderByDesc('created_at')->get();
            // dd($orders);
            return view('user.myorders', compact('user', 'orders'))->with(['page' => session('page'), 'limit' => session('limit')]);
        }
    }


    public function viewQuoteInvoice($interpretationID)
    {
        $interpretation = Interpretation::find($interpretationID);
        return view('user.viewQuoteInvoice', compact('interpretation'));
    }

    public function allInvoices()
    {
        $user = Auth::user();
        $invoices = $user->invoices;

        return view('user.allinvoices', compact('user', 'invoices'));
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

    public function viewProgress($id)
    {
        $order = Order::where('id', $id);

        return view('user.viewprogress', compact('order'));
    }


    public function viewInvoice($id)
    {

        $invoice = Invoice::findOrFail($id);

        return view('user.viewInvoice', compact('invoice'));
    }

    public function updatePaymentStatus($id)
    {
        $order_id = $id;

        $order = Order::findOrFail($order_id);

        $order->paymentStatus = 1;
        $order->orderStatus = 'Translation Pending';

        $order->save();

        HelperClass::storeOrderLog(
            LogActionsEnum::NOTADMIN,
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

        $email = $order->user->email;

        if (env("IS_DEV") == 1) {
            Mail::mailer('dev')->to($email)->send(new CustomerPaymentReceived($order, "Flow Translate - Payment Received", env("ADMIN_EMAIL_DEV")));
            Mail::mailer('dev')->to('webpage@flowtranslate.com')->send(new AdminPaymentReceived($order, "Flow Translate - Customer Payment Received", env("ADMIN_EMAIL_DEV")));
        } else {
            Mail::mailer('clients')->to($email)->send(new CustomerPaymentReceived($order, "Flow Translate - Payment Received", env("ADMIN_EMAIL")));
            Mail::mailer('clients')->to('webpage@flowtranslate.com')->send(new AdminPaymentReceived($order, "Flow Translate - Customer Payment Received", env("ADMIN_EMAIL")));
        }
        return view('user.thankyou');
    }


    public function updateQuotePaymentStatus($id)
    {
        $interpretation_id = $id;

        $interpretation = Interpretation::findOrFail($interpretation_id);

        $interpretation->paymentStatus = 1;
        $interpretation->wantQuote = 3;
        $interpretation->invoiceSent = 1;

        HelperClass::storeInvoiceLogs(Auth::user()->id, 0, null, "Invoice", "Individual User", LogActionsEnum::INVOICESENT, 1, $interpretation_id);

        HelperClass::storeOrderLog(
            LogActionsEnum::NOTADMIN,
            Auth::user()->id,
            null,
            "Interpretation",
            "User",
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

        $interpretation->save();

        $email = $interpretation->user->email;

        if (env("IS_DEV") == 1) {
            Mail::mailer('dev')->to($email)->send(new UserInterpretationPaymentReceived($interpretation, "Flow Translate - Payment Received", env("ADMIN_EMAIL_DEV")));
            Mail::mailer('dev')->to('webpage@flowtranslate.com')->send(new AdminInterpretationPaymentReceived($interpretation, "Flow Translate - Customer Payment Received", env("ADMIN_EMAIL_DEV")));
        } else {
            Mail::mailer('clients')->to($email)->send(new UserInterpretationPaymentReceived($interpretation, "Flow Translate - Payment Received", env("ADMIN_EMAIL")));
            Mail::mailer('clients')->to('webpage@flowtranslate.com')->send(new AdminInterpretationPaymentReceived($interpretation, "Flow Translate - Customer Payment Received", env("ADMIN_EMAIL")));
        }

        return view('user.quoteThankYou');
    }

    public function provideProof($id)
    {
        $order = Order::findOrFail($id);
        return view('user.provideProof', compact('order'));
    }

    public function payLater(Request $request)
    {
        $id = $request->order_id;
        $code = $request->payLaterCode;

        // dd($code, $id);
        Order::where('id', $id)->update(['paymentStatus' => 3, 'payLaterCode' => $code]);

        HelperClass::storeOrderLog(
            LogActionsEnum::NOTADMIN,
            Auth::user()->id,
            $request->order_id,
            "Order",
            Auth::user()->role_id,
            LogActionsEnum::WILLPAYLATE,
            0,
            //old translation
            0, //new translation
            LogActionsEnum::PAYMENTINCOMPLETEDNUMBER,
            LogActionsEnum::WILLPAYLATENUMBER,
            0,
            0,
            0,
            0,
            0,
            0
        );
        return view('user.payLaterLanding');
    }



    public function uploadProof(Request $request)
    {
        if ($request->hasFile('transFiles')) {
            $files = $request->file('transFiles');

            // dd($files);

            foreach ($files as $file) {

                $filename = date('ymdHis') . $file->getClientOriginalName();
                // $folder = uniqid() . '-' . now()->timestamp;
                // $file->move(public_path('documents'), $filename);
                $file->move('evidence/', $filename);

                TemporaryFile::create([
                    'filename' => $filename
                ]);

                return $filename;
            }
        }
    }

    public function processProof(Request $request)
    {

        // dd($request);

        $order_id = $request->input('order_id');

        if ($request->transFiles) {

            $files = $request->transFiles;

            // dd($files);

            $fileArr2 = [];

            foreach ($files as $file) {

                $filename = $file;

                $fileArr2[] = public_path('evidence/' . $filename);
            }

            // dd($fileArr2);

            $zip2 = new ZipArchive;

            $zipName2 = 'payevidence' . date('ymdHis') . $order_id . '.zip';

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

        $orderUpdate = Order::where('id', $order_id)->update(['is_evidence' => 1, 'filename' => $zipName2]);

        return redirect()->route('myorders', ['page' => session('page'), 'limit' => session('limit')]);
    }

    public function downloadTranslatedForUser($id)
    {
        $order = Order::where('id', $id)->first();
        $order_id = $order->id;

        $completedRequest = CompletedRequest::where('order_id', $order_id)->first();

        $orderFiles = $completedRequest->completed_file;

        return response()->download(public_path('translated/' . $orderFiles));
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

        $zipName = date('ymdHis') . $order->id . '.zip';
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



    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $order = $orders = Order::with(['contractorOrder.contractor'])->where('id', $id)
            ->firstOrFail();
        return view('user.show-order', compact('order'));
    }

    public function copyOrderDetails($id)
    {
        $order = $orders = Order::with(['contractorOrder.contractor'])->where('id', $id)
            ->firstOrFail();
        return view('user.copy-order', compact('order'));
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
        //
    }

    public function instituteUserRequestAccept($id)
    {
        // Get the request
        $request = InstituteUserRequests::findOrFail($id);

        // Update the user's role
        $user = User::findOrFail($request->user_id);
        $user->role_id = 1; // You may need to adjust this according to your role_id for member
        $user->save();

        // Add the user to the Institute Members
        $request->institute->members()->attach($user->id);

        // Delete the request
        $request->delete();

        // Redirect with a success message
        Mail::to($user->email)->send(new InstituteRequestAccepted($user));

        return redirect()->back()->with('message', 'User request accepted!');
    }

    public function instituteUserRequestDecline($id)
    {
        // Get the request
        $request = InstituteUserRequests::findOrFail($id);

        $user = User::findOrFail($request->user_id);

        // Delete the request
        $request->delete();

        // Redirect with a success message
        Mail::to($user->email)->send(new InstituteRequestDeclined($user));

        return redirect()->back()->with('message', 'User request declined!');
    }


    public function instituteAdmin()
    {
        $user = Auth::user();

        // If the user does not manage an institute, return an error
        if ($user->institute_managed == null) {
            return redirect()->back()->with('error', 'You do not manage any institute!');
        }
        // Get the users of the institute managed by the authenticated user
        $instituteUsers = $user->institute_managed->members;

        // Get the join requests for the institute managed by the authenticated user
        $instituteRequests = $user->institute_managed->requests;

        $institute = $user->institute_managed;

        // Pass the institute users and requests to the view
        return view('user.InstituteAdmin', compact('institute', 'user', 'instituteUsers', 'instituteRequests'));
    }

    public function updateProfile(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $user->name = $request->input('name');
        $user->phone = $request->input('phone');

        if ($request->input('password')) {
            $user->password = Hash::make($request->input('password'));
        }

        $user->save();

        return back()->with('success', 'Your profile has been updated successfully.');
    }


    public function viewProfile()
    {
        $user = Auth::user();

        // dd($user->institute);

        return view('user.profile', compact('user'));
    }

    public function updateInstitute(Request $request, $id)
    {
        // Find the user
        $user = User::findOrFail($id);

        // Check if the user is a member
        if ($user->role_id == 2) {
            // Update the institute
            $institute = $user->institute_managed;
            $institute->name = $request->input('name');
            $institute->passcode = $request->input('passcode');
            $institute->member_approval_needed = $request->input('member_approval_needed') == 'on' ? 1 : 0;
            $institute->save();
        }

        // Redirect back with a success message
        return redirect()->back()->with('message', 'Institute updated successfully!');
    }



    public function destroySession(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('login');
    }

    public function submitFeedback(Request $request)
    {
        $validate = $request->validate([
            'order_id' => 'integer|required',
            'experience' => 'string|required|max:255',
            'improvements' => 'string|max:255',
            'rating' => 'integer|required'
        ]);

        Feedback::create($validate);

        return redirect()->route('myorders', ['page' => session('page'), 'limit' => session('limit')])->with('message', 'Thank you for submitting your feedback!');
    }


    public function storeNewInterpretation(Request $request)
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

        $isInstitute = 0;
        $paymentStatus = 0;
        $invoiceSent = 0;

        if (Auth::user()->role_id == 1 || Auth::user()->role_id == 2) {
            $isInstitute = 1;
            $paymentStatus = 1;
            $invoiceSent = 1;
        }


        $worknumber = $currentTime;

        $interpretation = new Interpretation();
        $interpretation->worknumber = $worknumber;


        $interpretation->user_id = auth()->id(); // Add the authenticated user's ID
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
        $interpretation->wantQuote = $request->has('wantQuote') ? true : false;
        $interpretation->added_by_institute_user = $isInstitute;
        $interpretation->invoiceSent = $invoiceSent;
        $interpretation->paymentStatus = $paymentStatus;
        $interpretation->message = $request->message;

        $interpretation->save();

        if ($invoiceSent == 1) {
            HelperClass::storeInvoiceLogs(auth()->id(), 0, null, "Invoice", "Individual User", "Sent Invoice", 1, $interpretation->id);
        }

        HelperClass::storeOrderLog(
            LogActionsEnum::NOTADMIN,
            Auth::user()->id,
            null,
            "Interpretation",
            "User",
            LogActionsEnum::CREATEDINTERPRETATION,
            LogActionsEnum::ZEROTRANSLATIONSTATUS,
            LogActionsEnum::ZEROTRANSLATIONSTATUS,
            LogActionsEnum::PAYMENTINCOMPLETEDNUMBER,
            LogActionsEnum::PAYMENTINCOMPLETEDNUMBER,
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

        if (Auth::user()->role_id == 1 || Auth::user()->role_id == 2) {
            //storing interpretation with paid status
            HelperClass::storeOrderLog(
                LogActionsEnum::NOTADMIN,
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
        }

        if (env("IS_DEV") == 1) {
            Mail::to('webpage@flowtranslate.com')->send(new AdminNewInterpretation(auth()->user(), $interpretation, "Flow Translate - New Interpretation Request", env("ADMIN_EMAIL_DEV")));
            Mail::to(auth()->user()->email)->send(new UserNewInterpretation(auth()->user(), $interpretation, "Flow Translate - Your Interpretation Request", env("ADMIN_EMAIL_DEV")));
        } else {
            Mail::to('webpage@flowtranslate.com')->send(new AdminNewInterpretation(auth()->user(), $interpretation, "Flow Translate - New Interpretation Request", env("ADMIN_EMAIL")));
            Mail::to(auth()->user()->email)->send(new UserNewInterpretation(auth()->user(), $interpretation, "Flow Translate - Your Interpretation Request", env("ADMIN_EMAIL")));
        }
        return redirect()->route('newInterpretation')
            ->with('message', 'Interpretation request submitted successfully.');
    }

    public function viewInstituteOrders()
    {
        $user = Auth::user();

        // Get all the institutes managed by this user
        $institutes = Institute::where('managed_by', $user->id)->get();

        // Collect all the user IDs associated with these institutes
        $user_ids = [];
        foreach ($institutes as $institute) {
            $members = $institute->members()->get();
            foreach ($members as $member) {
                $user_ids[] = $member->id;
            }
        }
        $user_ids = array_unique($user_ids); // Remove duplicates

        // Get all orders made by these users
        $orders = Order::whereIn('user_id', $user_ids)->get();

        return view('user.institute.view-user-orders', compact('orders'));
    }

    public function viewInstituteInterpretations()
    {
        $members = Auth::user()->institute_managed->members;
        $user_ids = [];
        foreach ($members as $member) {
            // if($member->id != Auth::user()->id){
            $user_ids[] = $member->id;
            // }
        }
        $user_ids = array_unique($user_ids);
        $interpretations = Interpretation::whereIn('user_id', $user_ids)->get();
        return view('user.institute.view-user-interpretations', compact('interpretations'));
    }
}