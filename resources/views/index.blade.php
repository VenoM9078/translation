<!doctype html>
<html class="no-js" lang="zxx">

<head>

    <!--========= Required meta tags =========-->
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!--====== Title ======-->
    <title>Flow Translate - Home</title>

    <!--====== Favicon ======-->
    <link rel="shortcut icon" href="{{ url('dist/images/logo.svg') }}" type="images/x-icon" />

    <!--====== CSS Here ======-->
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/font-awesome.min.css">
    <link rel="stylesheet" href="assets/css/lightcase.css">
    <link rel="stylesheet" href="assets/css/meanmenu.css">
    <link rel="stylesheet" href="assets/css/nice-select.css">
    <link rel="stylesheet" href="assets/css/owl.carousel.min.css">
    <link rel="stylesheet" href="assets/css/odometer.css">
    <link rel="stylesheet" href="assets/css/animate.min.css">
    <link rel="stylesheet" href="assets/css/preloader.css">
    <link rel="stylesheet" href="assets/css/style.css">

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
        display: none !important;
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



    .mainmenu ul {
        display: -ms-flexbox;
        display: flex;
        -ms-flex-wrap: wrap;
        width: 100vh;
        flex-wrap: unset;
    }

    .header__bottom {
        padding: 0px 0px !Important;
    }
</style>

