<?php

namespace App\Http\Controllers;

use App\Enums\ContractorOrderEnum;
use App\Enums\TranslationStatusEnum;
use App\Mail\ContractorNotifyAdmin;
use App\Mail\InterpretationReportToAdmin;
use App\Mail\InterpretationReportToUser;
use App\Mail\NotifyAdminOfContractorAction;
use App\Mail\NotifyAdminProofRead;
use App\Mail\NotifyAdminTranslationSubmissionContractor;
use App\Models\Admin;
use App\Models\Contractor;
use App\Models\ContractorInterpretation;
use App\Models\ContractorOrder;
use App\Models\Interpretation;
use App\Models\Order;
use App\Models\ProofReaderOrders;
use App\Models\ProofRequest;
use App\Models\TemporaryFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Mail as Mail;
use ZipArchive;

class ContractorAuthController extends Controller
{

    public function showRegisterForm()
    {
        return view('auth.contractor.register');
    }

    public function showLoginForm()
    {
        return view('auth.contractor.login');
    }

    public function reportToAdmin($id)
    {
        $interpretation = Interpretation::findOrFail($id);

        return view('contractor.reportToAdmin', compact('interpretation'));
    }


    public function reportSubmission(Request $request)
    {
        $interpretationReport = ContractorInterpretation::find($request->contractor_interpretation_id);
        $interpretationReport->feedback = $request->feedback;
        $interpretationReport->start_time_decided = $request->start_time_decided;
        $interpretationReport->end_time_decided = $request->end_time_decided;
        $interpretationReport->dateDecided = $request->interpretationDate;

        $interpretationReport->save();

        $interpretation = Interpretation::find($interpretationReport->interpretation->id);
        $interpretation->start_time = $request->start_time_decided;
        $interpretation->end_time = $request->end_time_decided;
        $interpretation->feedback = $request->feedback;
        $interpretation->interpretationDate = $request->interpretationDate;

        $interpretation->interpreter_completed = 1;

        $interpretation->save();

        // Sending email to admin
        Mail::to('wahaj.dkz@gmail.com')->send(new InterpretationReportToAdmin($interpretation));

        // Sending email to user
        Mail::to($interpretation->user->email)->send(new InterpretationReportToUser($interpretation));

        return redirect()->route('contractor.interpretations');
    }



    public function interpretationRequests()
    {
        $contractorId = Auth::id();

        $interpretationRequests = ContractorInterpretation::where([
            ['contractor_id', '=', $contractorId],
            ['is_accepted', '=', 1]
        ])->get();

        return view('contractor.interpretationRequests', ['interpretationRequests' => $interpretationRequests]);
    }

    public function viewReport($id)
    {
        // dd($id);

        $interpretation = ContractorInterpretation::findOrFail($id);

        return view('contractor.view-report', ['interpretation' => $interpretation]);
    }



    // public function store(Request $request)
    // {
    //     $validated = $request->validate([
    //         'name' => 'required|string|max:255',
    //         'email' => 'required|email',
    //         'password' => 'required|string|min:6',
    //     ]);
    //     if ($request->password !== $request->password2) {
    //         return back()->withErrors([
    //             'password' => 'Passwords do not match'
    //         ]);
    //     }

    //     $validated['password'] = bcrypt($validated['password']);

    //     $contractor = Contractor::create($validated);

    //     Auth::guard('contractor')->login($contractor);

    //     return redirect()->route('contractor.dashboard');
    // }

    public function acceptProofReadRequest($id)
    {

        $contractorProofReader = ProofReaderOrders::findOrFail($id);
        $contractorProofReader->is_accepted = 1;

        $contractorProofReader->save();
        $contractorObj = Contractor::findOrFail($contractorProofReader->contractor_id);

        Mail::to('webpage@flowtranslate.com')->send(new NotifyAdminProofRead($contractorObj, 'accepted', $contractorProofReader));

        return redirect()->back()->with('message', 'You have successfully accepted the proof read request.');
    }

    public function denyProofReadRequest($id)
    {

        $contractorProofReader = ProofReaderOrders::findOrFail($id);
        //clear the proof read values
        $contractorObj = Contractor::find($contractorProofReader->contractor_id);
        $contractorProofReader->delete();

        Mail::to('webpage@flowtranslate.com')->send(new NotifyAdminProofRead($contractorObj, 'denied', $contractorProofReader));

        return redirect()->back()->with('message', 'You have successfully denied the interpretation request.');
    }
    public function acceptInterpretationRequest($id)
    {

        $contractorInterpretation = ContractorInterpretation::findOrFail($id);
        $contractorInterpretation->is_accepted = 1;

        $interpretation_id = $contractorInterpretation->interpretation_id;

        $contractorInterpretation->save();
        $interpretation = Interpretation::findOrFail($interpretation_id);

        $contractor = $contractorInterpretation->contractor;

        $interpretation->interpreter_id = $contractor->id;

        $interpretation->save();

        Mail::to('webpage@flowtranslate.com')->send(new NotifyAdminOfContractorAction($contractor, 'accepted', $contractorInterpretation->interpretation));

        return redirect()->back()->with('message', 'You have successfully accepted the interpretation request.');
    }

