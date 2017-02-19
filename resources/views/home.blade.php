@extends('layouts.app')
@section('content')
<section>
  <div class="container">
    <div class="row wow fadeInRight animated">
      <div class="col-md-8 intro-wrap" data-wow-offset="30" data-wow-duration="1.5s" data-wow-delay="0.15s">
          <h2 class="intro">Bit Company Trading</h2>
          <p>Take care your financial future. The way to your financial freedom.</p>
          <a href="/register" class="btn btn-join">Get start</a>
      </div>
      <div class="col-md-4" data-wow-offset="30" data-wow-duration="1.5s" data-wow-delay="0.15s">
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

<section>
    <div class="container">
      <div class="row wow fadeInRight animated">
          <h2 class="color-white">Statistics</h2>
          <div data-wow-offset="30" data-wow-duration="1.5s" data-wow-delay="0.15s">
              <portfolio></portfolio>
          </div>
      </div>
    </div>
</section> 

<section>
    <div class="container">
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
</section> 

@endsection