<body id="header">
    <!--[if lt IE 8]>
        <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
    <![endif]-->
    <!-- preloader  -->
    <div id="preloader">
        <div id="ctn-preloader" class="ctn-preloader">
            <div class="animation-preloader">
                <div class="spinner"></div>

            </div>
            <div class="loader">
                <div class="row">
                    <div class="col-3 loader-section section-left">
                        <div class="bg"></div>
                    </div>
                    <div class="col-3 loader-section section-left">
                        <div class="bg"></div>
                    </div>
                    <div class="col-3 loader-section section-right">
                        <div class="bg"></div>
                    </div>
                    <div class="col-3 loader-section section-right">
                        <div class="bg"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- preloader end -->

    <!-- header start -->
    <header class="header">
        <div class="header__bottom header__bottom--2">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-xl-8 col-lg-12">
                        <div class="navarea navarea__2">
                            <a href="{{ route('/') }}" class="site-logo">
                                <img style="height: 67px;width: auto;/* position:  relative; *//* top: 14px; */"
                                    src="{{ asset('assets/images/logo.png') }}" alt="">
                            </a>
                            <div class="mainmenu mainmenu__2"
                                style="padding-bottom: 0 !important;
                            height: 90px !Important;
                        ">
                                <nav id="mobile-menu">
                                    <ul>
                                        <li>
                                            <a href="{{ route('/') }}">Home</a>
                                        </li>
                                        <li><a href="#about">About</a></li>

                                        <li><a href="#services">Services</a></li>

                                        <li><a href="#quote">Get a Quote</a></li>

                                        <li><a href="#howwework">How We Work</a></li>

                                        <li><a href="{{ route('contact') }}">Contact</a></li>

                                        <li>
                                            <div style="
                                            position: relative;
                                            /* top: 8px; */
                                            margin-left: 30px;
                                            margin-top: 23px;
                                        "
                                                id="google_translate_element2"></div>
                                        </li>
                                    </ul>
                                </nav>
                            </div>
                            <div class="mobile-menu"></div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-4 my-auto">
                        <div class="lang-quote lang-quote__2">
                            <div class="call-info">
                                <div class="call-info__icon">
                                    <i class="fa fa-phone-volume"></i>
                                </div>
                                <div class="call-info__content">
                                    <span>Call us:</span>
                                    <a href="tel:650229-4621">(650) 229-4621</a>
                                </div>
                            </div>
                            <a href="{{ route('login') }}" style="padding: 17px !important;" class="quote-btn">Translate
                                your Document</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <!-- header end -->

    <!-- hero start -->
    <section class="hero__2 bg_img" data-background="assets/images/banner/hero-banner-2.jpg">
        <div class="container-fluid">
            <div class="row justify-content-end">
                <div class="col-xl-5 custom-col-width justify-content-end col-lg-7">
                    <div class="hero__content hero__content--2 text-center">
                        <div class="hero-icon">
                            <img src="assets/images/icons/hero-icon.png" alt="">
                        </div>
                        <div class="hero-text">
                            <h2>Translation <br>
                                Made Easier</h2>
                            <p>Your priority is ours</p>
                            <a href="#about" class="site-btn site-btn__2"><span class="icon"><i
                                        class="far fa-arrow-right"></i></span> Read More</a>
                        </div>
                        <div class="dot-shape"><img src="assets/images/shape/hero-pattern-2.png" alt=""></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="shape-pattern">
            <img src="assets/images/shape/hero-pattern-1.png" alt="">
        </div>
    </section>
    <!-- hero end -->

    <!-- about section start -->
    <section id="about" class="about-area pt-125 pb-125">
        <div class="container">
            <div class="row justify-content-between">
                <div class="col-xl-5">
                    <div class="about__bg about__bg--2 mt-75">
                        <div class="big-thumb">
                            <img height="507" width="470" src="assets/images/about/about-bg-1.jpg"
                                alt="">
                        </div>
                        <div class="mid-thumb position-absulate">
                            <img height="271" width="222" src="assets/images/about/about-bg-2.jpg"
                                alt="">
                        </div>
                        <div class="small-thumb position-absulate">
                            <img height="230" width="144" src="assets/images/about/about-bg-3.jpg"
                                alt="">
                        </div>
                        <span class="circle-shape position-absulate"><img src="assets/images/shape/border-shape-2.png"
                                alt=""></span>
                        <span class="patternt-shape position-absulate"><img
                                src="assets/images/shape/about-shape-1.png" alt=""></span>
                    </div>
                </div>
                <div class="col-xl-6">
                    <div class="section-header section-header__2 mb-40">
                        <h4 class="sub-heading sub-heading__2 mb-10">About Us <span><img
                                    src="assets/images/shape/heading-shape-4.png" class="ml-10"
                                    alt=""></span></h4>
                        <h2 class="section-title section-title__2 mb-30">Facilitating communication in the global
                            village</h2>
                        <p>At Flow Translations we know the crucial role that information and communication plays in
                            society, business, health, legal matters and leisure, being the basis for making everyday
                            life decisions. This is why all our translations are done exclusively by professional native
                            linguists to preserve the integrity of the message including any cultural nuances and never
                            use machine translations. Our commitment to our customers is to deliver documents
                            professionally translated that reflect the true meaning and energy of the message, on time
                            and at a reasonable price. </p>
                    </div>
                    <div class="row mt-none-40">
                        <div class="col-xl-6 mt-40">
                            <div class="ab__box">
                                <div class="ab__box--head">
                                    <div class="icon">
                                        <img src="assets/images/icons/ab-1.png" alt="">
                                    </div>
                                    <h4 class="title"> Our Mission</h4>
                                </div>
                                <p>To be the channel through which information can "flow" seamlessly and smoothly
                                    between different cultures and languages so that the true meaning of messages are
                                    transmitted and understood.</p>
                            </div>
                        </div>
                        <div class="col-xl-6 mt-40">
                            <div class="ab__box">
                                <div class="ab__box--head">
                                    <div class="icon icon__2">
                                        <img src="assets/images/icons/ab-2.png" alt="">
                                    </div>
                                    <h4 class="title">Who We Are</h4>
                                </div>
                                <p>FLOW Translations is founded by two professionals who understand first hand the
                                    challenge of cross-cultural communication and interaction.</p>
                            </div>
                        </div>
                    </div>
                    <div class="ab-author-signature mt-55">
                        <div class="author__box">
                            <div class="author__box--thumb">
                                <img src="assets/images/icons/author-2.webp" alt="">
                            </div>
                            <div class="author__box--text">
                                <h4 class="name">Silvia Cabal</h4>
                                <span class="designation">Director of Operations</span>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- about section end -->

    <!-- feature section start -->
    <section id="services" class="feature-area feature-area__2 grey-bg pt-125">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xl-8 text-center">
                    <div class="section-header mb-70">
                        <h4 class="sub-heading sub-heading__2 mb-15">
                            <span><img src="assets/images/shape/heading-shape-3.png" class="mr-5"
                                    alt=""></span>
                            what we offer
                            <span><img src="assets/images/shape/heading-shape-4.png" class="ml-5"
                                    alt=""></span>
                        </h4>
                        <h2 class="section-title section-title__2">Our Services</h2>
                    </div>
                </div>
            </div>
            <div class="row mt-none-30">
                <div class="col-xl-4 col-lg-6 col-md-6 mt-30">
                    <div class="feature-item feature-item__2">
                        <div class="feature-item__icon feature-item__icon--round bg_img"
                            data-background="assets/images/shape/round-shape.png">
                            <img src="assets/images/icons/f-5.png" alt="">
                        </div>
                        <div class="feature-item__content feature-item__content--2">
                            <h4 class="feature-item__title feature-item__title--2">Document Translation</h4>
                            <p>We understand the importance of cross-cultural communication and deliver professional
                                translation services in many languages. The main ones are Spanish, Chinese, Vietnamese,
                                Korean, Japanese, Tagalog, Russian, Dutch, French, German Farsi, Dari, Tigrinya, and
                                other languages of lesser diffusion. Each translated document goes through a
                                proofreading and editing process before considered final.</p>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 col-lg-6 col-md-6 mt-30">
                    <div class="feature-item feature-item__2">
                        <div class="feature-item__icon feature-item__icon--round bg_img"
                            data-background="assets/images/shape/round-shape.png">
                            <img src="assets/images/icons/f-6.png" alt="">
                        </div>
                        <div class="feature-item__content feature-item__content--2">
                            <h4 class="feature-item__title feature-item__title--2">Remote Video Interpreting</h4>
                            <p> To achieve a common understanding across cultures, translation is not enough but local
                                customs and habits need to be considered. </p>

                        </div>
                    </div>
                </div>
                <div class="col-xl-4 col-lg-6 col-md-6 mt-30">
                    <div class="feature-item feature-item__2">
                        <div class="feature-item__icon feature-item__icon--round bg_img"
                            data-background="assets/images/shape/round-shape.png">
                            <img src="assets/images/icons/f-7.png" alt="">
                        </div>
                        <div class="feature-item__content feature-item__content--2">
                            <h4 class="feature-item__title feature-item__title--2">In-Person Interpretation</h4>
                            <p>We can support in-person interpretation services
                                for Medical, Education, Business and Legal meetings in the Bay Area, California.</p>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- feature section end -->

    <!-- video area start -->
    <section id="quote" class="video-area">
        <div class="container-fluid">
            <div class="row no-gutters">
                <div class="col-xl-8">
                    <div class="video__bg bg_img" data-background="assets/images/bg/quotebg-1.jpg"
                        data-overlay="dark" data-opacity="34">
                    </div>
                </div>
                <div class="col-xl-4">
                    <div class="quote-wrapper">
                        <h2 class="quote-title">Free quote</h2>
                        <div class="quote-form">
                            <form method="POST" action="{{ route('freequote') }}" class="mt-none-15">
                                @csrf
                                @method('POST')
                                <div class="form-group mt-15">
                                    <input type="text" name="name" id="name" placeholder="Your Name">
                                </div>
                                <div class="form-group mt-15">
                                    <input type="email" name="email" id="tel" placeholder="Email">
                                </div>
                                <div class="form-group mt-15">
                                    <input type="text" name="message" id="message" placeholder="Write Message">
                                </div>
                                <div class="form-group mt-15">
                                    <div class="g-recaptcha" data-sitekey="6Ldw1WAjAAAAAPCSidRXZg7jDuIG7_GWikO24ElP">
                                    </div>
                                </div>

                                <div class="form-group mt-15">
                                    <button type="submit" class="quote-btn"><span class="icon"><i
                                                class="far fa-arrow-right"></i></span> free
                                        estimate</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- video area end -->

    <!-- working-process area start -->
    <section id="howwework" class="wp-area pt-125 pb-125">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xl-8 text-center">
                    <div class="section-header mb-65">
                        <h4 class="sub-heading mb-15">
                            <span><img src="assets/images/shape/heading-shape-3.png" class="mr-5"
                                    alt=""></span>
                            working process
                            <span><img src="assets/images/shape/heading-shape-4.png" class="ml-5"
                                    alt=""></span>
                        </h4>
                        <h2 class="section-title section-title__2">How We Work</h2>
                    </div>
                </div>
            </div>
            <div class="row mt-none-40">
                <div class="col-xl-3 col-lg-6 col-md-6 mt-40">
                    <a href="{{ route('register') }}">
                        <div class="wp-box">
                            <div class="wp-box__icon wp-box__icon--1 mb-35">
                                <img src="assets/images/icons/w-p-1.png" alt="">
                            </div>
                            <div class="wp-box__content">
                                <h4 class="wp-box__title">
                                    Registration
                                </h4>
                                <p>First step for you is to Sign Up! This gives you a look at our Translation Center.
                                </p>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-xl-3 col-lg-6 col-md-6 mt-40">
                    <div class="wp-box reverse-col">
                        <a href="{{ url('/user') }}">

                            <div class="wp-box__content">
                                <h4 class="wp-box__title">Request Translation</h4>
                                <p>Have a document you need translated? Fill in the details, attach the document and
                                    wait
                                    for the magic to happen!</p>
                            </div>
                            <div class="wp-box__icon wp-box__icon--2 mt-35">
                                <img src="assets/images/icons/w-p-2.png" alt="">
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-6 col-md-6 mt-40">
                    <div class="wp-box">
                        <div class="wp-box__icon wp-box__icon--3 mb-35">
                            <img src="assets/images/icons/w-p-3.png" alt="">
                        </div>
                        <div class="wp-box__content">
                            <h4 class="wp-box__title">Payment</h4>
                            <p>Our team will get in contact with you and send you an appropriate invoice for your order
                                - once you pay a reasonable fees, your order will be processed!</p>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-6 col-md-6 mt-40">
                    <a href="{{ url('/myorders') }}">
                        <div class="wp-box reverse-col">
                            <div class="wp-box__content">
                                <h4 class="wp-box__title">Deliverance</h4>
                                <p>You will be able to track the entire process of your translation and once it is
                                    translated and proofread - you can download the translation.</p>
                            </div>
                            <div class="wp-box__icon mt-35">
                                <img src="assets/images/icons/w-p-4.png" alt="">
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </section>


    <!-- footer start -->
    <footer class="footer footer__2 pt-120">

        <div class="footer__bottom footer__bottom--2 mt-115">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6 my-auto">
                        <div class="copyright-text">
                            <p>Contact Us at info@flowtranslate.com</p>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="copyright-text" style="text-align: right;">
                            <p>or Call Us at (650) 229-4621</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <!-- footer end -->

    <!--========= JS Here =========-->
    <script src="assets/js/jquery-2.2.4.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/jquery.meanmenu.min.js"></script>
    <script src="assets/js/jquery.nice-select.min.js"></script>
    <script src="assets/js/counterup.min.js"></script>
    <script src="assets/js/lightcase.js"></script>
    <script src="assets/js/owl.carousel.min.js"></script>
    <script src="assets/js/tilt.jquery.min.js"></script>
    <script src="assets/js/jquery.easing.min.js"></script>
    <script src="assets/js/scrollwatch.js"></script>
    <script src="assets/js/sticky-header.js"></script>
    <script src="assets/js/waypoint.js"></script>
    <script src="assets/js/imagesloaded.pkgd.min.js"></script>
    <script src="assets/js/isotope.pkgd.min.js"></script>
    <script src="assets/js/jquery.appear.js"></script>
    <script src="assets/js/odometer.min.js"></script>
    <script src="assets/js/wow.min.js"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDfpGBFn5yRPvJrvAKoGIdj1O1aO9QisgQ"></script>
    <script src="assets/js/main.js"></script>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>

    <script type="text/javascript">
        function googleTranslateElementInit2() {
            new google.translate.TranslateElement({
                includedLanguages: 'en,es,zh-CN,vi',
                pageLanguage: 'af',
                autoDisplay: true
            }, 'google_translate_element2');
        }
    </script>

    <script type="text/javascript" src="https://translate.google.com/translate_a/element.js?cb=googleTranslateElementInit2">
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
    </script>


</body>

</html>