    public function denyInterpretationRequest($id)
    {
        $contractorInterpretation = ContractorInterpretation::findOrFail($id);

        // Get the associated contractor before deleting the request
        $contractor = $contractorInterpretation->contractor;
        $interpretation = $contractorInterpretation->interpretation;

        $contractorInterpretation->delete();

        // Send email to admin
        Mail::to('webpage@flowtranslate.com')->send(new NotifyAdminOfContractorAction($contractor, 'denied', $interpretation));

        return redirect()->back()->with('message', 'You have successfully denied the interpretation request.');
    }


    public function store(Request $request)
    {

        // dd($request->input('translator_languages'));
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'password' => 'required|string|min:6',
            'password2' => 'required|string|min:6|same:password',

        ]);

        $validated['password'] = bcrypt($validated['password']);

        $contractor = Contractor::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => bcrypt($request->input('password')),
            'address' => $request->input('address'),
            'phonenumber' => $request->input('phonenumber'),
            'SSN' => $request->input('SSN'),
            'translation_rate' => $request->input('translator_rate'),
            'interpretation_rate' => $request->input('interpreter_rate'),
            'proofreader_rate' => $request->input('proofreader_rate'),
        ]);

        if ($request->input('translator_languages')) {
            foreach ($request->input('translator_languages') as $language) {
                $contractor->languages()->create([
                    'language' => $language,
                    'is_translator' => 1,
                ]);
            }
        }

        if ($request->input('interpreter_languages')) {
            foreach ($request->input('interpreter_languages') as $language) {
                $contractor->languages()->create([
                    'language' => $language,
                    'is_interpreter' => 1,
                ]);
            }
        }

        if ($request->input('proofreader_languages')) {
            foreach ($request->input('proofreader_languages') as $language) {
                $contractor->languages()->create([
                    'language' => $language,
                    'is_proofreader' => 1,
                ]);
            }
        }

        Auth::guard('contractor')->login($contractor);

        return redirect()->route('contractor.dashboard');
    }


    public function index()
    {
        $proofReadCount = ProofReaderOrders::with([
            'contractor',
            'order',
            'contractorOrder'
        ])
            ->where('contractor_id', auth()->guard('contractor')->user()->id)
            ->where('is_accepted', 0) // assuming 0 represents "pending"
            ->where('translation_status', TranslationStatusEnum::PENDING)
            ->whereHas('contractorOrder', function ($query) {
                $query->where('is_accepted', ContractorOrderEnum::ACCEPTED);
            })
            ->get()->count();
        $translationsCount = ContractorOrder::where('contractor_id', auth()->guard('contractor')->user()->id)
            ->where('is_accepted', ContractorOrderEnum::PENDING)
            ->get()->count();
        return view('contractor.dashboard', compact('proofReadCount', 'translationsCount'));
    }

    public function pendingTranslations()
    {
        // $translations = [];
        $translations = ContractorOrder::where('contractor_id', auth()->guard('contractor')->user()->id)
            ->where('is_accepted', ContractorOrderEnum::PENDING)
            ->get();
        return view('contractor.pending-translations', compact('translations'));
    }

    //completedTranslations create method
    public function completedTranslations()
    {
        $translations = ContractorOrder::where('contractor_id', auth()->guard('contractor')->user()->id)
            ->where('is_accepted', ContractorOrderEnum::ACCEPTED)->orderBy('created_at', 'desc')
            ->get();
        return view('contractor.completed-translations', compact('translations'));
    }

    public function acceptTranslation($contractor_order_id)
    {
        //update the contractor order is_accepted to 1
        $contractorOrder = ContractorOrder::find($contractor_order_id);
        // dd($contractorOrder);
        $contractorOrder->is_accepted = ContractorOrderEnum::ACCEPTED;
        $contractorOrder->save();

        $contractorName = Auth::guard('contractor')->user()->name;
        $admins = Admin::all(['email']);

        foreach ($admins as $admin) {
            Mail::to($admin->email)->send(new ContractorNotifyAdmin($contractorName, $contractorOrder, true));
        }
        return redirect()->route('contractor.translations.completed');
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
        $zipName = date('YmdHi') . $id . '.zip';

        if ($zip->open(public_path('compressed/' . $zipName), ZipArchive::CREATE) === TRUE) {
            $relativeNameInZipFile = basename($file);
            // dd($file, $relativeNameInZipFile);
            $zip->addFile($file, $relativeNameInZipFile);

            $zip->close();
        }
        return response()->download($file);
    }
    public function declineTranslation($contractor_order_id)
    {
        $contractorOrder = ContractorOrder::find($contractor_order_id);
        $contractorOrder->is_accepted = ContractorOrderEnum::DECLINED;
        $contractorOrder->save();
        //only select emails of admins from the query
        $contractorName = Auth::guard('contractor')->user()->name;
        $admins = Admin::all(['email']);

        foreach ($admins as $admin) {
            Mail::to($admin->email)->send(new ContractorNotifyAdmin($contractorName, $contractorOrder, false));
        }

        return redirect()->route('contractor.dashboard');
    }

    public function uploadTranslationFile(Request $request)
    {
        // if ($request->hasFile('translationFile')) {
        //     $file = $request->file('translationFile');
        //     $filePath = 'translations_by_contractors/';

        //     // dd($file);

        //     $filename = date('YmdHi') . $file->getClientOriginalName();
        //     // $folder = uniqid() . '-' . now()->timestamp;
        //     // $file->move(public_path('documents'), $filename);
        //     //if the path does not exist, create it

        //     if (!file_exists(public_path($filePath))) {
        //         mkdir(public_path($filePath), 0777, true);
        //         $file->move($filePath, $filename);
        //     } else {
        //         $file->move($filePath, $filename);
        //     }

        //     TemporaryFile::create([
        //         'filename' => $filename
        //     ]);

        //     // session(['uploaded_translation_file' => $filename]);


        $filenames = [];

        if ($request->hasFile('translationFile')) {
            $files = $request->file('translationFile');
            $filePath = 'translations_by_contractors/';

            foreach ($files as $file) {
                $filename = date('YmdHi') . $file->getClientOriginalName();

                if (!file_exists(public_path($filePath))) {
                    mkdir(public_path($filePath), 0777, true);
                }

                $file->move($filePath, $filename);

                TemporaryFile::create([
                    'filename' => $filename
                ]);

                $filenames[] = $filename;
            }
        }
        session(['uploaded_translation_file' => $filenames]);

        return $filenames;
        // return response()->json(['filename' => $filename], 200);

    }

    public function submitTranslationFile(Request $request)
    {
        // dd($request->all());
        // dd($request->all(),$request->translationFile, $request->file('translationFile'));
        // dd($request->hasFile('translationFile'), $request->input('translationFile'));
        $uploadedFilePath = session('uploaded_translation_file', '');

        $contractorOrder = ContractorOrder::find($request['contractor_order_id']);
        $contractorOrder->file_name = $uploadedFilePath;
        $contractorOrder->save();
        $request->session()->forget('uploaded_translation_file');

        //fetch order with the order_id, then update the orders table column translationStatus to 1
        $order = Order::find($contractorOrder->order_id);
        $order->translation_status = 1;
        $order->save();

        $contractorName = Auth::guard('contractor')->user()->name;
        $admins = Admin::all(['email']);
        foreach ($admins as $admin) {
            Mail::to($admin->email)->send(new NotifyAdminTranslationSubmissionContractor($contractorName, $contractorOrder));
        }
        return redirect()->route('contractor.translations.completed');
    }


    public function downloadOriginalFiles(Order $order)
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

    public function pendingProofRead()
    {
        $contractorId = Auth::id();

        $proofReadData = ProofReaderOrders::with([
            'contractor',
            'order',
            'contractorOrder'
        ])
            ->where('contractor_id', $contractorId)
            ->where('is_accepted', 0) // assuming 0 represents "pending"
            ->where('translation_status', TranslationStatusEnum::PENDING)
            ->whereHas('contractorOrder', function ($query) {
                $query->where('is_accepted', ContractorOrderEnum::ACCEPTED);
            })
            ->orderBy('created_at', 'desc')
            ->get();

        return view('contractor.proof-read-pending', compact('proofReadData'));
    }
    public function onGoingProofRead()
    {
        $proofReadData = ProofReaderOrders::with([
            'contractor',
            'order',
            'contractorOrder'
        ])
            ->where('contractor_id', auth()->guard('contractor')->user()->id)
            ->where('is_accepted', 1) // assuming 0 represents "accepted"
            ->where('translation_status', TranslationStatusEnum::PENDING)
            ->whereHas('contractorOrder', function ($query) {
                $query->where('is_accepted', ContractorOrderEnum::ACCEPTED);
            })
            ->orderBy('created_at', 'desc')
            ->get();
        // dd($proofReadData);
        return view('contractor.proof-read', compact('proofReadData'));
    }

    public function pendingInterpretations()
    {
        $contractorId = Auth::id();

        $interpretations = ContractorInterpretation::where([
            ['contractor_id', '=', $contractorId],
            ['is_accepted', '=', 1]
        ])->get();
        return view('contractor.interpretations', compact('interpretations'));
    }

    public function login(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email|max:255',
            'password' => 'required|string|min:6',
        ]);

        if (
            auth()->guard('contractor')->attempt([
                'email' => $request->email,
                'password' => $request->password
            ])
        ) {
            return redirect()->intended(url('/contractor/dashboard'));
        } else {
            return back()->withErrors([
                'email' => 'The provided credentials do not match our records.',
            ]);
        }
    }
    public function logout(Request $request)
    {
        Auth::guard('contractor')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('contractor.login');
    }
}