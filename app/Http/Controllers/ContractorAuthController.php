<?php

namespace App\Http\Controllers;

use App\Enums\ContractorOrderEnum;
use App\Models\Contractor;
use App\Models\ContractorOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        $translations = ContractorOrder::where('contractor_id', auth()->guard('contractor')->user()->id)->get();
        return view('contractor.translations', compact('translations'));
    }


    public function acceptTranslation(Request $request)
    {
        //update the contractor order is_accepted to 1
        $contractorOrder = ContractorOrder::find($request->contractor_order_id);
        $contractorOrder->is_accepted = ContractorOrderEnum::ACCEPTED;
        $contractorOrder->save();
        return redirect()->route('contractor.translations');
    }

    public function declineTranslation(Request $request)
    {
        $contractorOrder = ContractorOrder::find($request->contractor_order_id);
        $contractorOrder->is_accepted = ContractorOrderEnum::DECLINED;
        $contractorOrder->save();
        return redirect()->route('contractor.translations');
    }

    public function pendingProofRead()
    {
        $proofReadData = [];
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