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
                            <li><a href="/">Home</a></li>
                            @if(!auth()->check())
                                <li><a href="/register">Register</a></li>
                            @endif
                            <li><a href="{{url('faq')}}">FAQ</a></li>
                            <li><a href="{{url('term')}}">Term</a></li>
                            <li><a href="{{url('news')}}">News</a></li>
                            <li><a href="{{url('support')}}">Support</a></li>
                            <li><a href="{{url('about-us')}}">About Us</a></li>
                            <li><a href="{{url('contact-us')}}">Contact</a></li>
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
                    <!-- COMPANY ADDRESS-->
                    <div class="col-md-3 sec-block">
                        <ul>
                            <li>News</li>
                            <li>Support</li>
                            <li>FAQ</li>
                            <li>About Us</li>
                            <li>Contact</li>
                            <li>Term & Condition</li>
                        </ul>
                        {{-- <div class="icon-top red-text">
                            <i class="icon-fontawesome-webfont-302"></i>
                        </div>
                        PO Box 16122 Collins Street West, Victoria 8007 Australia --}}
                    </div>

                    <!-- COMPANY EMAIL-->
                    <div class="col-md-4 sec-block">
                        <dl class="dl-horizontal">
                          <dt><i class="icon-fontawesome-webfont-302 red-text"></i></dt>
                          <dd>PO Box 16122 Collins Street West, Victoria 8007 Australia</dd>
                        </dl>
                        <dl class="dl-horizontal">
                          <dt><i class="icon-fontawesome-webfont-329 green-text"></i></dt>
                          <dd>contact@designlab.co</dd>
                        </dl>
                        <dl class="dl-horizontal">
                          <dt><i class="icon-fontawesome-webfont-101 blue-text"></i></dt>
                          <dd>+613 0000 0000</dd>
                        </dl>
                    </div>

                    <!-- COMPANY PHONE NUMBER -->
                    {{-- <div class="col-md-2 sec-block">
                        <div class="icon-top blue-text">
                            <i class="icon-fontawesome-webfont-101"></i>
                        </div>
                        +613 0000 0000
                    </div> --}}

                    <!-- SOCIAL ICON AND COPYRIGHT -->
                    <div class="col-md-5 col-sm-5 sec-block contact">
                        <div class="row">
                            <form class="form-horizontal" role="form" method="POST" action="{{ url('/guest/message') }}">
                                {{ csrf_field() }}

                                <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                    <label for="name" class="col-md-4 control-label">Name</label>

                                    <div class="col-md-8">
                                        <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" required autofocus>
                                        @if ($errors->has('name'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('name') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                    <label for="email" class="col-md-4 control-label">Email</label>

                                    <div class="col-md-8">
                                        <input id="email" type="email" class="form-control" name="email" required>
                                        @if ($errors->has('email'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('email') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group{{ $errors->has('message') ? ' has-error' : '' }}">
                                    <label for="message" class="col-md-4 control-label">Message</label>

                                    <div class="col-md-8">
                                        <textarea class="form-control" rows="3" id="message" name="message"></textarea>
                                        @if ($errors->has('message'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('message') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-md-4 col-md-offset-6 btn-submit-wrap">
                                        <button type="submit" class="btn btn-primary">
                                            Send
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
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
    <script src="/js-template/zerif.js"></script>

    <script>
        $('.date').datepicker({
            autoclose: true,
            todayHighlight: true,
            format: 'yyyy-mm-dd'
        });

        $('#main-nav .navbar-toggle').click(function(){
            $('#bs-navbar-collapse').toggleClass('open');
        });
    </script>
    @yield('script')
</body>
</html>
