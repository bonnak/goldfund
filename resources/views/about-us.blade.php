@extends('layouts.app')

@section('content')
    <section class="about-us" id="aboutus">
        <div class="container">

            <div class="col-md-2"></div>
            <!-- SECTION HEADER -->
            <div class="section-header col-md-8">
                {!! $data->value !!}
            </div>
            <div class="col-md-2"></div>
            <!-- / END SECTION HEADER -->
        </div> <!-- / END CONTAINER -->

    </section> <!-- END ABOUT US SECTION -->
@endsection
