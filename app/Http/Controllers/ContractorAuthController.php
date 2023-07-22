<?php

namespace App\Http\Controllers;

use App\Enums\ContractorOrderEnum;
use App\Enums\LogActionsEnum;
use App\Enums\OrderStatusEnum;
use App\Enums\TranslationStatusEnum;
use App\Helpers\HelperClass;
use App\Mail\ContractorNotifyAdmin;
use App\Mail\InterpretationCancellation;
use App\Mail\InterpretationReportToAdmin;
use App\Mail\InterpretationReportToUser;
use App\Mail\NotifyAdminOfContractorAction;
use App\Mail\NotifyAdminProofRead;
use App\Mail\NotifyAdminTranslationSubmissionContractor;
use App\Mail\VerifyContractorMail;
use App\Models\Admin;
use App\Models\Contractor;
use App\Models\ContractorInterpretation;
use App\Models\ContractorLanguage;
use App\Models\ContractorOrder;
use App\Models\Interpretation;
use App\Models\Order;
use App\Models\ProofReaderOrders;
use App\Models\ProofRequest;
use App\Models\TemporaryFile;
use App\Models\VerifyContractor;
use Carbon\Carbon;
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

    public function showRegisterForm2(Request $request)
    {

        $verifyUser = Contractor::where('email', $request->email)->first();
        // dd($verifyUser);
        if (!isset($verifyUser)) {
            $validated = $request->validate(
                [
                    'name' => 'required|string|max:255',
                    'email' => 'required|email|max:255',
                    'password' => 'required|string|min:6',
                    'password2' => 'required|string|min:6|same:password',
                ],
                [
                    'name.required' => 'The name field is required.',
                    'name.max' => 'The name may not be greater than 255 characters.',
                    'email.required' => 'The email field is required.',
                    'email.max' => 'The email may not be greater than 255 characters.',
                    'password.required' => 'The password field is required.',
                    'password.min' => 'The password must be at least 6 characters.',
                    'password2.required' => 'The confirmation password field is required.',
                    'password2.same' => 'The confirmation password does not match.',
                    'password2.min' => 'The confirmation password must be at least 6 characters.',
                ]
            );
            $validated['password'] = bcrypt($validated['password']);
            $contractor = Contractor::create([
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'password' => bcrypt($request->input('password')),
                'address' => "",
                'phonenumber' => "",
                'SSN' => "",
                'translation_rate' => 0,
                'interpretation_rate' => 0,
                'proofreader_rate' => 0,
                'verified' => 0
            ]);

            $verifyContractor = VerifyContractor::create([
                'contractor_id' => $contractor->id,
                'token' => sha1(time())
            ]);

            Mail::to($contractor->email)->send(new VerifyContractorMail($contractor));

            Auth::guard('contractor')->login($contractor);
            return redirect()->route('contractor.verification.notice');
        } else if (isset($verifyUser)) {
            // dd($verifyUser);
            return redirect()->back()->with('error', 'This email already exists');
        }
        // Pass input data from the previous form to the view
        // return view('auth.contractor.register2', [
        //     'name' => $request->input('name'),
        //     'email' => $request->input('email'),
        //     'password' => $request->input('password'),
        //     'password2' => $request->input('password2'),
        // ]);
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
        $interpretationReport = ContractorInterpretation::where('id', $request->contractor_interpretation_id)->first();
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

        //storing interpretation with paid status
        HelperClass::storeOrderLog(
            LogActionsEnum::NOTADMIN,
            Auth::user()->id,
            null,
            "Interpretation",
            "Contractor",
            LogActionsEnum::COMPLETEDINTERPRETATION,
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
            LogActionsEnum::COMPLETEDINTERPRETATIONNUMBER
        );

        $admins = Admin::all()->pluck('email');
        // Sending email to admin
        if (env("IS_DEV") == 1) {
            Mail::to(env('ADMIN_EMAIL_DEV'))->send(new InterpretationReportToAdmin($interpretation));
        } else {
            Mail::to('info@flowtranslate.com')->send(new InterpretationReportToAdmin($interpretation));
        }

        // Sending email to user
        Mail::to($interpretation->user->email)->send(new InterpretationReportToUser($interpretation));

        return redirect()->route('contractor.interpretations');
    }



    public function interpretationRequests()
    {
        $contractorId = Auth::id();

        $interpretationRequests = ContractorInterpretation::where([
            ['contractor_id', '=', $contractorId],
            ['is_accepted', '=', 0]
        ])->get();

        return view('contractor.interpretationRequests', ['interpretationRequests' => $interpretationRequests]);
    }

    public function viewReport($id)
    {
        // dd($id);

        $interpretation = ContractorInterpretation::findOrFail($id);

        return view('contractor.view-report', ['interpretation' => $interpretation]);
    }

    public function viewTranslationSubmissionPage($id)
    {
        $contractorOrder = ContractorOrder::findOrFail($id);

        return view('contractor.submit-translation-file', ['contractorOrder' => $contractorOrder]);
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
        $admins = Admin::all();
        HelperClass::storeContractorLog(Auth::user()->id, LogActionsEnum::NOTADMIN, $contractorProofReader->order_id, $contractorProofReader->contractor_id, "ProofRead", "ProofReader", "Proof Reader", LogActionsEnum::ACCEPTPROOFREAD, 0, 0, LogActionsEnum::ACCEPTEDNUMBER, 0, 0, 0, 0);

        if (env('IS_DEV') != 1) {
            Mail::to('webpage@flowtranslate.com')->send(new NotifyAdminProofRead($contractorObj, 'accepted', $contractorProofReader));
        } else {
            foreach ($admins as $admin) {
                Mail::to($admin->email)->send(new NotifyAdminProofRead($contractorObj, 'accepted', $contractorProofReader));
            }
        }

        return redirect()->route('contractor.proof-read')->with('message', 'You have successfully accepted the proof read request.');
    }

    public function denyProofReadRequest($id)
    {

        $contractorProofReader = ProofReaderOrders::findOrFail($id);
        //clear the proof read values
        $contractorObj = Contractor::find($contractorProofReader->contractor_id);
        $contractorProofReader->is_accepted = ContractorOrderEnum::DECLINED;
        $contractorProofReader->save();
        $admins = Admin::all();

        HelperClass::storeContractorLog(Auth::user()->id, LogActionsEnum::NOTADMIN, $contractorProofReader->order_id, $contractorProofReader->contractor_id, "ProofRead", "ProofReader", "ProofReader", LogActionsEnum::DECLINEPROOFREAD, 0, 0, LogActionsEnum::DECLINENUMBER, 0, 0, 0, 0);

        if (env('IS_DEV') != 1) {
            Mail::to('webpage@flowtranslate.com')->send(new NotifyAdminProofRead($contractorObj, 'denied', $contractorProofReader));
        } else {
            foreach ($admins as $admin) {
                Mail::to($admin->email)->send(new NotifyAdminProofRead($contractorObj, 'accepted', $contractorProofReader));
            }
        }
        return redirect()->back()->with('message', 'You have successfully denied the interpretation request.');
    }
    public function acceptInterpretationRequest($id)
    {

        $contractorInterpretation = ContractorInterpretation::findOrFail($id);
        $contractorInterpretation->is_accepted = 1;
        $contractorInterpretation->contractor_id = Auth::user()->id;
        $interpretation_id = $contractorInterpretation->interpretation_id;

        $contractorInterpretation->save();
        $interpretation = Interpretation::findOrFail($interpretation_id);

        $contractor = $contractorInterpretation->contractor;

        $interpretation->interpreter_id = $contractor->id;

        $interpretation->save();

        HelperClass::storeContractorLog(Auth::user()->id, LogActionsEnum::NOTADMIN, null, $contractor->id, "Interpretation", "Interpreter", "Interpreter", LogActionsEnum::ACCEPTINTERPRETATION, 0, 0, LogActionsEnum::ACCEPTINTERPRETATIONNUMBER, 0, 0, 0, 0, $interpretation->id);

        Mail::to('webpage@flowtranslate.com')->send(new NotifyAdminOfContractorAction($contractor, 'accepted', $contractorInterpretation->interpretation));

        return redirect()->back()->with('message', 'You have successfully accepted the interpretation request.');
    }

    public function denyInterpretationRequest($id)
    {
        $contractorInterpretation = ContractorInterpretation::findOrFail($id);

        // Get the associated contractor before deleting the request
        $contractor = $contractorInterpretation->contractor;
        $interpretation = $contractorInterpretation->interpretation;

        HelperClass::storeContractorLog(Auth::user()->id, LogActionsEnum::NOTADMIN, null, $contractor->id, "Interpretation", "Interpreter", "Interpreter", LogActionsEnum::DECLINEINTERPRETATION, 0, 0, LogActionsEnum::DECLINEINTERPRETATIONNUMBER, 0, 0, 0, 0, $interpretation->id);

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
            'email' => 'required|email|max:255',
            'password' => 'required|string|min:6',
            'password2' => 'required|string|min:6|same:password',
        ], [
                'name.required' => 'The name field is required.',
                'name.max' => 'The name may not be greater than 255 characters.',
                'email.required' => 'The email field is required.',
                'email.max' => 'The email may not be greater than 255 characters.',
                'password.required' => 'The password field is required.',
                'password.min' => 'The password must be at least 6 characters.',
                'password2.required' => 'The confirmation password field is required.',
                'password2.same' => 'The confirmation password does not match.',
                'password2.min' => 'The confirmation password must be at least 6 characters.',
            ]);


        $validated['password'] = bcrypt($validated['password']);
        // $verifyUser = Contractor::where('email', $request->email)->first();
        // if (!isset($verifyUser)) {
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

        $verifyContractor = VerifyContractor::create([
            'contractor_id' => $contractor->id,
            'token' => sha1(time()),
            'expiry_time' => Carbon::now()->addHours(2)
        ]);

        // dd($verifyContractor);

        Mail::to($contractor->email)->send(new VerifyContractorMail($contractor));

        Auth::guard('contractor')->login($contractor);
        return redirect()->route('contractor.verification.notice');
        // } 
        // else if (isset($verifyUser)) {
        //     return back()->with('error', 'This email already exists');
        // }


        // return redirect()->route('contractor.dashboard');
    }

    public function verifyContractor($token)
    {
        // dd($token);
        $verifyUser = VerifyContractor::where('token', $token)->first();
        // dd($verifyUser);
        if (isset($verifyUser)) {
            if (Carbon::parse($verifyUser->expiry_time)->greaterThan(Carbon::now())) {
                $contractor = $verifyUser->contractor;
                if (!$contractor->verified) {
                    $verifyUser->contractor->verified = 1;
                    $verifyUser->contractor->save();
                    $status = "Your e-mail is verified. You can now setup your profile.";
                } else {
                    $status = "Your e-mail is already verified. You can now login.";
                }
            } else {
                // Token has expired
                return redirect()->route('contractor.login')->with('warning', "Sorry, your verification token has expired. Please request a new one.");
            }
        } else {
            return redirect()->route('contractor.login')->with('warning', "Sorry your email cannot be identified.");
        }
        $languages = ContractorLanguage::where('contractor_id', $verifyUser->contractor->id)->distinct()->get();
        return redirect()->route('contractor.edit-profile')->with(['status' => $status, 'languages' => $languages]);
    }

    public function viewProfile(Request $request)
    {
        // dd($request['languages']);
        $languages = ContractorLanguage::where('contractor_id', Auth::user()->id)->distinct()->get();
        return view('contractor.edit-profile', compact('languages'));
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
        $interpretationsCount = ContractorInterpretation::where('contractor_id', auth()->guard('contractor')->user()->id)
            ->where('is_accepted', ContractorOrderEnum::PENDING)
            ->get()->count();
        return view('contractor.dashboard', compact('proofReadCount', 'translationsCount', 'interpretationsCount'));
    }

    public function updateProfile(Request $request)
    {
        $id = Auth::user()->id;
        $contractor = Contractor::findOrFail($id);

        // Update basic fields
        $contractor->name = $request->input('name');
        $contractor->phonenumber = $request->input('phonenumber');
        $contractor->address = $request->input('address');
        $contractor->education_1 = $request->input('education_1');
        $contractor->education_2 = $request->input('education_2');
        $contractor->education_3 = $request->input('education_3');
        $contractor->certification = $request->input('certification');
        $contractor->years_of_experience = $request->input('years_of_experience');
        // $contractor->email = $request->input('email');

        // $contractor->interpretation_rate = $request->input('interpretation_rate');
        // $contractor->translation_rate = $request->input('translation_rate');
        // $contractor->proofreader_rate = $request->input('proofreader_rate');

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
        return redirect()->back()->with('status', 'Contractor updated successfully.');
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
    public function completedTranslations(Request $request)
    {
        $recordsPerPage = $request->query('limit', 10); // Default to 10 if not provided
        $page = $request->input('page', 1); // Default to 1 if not provided
        $skip = ($page - 1) * $recordsPerPage;

        $translations = ContractorOrder::where('contractor_id', auth()->guard('contractor')->user()->id)
            ->orderBy('created_at', 'desc')
            ->skip($skip)->paginate($recordsPerPage);
        return view('contractor.completed-translations', compact('translations', 'recordsPerPage'))->with(['page' => session('page'), 'limit' => session('limit')]);
    }

    public function acceptTranslation($contractor_order_id)
    {
        //update the contractor order is_accepted to 1
        $contractorOrder = ContractorOrder::find($contractor_order_id);
        // dd($contractorOrder);
        $contractorOrder->is_accepted = ContractorOrderEnum::ACCEPTED;
        $contractorOrder->save();

        HelperClass::storeContractorLog(
            Auth::user()->id,
            LogActionsEnum::NOTADMIN,
            $contractorOrder->order_id,
            $contractorOrder->contractor_id,
            "Contractor",
            0,
            "Translator",
            LogActionsEnum::ACCEPTTRANSLATION,
            0,
            0,
            1
        );

        $contractorName = Auth::guard('contractor')->user()->name;
        $admins = Admin::all(['email']);

        foreach ($admins as $admin) {
            Mail::to($admin->email)->send(new ContractorNotifyAdmin($contractorName, $contractorOrder, true));
        }
        return redirect()->route('contractor.translations.completed', ['page' => session('page'), 'limit' => session('limit')]);
    }

    //create function for downloading proofread file
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


    public function downloadTranslationFileByAdmin($id)
    {
        //select only file_name;
        $filePath = '/translations_by_contractors/' . ProofReaderOrders::where(['id' => $id])->firstOrFail()->file_uploaded_by_admin;
        $file = "";
        // dd($filePath,$id);
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
        // $contractorOrder->is_accepted = ContractorOrderEnum::DECLINED;
        $contractorOrder->delete();

        $order = Order::find($contractorOrder->order_id);
        $order->translation_sent = 0;
        $order->save();

        HelperClass::storeContractorLog(
            Auth::user()->id,
            LogActionsEnum::NOTADMIN,
            $contractorOrder->order_id,
            $contractorOrder->contractor_id,
            "Contractor",
            0,
            "Translator",
            LogActionsEnum::DECLINETRANSLATION,
            0,
            0,
            ContractorOrderEnum::DECLINED
        );
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
        //     // session(['uploaded_translation_file' => $filename]);


        // $filenames = [];

        // if ($request->hasFile('translationFile')) {
        //     $files = $request->file('translationFile');
        //     $filePath = 'translations_by_contractors/';

        //     foreach ($files as $file) {
        //         $filename = date('YmdHi') . $file->getClientOriginalName();

        //         if (!file_exists(public_path($filePath))) {
        //             mkdir(public_path($filePath), 0777, true);
        //         }

        //         $file->move($filePath, $filename);

        //         TemporaryFile::create([
        //             'filename' => $filename
        //         ]);

        //         $filenames[] = $filename;
        //     }
        // }
        // session(['uploaded_translation_file' => $filenames]);

        return $filename;
        // return response()->json(['filename' => $filename], 200);

    }

    public function submitTranslationFile(Request $request)
    {
        // dd($request->all());
        // dd($request->all(),$request->translationFile, $request->file('translationFile'));
        $uploadedFilePath = $request->input('translationFile');
        $contractorOrder = ContractorOrder::find($request['contractor_order_id']);
        $contractorOrder->file_name = $uploadedFilePath;
        // dd($contractorOrder);
        $contractorOrder->save();
        // $request->session()->forget('uploaded_translation_file');

        //fetch order with the order_id, then update the orders table column translationStatus to 1
        $order = Order::find($contractorOrder->order_id);
        $old_translation_status = $order->translation_status;
        $order->translation_status = 1;
        $order->save();

        HelperClass::storeContractorLog(
            Auth::user()->id,
            LogActionsEnum::NOTADMIN,
            $contractorOrder->order_id,
            $contractorOrder->contractor_id,
            "Contractor",
            0,
            "Translator",
            LogActionsEnum::UPLOADTRANSLATION,
            $old_translation_status,
            $order->translation_status,
            1
        );

        $contractorName = Auth::guard('contractor')->user()->name;
        $admins = Admin::all(['email']);
        foreach ($admins as $admin) {
            Mail::to($admin->email)->send(new NotifyAdminTranslationSubmissionContractor($contractorName, $contractorOrder, $order));
        }
        return redirect()->route('contractor.translations.completed', ['page' => session('page'), 'limit' => session('limit')]);
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
            ->orderByDesc('id')->paginate(10);
        // dd($proofReadData);
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
            // ->where('is_accepted', 1) // assuming 0 represents "accepted"
            // ->where('translation_status', TranslationStatusEnum::PENDING)

            ->orderByDesc('id')->paginate(10);
        // dd($proofReadData);
        return view('contractor.proof-read', compact('proofReadData'));
    }

    public function downloadProofreadFileByAdmin($id)
    {
        //select only file_name;
        $filePath = '/proofread_by_proofreader/' . ProofReaderOrders::where(['order_id' => $id])->firstOrFail()->file_uploaded_by_admin;
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

    public function completedProofReads()
    {
        $proofReadData = ProofReaderOrders::with([
            'contractor',
            'order',
            'contractorOrder'
        ])
            ->where('contractor_id', auth()->guard('contractor')->user()->id)
            ->where('is_accepted', 1) // assuming 0 represents "accepted"
            ->where('translation_status', TranslationStatusEnum::ACCEPTED)
            ->whereHas('contractorOrder', function ($query) {
                $query->where('is_accepted', ContractorOrderEnum::ACCEPTED);
            })
            ->orderBy('created_at', 'desc')
            ->get();
        return view('contractor.proof-read-completed', compact('proofReadData'));
    }

    public function pendingInterpretations(Request $request)
    {
        $contractorId = Auth::id();
        $recordsPerPage = $request->query('limit', 10); // Default to 10 if not provided
        $page = $request->input('page', 1); // Default to 1 if not provided
        $skip = ($page - 1) * $recordsPerPage;
        $interpretations = ContractorInterpretation::where([
            ['contractor_id', '=', $contractorId],
        ])->skip($skip)->paginate($recordsPerPage);

        return view('contractor.interpretations', compact('interpretations'))->with(['page' => session('page'), 'limit' => session('limit')]);
    }

    public function deleteInterpretation($id)
    {
        $contractorInterpretation = ContractorInterpretation::find($id);

        if ($contractorInterpretation) {
            // Find the associated interpretation
            $interpretation = $contractorInterpretation->interpretation;

            if ($interpretation) {
                // Set interpreter_id to null
                $interpretation->interpreter_id = null;
                $interpretation->save();
            }

            $contractorInterpretation->delete();

            // Send an email to the admin
            Mail::to('wahaj.dkz@gmail.com')->send(new InterpretationCancellation($interpretation));

            return redirect()->back()->with('success', 'Interpretation cancelled successfully.');
        }

        return redirect()->back()->with('error', 'Interpretation not found.');
    }

    public function login(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email|max:255',
            'password' => 'required|string|min:6',
        ]);

        if (
            auth()->guard('contractor')->attempt(['email' => $request->email, 'password' => $request->password])
        ) {
            $contractor = auth()->guard('contractor')->user();
            // dd($contractor);
            if ($contractor->verified != 1) {
                // auth()->logout();
                return redirect()->route('contractor.verification.notice');
            } else {
                Auth::guard('contractor')->login($contractor);
                return redirect()->intended(url('/contractor/dashboard'));
            }
        } else {
            return back()->withErrors([
                'email' => 'The provided credentials do not match our records.',
            ]);
        }
    }

    public function viewProofReadSubmission($id)
    {
        $proofReaderOrders = ProofReaderOrders::find($id);
        return view('contractor.submit-proof-read', compact('proofReaderOrders'));
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
    //create a function for submission of proof reader order file
    public function submitProofRead(Request $request)
    {
        // dd($request);
        $proofReaderOrders = ProofReaderOrders::find($request->id);
        // dd($proofReaderOrders);
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
            LogActionsEnum::NOTADMIN,
            $order->id,
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

        $contractor = $proofReaderOrders->contractor;
        $contractorName = $contractor->name;

        // $admin = User::where('role', 'admin')->first();

        // Mail::to($admin->email)->send(new NotifyAdminProofReadSubmissionContractor($contractorName, $contractorOrder));

        return redirect()->route('contractor.completed-proof-read', ['page' => session('page'), 'limit' => session('limit')]);
    }

    public function logout(Request $request)
    {
        Auth::guard('contractor')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('contractor.login');
    }
}
