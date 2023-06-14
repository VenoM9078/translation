<!DOCTYPE html>
<html lang="en" class="light">
<!-- BEGIN: Head -->

<head>
    <meta charset="utf-8">
    <link href="{{ url('dist/images/logo.svg') }}" rel="shortcut icon">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="keywords" content="">
    <meta name="author" content="">
    <title>FlowTranslate - Login</title>
    <!-- BEGIN: CSS Assets-->
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
                        translation orders in one place!</div>
                </div>
            </div>
            <!-- END: Login Info -->
            <!-- BEGIN: Login Form -->
            <div class="h-screen xl:h-auto flex py-5 xl:py-0 my-10 xl:my-0">
                <div
                    class="my-auto mx-auto xl:ml-20 bg-white dark:bg-darkmode-600 xl:bg-transparent px-5 sm:px-8 py-8 xl:p-0 rounded-md shadow-md xl:shadow-none w-full sm:w-3/4 lg:w-2/4 xl:w-auto">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            @foreach ($errors->all() as $error)
                                <div>{{ $error }}</div>
                            @endforeach
                        </div>
                    @endif
                    <h2 class="intro-x font-bold text-2xl xl:text-3xl text-center xl:text-left">
                        Reset Password
                    </h2>
                    @error('status')
                        <div class="alert alert-danger-soft show flex items-center mb-2 mt-2" role="alert">
                            {{ $message }} </div>
                    @enderror
                    <div class="intro-x mt-2 text-slate-400 xl:hidden text-center">A few more clicks to sign in to your
                        account. Manage all your translation orders in one place!</div>
                    @if (isset($isContractor) && $isContractor == 1)
                        <form method="POST" action="{{ route('contractor.password.update') }}">
                        @else
                            <form method="POST" action="{{ route('password.update') }}">
                    @endif
                    @csrf

                    @method('POST')

                    <input type="hidden" name="token" value="{{ $request->route('token') }}">

                    <div class="intro-x mt-8">
                        <input required type="email" name="email"
                            class="intro-x login__input form-control py-3 px-4 block" placeholder="Enter Email Address">
                    </div>
                    <div class="intro-x mt-8">
                        <input required type="password" name="password"
                            class="intro-x login__input form-control py-3 px-4 block" placeholder="Enter New Password">
                    </div>
                    <div class="intro-x mt-8">
                        <input required type="password" name="password_confirmation"
                            class="intro-x login__input form-control py-3 px-4 block" placeholder="Confirm Password">
                    </div>
                    <div class="intro-x mt-5 xl:mt-8 text-center xl:text-left">
                        <button style="width: 200px;" type="submit"
                            class="btn btn-primary py-3 px-4 w-full xl:w-32 xl:mr-3 align-top">Reset Password</button>
                        {{-- <a href="{{ route('login') }}" class="btn btn-outline-secondary py-3 px-4 w-full xl:w-32 mt-3 xl:mt-0 align-top">Go Back</a> --}}
                        {{-- <a href="{{ route('admin.login') }}" class="btn btn-outline-secondary " style="margin: auto; margin-left: 10px;"><i data-lucide="unlock"></i></a> --}}

                    </div>
                    </form>
                </div>
            </div>
            <!-- END: Login Form -->
        </div>
    </div>


    <!-- BEGIN: JS Assets-->
    <script src="{{ url('dist/js/app.js') }}"></script>
    <!-- END: JS Assets-->
</body>

</html>
