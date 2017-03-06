@extends('layouts.app')
@section('content')
<link rel="stylesheet" href="/css-template/plan_style.css">
<section class="intro-section">
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

<section class="section-2">
    <div class="container">
        <div class="row wow fadeInRight animated">
            <div data-wow-offset="30" data-wow-duration="1.5s" data-wow-delay="0.15s">
                <div class="row">
                    <div class="col-md-4 text-center">
                        <img src="/images/icons/icon-register.gif">
                        <h2 class="caption">REGISTER ACCOUNT</h2>
                        <p class="description">Register an account to start making money with bitcompanytradingJust fill out registration form.</p>
                    </div>
                    <div class="col-md-4 text-center">
                        <img src="/images/icons/icon-deposit.gif">
                        <h2 class="caption">MAKE DEPOSIT</h2>
                        <p class="description">To make a deposit you have to log into your personal account. You can do this after registration and use make deposit function in your account.</p>
                    </div>
                    <div class="col-md-4 text-center">
                        <img src="/images/icons/icon-earn.gif">
                        <h2 class="caption">RECEIVE EARNING</h2>
                        <p class="description">Once you collected certain amount on your account balance. You can make withdrawal request. Withdrawals processes within 24 hours on business days.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section data-ng-controller="liveUser as vm" ng-cloak>
    <div class="container">
      <div class="row wow fadeInRight animated">
          <h2>Statistics</h2>
          <div data-wow-offset="30" data-wow-duration="1.5s" data-wow-delay="0.15s">
              <div class="row">
                  <div class="col-md-4">
                      <h4>Last Registrations</h4>
                      <br/>
                      <dl>
                          <div data-ng-repeat="customer in vm.customers">
                              <div class="col-md-6 col-xs-6 align-left">
                                  <span am-time-ago="customer.created_at"></span>
                                </div>
                                <div class="col-md-6 col-xs-6 align-left">
                                   <% customer.username %>
                                </div>
                          </div>
                    </dl>
                </div>
                <div class="col-md-4">
                    <br/>
                    <div class="stat">
                        <p class="num">95</p>
                        <p class="text">Days Online</p>
                    </div>
                    <div class="stat">
                        <p class="num"><% vm.totalMember %></p>
                        <p class="text">Members</p>
                    </div>
                    <div class="stat">
                        <p class="num"><% vm.investedCapital | currency %></p>
                        <p class="text">Invested</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <h4>Last Investments</h4>
                    <br/>
                    <dl>
                        <div ng-repeat="last_deposit in vm.lastDeposits">
                            <div class="col-md-6 col-xs-6 align-left">
                                <% last_deposit.owner.username %>
                            </div>
                            <div class="col-md-6 col-xs-6 align-left">
                                <% last_deposit.amount | currency%>
                            </div>
                        </div>
                    </dl>
                </div>
            </div>
          </div>
      </div>
        <div class="row">
            <h2>investment Plan</h2>
            <div>
                <div class="row">
                    <div class="bs-five-area">
                        <div class="col-md-4 no-padding" data-ng-repeat="(key, plan) in vm.plans">
                            <div class="bs-five">
                                <img src="<% plan.image %>" alt="logo">
                                <div class="text-uppercase plan-name"><%  plan.name %></div>
                                <h1 class="bs-caption" style="margin: 30px;"><% plan.daily * 100 %><sup>%</sup></h1>
                                <p>Daily for <% plan.duration %> days</p>
                                <ul>
                                    <li><b>Deposit: <% plan.min_deposit %>$ - <% plan.max_deposit %>$</b></li>
                                    <li>Profit: <% plan.daily * 100 * plan.duration %>%</li>
                                    <li>24/7 Customer Support</li>
                                </ul>
                                <a class="btn blue btn-success btn-round m-top-40">Deposit</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section> 

<section>
    <div class="container">
            <h2>Advantage of company</h2>
            <div class="col-md-6 col-sm-6 wow fadeInLeft animated"
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
            <div class="col-md-6 col-sm-6 wow fadeInRight animated"
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

@section('script')
<script src="/angular/angular-moment/moment.min.js"></script>
<script src="/angular/1.5.6/angular.min.js"></script>
<script src="/angular/angular-moment/angular-moment.min.js"></script>
<script src="/js/controllers/liveUserController.js"></script>
@endsection