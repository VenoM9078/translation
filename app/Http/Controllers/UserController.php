<?php

namespace App\Http\Controllers;

use App\Mail\adminOrderCreated;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Order;
use App\Models\OrderFiles;
use App\Models\Invoice;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

use App\Mail\OrderCreated;
use App\Models\CompletedRequest;
use Illuminate\Support\Facades\Mail;

use File;
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

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        // dd("hi");
        $userID = Auth::id();

        $validated = $request->validate([
            'user_id' => 'integer',
            'language1' => 'required|max:255',
            'language2' => 'required|max:255',
            'access_code' => 'string|max:255',
            'casemanager' => 'string|max:255',
            'files' => 'required',
            'files.*' => 'mimes:docx,doc,png,jpg,pdf,txt'
        ]);

        $validated['user_id'] = $userID;
        $validated['worknumber'] = substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ*.-_"), 0, 10);
        $order = Order::create($validated);


        if ($request->hasFile('files')) {

            $files = $request->file('files');

            // dd($files);

            foreach ($files as $file) {

                $filename = date('YmdHi') . $file->getClientOriginalName();

                $file->move(public_path('documents'), $filename);
                $fileData['filename'] = $filename;
                $completion = OrderFiles::create([
                    'order_id' => $order->id,
                    'user_id' => $userID,
                    'filename' => $filename
                ]);
            }

            $user = Auth::user();

            $email = $user->email;
            Mail::to($email)->send(new OrderCreated($user, $order));
            Mail::to('info@flowtranslate.com')->send(new adminOrderCreated($user, $order));


            return redirect()->route('myorders')->with('status', 'Translation Order placed successfully!');
        }
    }

    public function myorders()
    {
        $user = Auth::user();
        $orders = Order::all();

        return view('user.myorders', compact('user', 'orders'));
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

        return view('user.thankyou');
    }

    public function provideProof($id) {
        $order = Order::findOrFail($id);
        return view('user.provideProof', compact('order'));
    }

    public function processProof(Request $request) {
        $validated = $request->validate([
            'order_id' => 'required|integer',
            'files' => 'required',
            'files.*' => 'mimes:docx,doc,png,jpg,pdf,txt,webp,csv'
        ]);

        $order_id = $request->input('order_id');
        
        if ($request->hasFile('files')) {

            $files = $request->file('files');

            // dd($files);

            $fileArr2 = [];

            foreach ($files as $file) {

                $filename = date('YmdHi') . $file->getClientOriginalName();

                $file->move(public_path('evidence'), $filename);
                $fileArr2[] = public_path('evidence/' . $filename);
                
            }

            $zip2 = new ZipArchive;

            $zipName2 = 'payevidence' . $order_id . '.zip';

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

        $orderUpdate = Order::where('id',$order_id)->update(['is_evidence' => 1, 'filename' => $zipName2]);

        return redirect()->route('myorders');

    }

    public function downloadTranslatedForUser($id)
    {
        $order = Order::where('id',$id)->first();
        $order_id = $order->id;

        $completedRequest = CompletedRequest::where('order_id',$order_id)->first();

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
}
