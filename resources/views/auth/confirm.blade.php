@extends('layouts.app')

@section('content')
<section class="focus" id="verify_email">
    <div class="container">
    		<div class="icon"><i class="fa fa-check" aria-hidden="true"></i></div>
    		<div class="text">
    			<h2>Verification Successful!</h2>
        	<p>Congratulations, you have successfully verified your email. You can start contributing to our thriving community right away.</p>
    		</div>
    		<div class="action">
    			<a href="/login" class="btn btn-success">Go back to login page</a>
    		</div>
        
    </div>
</section>
@endsection
