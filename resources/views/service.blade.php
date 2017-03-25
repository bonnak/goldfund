@extends('layouts.app')
@section('content')
    <section class="about-us" id="aboutus">
        <div class="container">
            {!! $service->description !!}
        </div>
    </section>
@endsection
