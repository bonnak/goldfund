@extends('admin._layouts.app')

@section('login-section')
    @if ($errors->has('username'))
    <div class="error-block">
        <strong>{{ $errors->first('username') }}</strong>
    </div>
    @endif
    <div class="module form-module">
      <div class="toggle"><i class="fa fa-times fa-pencil"></i>
        <div class="tooltip">Click Me</div>
      </div>
      <div class="form">
        <h2>Login to your account</h2>
        <form role="form" method="POST" action="{{ url('/admin/login') }}">
            {{ csrf_field() }}
            <input id="username" type="text" name="username" value="{{ old('username') }}" required autofocus placeholder="Username">
            <input id="password" type="password" name="password" required placeholder="Password">
            <button type="submit">Login</button>
        </form>
      </div>
      <div class="cta"><a href="{{ url('/password/reset') }}">Forgot your password?</a></div>
    </div>
@endsection
