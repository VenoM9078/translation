<?php

namespace App\Http\Controllers;

use App\Mail\AdminInterpretationPaymentReceived;
use App\Mail\AdminNewInterpretation;
use App\Mail\adminOrderCreated;
use App\Mail\AdminPaymentReceived;
use App\Mail\CustomerPaymentReceived;
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
use App\Models\TemporaryFile;
use Illuminate\Support\Facades\Mail;

use File;
use Illuminate\Http\File as HttpFile;
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
        return view('user.dashboard');
    }

    public function newInterpretation()
    {
        return view('user.newInterpretation');
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


    public function uploadImage(Request $request)
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





    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request);
        // dd($request);
        // dd($request);
        $userID = Auth::id();
        // // dd($request, $userID);
        // $validated = $request->validate([
        //     'language1' => 'required|max:255',
        //     'language2' => 'required|max:255',
        //     'access_code' => 'string|max:255',
        //     'casemanager' => 'string|max:255',
        //     'files' => 'required',
        //     'files.*' => 'mimes:docx,doc,png,jpg,pdf,txt'
        // ]);



        // $validated['user_id'] = $userID;
        $currDate = date('Ymd');
        $randomDigits = mt_rand(1111, 9999);
        $worknumber = $currDate . date('md', strtotime($currDate . ' + 10 days')) . '_' . $randomDigits;
        //    var_dump($worknumber);

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
                'orderStatus' => 'Completed'
            ];
        } else {
            $data = [
                'language1' => $request->input('language1'),
                'language2' => $request->input('language2'),
                'access_code' => $request->input('access_code'),
                'casemanager' => $request->input('casemanager'),
                'user_id' => $userID,
                'worknumber' => $worknumber
            ];
        }

        // dd($data);
        $order = Order::create($data);


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

            // Mail::mailer('clients')->to($email)->send(new OrderCreated($user, $order, "Flow Translate - Order Created", "info@flowtranslate.com"));
            // Mail::mailer('clients')->to('webpage@flowtranslate.com')->send(new adminOrderCreated($user, $order, "Flow Translate - New Order Created", "info@flowtranslate.com"));
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

                return view('user.paymentInvoice', compact('order'));
            }


            // Mail::to($email)->send(new OrderCreated($user, $order));
            // Mail::to('webpage@flowtranslate.com')->send(new adminOrderCreated($user, $order));


            return redirect()->route('myorders')->with('status', 'Translation Order placed successfully!');
        }
        return redirect()->back()->with('status', 'Attach Files!');
        // redirect()->back();
    }

    public function viewPayment($orderid)
    {
        $order = Order::where('id', $orderid);

        return view('viewPayment', compact('order'));
    }
    public function myorders()
    {
        $user = Auth::user();
        $orders = Order::where('user_id', $user->id)->orderByDesc('created_at')->get();
        $interpretations = Interpretation::where('user_id', $user->id)->orderByDesc('created_at')->get();

        return view('user.myorders', compact('user', 'orders', 'interpretations'));
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

        $email = $order->user->email;

        Mail::mailer('clients')->to($email)->send(new CustomerPaymentReceived($order, "Flow Translate - Payment Received", "info@flowtranslate.com"));
        Mail::mailer('clients')->to('webpage@flowtranslate.com')->send(new AdminPaymentReceived($order, "Flow Translate - Customer Payment Received", "info@flowtranslate.com"));

        return view('user.thankyou');
    }


    public function updateQuotePaymentStatus($id)
    {
        $interpretation_id = $id;

        $interpretation = Interpretation::findOrFail($interpretation_id);

        $interpretation->paymentStatus = 1;
        $interpretation->wantQuote = 3;
        $interpretation->invoiceSent = 1;


        $interpretation->save();

        $email = $interpretation->user->email;

        Mail::mailer('clients')->to($email)->send(new UserInterpretationPaymentReceived($interpretation, "Flow Translate - Payment Received", "info@flowtranslate.com"));
        Mail::mailer('clients')->to('webpage@flowtranslate.com')->send(new AdminInterpretationPaymentReceived($interpretation, "Flow Translate - Customer Payment Received", "info@flowtranslate.com"));

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

        return view('user.payLaterLanding');
    }



    public function uploadProof(Request $request)
    {
        if ($request->hasFile('transFiles')) {
            $files = $request->file('transFiles');

            // dd($files);

            foreach ($files as $file) {

                $filename = date('YmdHi') . $file->getClientOriginalName();
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

            $zipName2 = 'payevidence' . date('YmdHi') . $order_id . '.zip';

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

        return redirect()->route('myorders');
    }

    public function downloadTranslatedForUser($id)
    {
        $order = Order::where('id', $id)->first();
        $order_id = $order->id;

        $completedRequest = CompletedRequest::where('order_id', $order_id)->first();

        $orderFiles = $completedRequest->completed_file;

        return response()->download(public_path('translated/' . $orderFiles));
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
        //
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

        return redirect()->route('myorders')->with('message', 'Thank you for submitting your feedback!');
    }


    public function storeNewInterpretation(Request $request)
    {
        $currDate = date('Ymd');
        $randomDigits = mt_rand(1111, 9999);
        $worknumber = $currDate . date('md', strtotime($currDate . ' + 10 days')) . '_' . $randomDigits;

        $interpretation = new Interpretation();
        $interpretation->worknumber = $worknumber;
        $interpretation->user_id = auth()->id(); // Add the authenticated user's ID
        $interpretation->language = $request->language;
        $interpretation->interpretationDate = $request->interpretationDate;
        $interpretation->start_time = $request->start_time;
        $interpretation->end_time = $request->end_time;
        $interpretation->session_format = $request->session_format;
        $interpretation->location = $request->location;
        $interpretation->session_topics = $request->session_topics;
        $interpretation->wantQuote = $request->has('wantQuote') ? true : false;
        $interpretation->save();

        Mail::to('webpage@flowtranslate.com')->send(new AdminNewInterpretation(auth()->user(), $interpretation, "Flow Translate - New Interpretation Request", "info@flowtranslate.com"));
        Mail::to(auth()->user()->email)->send(new UserNewInterpretation(auth()->user(), $interpretation, "Flow Translate - Your Interpretation Request", "info@flowtranslate.com"));

        return redirect()->route('newInterpretation')
            ->with('message', 'Interpretation request submitted successfully.');
    }
}
