@extends('layouts.app')

@section('content')
    <header class="header" id="header">
        <section class="" id="">
            <div class="container">
                <div class="col-md-4">
                    <!-- HEADING -->
                    <h2 class="intro">WHO WE ARE?</h2>
                    <div class="content-company">
                        <p>
                            Elizion - a new era of passive earnings. Accuracy and efficiency of our work in the cryptoforeign exchange
                            markets creates prerequisites for expansion of growth of our platform around the world and provides high profit for investors.
                            We're always one step ahead. We create the future of financial deals already today.
                        </p>
                        <br/>
                        <h4>
                            <i class="fa fa-lock"></i>
                            Login Member
                        </h4>
                        <form name="resignationForm" novalidate role="form" class="form-horizontal" style="margin-top: -30px;">
                            <!-- CALL TO ACTION BUTTONS -->
                            <div class="buttons inpage-scroll">
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <input type="text" class="form-control" name="username" placeholder="Username..."/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <input type="password" class="form-control" name="password" placeholder="Password..."/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <button class="btn btn-primary custom-button green-btn">
                                            <i class="fa fa-sign-in"></i>
                                            Sign-in
                                        </button>
                                        <button class="btn btn-primary custom-button blue-btn">
                                            <i class="fa fa-sign-out"></i>
                                            Sign-out
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-md-8">
                    <h2 class="intro" style="margin-top: 12%;">STATISTICS</h2>
                    <portfolio></portfolio>
                </div>
            </div>
        </section>
    </header>
<!-- =========================
   SEPARATOR ONE
============================== -->

<!-- =========================
   FEATURES SECTION
============================== -->
<section class="features" id="features">
    <div class="container">

        <!-- SECTION HEADER -->
        <div class="section-header">

            <!-- SECTION TITLE -->
            <h2 class="dark-text">Features</h2>

            <!-- SHORT DESCRIPTION ABOUT THE SECTION -->
            <h6>
                We design &amp; develop qaulity products to help small &amp; medium level business.
            </h6>
        </div>
        <!-- / END SECTION HEADER -->

        <!-- FEATURS -->
        <div class="row">

            <!-- FEATURES COLUMN LEFT -->
            <div class="col-md-6 col-sm-6 wow fadeInLeft animated" data-wow-offset="30" data-wow-duration="1.5s" data-wow-delay="0.15s">

                <!-- FEATURE -->
                <div class="feature">
                    <div class="feature-icon">
                        <i class="icon-heart-1"></i>
                    </div>
                    <h5>Design with Love</h5>
                    <p>
                        Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
                    </p>
                </div>
                <!-- / END FEATURE -->

                <!-- FEATURE -->
                <div class="feature">
                    <div class="feature-icon">
                        <i class="icon-bulb"></i>
                    </div>
                    <h5>Creative Features</h5>
                    <p>
                        Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
                    </p>
                </div>
                <!-- / END FEATURE -->

                <!-- FEATURE -->
                <div class="feature">
                    <div class="feature-icon">
                        <i class="icon-settings-1"></i>
                    </div>
                    <h5>Thousands of Options</h5>
                    <p>
                        Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
                    </p>
                </div>
                <!-- / END FEATURE -->
            </div> <!-- / FEATURES COLUMN LEFT -->

            <!-- FEATURES COLUMN RIGHT -->
            <div class="col-md-6 col-sm-6 wow fadeInRight animated" data-wow-offset="30" data-wow-duration="1.5s" data-wow-delay="0.15s">
                <!-- FEATURE -->
                <div class="feature">
                    <div class="feature-icon">
                        <i class="icon-params"></i>
                    </div>
                    <h5>Easy to Customize</h5>
                    <p>
                        Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
                    </p>
                </div>
                <!-- / END FEATURE -->

                <!-- FEATURE -->
                <div class="feature">
                    <div class="feature-icon">
                        <i class="icon-handle-streamline-vector"></i>
                    </div>
                    <h5>Clean Strategy</h5>
                    <p>
                        Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
                    </p>
                </div>
                <!-- / END FEATURE -->

                <!-- FEATURE -->
                <div class="feature">
                    <div class="feature-icon">
                        <i class="icon-speech-streamline-talk-user"></i>
                    </div>
                    <h5>Awesome Support</h5>
                    <p>
                        Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
                    </p>
                </div>
                <!-- / END FEATURE -->

            </div> <!-- / END FEATURES COLUMN RIGHT -->
        </div> <!-- / END FEATURES -->
    </div> <!-- / END CONTAINER -->
</section> <!-- / END FEATURES SECTION -->

@endsection
