@extends('layouts.app')

@section('content')

    <section class="contact-us" id="contact">
        <div class="container">

            <!-- SECTION HEADER -->
            <div class="section-header">

                <!-- SECTION TITLE -->
                <h2 class="white-text">Get in touch</h2>

                <!-- SHORT DESCRIPTION ABOUT THE SECTION -->
                <h6 class="white-text">
                    Have any question? Drop us a message. We will get back to you in 24 hours.
                </h6>
            </div>
            <!-- / END SECTION HEADER -->

            <!-- CONTACT FORM-->
            <div class="row">
                <form role="form" class="contact-form" id="contact-form">
                    <div class="wow fadeInLeft animated" data-wow-offset="30" data-wow-duration="1.5s" data-wow-delay="0.15s">
                        <div class="col-lg-4 col-sm-4">
                            <input type="text" name="name" placeholder="Your Name" class="form-control input-box" id="name">
                        </div>
                        <div class="col-lg-4 col-sm-4">
                            <input type="email" name="email" placeholder="Your Email" class="form-control input-box" id="email">
                        </div>
                        <div class="col-lg-4 col-sm-4">
                            <input type="text" name="subject" placeholder="Subject" class="form-control input-box" id="subject">
                        </div>
                    </div>

                    <div class="col-md-12 wow fadeInRight animated" data-wow-offset="30" data-wow-duration="1.5s" data-wow-delay="0.15s">
                        <textarea name="message" class="form-control textarea-box" placeholder="Your Message" id="message"></textarea>
                    </div>
                    <!-- IF MAIL SENT SUCCESSFULLY -->
                    <h4 class="success pull-left white-text">
                        Your message has been sent successfully.
                    </h4>

                    <!-- IF MAIL SENDING UNSUCCESSFULL -->
                    <h4 class="error pull-left white-text">
                        E-mail must be valid and message must be longer than 1 character.
                    </h4>
                    <button class="btn btn-primary custom-button red-btn wow fadeInLeft animated" id="submit" data-wow-offset="30" data-wow-duration="1.5s" data-wow-delay="0.15s" type="submit">Send Message</button>
                </form>
            </div>
            <!-- / END CONTACT FORM-->
        </div> <!-- / END CONTAINER -->
    </section> <!-- / END CONTACT US SECTION-->

@endsection
