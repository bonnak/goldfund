@extends('layouts.app')

@section('content')
<section class="focus" id="verify_email">
    <div class="container">
    	<div class="text">
        <h2>Please verify your email</h2>
        <p>We sent a verification email to <b>{{ $user->email }}</b>.</p>
      </div>
    </div>
</section>
@endsection