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
                <a href="{{route('/')}}" class="-intro-x flex items-center pt-5">
                    <img class="w-6" src="{{ url('dist/images/logo.svg') }}">
                    <span class="text-white text-lg ml-3"> FlowTranslate Homepage </span>
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
                    <h2 class="intro-x font-bold text-2xl xl:text-3xl text-center xl:text-left">
                        User Sign In
                    </h2>

                    <div class="intro-x mt-2 text-slate-400 xl:hidden text-center">A few more clicks to sign in to your
                        account. Manage all your translation orders in one place!</div>
                    @if($errors->any())
                    <div class="alert alert-danger mt-3 mb-3">
                        <ul>
                            @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif
                    <form action="{{ route('login') }}" method="POST">
                        @csrf
                        @method('POST')
                        <div class="intro-x mt-8">
                            <input type="email" name="email" class="intro-x login__input form-control py-3 px-4 block"
                                placeholder="Email">
                            <input type="password" name="password"
                                class="intro-x login__input form-control py-3 px-4 block mt-4" placeholder="Password">
                        </div>
                        <div class="intro-x flex text-slate-600 dark:text-slate-500 text-xs sm:text-sm mt-4">
                            <div class="flex items-center mr-auto">
                            </div>
                            <a href="{{ route('password.request') }}">Forgot Password?</a>
                        </div>
                        <div class="intro-x mt-3 text-center xl:text-left">
                            <button type="submit"
                                class="btn btn-primary py-3 px-4 w-full xl:w-32 xl:mr-3 align-top">Login</button>
                            <a href="{{ route('register') }}"
                                class="btn btn-outline-secondary py-3 px-4 w-full xl:w-32 mt-3 xl:mt-0 align-top">Register</a>
                            <a href="{{ route('admin.login') }}" class="btn btn-outline-secondary "
                                style="margin: auto; margin-left: 10px;"><i data-lucide="unlock"></i></a>

                        </div>
                        <hr class="mt-3 mb-3">
                        <div class="alert alert-secondary show flex items-center mb-2" role="alert"> <i
                                data-lucide="alert-circle" class="w-6 h-6 mr-2"></i> Are you a Contractor? <a
                                href="{{route('contractor.login')}}" class="underline font-bold ml-2">Sign
                                In</a> </div>
                        {{-- <p class="mt-5 text-slate-600 dark:text-slate-500 text-xs sm:text-sm"></p> --}}
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