<!DOCTYPE html>

<html lang="en" class="light">
<!-- BEGIN: Head -->

<head>
    <meta charset="utf-8">
    <link href="{{ url('dist/images/logo.svg') }}" rel="shortcut icon">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>FlowTranslate - Register</title>
    <!-- BEGIN: CSS Assets-->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.5/flowbite.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="{{ url('dist/css/app.css') }}" />
    <!-- END: CSS Assets-->
</head>
<!-- END: Head -->

<body class="login">
    <div class="container sm:px-10">
        <div class="block xl:grid grid-cols-2 gap-4">
            <!-- BEGIN: Login Info -->
            <div class="hidden xl:flex flex-col min-h-screen">
                <a href="" class="-intro-x flex items-center pt-5">
                    <img class="w-6" src="{{ url('dist/images/logo.svg') }}">
                    <span class="text-white text-lg ml-3"> FlowTranslate </span>
                </a>
                <div class="my-auto">
                    <img class="-intro-x w-1/2 -mt-16" src="{{ url('dist/images/illustration.svg') }}">
                    <div class="-intro-x text-white font-medium text-4xl leading-tight mt-10">
                        A few more clicks to
                        <br>
                        sign in to your account.
                    </div>
                    <div class="-intro-x mt-5 text-lg text-white text-opacity-70 dark:text-slate-400">Manage all your
                        translations in one place!</div>
                </div>
            </div>
            <!-- END: Login Info -->
            <!-- BEGIN: Login Form -->
            <div class="h-screen xl:h-auto flex py-5 xl:py-0 my-10 xl:my-0">
                <div
                    class="my-auto mx-auto xl:ml-20 bg-white dark:bg-darkmode-600 xl:bg-transparent px-5 sm:px-8 py-8 xl:p-0 rounded-md shadow-md xl:shadow-none w-full sm:w-3/4 lg:w-2/4 xl:w-auto">
                    <h2 class="intro-x font-bold text-2xl xl:text-3xl text-center xl:text-left">
                        @if ($role_id == 1)
                        Institute User Sign Up
                        @elseif($role_id == 2)
                        Institute Admin Sign Up
                        @endif
                    </h2>
                    <div class="intro-x mt-2 text-slate-400 xl:hidden text-center">A few more clicks to sign in to your
                        account. Manage all your e-commerce accounts in one place</div>
                    @if (isset($error))
                    <div class="alert alert-danger mt-3 mb-1">
                        <ul>
                            <li>{{ $error }}</li>
                        </ul>
                    </div>
                    @endif
                    <form action="{{ route('register2-complete') }}" method="POST">
                        @csrf
                        @method('POST')
                        <div class="intro-x mt-8">
                            <input type="hidden" name="role_id" value="{{$role_id}}">
                            @if ($role_id == 1)
                            <input type="text" name="institute_passcode"
                                class="intro-x login__input form-control py-3 px-4 block"
                                placeholder="Enter Institute's Passcode Here">
                            @elseif($role_id == 2)
                            <input type="text" name="institute_name"
                                class="intro-x login__input form-control py-3 px-4 block"
                                placeholder="Enter Institute's Name Here">
                            <input type="text" name="institute_passcode"
                                class="intro-x mt-2 login__input form-control py-3 px-4 block"
                                placeholder="Enter Institute's Passcode Here">
                            @endif
                            <input type="hidden" name="name" class="intro-x login__input form-control py-3 px-4 block"
                                value="{{ $name }}">
                            <input type="hidden" name="email"
                                class="intro-x login__input form-control py-3 px-4 block mt-4" value="{{ $email }}">
                            <input type="hidden" name="password"
                                class="intro-x login__input form-control py-3 px-4 block mt-4" value="{{ $password }}">
                        </div>

                        <div class="mt-2 xl:mt-8 text-center xl:text-left">
                            <button type="submit"
                                class="btn btn-primary py-3 px-4 w-full xl:mr-3 align-top">Register</button>
                        </div>
                    </form>
                    <hr class="mt-3 mb-3">
                </div>
            </div>

            <!-- END: Login Form -->
        </div>
    </div>

    <!-- BEGIN: JS Assets-->
    <script src="{{ url('dist/js/app.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.5/flowbite.min.js"></script>
    <!-- END: JS Assets-->
</body>

</html>