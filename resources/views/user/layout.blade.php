
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
        <title>Dashboard</title>
        <!-- BEGIN: CSS Assets-->
        <link rel="stylesheet" href="{{ url('dist/css/app.css') }}" />
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.css"/>

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
                        <a href="{{ route('user.index') }}" class="menu menu--active">
                            <div class="menu__icon"> <i data-lucide="home"></i> </div>
                            <div class="menu__title"> Dashboard</div>
                        </a>
                        
                    </li>
                   
                    <li>
                        <a href="{{ route('myorders') }}" class="menu">
                            <div class="menu__icon"> <i data-lucide="archive"></i> </div>
                            <div class="menu__title"> My Orders</div>
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
                    <img class="w-6" src="{{url('dist/images/logo.svg')}}">
                    <span class="hidden xl:block text-white text-lg ml-3"> FlowTranslate </span> 
                </a>
                <div class="side-nav__devider my-6"></div>
                <ul>
                    <li>
                        <a href="{{ route('user.index') }}" class="{{ ((Route::getCurrentRoute()->uri == 'user') ? 'side-menu   side-menu--active' : 'side-menu' ) }}">
                            <div class="side-menu__icon"> <i data-lucide="home"></i> </div>
                            <div class="side-menu__title">
                                Dashboard 
                            </div>
                        </a>
                    </li>
                  
                    <li>
                        <a href="{{ route('myorders') }}" class="{{ ((Route::getCurrentRoute()->uri == 'myorders') ? 'side-menu   side-menu--active' : 'side-menu' ) }}">
                            <div class="side-menu__icon"> <i data-lucide="archive"></i> </div>
                            <div class="side-menu__title">
                                My Orders 
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
                            <li class="breadcrumb-item active" aria-current="page"><a href="{{ route('user.index') }}">User Dashboard</a></li>
                        </ol>
                    </nav>
                    <!-- END: Breadcrumb -->

     
                    <!-- BEGIN: Account Menu -->
                    <div class="intro-x dropdown w-8 h-8">
                        <div class="dropdown-toggle w-8 h-8 rounded-full overflow-hidden shadow-lg image-fit zoom-in" role="button" aria-expanded="false" data-tw-toggle="dropdown">
                            <img  src="{{url('https://cdn.icon-icons.com/icons2/1378/PNG/512/avatardefault_92824.png')}}">
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
                                    <a href="{{ route('logout') }}" class="dropdown-item hover:bg-white/5"> <i data-lucide="toggle-right" class="w-4 h-4 mr-2"></i> Logout </a>
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
        <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous" ></script>
<script type="text/javascript" src="//cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>

<script>
 $(document).ready( function () {
    $('#myTable').DataTable({
        info: false,
        paging: false
    });
} );
</script>
        
        <!-- END: JS Assets-->
    </body>
</html>