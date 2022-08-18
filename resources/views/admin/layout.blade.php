
<!DOCTYPE html>

<html lang="en" class="light">
    <!-- BEGIN: Head -->
    <head>
        <meta charset="utf-8">
        <link href="{{url('dist/images/logo.svg')}}" rel="shortcut icon">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="Midone admin is super flexible, powerful, clean & modern responsive tailwind admin template with unlimited possibilities.">
        <meta name="keywords" content="admin template, Midone Admin Template, dashboard template, flat admin template, responsive admin template, web app">
        <meta name="author" content="LEFT4CODE">
        <title>Admin Dashboard</title>
        <!-- BEGIN: CSS Assets-->
        <link rel="stylesheet" href="{{ url('dist/css/app.css') }}" />
        <!-- END: CSS Assets-->
    </head>
    <!-- END: Head -->
    <body class="py-5">
        <!-- BEGIN: Mobile Menu -->
        <div class="mobile-menu md:hidden">
            <div class="mobile-menu-bar">
                <a href="" class="flex mr-auto">
                    <img alt="Midone - HTML Admin Template" class="w-6" src="{{ url('dist/images/logo.svg') }}">
                </a>
                <a href="javascript:;" class="mobile-menu-toggler"> <i data-lucide="bar-chart-2" class="w-8 h-8 text-white transform -rotate-90"></i> </a>
            </div>
            <div class="scrollable">
                <a href="javascript:;" class="mobile-menu-toggler"> <i data-lucide="x-circle" class="w-8 h-8 text-white transform -rotate-90"></i> </a>
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
                            <div class="menu__title"> Menu Layout <i data-lucide="chevron-down" class="menu__sub-icon "></i> </div>
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
                        <a href="{{route('admin.dashboard')}}" class="{{ ((Route::getCurrentRoute()->uri == 'admin/dashboard') ? 'side-menu   side-menu--active' : 'side-menu' ) }}">
                            <div class="side-menu__icon"> <i data-lucide="home"></i> </div>
                            <div class="side-menu__title">
                                Dashboard 
                            </div>
                        </a>
                    </li>


                    <li>
                        <a href="{{ route('invoice.index') }}" class="{{ ((Route::getCurrentRoute()->uri == 'invoice') ? 'side-menu side-menu--active' : 'side-menu' ) }}">
                            <div class="side-menu__icon"> <i data-lucide="dollar-sign"></i> </div>
                            <div class="side-menu__title">
                                Invoices
                            </div>
                        </a>
                    </li>

                    <li>
                        <a href="javascript:;" class="{{ ((Route::getCurrentRoute()->uri == 'admin/pending' || (Route::getCurrentRoute()->uri == 'completedOrders')) ? 'side-menu side-menu--active' : 'side-menu' ) }}">
                            <div class="side-menu__icon"> <i data-lucide="activity"></i> </div>
                            <div class="side-menu__title">
                                Orders 
                                <div class="side-menu__sub-icon "> <i data-lucide="chevron-down"></i> </div>
                            </div>
                        </a>
                        <ul class="">
                            <li>
                                <a href="{{ route('admin.pending') }}" class="side-menu">
                                    <div class="side-menu__icon"> <i data-lucide="activity"></i> </div>
                                    <div class="side-menu__title"> Pending Orders </div>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('completedOrders') }}" class="side-menu">
                                    <div class="side-menu__icon"> <i data-lucide="activity"></i> </div>
                                    <div class="side-menu__title"> Completed Orders </div>
                                </a>
                            </li>
                        
                        </ul>
                    </li>

                    <li>
                        <a href="javascript:;" class="{{ ((Route::getCurrentRoute()->uri == 'showTranslationRequests' || (Route::getCurrentRoute()->uri == 'showProofReadRequests')) ? 'side-menu side-menu--active' : 'side-menu' ) }}">
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
                        <a href="{{ route('viewQuoteRequests') }}" class="{{ ((Route::getCurrentRoute()->uri == 'viewQuoteRequests') ? 'side-menu side-menu--active' : 'side-menu' ) }}">
                            <div class="side-menu__icon"> <i data-lucide="message-square"></i> </div>
                            <div class="side-menu__title">
                                Quote Requests
                            </div>
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('viewFeedback') }}" class="{{ ((Route::getCurrentRoute()->uri == 'viewFeedback') ? 'side-menu side-menu--active' : 'side-menu' ) }}">
                            <div class="side-menu__icon"> <i data-lucide="award"></i> </div>
                            <div class="side-menu__title">
                                Feedbacks
                            </div>
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('viewMessages') }}" class="{{ ((Route::getCurrentRoute()->uri == 'viewMessages') ? 'side-menu side-menu--active' : 'side-menu' ) }}">
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
                            <li class="breadcrumb-item"><a href="#">Translators</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
                        </ol>
                    </nav>
                    <!-- END: Breadcrumb -->

     
                    <!-- BEGIN: Account Menu -->
                    <div class="intro-x dropdown w-8 h-8">
                        <div class="dropdown-toggle w-8 h-8 rounded-full overflow-hidden shadow-lg image-fit zoom-in" role="button" aria-expanded="false" data-tw-toggle="dropdown">
                            <img src="{{url('dist/images/profile-6.jpg')}}">
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
                                    <a href="{{ route('admin.logout') }}" class="dropdown-item hover:bg-white/5"> <i data-lucide="toggle-right" class="w-4 h-4 mr-2"></i> Logout </a>
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
        <!-- END: JS Assets-->
    </body>
</html>