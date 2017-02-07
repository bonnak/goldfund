@extends('layouts.app')

@section('content')

<section class="focus" id="focus">
    <div class="container">

        <!-- SECTION HEADER -->
        <div class="section-header">

            <!-- SECTION TITLE -->
            <h2 class="dark-text">Our Focus</h2>

            <!-- SHORT DESCRIPTION ABOUT THE SECTION -->
            <h6>
                We design &amp; develop qaulity products to help small &amp; medium level business.
            </h6>
        </div>

        <portfolio></portfolio>
        <!-- / END SECTION HEADER -->
        <!-- 4 FOCUS BOXES -->

        <!-- OTHER FOCUSES -->
        <div class="other-focuses">
            <h5><span class="section-footer-title">ALSO WE FOCUS ON</span></h5>
        </div>

        <!-- OTHER FOCUS LIST -->
        <div class="other-focus-list wow fadeInUp animated" data-wow-offset="30" data-wow-duration="1.5s" data-wow-delay="0.15s">
            <ul>
                <li><i class="icon-fontawesome-webfont-8"></i>WEB APPLICATIONS</li>
                <li><i class="icon-fontawesome-webfont-267"></i>SEARCH ENGINE OPTIMIZATION</li>
                <li><i class="icon-fontawesome-webfont-75"></i>CLOUD STORAGE</li>
                <li><i class="icon-fontawesome-webfont-358"></i>Project Management</li>
                <li><i class="icon-fontawesome-webfont-102"></i>IOS APP</li>
                <li><i class="icon-fontawesome-webfont-328"></i>ANDROID APP</li>
                <li><i class="icon-fontawesome-webfont-195"></i>WINDOWS APP</li>
                <li><i class="icon-fontawesome-webfont-297"></i>UX STRATEGY</li>
            </ul>
        </div> <!-- / END OTHER FOCUS LIST -->
    </div> <!-- / END CONTAINER -->
</section>  <!-- / END FOCUS SECTION -->

<!-- =========================
   SEPARATOR ONE
============================== -->

<section class="separator-one">
    <div class="color-overlay">
        <h3 class="container text wow fadeInLeft animated" data-wow-offset="30" data-wow-duration="1.5s" data-wow-delay="0.15s">
            We have 100+ happy customers in last few years. You can check what they're saying about us. </h3>
        <div class="wow fadeInRight animated" data-wow-offset="30" data-wow-duration="1.5s" data-wow-delay="0.15s">
            <a href="v1.3.1.html" class="btn btn-primary custom-button green-btn">TESTIMONIALS</a>
        </div>
    </div>
</section>  <!-- / END SEPARATOR -->
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
