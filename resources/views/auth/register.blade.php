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
                <a href="{{ route('/') }}" class="-intro-x flex items-center pt-5">
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
                        translations in one place!</div>
                </div>
            </div>
            <!-- END: Login Info -->
            <!-- BEGIN: Login Form -->
            <div class="h-screen xl:h-auto flex py-5 xl:py-0 my-10 xl:my-0">
                <div
                    class="my-auto mx-auto xl:ml-20 bg-white dark:bg-darkmode-600 xl:bg-transparent px-5 sm:px-8 py-8 xl:p-0 rounded-md shadow-md xl:shadow-none w-full sm:w-3/4 lg:w-2/4 xl:w-auto">
                    <h2 class="intro-x font-bold text-2xl xl:text-3xl text-center xl:text-left">
                        User Sign Up
                    </h2>
                    <div class="intro-x mt-2 text-slate-400 xl:hidden text-center">A few more clicks to sign in to your
                        account. Manage all your e-commerce accounts in one place</div>
                    @if ($errors->any())
                        <div class="alert alert-danger mt-3 mb-3">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <form action="{{ route('register2') }}" id="registerForm" method="POST">
                        @csrf
                        @method('POST')
                        <div class="intro-x mt-8">
                            <div class="mt-2 mb-4">
                                <label for="user_role">What are you registering as?</label>
                                <ul class="grid w-full gap-2 mt-3 md:grid-cols-3">
                                    <li>
                                        <input type="radio" id="regular_user" name="role_id" value="0"
                                            class="hidden peer" checked>
                                        <label for="regular_user"
                                            class="inline-flex items-center justify-between w-full p-5 text-gray-500 bg-white border border-gray-200 rounded-lg cursor-pointer  peer-checked:border-blue-600 peer-checked:text-blue-600 hover:text-gray-600 hover:bg-gray-100">
                                            <div class="block">
                                                <div class="w-full text-md font-semibold">Individual User</div>

                                            </div>
                                            {{-- <svg aria-hidden="true" class="w-6 h-6 ml-3" fill="currentColor"
                                                viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                <path fill-rule="evenodd"
                                                    d="M12.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-2.293-2.293a1 1 0 010-1.414z"
                                                    clip-rule="evenodd"></path>
                                            </svg> --}}
                                        </label>
                                    </li>
                                    <li>
                                        <input type="radio" id="hosting-big" name="role_id" value="1"
                                            class="hidden peer">
                                        <label for="hosting-big"
                                            class="inline-flex items-center justify-between w-full p-5 text-gray-500 bg-white border border-gray-200 rounded-lg cursor-pointer  peer-checked:border-blue-600 peer-checked:text-blue-600 hover:text-gray-600 hover:bg-gray-100">
                                            <div class="block">
                                                <div class="w-full text-md font-semibold">Institute User</div>
                                            </div>
                                            {{-- <svg aria-hidden="true" class="w-6 h-6 ml-3" fill="currentColor"
                                                viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                <path fill-rule="evenodd"
                                                    d="M12.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-2.293-2.293a1 1 0 010-1.414z"
                                                    clip-rule="evenodd"></path>
                                            </svg> --}}
                                        </label>
                                    </li>
                                    <li>
                                        <input type="radio" id="institute_admin" name="role_id" value="2"
                                            class="hidden peer">
                                        <label for="institute_admin"
                                            class="inline-flex items-center justify-between w-full p-5 text-gray-500 bg-white border border-gray-200 rounded-lg cursor-pointer  peer-checked:border-blue-600 peer-checked:text-blue-600 hover:text-gray-600 hover:bg-gray-100">
                                            <div class="block">
                                                <div class="w-full text-md font-semibold">Institute Admin</div>
                                            </div>
                                            {{-- <svg aria-hidden="true" class="w-6 h-6 ml-3" fill="currentColor"
                                                viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                <path fill-rule="evenodd"
                                                    d="M12.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-2.293-2.293a1 1 0 010-1.414z"
                                                    clip-rule="evenodd"></path>
                                            </svg> --}}
                                        </label>
                                    </li>
                                </ul>
                            </div>
                            <input type="text" name="name"
                                class="intro-x login__input form-control py-3 px-4 block" placeholder="Name">
                            <input type="email" name="email"
                                class="intro-x login__input form-control py-3 px-4 block mt-4" placeholder="Email">
                            <input type="password" name="password"
                                class="intro-x login__input form-control py-3 px-4 block mt-4" placeholder="Password">


                            {{-- <div class="mt-2">
                                <label class="inline-flex items-center">

                                </label>
                            </div> --}}
                        </div>

                        <div class="flex mt-2 xl:mt-8 text-center xl:text-left">
                            <button type="submit" class="btn btn-primary py-3 px-4 w-full xl:mr-3 align-top"
                                id="registerButton">Register</button>
                            <a href="{{ route('login') }}"
                                class="btn btn-outline-secondary py-3 px-4 w-fullmt-3 xl:mt-0 align-top">Login</a>
                        </div>
                    </form>
                    <hr class="mt-3 mb-3">
                    <div class="alert alert-secondary show flex items-center mb-2" role="alert"> <i
                            data-lucide="alert-circle" class="w-6 h-6 mr-2"></i> Are you a Contractor? <a
                            href="{{ route('contractor.login') }}" class="underline font-bold ml-2">Sign
                            In</a> </div>
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
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
    $("#registerButton").click(function() {
        console.log("he");
        $(this).prop("disabled", true);
        $("#registerForm").submit();
    });
</script>

</html>
