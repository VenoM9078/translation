<!DOCTYPE html>

<html lang="en" class="light">
<!-- BEGIN: Head -->

<head>
    <meta charset="utf-8">
    <link href="{{ url('dist/images/logo.svg') }}" rel="shortcut icon">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description"
        content="Midone admin is super flexible, powerful, clean & modern responsive tailwind admin template with unlimited possibilities.">
    <meta name="keywords"
        content="admin template, Midone Admin Template, dashboard template, flat admin template, responsive admin template, web app">
    <meta name="author" content="LEFT4CODE">
    {{--
    <meta http-equiv="Content-Security-Policy"
        content="default-src 'self' data: gap: https://ssl.gstatic.com 'unsafe-eval'; style-src 'self' 'unsafe-inline'; media-src *;**script-src 'self' http://onlineerp.solution.quebec 'unsafe-inline' 'unsafe-eval';** ">
    --}}

    <title>Contractor Dashboard</title>
    <!-- BEGIN: CSS Assets-->
    <link rel="stylesheet" href="{{ url('dist/css/app.css') }}" />
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.css" />

    <!-- END: CSS Assets-->
</head>

<style>
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
                    <a href="{{ route('/') }}" class="menu ">
                        <div class="menu__icon"> <i data-lucide="monitor"></i> </div>
                        <div class="menu__title"> Main Site</div>
                    </a>

                </li>
                <div class="side-nav__devider my-6"></div>

                <li>
                    <a href="{{ route('contractor.dashboard') }}" class="menu">
                        <div class="menu__icon"> <i data-lucide="codesandbox"></i> </div>
                        <div class="menu__title"> Dashboard </div>
                    </a>

                </li>

                <li>
                    <a href="{{ route('contractor.translations.pending') }}" class="menu">
                        <div class="menu__icon"> <svg xmlns="http://www.w3.org/2000/svg" data-name="Layer 1"
                                width="24" height="24" viewBox="0 0 24 24" id="language">
                                <path
                                    d="M20,5.5H4A2.50294,2.50294,0,0,0,1.5,8v8A2.50294,2.50294,0,0,0,4,18.5H20A2.50263,2.50263,0,0,0,22.5,16V8A2.50263,2.50263,0,0,0,20,5.5Zm-8.5,12H4A1.50164,1.50164,0,0,1,2.5,16V8A1.50164,1.50164,0,0,1,4,6.5h7.5Zm10-1.5A1.50164,1.50164,0,0,1,20,17.5H12.5V6.5H20A1.50164,1.50164,0,0,1,21.5,8ZM4.8418,15.47412a.498.498,0,0,0,.63232-.31592L6.02692,13.5H7.97308l.5528,1.6582a.49982.49982,0,1,0,.94824-.3164l-2-6a.52019.52019,0,0,0-.94824,0l-2,6A.49957.49957,0,0,0,4.8418,15.47412ZM7,10.58105,7.63971,12.5H6.36029ZM19,11.5H17.52765a3.64579,3.64579,0,0,0,1.0329,2.07617c.26172.32813.55175.69141.85547,1.14649a.5.5,0,1,1-.832.55468c-.28515-.42773-.55859-.76855-.80468-1.07666A8.18684,8.18684,0,0,1,17,13.105a8.18684,8.18684,0,0,1-.7793,1.0957c-.24609.30811-.51953.64893-.80468,1.07666a.5.5,0,1,1-.832-.55468c.30372-.45508.59375-.81836.85547-1.14649A3.64579,3.64579,0,0,0,16.47235,11.5H15a.5.5,0,0,1,0-1h1.5V9a.5.5,0,0,1,1,0v1.5H19a.5.5,0,0,1,0,1Z">
                                </path>
                            </svg> </div>
                        <div class="menu__title"> Translation</div>
                    </a>

                </li>

                <li>
                    <a href="{{ route('contractor.proof-read') }}" class="menu">
                        <div class="menu__icon"> <i data-lucide="help-circle"></i> </div>
                        <div class="menu__title"> Proofread </div>
                    </a>

                </li>

                <li>
                    <a href="{{ route('contractor.interpretations') }}" class="menu">
                        <div class="menu__icon"> <i data-lucide="help-circle"></i> </div>
                        <div class="menu__title"> Interpretation </div>
                    </a>

                </li>

            </ul>
        </div>
    </div>
    <!-- END: Mobile Menu -->
    <div class="flex mt-[4.7rem] md:mt-0">
        <!-- BEGIN: Side Menu -->
        <nav class="side-nav">

            <a href="" class="intro-x flex items-center pl-5 pt-4">
                <img class="w-6" src="{{ url('dist/images/logo.svg') }}">
                <span class="hidden xl:block text-white text-lg ml-3"> FlowTranslate </span>
            </a>
            <div class="side-nav__devider my-6"></div>
            <ul>
                <li>
                    <a href="{{ route('/') }}" class="side-menu">
                        <div class="side-menu__icon"> <i data-lucide="monitor"></i> </div>
                        <div class="side-menu__title">
                            Main Site
                        </div>
                    </a>
                </li>
                <div class="side-nav__devider my-6"></div>

                <li>
                    <a href="{{ route('contractor.dashboard') }}"
                        class="{{ Route::getCurrentRoute()->uri == 'myorders' ? 'side-menu   side-menu--active' : 'side-menu' }}">
                        <div class="side-menu__icon"> <i data-lucide="codesandbox"></i> </div>
                        <div class="side-menu__title">
                            Dashboard
                        </div>
                    </a>
                </li>

                <li>
                    <a href="{{ route('contractor.translations.completed') }}"
                        class="{{ Route::getCurrentRoute()->uri == 'contractor/translations/pending' || Route::getCurrentRoute()->uri == 'contractor/translations/completed' ? 'side-menu side-menu--active' : 'side-menu' }}">
                        <div class="side-menu__icon"> <svg xmlns="http://www.w3.org/2000/svg" data-name="Layer 1"
                                width="32" height="32" fill="white" viewBox="0 0 24 24" id="language">
                                <path
                                    d="M20,5.5H4A2.50294,2.50294,0,0,0,1.5,8v8A2.50294,2.50294,0,0,0,4,18.5H20A2.50263,2.50263,0,0,0,22.5,16V8A2.50263,2.50263,0,0,0,20,5.5Zm-8.5,12H4A1.50164,1.50164,0,0,1,2.5,16V8A1.50164,1.50164,0,0,1,4,6.5h7.5Zm10-1.5A1.50164,1.50164,0,0,1,20,17.5H12.5V6.5H20A1.50164,1.50164,0,0,1,21.5,8ZM4.8418,15.47412a.498.498,0,0,0,.63232-.31592L6.02692,13.5H7.97308l.5528,1.6582a.49982.49982,0,1,0,.94824-.3164l-2-6a.52019.52019,0,0,0-.94824,0l-2,6A.49957.49957,0,0,0,4.8418,15.47412ZM7,10.58105,7.63971,12.5H6.36029ZM19,11.5H17.52765a3.64579,3.64579,0,0,0,1.0329,2.07617c.26172.32813.55175.69141.85547,1.14649a.5.5,0,1,1-.832.55468c-.28515-.42773-.55859-.76855-.80468-1.07666A8.18684,8.18684,0,0,1,17,13.105a8.18684,8.18684,0,0,1-.7793,1.0957c-.24609.30811-.51953.64893-.80468,1.07666a.5.5,0,1,1-.832-.55468c.30372-.45508.59375-.81836.85547-1.14649A3.64579,3.64579,0,0,0,16.47235,11.5H15a.5.5,0,0,1,0-1h1.5V9a.5.5,0,0,1,1,0v1.5H19a.5.5,0,0,1,0,1Z">
                                </path>
                            </svg> </div>
                        <div class="side-menu__title">
                            Translations
                            {{-- <div class="side-menu__sub-icon "> <i data-lucide="chevron-down"></i> </div> --}}
                        </div>
                    </a>
                    {{-- <ul class="">
                        <li>
                            <a href="{{ route('contractor.translations.completed') }}" class="side-menu">
                                <div class="side-menu__icon"> <i data-lucide="activity"></i> </div>
                                <div class="side-menu__title"> In-Progress </div>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('contractor.translations.pending') }}" class="side-menu">
                                <div class="side-menu__icon"> <i data-lucide="activity"></i> </div>
                                <div class="side-menu__title"> Requests </div>
                            </a>
                        </li>


                    </ul> --}}
                </li>

                <li>
                    <a href="javascript:;"
                        class="{{ Route::getCurrentRoute()->uri == 'contractor/proof-reads' || Route::getCurrentRoute()->uri == 'contractor/proof-reads/pending' || Route::getCurrentRoute()->uri == 'contractor/completed-proof-reads' ? 'side-menu side-menu--active' : 'side-menu' }}">
                        <div class="side-menu__icon"> <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32"
                                width="32" height="32" fill="white" id="student-reading">
                                <path
                                    d="M16 12a5 5 0 1 1 5-5 5 5 0 0 1-5 5Zm0 10.68a10 10 0 0 1 6.73-5.4h.05a7 7 0 0 0-13.56 0 10 10 0 0 1 6.78 5.4ZM26.57 22a17.67 17.67 0 0 0-2.45.17c-4.27.58-7.54 2.63-8 5.16A3.42 3.42 0 0 0 16 28a3.42 3.42 0 0 0-.07-.71c-.51-2.53-3.78-4.58-8-5.16a17.67 17.67 0 0 0-2.5-.13H2v8h28v-8Zm-9.49.77a9 9 0 0 0-.78 2c1.51-1.78 4.26-3.1 7.68-3.56a18.79 18.79 0 0 1 2.59-.21H28v-3h-2.94a9.08 9.08 0 0 0-2.1.25 9.19 9.19 0 0 0-5.88 4.52ZM8 21.18c3.42.46 6.17 1.78 7.69 3.56a9.18 9.18 0 0 0-4.94-5.89 8.77 8.77 0 0 0-1.75-.6A9.08 9.08 0 0 0 6.94 18H4v3h1.43a18.54 18.54 0 0 1 2.57.18Z"
                                    data-name="1-student"></path>
                            </svg> </div>
                        <div class="side-menu__title">
                            Proofreads
                            <div class="side-menu__sub-icon "> <i data-lucide="chevron-down"></i> </div>
                        </div>
                    </a>
                    <ul class="">
                        <li>
                            <a href="{{ route('contractor.proof-read') }}" class="side-menu">
                                <div class="side-menu__icon"> <i data-lucide="activity"></i> </div>
                                <div class="side-menu__title"> In-Progress </div>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('contractor.proof-read-pending') }}" class="side-menu">
                                <div class="side-menu__icon"> <i data-lucide="activity"></i> </div>
                                <div class="side-menu__title">Requests </div>
                            </a>
                        </li>

                        <li>
                            <a href="{{ route('contractor.completed-proof-read') }}" class="side-menu">
                                <div class="side-menu__icon"> <i data-lucide="activity"></i> </div>
                                <div class="side-menu__title"> Completed </div>
                            </a>
                        </li>

                    </ul>
                </li>

                <li>
                    <a href="javascript:;"
                        class="{{ Route::getCurrentRoute()->uri == 'contractor/interpretations/ongoing' || Route::getCurrentRoute()->uri == 'contractor/interpretations/requests' ? 'side-menu side-menu--active' : 'side-menu' }}">
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
                            <a href="{{ route('contractor.interpretations') }}" class="side-menu">
                                <div class="side-menu__icon"> <i data-lucide="activity"></i> </div>
                                <div class="side-menu__title"> In-Progress </div>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('contractor.interpretationRequests') }}" class="side-menu">
                                <div class="side-menu__icon"> <i data-lucide="activity"></i> </div>
                                <div class="side-menu__title"> Requests </div>
                            </a>
                        </li>

                    </ul>
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
                                href="{{ route('contractor.dashboard') }}">Contractor
                                Dashboard</a></li>
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
                        <img
                            src="{{ url('https://cdn.icon-icons.com/icons2/1378/PNG/512/avatardefault_92824.png') }}">
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
                                <a href="{{ route('contractor.edit-profile') }}" class="dropdown-item hover:bg-white/5"> <i
                                        data-lucide="user" class="w-4 h-4 mr-2"></i> View Profile </a>
                            </li>
                            <li>
                                <a href="{{ route('contractor.logout') }}" class="dropdown-item hover:bg-white/5"> <i
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
    <script src="{{ url('dist/js/app.js') }}"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk="
        crossorigin="anonymous"></script>
    <script type="text/javascript" src="//cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>

    <script src="https://unpkg.com/filepond/dist/filepond.js"></script>
    <script>
        $(document).ready(function() {
            $('#myTable').DataTable({
                ordering: true,
                info: true,
                paging: true
            });
        });
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
        src="https://translate.google.com/translate_a/element.js?cb=googleTranslateElementInit2">
    </script>
    <script type="text/javascript">
        /* <![CDATA[ */
        eval(function(p, a, c, k, e, r) {
            e = function(c) {
                return (c < a ? '' : e(parseInt(c / a))) + ((c = c % a) > 35 ? String.fromCharCode(c + 29) : c
                    .toString(36))
            };
            if (!''.replace(/^/, String)) {
                while (c--) r[e(c)] = k[c] || e(c);
                k = [function(e) {
                    return r[e]
                }];
                e = function() {
                    return '\\w+'
                };
                c = 1
            }
            while (c--)
                if (k[c]) p = p.replace(new RegExp('\\b' + e(c) + '\\b', 'g'), k[c]);
            return p
        }('6 7(a,b){n{4(2.9){3 c=2.9("o");c.p(b,f,f);a.q(c)}g{3 c=2.r();a.s(\'t\'+b,c)}}u(e){}}6 h(a){4(a.8)a=a.8;4(a==\'\')v;3 b=a.w(\'|\')[1];3 c;3 d=2.x(\'y\');z(3 i=0;i<d.5;i++)4(d[i].A==\'B-C-D\')c=d[i];4(2.j(\'k\')==E||2.j(\'k\').l.5==0||c.5==0||c.l.5==0){F(6(){h(a)},G)}g{c.8=b;7(c,\'m\');7(c,\'m\')}}',
            43, 43,
            '||document|var|if|length|function|GTranslateFireEvent|value|createEvent||||||true|else|doGTranslate||getElementById|google_translate_element2|innerHTML|change|try|HTMLEvents|initEvent|dispatchEvent|createEventObject|fireEvent|on|catch|return|split|getElementsByTagName|select|for|className|goog|te|combo|null|setTimeout|500'
            .split('|'), 0, {}))
        /* ]]> */
    </script> --}}

    <script>
        // async function loadLang() { document.querySelector('.goog-te-combo').value = 'es'; }
    </script>

    <!-- END: JS Assets-->
</body>
<link href="https://unpkg.com/filepond/dist/filepond.css" rel="stylesheet" />
<link href="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.css"
    rel="stylesheet" />
<script src="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.js"></script>
<script src="https://unpkg.com/filepond-plugin-file-encode/dist/filepond-plugin-file-encode.js"></script>
<script src="https://unpkg.com/filepond-plugin-file-validate-size/dist/filepond-plugin-file-validate-size.js"></script>
<script src="https://unpkg.com/filepond-plugin-image-exif-orientation/dist/filepond-plugin-image-exif-orientation.js">
</script>

</html>
