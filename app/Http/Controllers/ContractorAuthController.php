<?php

namespace App\Http\Controllers;

use App\Enums\ContractorOrderEnum;
use App\Enums\TranslationStatusEnum;
use App\Mail\ContractorNotifyAdmin;
use App\Mail\NotifyAdminTranslationSubmissionContractor;
use App\Models\Admin;
use App\Models\Contractor;
use App\Models\ContractorInterpretation;
use App\Models\ContractorOrder;
use App\Models\Order;
use App\Models\ProofReaderOrders;
use App\Models\TemporaryFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Mail;
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

    public function interpretationRequests()
    {
        $contractorId = Auth::id();

        $interpretationRequests = ContractorInterpretation::where([
            ['contractor_id', '=', $contractorId],
            ['is_accepted', '=', 0]
        ])->get();

        return view('contractor.interpretationRequests', ['interpretationRequests' => $interpretationRequests]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ]);
        if ($request->password !== $request->password2) {
            return back()->withErrors([
                'password' => 'Passwords do not match'
            ]);
        }

        $validated['password'] = bcrypt($validated['password']);

        $contractor = Contractor::create($validated);

        Auth::guard('contractor')->login($contractor);

        return redirect()->route('contractor.dashboard');
    }

    public function index()
    {
        return view('contractor.dashboard');
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
            ->where('is_accepted', ContractorOrderEnum::ACCEPTED)
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

            session(['uploaded_translation_file' => $filename]);


            return $filename;
        }
    }

    public function submitTranslationFile(Request $request)
    {
        $uploadedFilePath = session('uploaded_translation_file', '');

        $contractorOrder = ContractorOrder::find($request['contractor_order_id']);
        $contractorOrder->file_name = $uploadedFilePath;
        $contractorOrder->save();
        $request->session()->forget('uploaded_translation_file');

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
        $proofReadData = ProofReaderOrders::with([
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
            ->get();
        // dd($proofReadData);
        return view('contractor.proof-read', compact('proofReadData'));
    }

    public function pendingInterpretations()
    {
        $interpretations = [];
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
