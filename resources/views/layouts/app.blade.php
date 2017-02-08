<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Laravel</title>

    <!-- =========================
     FAV AND TOUCH ICONSbackgrounds/bg3.jpg
    ============================== -->
    <link rel="shortcut icon" href="images/icons/favicon.ico">
    <link rel="apple-touch-icon" href="images/icons/apple-touch-icon.png">
    <link rel="apple-touch-icon" sizes="72x72" href="http://demo.templateocean.com/wrapbootstrap/zerif-html/v1.3.1/images/icons/apple-touch-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="114x114" href="images/icons/apple-touch-icon-114x114.png">
    <!-- =========================
         STYLESHEETS Template
    ============================== -->
    <link rel="stylesheet" href="/css-template/bootstrap.min.css">
    {{--<link rel="stylesheet" href="/css-template/owl.theme.css">--}}
    {{--<link rel="stylesheet" href="/css-template/owl.carousel.css">--}}
    {{--<link rel="stylesheet" href="/css-template/jquery.vegas.min.css">--}}
    {{--<link rel="stylesheet" href="/css-template/animate.min.css">--}}

    <link rel="stylesheet" href="/assets/icon-fonts/styles.css">
    <link rel="stylesheet" href="/css-template/pixeden-icons.css">

    <!-- CUSTOM STYLES -->
    <link rel="stylesheet" href="/css-template/styles.css">
    <link rel="stylesheet" href="/css-template/responsive.css">
    <!-- Fonts -->
    <link href='http://fonts.googleapis.com/css?family=Lato:300,400,700,400italic|Montserrat:700,400|Homemade+Apple' rel='stylesheet' type='text/css'>

    <script src="/js-template/jquery.min.js"></script>

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
     <script>
       window.Laravel = {!! json_encode([
           'csrfToken' => csrf_token(),
       ]) !!};
     </script>

     <style>
        .inner {
            position: relative;
            padding: 30px 40px 130px;
            text-align: center;
            width: 700px;
            border-radius: 20px 20px 0 0;
            background: #191919;
        }

        .table-stat {
            display: -webkit-box;
            display: flex;
            position: relative;
            z-index: 1;
        }

        .table-stat__left {
            width: 33%;
        }

        .table-stat__right {
            width: 33%;
        }

        .table-stat__title {
            text-transform: uppercase;
            color: #fff;
            font-size: 17px;
            text-align: left;
        }

        .table-stat dl {
            display: -webkit-box;
            display: flex;
            flex-wrap: wrap;
            text-align: left;
            font-size: 11px;
            font-weight: 400;
        }

        .table-stat dl dt {
            margin: 0;
            padding: 0;
            font-weight: 300;
            line-height: 20px;
        }

        .table-stat__left dt {
            width: 40%;
            color: #c6c6c6;
        }

        .table-stat dl dd {
            margin: 0;
            padding: 0;
            font-weight: 400;
            line-height: 20px;
        }

        .table-stat__left dd {
            width: 60%;
            color: #6dc3f5;
        }

        dl {
            margin-top: 0;
            margin-bottom: 20px;
        }



        .table-stat__center {
            width: 34%;
            padding-top: 24px;
        }

        .table-stat__center .stat {
            margin-bottom: 27px;
        }

        .table-stat__center .num {
            color: #fff;
            font-size: 21px;
            margin: 0 0 3px;
            line-height: 1;
        }

        .table-stat__center .text {
            color: #6dc3f5;
            font-weight: 300;
            margin: 0;
            font-size: 15px;
        }

        .table-stat__right dt {
            width: 60%;
            color: #6dc3f5;
        }

        .table-stat__right dd {
            color: #c6c6c6;
            width: 40%;
        }

        .table-stat__right .table-stat__title,
        .table-stat__right dl{
            text-align: right;
        }
    </style>
</head>
<body>
    <div id="app">
        <header id="home" class="header">
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
                            <img src="images/logo.png" alt="Zerif">
                        </div>
                    </div>
                    <nav class="navbar-collapse collapse" role="navigation" id="bs-navbar-collapse">
                        <ul class="nav navbar-nav navbar-right responsive-nav main-nav-list">
                            <li><a href="/home">Home</a></li>
                            @if(!auth()->check())
                                <li><a href="/register">Register</a></li>
                            @endif
                            <li><a href="/faq">FAQ</a></li>
                            <li><a href="/term">Term</a></li>
                            <li><a href="/news">News</a></li>
                            <li><a href="/support">Support</a></li>
                            <li><a href="/about-us">About Us</a></li>
                            <li><a href="/contact-us">Contact</a></li>
                            <li><a href="/my-account">My Account</a></li>
                            @if(auth()->check())
                                <li><a href="/logout">Logout</a></li>
                            @endif
                        </ul>
                    </nav>
                </div>
            </div>
            <!-- / END TOP BAR -->
            <!-- / END HOME SECTION  -->
            <!-- BIG HEADING WITH CALL TO ACTION BUTTONS AND SHORT MESSAGES -->
            <div class="">
                @yield('content')
            </div>
        </header>
        <!-- =========================
           FOOTER
        ============================== -->
        <footer>
            <div class="container">

                <!-- COMPANY ADDRESS-->
                <div class="col-md-5 company-details">
                    <div class="icon-top red-text">
                        <i class="icon-fontawesome-webfont-302"></i>
                    </div>
                    PO Box 16122 Collins Street West, Victoria 8007 Australia
                </div>

                <!-- COMPANY EMAIL-->
                <div class="col-md-2 company-details">
                    <div class="icon-top green-text">
                        <i class="icon-fontawesome-webfont-329"></i>
                    </div>
                    contact@designlab.co
                </div>

                <!-- COMPANY PHONE NUMBER -->
                <div class="col-md-2 company-details">
                    <div class="icon-top blue-text">
                        <i class="icon-fontawesome-webfont-101"></i>
                    </div>
                    +613 0000 0000
                </div>

                <!-- SOCIAL ICON AND COPYRIGHT -->
                <div class="col-lg-3 col-sm-3 copyright">
                    <ul class="social">
                        <li><a href="v1.3.1.html"><i class="icon-facebook"></i></a></li>
                        <li><a href="v1.3.1.html"><i class="icon-twitter-alt"></i></a></li>
                        <li><a href="v1.3.1.html"><i class="icon-linkedin"></i></a></li>
                        <li><a href="v1.3.1.html"><i class="icon-behance"></i></a></li>
                        <li><a href="v1.3.1.html"><i class="icon-dribbble"></i></a></li>
                    </ul>
                    ©2013 Zerif LLC
                </div>
            </div> <!-- / END CONTAINER -->
        </footer> <!-- / END FOOOTER  -->
    </div>

    <!-- SCRIPTS -->
    <script src="/js-template/bootstrap.min.js"></script>
    {{--<script src="/js-template/wow.min.js"></script>--}}
    {{--<script src="/js-template/jquery.nav.js"></script>--}}
    {{--<script src="/js-template/jquery.knob.js"></script>--}}
    {{--<script src="/js-template/owl.carousel.min.js"></script>--}}
    {{--<script src="/js-template/smoothscroll.js"></script>--}}
    {{--<script src="/js-template/jquery.vegas.min.js"></script>--}}
    {{--<script src="/js-template/zerif.js"></script>--}}

    <script src="/js/app.js"></script>
</body>
</html>
