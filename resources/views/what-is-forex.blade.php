@extends('layouts.app')
@section('content')

    <section class="focus" id="focus">
        <div class="container">

            <div class="section-header col-md-12">
                {!! $data->value !!}                
            </div>
            <!-- / END SECTION HEADER -->


        </div> <!-- / END CONTAINER -->
    </section>  <!-- / END FOCUS SECTION -->

@endsection
