@extends('layouts.app')

@section('content')

    <section class="contact-us" id="contact">
        <div class="container">

            <!-- SECTION HEADER -->
            <div class="section-header">
                <!-- SECTION TITLE -->
                <h2 class="white-text">
                    Contact Detail
                </h2>
                <!-- SHORT DESCRIPTION ABOUT THE SECTION -->
                <h6 class="white-text">
                    Have any question? Drop us a message. We will get back to you in 24 hours.
                </h6>
            </div>
            <!-- / END SECTION HEADER -->

            <!-- CONTACT FORM-->
            <div class="row">
                <div class="col-sm-6">
                    <div class="address">
                        <img src="images/support.jpg" style="width: 300px; padding-bottom: 15px;"
                             class="img-responsive">
                        <ul class="contact_address">
                            <li>
                                <i class="fa fa-phone"></i>
                                <a href="tel:‎{{$data['phone']}}">
                                    {{$data['phone']}}
                                </a>
                            </li>
                            <li><i class="fa fa-envelope"></i>
                                <a href="mailto:{{$data['email']}}">
                                    {{$data['email']}}
                                </a>
                            </li>
                            <li>
                                <i class="fa fa-globe"></i>
                                www.bitcompanytrading.com
                            </li>
                            <li><i class="fa fa-map-marker"></i>
                                {{$data['address']}}
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="contact_box">
                        <h4>
                            Send Us A Message          </h4>
                        <label id="text-message" class="error"></label>
                        <form id="contact-form" novalidate="novalidate"  role="form">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="name" id="name" placeholder="Name">
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <input type="email" name="email" id="email" class="form-control" placeholder="E-Mail Address">
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <input type="text" name="subject" placeholder="Subject" class="form-control" id="subject">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <textarea class="form-control" name="message" id="message" placeholder="Your Message" rows="5"></textarea>
                            </div>
                            <div class="form-group">
                                <!-- IF MAIL SENT SUCCESSFULLY -->
                                <h4 class="success pull-left white-text">
                                    Your message has been sent successfully.
                                </h4>

                                <!-- IF MAIL SENDING UNSUCCESSFULL -->
                                <h4 class="error pull-left white-text">
                                    E-mail must be valid and message must be longer than 1 character.
                                </h4>
                                <button class="btn btn-company wow fadeInLeft animated"
                                        id="submit"
                                        data-wow-offset="30" data-wow-duration="1.5s"
                                        data-wow-delay="0.15s"
                                        type="submit">Send Message</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- / END CONTACT FORM-->
        </div> <!-- / END CONTAINER -->
    </section> <!-- / END CONTACT US SECTION-->

@endsection
