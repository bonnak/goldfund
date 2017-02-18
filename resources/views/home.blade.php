@extends('layouts.app')
@section('content')
    <header class="header" id="header">
        <section class="" id="">
            <div class="container">
                <div class="row wow fadeInRight animated">
                <div class="col-md-8" data-wow-offset="30" data-wow-duration="1.5s" data-wow-delay="0.15s">
                    <h2 class="intro" style="margin-top: 17%;">Fundcrpto Trader</h2>
                    <p class="content-company">
                        Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
                        Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
                        Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
                        Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
                        Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
                        Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
                        Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
                        Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
                        Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
                        Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
                        Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
                        Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
                    </p>
                </div>
                <div class="col-md-4" data-wow-offset="30" data-wow-duration="1.5s" data-wow-delay="0.15s">
                    <!-- HEADING -->
                    {{-- <h2 class="intro">Who we are?</h2> --}}
                    {{-- <div class="content-company">
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
                        <form class="form-horizontal" role="form" method="POST" action="{{ url('/login') }}" style="margin-top: -30px;">
                            {{ csrf_field() }}
                            <!-- CALL TO ACTION BUTTONS -->
                            <div class="buttons inpage-scroll">
                                <div class="form-group{{ $errors->has('username') ? ' has-error' : '' }}">
                                    <div class="col-md-12">
                                        <div class="input-group">
                                            <input id="username" type="text" class="form-control" name="username" value="{{ old('username') }}" required autofocus>
                                            <span class="input-group-btn">
                                                <button class="btn btn-default" type="button">
                                                    <i class="fa fa-user"></i>
                                                </button>
                                            </span>
                                        </div>
                                        @if ($errors->has('username'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('username') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                    <div class="col-md-12">
                                        <div class="input-group">
                                            <input id="password" type="password" class="form-control" name="password" required>
                                            <span class="input-group-btn">
                                                <button class="btn btn-default" type="button">
                                                    <i class="fa fa-key"></i>
                                                </button>
                                            </span>
                                        </div>
                                        @if ($errors->has('password'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('password') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <button class="btn btn-primary custom-button green-btn">
                                            <i class="fa fa-sign-in"></i>
                                            Login
                                        </button>
                                        <a href="{{ url('register') }}"
                                           class="btn btn-primary custom-button blue-btn"
                                            style="text-decoration: none;">
                                            <i class="fa fa-sign-out"></i>
                                            Register
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <p>
                            <a href="/password/reset">Forget your password?</a>
                        </p>
                    </div> --}}
                    <div class="form-login-box">
                        <div class="form-top">
                            <div class="form-top-left">
                                <h3>Member login</h3>
                            </div>
                            <div class="form-top-right">
                                <i class="fa fa-lock"></i>
                            </div>
                        </div>
                        <div class="form-bottom">
                            @if ($errors->has('username'))
                                <div class="has-error">
                                    <span class="help-block">
                                        <strong>{{ $errors->first('username') }}</strong>
                                    </span>
                                </div>
                            @endif
                            <form role="form" method="POST" action="{{ url('/login') }}" class="login-form">
                                {{ csrf_field() }}
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-user"></i></span> 
                                    <input id="username" type="text" class="form-control" name="username" value="{{ old('username') }}" placeholder="Username or email address" autofocus>                                  
                                </div>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-key"></i></span>
                                    <input id="password" type="password" class="form-control" name="password" placeholder="Password">
                                </div>
                                <div class="input-group rf">
                                  <div class="checkbox">
                                    <label>
                                      <input id="login-remember" type="checkbox" name="remember"> Remember me
                                    </label>
                                  </div>
                                  <a href="/password/reset">Forgot your password?</a>
                                </div>
                                <button type="submit" class="btn">Sign in</button>
                                <div class="form-group signup">
                                    Don't have an account! <a href="/register">Register</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
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
<section>
    <div class="container">
        <!-- FEATURS -->
        <div class="row wow fadeInRight animated">
            <h2 class="color-white">Statistics</h2>
            <div data-wow-offset="30" data-wow-duration="1.5s" data-wow-delay="0.15s">
                <portfolio></portfolio>
            </div>
            <!-- FEATURES COLUMN LEFT -->
                <!-- SECTION TITLE -->
            <h2 class="color-white">Advantage of company</h2>
            <div class="col-md-6 col-sm-6 wow fadeInLeft animated content-company"
                 data-wow-offset="30" data-wow-duration="1.5s" data-wow-delay="0.15s">
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
            <div class="col-md-6 col-sm-6 wow fadeInRight animated content-company"
                 data-wow-offset="30" data-wow-duration="1.5s" data-wow-delay="0.15s">
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
