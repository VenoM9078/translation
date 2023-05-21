<!DOCTYPE html>

<html lang="en" class="light">
<!-- BEGIN: Head -->

<head>
    <meta charset="utf-8">
    <link href="{{url('dist/images/logo.svg')}}" rel="shortcut icon">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description"
        content="Midone admin is super flexible, powerful, clean & modern responsive tailwind admin template with unlimited possibilities.">
    <meta name="keywords"
        content="admin template, Midone Admin Template, dashboard template, flat admin template, responsive admin template, web app">
    <meta name="author" content="LEFT4CODE">
    <title>Admin Dashboard</title>
    <!-- BEGIN: CSS Assets-->
    <link rel="stylesheet" href="{{ url('dist/css/app.css') }}" />
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.css" />

    <!-- END: CSS Assets-->
</head>

<style type="text/css">
    a.gflag {
        vertical-align: middle;
        font-size: 15px;
        padding: 0px;
        background-repeat: no-repeat;
        background-image: url(//gtranslate.net/flags/16.png);
    }

    a.gflag img {
        border: 0;
    }

    a.gflag:hover {
        background-image: url(//gtranslate.net/flags/16a.png);
    }


    .goog-te-banner-frame {
        display: none !important;
    }

    .goog-te-menu-value:hover {
        text-decoration: none !important;
    }

    .goog-logo-link {
        display: none;
    }

    .goog-te-combo {
        color: #000;
    }


    .goog-te-gadget {
        color: transparent !important;
    }

    body {
        top: 0 !important;
    }

    /* #google_translate_element2 {
        display: none !important;
    } */
</style>
<!-- END: Head -->

<body class="py-5">
    <!-- BEGIN: Mobile Menu -->
    <div class="mobile-menu md:hidden">
        <div class="mobile-menu-bar">
            <a href="" class="flex mr-auto">
                <img class="w-6" src="{{ url('dist/images/logo.svg') }}">
            </a>
            <a href="javascript:;" class="mobile-menu-toggler"> <i data-lucide="bar-chart-2"
                    class="w-8 h-8 text-white transform -rotate-90"></i> </a>
        </div>
        <div class="scrollable">
            <a href="javascript:;" class="mobile-menu-toggler"> <i data-lucide="x-circle"
                    class="w-8 h-8 text-white transform -rotate-90"></i> </a>
            <ul class="scrollable__content py-2">
                <li>
                    <a href="{{ route('admin.dashboard') }}" class="menu menu--active">
                        <div class="menu__icon"> <i data-lucide="home"></i> </div>
                        <div class="menu__title"> Dashboard</div>
                    </a>

                </li>
                <li>
                    <a href="{{ route('admin.pending') }}" class="menu menu--active">
                        <div class="menu__icon"> <i data-lucide="home"></i> </div>
                        <div class="menu__title"> Pending Orders</div>
                    </a>

                </li>

                <li>
                    <a href="{{ route('invoice.index') }}" class="menu menu--active">
                        <div class="menu__icon"> <i data-lucide="home"></i> </div>
                        <div class="menu__title"> Pending Orders</div>
                    </a>

                </li>

                <li>
                    <a href="javascript:;" class="menu">
                        <div class="menu__icon"> <i data-lucide="box"></i> </div>
                        <div class="menu__title"> Menu Layout <i data-lucide="chevron-down" class="menu__sub-icon "></i>
                        </div>
                    </a>
                    <ul class="">
                        <li>
                            <a href="index.html" class="menu">
                                <div class="menu__icon"> <i data-lucide="activity"></i> </div>
                                <div class="menu__title"> Side Menu </div>
                            </a>
                        </li>
                        <li>
                            <a href="simple-menu-light-dashboard-overview-1.html" class="menu">
                                <div class="menu__icon"> <i data-lucide="activity"></i> </div>
                                <div class="menu__title"> Simple Menu </div>
                            </a>
                        </li>
                        <li>
                            <a href="top-menu-light-dashboard-overview-1.html" class="menu">
                                <div class="menu__icon"> <i data-lucide="activity"></i> </div>
                                <div class="menu__title"> Top Menu </div>
                            </a>
                        </li>
                    </ul>
                </li>


            </ul>
        </div>
    </div>
    <!-- END: Mobile Menu -->
    <div class="flex mt-[4.7rem] md:mt-0">
        <!-- BEGIN: Side Menu -->
        <nav class="side-nav">
            <a href="{{ route('admin.dashboard') }}" class="intro-x flex items-center pl-5 pt-4">
                <img class="w-6" src="{{url('dist/images/logo.svg')}}">
                <span class="hidden xl:block text-white text-lg ml-3"> Translators </span>
            </a>
            <div class="side-nav__devider my-6"></div>
            <ul>
                <li>
                    <a href="{{route('admin.dashboard')}}"
                        class="{{ ((Route::getCurrentRoute()->uri == 'admin/dashboard') ? 'side-menu   side-menu--active' : 'side-menu' ) }}">
                        <div class="side-menu__icon"> <i data-lucide="home"></i> </div>
                        <div class="side-menu__title">
                            Dashboard
                        </div>
                    </a>
                </li>


                <li>
                    <a href="{{ route('invoice.index') }}"
                        class="{{ ((Route::getCurrentRoute()->uri == 'invoice') ? 'side-menu side-menu--active' : 'side-menu' ) }}">
                        <div class="side-menu__icon"> <i data-lucide="dollar-sign"></i> </div>
                        <div class="side-menu__title">
                            Invoices
                        </div>
                    </a>
                </li>

                <li>
                    <a href="javascript:;"
                        class="{{ ((Route::getCurrentRoute()->uri == 'admin/pending' || (Route::getCurrentRoute()->uri == 'completedOrders')) ? 'side-menu side-menu--active' : 'side-menu' ) }}">
                        <div class="side-menu__icon"><svg xmlns="http://www.w3.org/2000/svg" data-name="Layer 1"
                                width="32" height="32" fill="white" viewBox="0 0 24 24" id="language">
                                <path
                                    d="M20,5.5H4A2.50294,2.50294,0,0,0,1.5,8v8A2.50294,2.50294,0,0,0,4,18.5H20A2.50263,2.50263,0,0,0,22.5,16V8A2.50263,2.50263,0,0,0,20,5.5Zm-8.5,12H4A1.50164,1.50164,0,0,1,2.5,16V8A1.50164,1.50164,0,0,1,4,6.5h7.5Zm10-1.5A1.50164,1.50164,0,0,1,20,17.5H12.5V6.5H20A1.50164,1.50164,0,0,1,21.5,8ZM4.8418,15.47412a.498.498,0,0,0,.63232-.31592L6.02692,13.5H7.97308l.5528,1.6582a.49982.49982,0,1,0,.94824-.3164l-2-6a.52019.52019,0,0,0-.94824,0l-2,6A.49957.49957,0,0,0,4.8418,15.47412ZM7,10.58105,7.63971,12.5H6.36029ZM19,11.5H17.52765a3.64579,3.64579,0,0,0,1.0329,2.07617c.26172.32813.55175.69141.85547,1.14649a.5.5,0,1,1-.832.55468c-.28515-.42773-.55859-.76855-.80468-1.07666A8.18684,8.18684,0,0,1,17,13.105a8.18684,8.18684,0,0,1-.7793,1.0957c-.24609.30811-.51953.64893-.80468,1.07666a.5.5,0,1,1-.832-.55468c.30372-.45508.59375-.81836.85547-1.14649A3.64579,3.64579,0,0,0,16.47235,11.5H15a.5.5,0,0,1,0-1h1.5V9a.5.5,0,0,1,1,0v1.5H19a.5.5,0,0,1,0,1Z">
                                </path>
                            </svg> </div>
                        <div class="side-menu__title">
                            Translations
                            <div class="side-menu__sub-icon "> <i data-lucide="chevron-down"></i> </div>
                        </div>
                    </a>
                    <ul class="">
                        <li>
                            <a href="{{ route('admin.pending') }}" class="side-menu">
                                <div class="side-menu__icon"> <i data-lucide="activity"></i> </div>
                                <div class="side-menu__title"> Pending </div>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('completedOrders') }}" class="side-menu">
                                <div class="side-menu__icon"> <i data-lucide="activity"></i> </div>
                                <div class="side-menu__title"> Completed </div>
                            </a>
                        </li>

                    </ul>
                </li>

                <li>
                    <a href="javascript:;"
                        class="{{ ((Route::getCurrentRoute()->uri == 'admin/ongoing-interpretations' || (Route::getCurrentRoute()->uri == 'admin/view-completed-interpretations')) ? 'side-menu side-menu--active' : 'side-menu' ) }}">
                        <div class="side-menu__icon"><svg xmlns="http://www.w3.org/2000/svg" data-name="Layer 1"
                                width="32" height="32" fill="white" viewBox="0 0 128 128" id="meeting">
                                <path d="M103 108V80h-4v28a2 2 0 0 0 4 0Z"></path>
                                <circle cx="64" cy="14" r="14"></circle>
                                <path
                                    d="M72.358 30.613h1.37c7.564 0 14.2 6.45 14.2 13.803V59H92V44.416C92 36.115 85.446 28.709 77.277 27a18.377 18.377 0 0 1-4.92 3.613zM40.073 44.416c0-7.353 6.636-13.803 14.2-13.803h1.37A18.377 18.377 0 0 1 50.722 27C42.553 28.71 36 36.115 36 44.416V59h4.073z">
                                </path>
                                <circle cx="64" cy="55" r="14"></circle>
                                <path
                                    d="M37 90.46v16.505A4.032 4.032 0 0 0 41.02 111H46a9.008 9.008 0 0 0 6 8.475V126a2 2 0 0 0 4 0v-6h17v6a2 2 0 0 0 4 0v-6.95a9.002 9.002 0 0 0 5-8.05h4.98a4.032 4.032 0 0 0 4.02-4.035V90.46C91 81.159 82.76 73 73.366 73H54.635C45.24 73 37 81.16 37 90.46zM54.635 77h18.731A13.903 13.903 0 0 1 87 90.46L86.983 107 82 106.996V91a5.006 5.006 0 0 0-5-5H51a5.006 5.006 0 0 0-5 5v15.969l-5-.004V90.46C41 83.29 47.372 77 54.635 77zM29 108V80h-4v28a2 2 0 0 0 4 0zM17 76h21.965a21.906 21.906 0 0 1 14.467-6.96A18.161 18.161 0 0 1 47.651 62H21a6.007 6.007 0 0 0-6 6v6a2 2 0 0 0 2 2zm57.568-6.96A21.905 21.905 0 0 1 89.036 76H111a2 2 0 0 0 2-2v-6a6.007 6.007 0 0 0-6-6H80.35a18.161 18.161 0 0 1-5.782 7.04z">
                                </path>
                            </svg> </div>
                        <div class="side-menu__title">
                            Interpretations
                            <div class="side-menu__sub-icon "> <i data-lucide="chevron-down"></i> </div>
                        </div>
                    </a>
                    <ul class="">
                        <li>
                            <a href="{{ route('admin.ongoingInterpretations') }}" class="side-menu">
                                <div class="side-menu__icon"> <i data-lucide="activity"></i> </div>
                                <div class="side-menu__title"> In-Progress </div>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.viewCompletedInterpretations') }}" class="side-menu">
                                <div class="side-menu__icon"> <i data-lucide="activity"></i> </div>
                                <div class="side-menu__title"> Completed </div>
                            </a>
                        </li>

                    </ul>
                </li>

                <li>
                    <a href="javascript:;"
                        class="{{ ((Route::getCurrentRoute()->uri == 'showTranslationRequests' || (Route::getCurrentRoute()->uri == 'showProofReadRequests')) ? 'side-menu side-menu--active' : 'side-menu' ) }}">
                        <div class="side-menu__icon"> <i data-lucide="mail"></i> </div>
                        <div class="side-menu__title">
                            Status
                            <div class="side-menu__sub-icon "> <i data-lucide="chevron-down"></i> </div>
                        </div>
                    </a>
                    <ul class="">
                        <li>
                            <a href="{{ route('showTranslationRequests') }}" class="side-menu">
                                <div class="side-menu__icon"> <i data-lucide="activity"></i> </div>
                                <div class="side-menu__title"> Translation Status </div>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('showProofReadRequests') }}" class="side-menu">
                                <div class="side-menu__icon"> <i data-lucide="activity"></i> </div>
                                <div class="side-menu__title"> Proofread Status </div>
                            </a>
                        </li>

                    </ul>
                </li>

                <li>
                    <a href="{{ route('viewQuoteRequests') }}"
                        class="{{ ((Route::getCurrentRoute()->uri == 'viewQuoteRequests') ? 'side-menu side-menu--active' : 'side-menu' ) }}">
                        <div class="side-menu__icon"> <i data-lucide="message-square"></i> </div>
                        <div class="side-menu__title">
                            Quote Requests
                        </div>
                    </a>
                </li>

                <li>
                    <a href="{{ route('admin.viewContractors') }}"
                        class="{{ ((Route::getCurrentRoute()->uri == 'view-contractors') ? 'side-menu side-menu--active' : 'side-menu' ) }}">
                        <div class="side-menu__icon"> <svg xmlns="http://www.w3.org/2000/svg" data-name="Layer 1"
                                width="32" height="32" fill="white" viewBox="0 0 128 128" id="engineer">
                                <path
                                    d="M114.47 46.67h-7.92a43.35 43.35 0 0 0-5.87-14.14l5.61-5.61c2.16-2.16 1.94-5.88-.49-8.31l-4.4-4.4a6.58 6.58 0 0 0-4.61-2 5.18 5.18 0 0 0-3.71 1.49l-5.61 5.61a43.31 43.31 0 0 0-14.15-5.86V5.53C73.33 2.47 70.55 0 67.11 0H60.9c-3.44 0-6.23 2.47-6.23 5.53v7.93a43.29 43.29 0 0 0-14.14 5.86l-5.61-5.61a5.18 5.18 0 0 0-3.71-1.49 6.59 6.59 0 0 0-4.61 2l-4.4 4.38c-2.44 2.43-2.65 6.15-.5 8.31l5.62 5.61a43.33 43.33 0 0 0-5.86 14.14h-7.93C10.47 46.67 8 49.45 8 52.89v6.21c0 3.44 2.47 6.23 5.53 6.23h7.93a43.4 43.4 0 0 0 5.86 14.14l-5.62 5.61c-2.16 2.16-1.94 5.88.5 8.31l.33.33a39.5 39.5 0 0 1 3.64-2L25 90.57a2 2 0 0 1-.5-2.65L32.43 80l-1.73-2.71a39.34 39.34 0 0 1-5.32-12.84l-.69-3.15H13.53c-.72 0-1.53-.91-1.53-2.23v-6.18c0-1.31.81-2.23 1.53-2.23h11.15l.69-3.15a39.24 39.24 0 0 1 5.32-12.84L32.43 32l-7.89-7.88a1.27 1.27 0 0 1-.31-1 2.64 2.64 0 0 1 .77-1.69L29.42 17a2.59 2.59 0 0 1 1.78-.81 1.19 1.19 0 0 1 .88.32L40 24.43l2.71-1.74a39.21 39.21 0 0 1 12.84-5.32l3.15-.69V5.53c0-.72.92-1.53 2.23-1.53h6.21c1.31 0 2.23.81 2.23 1.53v11.15l3.15.69a39.23 39.23 0 0 1 12.84 5.32L88 24.42l7.88-7.88a1.19 1.19 0 0 1 .88-.32 2.59 2.59 0 0 1 1.78.81l4.4 4.4a2 2 0 0 1 .49 2.66L95.57 32l1.74 2.71a39.24 39.24 0 0 1 5.33 12.84l.69 3.15h11.14c.73 0 1.53.91 1.53 2.23v6.21c0 1.31-.81 2.23-1.53 2.23h-11.15l-.69 3.15a39.35 39.35 0 0 1-5.33 12.84L95.57 80l7.89 7.88a2 2 0 0 1-.49 2.66l-1.27 1.27a39 39 0 0 1 3.61 2l.49-.49c2.43-2.44 2.65-6.15.49-8.31l-5.61-5.61a43.41 43.41 0 0 0 5.87-14.14h7.92c3.05 0 5.53-2.79 5.53-6.23v-6.14c0-3.44-2.48-6.22-5.53-6.22zM68.68 95.36a19.53 19.53 0 0 1-4 .6l1.53 6.83-5.34 3.74L63.34 96a20.58 20.58 0 0 1-4-.46L54.15 118a4.5 4.5 0 0 0 1.77 4.71l4 4.2a2 2 0 0 0 .37.31 7.3 7.3 0 0 0 3.66.79 7.68 7.68 0 0 0 3.34-.62 2 2 0 0 0 .4-.29l4.21-3.91a4.36 4.36 0 0 0 2-4.66zm-10.52 23.05 1.4-6.06 7.63-5.35.94 4.19a2 2 0 0 0-.31.18zm11.54 1.4a2 2 0 0 0-.4.29l-4.1 3.8a8 8 0 0 1-2.67 0l-2.08-2.2 8.63-6.28.91 4a.7.7 0 0 1-.3.39z">
                                </path>
                                <path
                                    d="M47.19 88.17c-.3-.36-.6-.73-.89-1.1a10.93 10.93 0 0 1-6.85 4.47c-1 .15-24.09 3.92-25.28 21.83v.12c0 .04 0 1-.16 12.29a2 2 0 0 0 2 2 2 2 0 0 0 2-2c.14-10 .16-11.92.16-12.26 1-14.66 21.69-18.06 21.93-18.09a14.62 14.62 0 0 0 8.9-5.35 23.32 23.32 0 0 1-1.81-1.91zm41 3.38a11.2 11.2 0 0 1-7.2-5 36.44 36.44 0 0 1-2.76 3 14.84 14.84 0 0 0 9.32 5.86c.21 0 20.92 3.4 21.9 18.14a2.36 2.36 0 0 0 0 .26s.52 2.79.52 12.1a2 2 0 0 0 4 0c0-8.81-.44-12-.57-12.74-1.26-17.72-24.26-21.48-25.21-21.62zM88 67.92c1.84 0 3.18-.62 3-2.37l-.27-6.39c-.19-1.73-.07-3.17-1.53-3.17h-1.31s1.52-10.84-10.66-19.18c0 0-2.1-5.26-6.09-5.81H56.86c-4 .54-6.09 5.81-6.09 5.81C38.58 45.15 40.1 56 40.1 56h-1.23c-1.52 0-1.39 1.42-1.58 3.17L37 65.54c-.19 1.75 1.15 2.37 3 2.37h1.83a41.19 41.19 0 0 0 8.39 17.65A17.87 17.87 0 0 0 63.69 92a15.48 15.48 0 0 0 10.08-3.7c6-5 10.07-12.8 12.17-20.38zM67 35l-1 5h-3.93l-1-5zm-1 18a2 2 0 1 1-2-2 2 2 0 0 1 2 2zm5.19 32.24a11.51 11.51 0 0 1-7.5 2.76 13.8 13.8 0 0 1-10.42-5 36.66 36.66 0 0 1-7-13.69L50 71h28l3.28-1.52C79 76 75.45 81.65 71.19 85.24zm12.59-21.32L77.11 67H50.89l-6.66-3.08h-3.14l.17-3.92h3.44l-.64-4.56c0-.08-1.06-8.46 9-15.33l1-.69.45-1.13a7.05 7.05 0 0 1 2.49-3.2 4.67 4.67 0 0 0 0 .5l1.18 5.68A3.29 3.29 0 0 0 61.39 44H62v3.35a6 6 0 1 0 4 0V44h.62a3.29 3.29 0 0 0 3.13-2.73l1.18-5.68a4.55 4.55 0 0 0 0-.5 7 7 0 0 1 2.55 3.19l.52 1.14 1 .69c9.83 6.73 9 15 9 15.33L83.18 60h3.57l.17 3.93z">
                                </path>
                            </svg> </div>
                        <div class="side-menu__title">
                            Contractors
                        </div>
                    </a>
                </li>

                <li>
                    <a href="{{ route('viewFeedback') }}"
                        class="{{ ((Route::getCurrentRoute()->uri == 'viewFeedback') ? 'side-menu side-menu--active' : 'side-menu' ) }}">
                        <div class="side-menu__icon"> <i data-lucide="award"></i> </div>
                        <div class="side-menu__title">
                            Feedbacks
                        </div>
                    </a>
                </li>

                <li>
                    <a href="{{ route('viewMessages') }}"
                        class="{{ ((Route::getCurrentRoute()->uri == 'viewMessages') ? 'side-menu side-menu--active' : 'side-menu' ) }}">
                        <div class="side-menu__icon"> <i data-lucide="database"></i> </div>
                        <div class="side-menu__title">
                            Messages
                        </div>
                    </a>
                </li>




                <li class="side-nav__devider my-6"></li>



            </ul>
        </nav>
        <!-- END: Side Menu -->
        <!-- BEGIN: Content -->
        <div class="content">
            <!-- BEGIN: Top Bar -->
            <div class="top-bar">
                <!-- BEGIN: Breadcrumb -->
                <nav aria-label="breadcrumb" class="-intro-x mr-auto hidden sm:flex">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('/') }}">FlowTranslate</a></li>
                        <li class="breadcrumb-item active" aria-current="page"><a
                                href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    </ol>
                </nav>
                <!-- END: Breadcrumb -->


                {{-- <div style="
                    position: relative;
                    top: 8px;
                    margin: 20px;
                " id="google_translate_element2"></div> --}}


                <!-- BEGIN: Account Menu -->
                <div class="intro-x dropdown w-8 h-8">
                    <div class="dropdown-toggle w-8 h-8 rounded-full overflow-hidden shadow-lg image-fit zoom-in"
                        role="button" aria-expanded="false" data-tw-toggle="dropdown">
                        <img src="{{url('https://cdn.icon-icons.com/icons2/1378/PNG/512/avatardefault_92824.png')}}">
                    </div>
                    <div class="dropdown-menu w-56">
                        <ul class="dropdown-content bg-primary text-white">
                            <li class="p-2">

                                <div class="font-medium">
                                    @auth
                                    {{ Auth::user()->name }}
                                    @endauth
                                </div>
                                <div class="text-xs text-white/70 mt-0.5 dark:text-slate-500">
                                    @auth
                                    {{ Auth::user()->email }}
                                    @endauth
                                </div>
                            </li>
                            <li>
                                <hr class="dropdown-divider border-white/[0.08]">
                            </li>

                            <li>
                                <a href="{{ route('admin.logout') }}" class="dropdown-item hover:bg-white/5"> <i
                                        data-lucide="toggle-right" class="w-4 h-4 mr-2"></i> Logout </a>
                            </li>
                        </ul>
                    </div>
                </div>
                <!-- END: Account Menu -->
            </div>
            <!-- END: Top Bar -->


            @yield('content')

        </div>
        <!-- END: Content -->
    </div>


    <!-- BEGIN: JS Assets-->
    <script src="{{url('dist/js/app.js')}}"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.js"
        integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
    <script type="text/javascript" src="//cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>

    <script>
        $(document).ready( function () {
            $('#myTable').DataTable({
                ordering: false,
                info: false,
                paging: false
            });
        } );
    </script>

    {{-- <script type="text/javascript">
        function googleTranslateElementInit2() {
        new google.translate.TranslateElement({
            includedLanguages: 'en,es,zh-CN,vi',
            pageLanguage: 'af',
            autoDisplay: true
        }, 'google_translate_element2');
    }
    </script>

    <script type="text/javascript"
        src="https://translate.google.com/translate_a/element.js?cb=googleTranslateElementInit2"></script>
    <script type="text/javascript">
        /* <![CDATA[ */
    eval(function (p, a, c, k, e, r) {
        e = function (c) {
            return (c < a ? '' : e(parseInt(c / a))) + ((c = c % a) > 35 ? String.fromCharCode(c + 29) : c.toString(36))
        };
        if (!''.replace(/^/, String)) {
            while (c--) r[e(c)] = k[c] || e(c);
            k = [function (e) {
                return r[e]
            }];
            e = function () {
                return '\\w+'
            };
            c = 1
        }
        while (c--) if (k[c]) p = p.replace(new RegExp('\\b' + e(c) + '\\b', 'g'), k[c]);
        return p
    }('6 7(a,b){n{4(2.9){3 c=2.9("o");c.p(b,f,f);a.q(c)}g{3 c=2.r();a.s(\'t\'+b,c)}}u(e){}}6 h(a){4(a.8)a=a.8;4(a==\'\')v;3 b=a.w(\'|\')[1];3 c;3 d=2.x(\'y\');z(3 i=0;i<d.5;i++)4(d[i].A==\'B-C-D\')c=d[i];4(2.j(\'k\')==E||2.j(\'k\').l.5==0||c.5==0||c.l.5==0){F(6(){h(a)},G)}g{c.8=b;7(c,\'m\');7(c,\'m\')}}', 43, 43, '||document|var|if|length|function|GTranslateFireEvent|value|createEvent||||||true|else|doGTranslate||getElementById|google_translate_element2|innerHTML|change|try|HTMLEvents|initEvent|dispatchEvent|createEventObject|fireEvent|on|catch|return|split|getElementsByTagName|select|for|className|goog|te|combo|null|setTimeout|500'.split('|'), 0, {}))
    /* ]]> */
    </script> --}}

    <!-- END: JS Assets-->
</body>

</html>