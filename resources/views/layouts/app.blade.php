<!DOCTYPE html>
<html lang="en" data-ng-app="app">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0"/>
    <meta name="HandheldFriendly" content="true" />
    <title>@yield('title', 'Welcome') - {{ config('app.name') }}</title>

    <!-- =========================
     FAV AND TOUCH ICONSbackgrounds/bg3.jpg
    ============================== -->
    <link rel="shortcut icon" href="images/icons/favicon.png">
    <link rel="apple-touch-icon" href="images/icons/apple-touch-icon.png">
    <link rel="apple-touch-icon" sizes="72x72"
          href="http://demo.templateocean.com/wrapbootstrap/zerif-html/v1.3.1/images/icons/apple-touch-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="114x114" href="images/icons/apple-touch-icon-114x114.png">
    <!-- =========================
         STYLESHEETS Template
    ============================== -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />
    <link rel="stylesheet" href="/css-template/bootstrap.min.css">
    <link rel="stylesheet" href="/css-template/bootstrap-datepicker.min.css">
    <link rel="stylesheet" href="/css-template/owl.theme.css">
    <link rel="stylesheet" href="/css-template/owl.carousel.css">
    <link rel="stylesheet" href="/css-template/jquery.vegas.min.css">
    <link rel="stylesheet" href="/css-template/animate.min.css">

    <link rel="stylesheet" href="/assets/icon-fonts/styles.css">
    <link rel="stylesheet" href="/css-template/pixeden-icons.css">

    <!-- CUSTOM STYLES -->
    <link rel="stylesheet" href="/css-template/styles.css">
    <link rel="stylesheet" href="/css-template/responsive.css">
    <!-- Fonts -->
    <link href='http://fonts.googleapis.com/css?family=Lato:300,400,700,400italic|Montserrat:700,400|Homemade+Apple'
          rel='stylesheet' type='text/css'>
          
    <link rel="stylesheet" href="/css/app.css">

    <script src="/js-template/jquery.min.js"></script>

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
     <script>
       window.Laravel = {!! json_encode([
           'csrfToken' => csrf_token(),
       ]) !!};
     </script>
</head>
<body>
    <div id="app">
        <header id="home" class="header-nav">
            <!-- TOP BAR -->
            <div id="main-nav" class="navbar navbar-inverse bs-docs-nav" role="banner">
                <div class="container">
                    <div class="navbar-header responsive-logo">
                        <button class="navbar-toggle collapsed" type="button" data-toggle="collapse" data-target="#bs-navbar-collapse">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                        <div class="navbar-brand">
                            <a href="/">
                                <img src="/images/logo.png" alt="Bit Company Trading">
                            </a>
                        </div>
                    </div>
                    <nav class="navbar-collapse collapse" role="navigation" id="bs-navbar-collapse">
                        <ul class="nav navbar-nav navbar-right responsive-nav main-nav-list">
                            {{-- <li><a href="/">Home</a></li> --}}
                            @if(!auth()->check())
                                <li><a href="/register">Register</a></li>
                            @endif
                            <li><a href="{{url('plan')}}">Business Plan</a></li>
                            <li class="dropdown" id="service-menu">
                                <a href="#" class="dropdown-toggle"
                                   data-toggle="dropdown">
                                    Service
                                    <b class="caret"></b>
                                </a>
                                <ul class="dropdown-menu">
                                    @foreach($menus as $menu)
                                        <li>
                                            <a href="{{url('service/' . $menu->id)}}">
                                                {{$menu->title}}
                                            </a>
                                        </li>
                                    @endforeach
                                    <img src="/images/viberimage.jpg">
                                </ul>
                            </li>
                            <li><a href="{{url('what-is-forex')}}">What is Forex</a></li>
                            <li><a href="{{url('about-us')}}">About Us</a></li>
                            <li><a href="{{url('contact-us')}}">Contact Us</a></li>
                            <li><a href="{{url('faq')}}">FAQ</a></li>
                            <li><a href="{{url('account')}}">My Account</a></li>
                            @if(auth()->check())
                                <li><a href="{{url('logout')}}">Logout</a></li>
                            @endif
                        </ul>
                    </nav>
                </div>
            </div>
            <!-- / END TOP BAR -->
            <!-- / END HOME SECTION  -->
            <!-- BIG HEADING WITH CALL TO ACTION BUTTONS AND SHORT MESSAGES -->
            
        </header>

        <div class="middle-wrapper">
            @yield('content')
        </div>
        <!-- =========================
           FOOTER
        ============================== -->
        <footer>
            <div class="container">
                <div class="row">
                    <div class="col-md-3 sec-block">
                        <dl class="dl-horizontal">
                          <dt><i class="icon-fontawesome-webfont-302 red-text"></i></dt>
                          <dd>{{ $company_profile['address'] }}</dd>
                        </dl>
                        <dl class="dl-horizontal">
                          <dt><i class="icon-fontawesome-webfont-329 green-text"></i></dt>
                          <dd>{{ $company_profile['email'] }}</dd>
                        </dl>
                        <dl class="dl-horizontal">
                          <dt><i class="icon-fontawesome-webfont-101 blue-text"></i></dt>
                          <dd>{{ $company_profile['phone'] }}</dd>
                        </dl>
                    </div>
                    <div class="col-md-3 sec-block">
                        <img src="/images/60-day-unconditional-guarantee.png" class="img-responsive">
                    </div>
                    <div class="col-md-3 sec-block contact">
                        <img src="/images/symantec_norton_sites_seal.jpg" width="83px">
                        <img src="/images/PositiveSSL-comodo.png" width="140px">
                    </div>
                    <div class="col-md-3 sec-block">
                        <h2 style=" font-size: 20px !important;margin-bottom: 0px;">We Support</h2>
                        <img src="/images/Bitcoin_logo.svg.png" class="img-responsive">
                    </div>
                </div>
            </div> <!-- / END CONTAINER -->
        </footer> <!-- / END FOOOTER  -->
    </div>

    <!-- SCRIPTS -->
    <script src="/js-template/bootstrap.min.js"></script>
    <script src="/js-template/bootstrap-datepicker.min.js"></script>
    <script src="/js-template/wow.min.js"></script>
    <script src="/js-template/jquery.nav.js"></script>
    <script src="/js-template/jquery.knob.js"></script>
    <script src="/js-template/owl.carousel.min.js"></script>
    <script src="/js-template/smoothscroll.js"></script>
    <script src="/js-template/jquery.vegas.min.js"></script>
    <!-- <script src="/js-template/zerif.js"></script> -->

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bxslider/4.2.12/jquery.bxslider.min.js"></script>

    <script>
        $('.date').datepicker({
            autoclose: true,
            todayHighlight: true,
            format: 'yyyy-mm-dd'
        });

        $('#main-nav .navbar-toggle').click(function(){
            $('#bs-navbar-collapse').toggleClass('open');
        });

        // $('#service-menu a.dropdown-toggle').hover(function(){
        //     var dropdown_menu = $('#service-menu .dropdown-menu');
        //     dropdown_menu.css('display', 'none');
        //     dropdown_menu.css('opacity', '0');
        // },function(){
        //     var dropdown_menu = $('#service-menu .dropdown-menu');
        //     dropdown_menu.css('display', 'flex');
        //     dropdown_menu.css('opacity', '1');
        // });
    </script>
    @yield('script')
</body>
</html>
