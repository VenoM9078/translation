<?php

namespace App\Http\Controllers\Auth;

use App\Enums\InstituteRequestEnum;
use App\Http\Controllers\Controller;
use App\Mail\InstituteRequestAccepted;
use App\Mail\UserRequestMail;
use App\Models\Institute;
use App\Models\InstituteAdminRequests;
use App\Models\InstituteUserRequests;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Carbon\Carbon;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rules;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required'],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);


        event(new Registered($user));

        Auth::login($user);

        return redirect()->route('user.index');
    }
    public function showRegistrationForm(Request $request)
    {
        $user = User::where('email', $request->query('e'))->where('role_id', $request->query('r'))->firstOrFail();
        $roleToSend = 0;
        if ($user) {
            if ($user->role_id == 3) {
                $user->role_id = 1;
            } else if ($user->role_id == 4) {
                $user->role_id = 0;
                $roleToSend = 2;
            }
            $user->email_verified_at = Carbon::now();
            $user->save();
        }
        if ($roleToSend == 2) {
            return view('auth.register2', [
                'name' => $user->name,
                'role_id' => 0,
                'user_id' => $user->id,
                'role_id_sent' => $roleToSend,
                'email' => $user->email,
                'password' => $user->password,
            ]);
        }
        return view('auth.register2', [
            'name' => $user->name,
            'role_id' => 0,
            'user_id' => $user->id,
            'role_id_sent' => $user->role_id,
            'email' => $user->email,
            'password' => $user->password,
        ]);
    }

    public function register2(Request $request)
    {
        $validated = $request->validate(
            [
                'name' => 'required|string|max:255',
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'password' => 'required|string|min:6',
            ],
            [
                'name.required' => 'The name field is required.',
                'name.max' => 'The name may not be greater than 255 characters.',
                'email.required' => 'The email field is required.',
                'email.max' => 'The email may not be greater than 255 characters.',
                'password.required' => 'The password field is required.',
                'password.min' => 'The password must be at least 6 characters.'
            ]
        );

        // Pass input data from the previous form to the view
        $verifyUser = User::where('email', $request->email)->first();
        if (!isset($verifyUser)) {
            if ($request->role_id == 0) {
                $user = User::create([
                    'name' => $request->name,
                    'email' => $request->email,
                    'password' => Hash::make($request->password),
                    'role_id' => 0
                ]);


                event(new Registered($user));

                Auth::login($user);
                return redirect()->route('email-verification-notice');


            } else {

                // if role is 1 => 3 | role is 2 => 4
                $role_id = 0;
                if ($request->role_id == 1) {
                    $role_id = 3; //awaiting admin status
                } else {
                    $role_id = 4; //awaiting admin status
                }
                $user = User::create([
                    'name' => $request->name,
                    'email' => $request->email,
                    'password' => Hash::make($request->password),
                    'role_id' => $role_id
                ]);


                event(new Registered($user));
                Auth::login($user);

                return redirect()->route('email-verification-notice');

            }
        } else if (isset($verifyUser)) {
            return back()->with('error', 'This email already exists');
        }
    }
    public function register2Complete(Request $request)
    {
        $institute = Institute::where('passcode', $request->institute_passcode)
            ->where('is_active', InstituteRequestEnum::ACCEPTED)
            ->get();

        if ($request->role_id == 2) { //checking for insitute admin
            if (1 == 0) {
                return view('auth.register2', [
                    'name' => $request->input('name'),
                    'role_id' => 2,
                    'email' => $request->input('email'),
                    'password' => $request->input('password'),
                    'role_id_sent' => $request->role_id
                ])->with('error', 'Error');

            } else {

                $institute = Institute::create([
                    'name' => $request->institute_name,
                    'passcode' => $request->institute_passcode,
                    'managed_by' => $request->user_id,
                    'is_active' => InstituteRequestEnum::PENDING
                ]);
            }
        } else if ($request->role_id == 1) {
            if (count($institute) < 1) {
                return view('auth.register2', [
                    'name' => $request->input('name'),
                    'role_id' => 0,
                    'email' => $request->input('email'),
                    'password' => $request->input('password'),
                    'role_id_sent' => $request->role_id,
                    'user_id' => $request->user_id
                ])->with('error', 'Institute does not exist!');
            } else {
                $userBelongsToInstitute = false;
                $userEmailDomain = substr(strrchr($request->email, "@"), 1);
                foreach ($institute as $inst) {
                    $manager = User::find($inst->managed_by);

                    $managerEmailDomain = substr(strrchr($manager->email, "@"), 1);

                    if ($managerEmailDomain == $userEmailDomain) {
                        $userBelongsToInstitute = true;

                        if ($inst->is_active == 0) {
                            return view('auth.register2', [
                                'name' => $request->input('name'),
                                'role_id' => 0,
                                'email' => $request->input('email'),
                                'user_id' => $request->user_id,
                                'password' => $request->input('password'),
                                'role_id_sent' => $request->role_id
                            ])->with('error', 'Insititue with this passcode is not active.');
                        }


                        $user = User::where('id', $request->input('user_id'))->first();
                        if ($inst->member_approval_needed == 1) { //need to approve user first
                            $this->addInstituteUserToRequest($user, $inst);
                        } else {
                            $inst->members()->syncWithoutDetaching([$user->id]);

                            // Send an email to the institute manager about the new request
                            $manager = User::find($inst->managed_by);
                            Mail::to($user->email)->send(new InstituteRequestAccepted($user));
                        }
                    }
                }
                if (!$userBelongsToInstitute) {
                    // Register the user as an individual user
                    $user = User::where('id',$request->user_id)->first();
                    $user->role_id = 0;
                    $user->failed_inst_user = 1;
                    $user->save();
                        // 'name' => $request->input('name'),
                        // 'role_id' => 0,
                        // 'email' => $request->input('email'),
                        // 'failed_inst_user' => 1,
                        // 'password' => bcrypt($request->input('password')),
                    // ]);

                    event(new Registered($user));

                    Auth::login($user);
                    return redirect()->route('user.index');
                    // return view('auth.register2', [
                    //     'name' => $request->input('name'),
                    //     'role_id' => 0,
                    //     'email' => $request->input('email'),
                    //     'password' => $request->input('password'),
                    //     'role_id_sent' => $request->role_id,
                    //     'user_id' => $request->user_id
                    // ])->with('message', 'Your institute does not have an account with Flow Translate, please discuss with your administrator to set up one with Flow Translate. Now you are registered as individual user.');
                }

            }
        }

        return redirect()->route('user.index');
    }

    public function addInstituteUserToRequest($user, $institute)
    {
        InstituteUserRequests::create([
            'user_id' => $user->id,
            'institute_id' => $institute->id,
        ]);

        // Send an email to the institute manager about the new request
        $manager = User::find($institute->managed_by);
        Mail::to($manager->email)->send(new UserRequestMail($user, $institute));
    }

    public function redirectToPassCode($id)
    {

        $user = User::where('id', $id)->first();
        if ($user->role_id == 1 && ((count($user->institute) < 1) && count($user->user_requests) < 1)) {
            return view('auth.register2', [
                'name' => $user->name,
                'role_id' => 1,
                'email' => $user->email,
                'user_id' => $user->id,
                'password' => $user->password,
                'role_id_sent' => $user->role_id
            ])
                ->with('error', 'You do not belong to any Institute.');
        } else {
            Auth::logout();

            return redirect()->route('login');
        }
    }
}