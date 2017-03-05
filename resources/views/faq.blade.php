@extends('layouts.app')
@section('content')
    <section class="focus" id="focus">
        <div class="container">
            <!-- SECTION HEADER -->
            <div class="section-header">
                <!-- SECTION TITLE -->
                <h2 class="dark-text">
                    FAQ
                </h2>
            </div>   
            <div class="col-md-2"></div>         
            <div class="col-md-8">
                @foreach($faqList as $faq)
                <div class="wow fadeInLeft animated animated">
                    <p class="faq-header">
                        {{ $faq->question }}
                    </p>
                    <p class="faq-header-text">
                        {{$faq->answer}}
                    </p>
                </div>
                @endforeach
            </div>
            <div class="col-md-2"></div>         
            <!-- / END SECTION HEADER -->
        </div> <!-- / END CONTAINER -->
    </section>  <!-- / END FOCUS SECTION -->
@endsection
