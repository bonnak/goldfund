<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Admin</title>

  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <script>
    window.Laravel = {!! json_encode([
        'csrfToken' => csrf_token(),
    ]) !!};
  </script>

  <link rel="stylesheet" href="/css/admin.css">
</head>
<body>
	@if (Auth::guest())
    @yield('login-section')
  @else
	  <div id="admin-app">
	  </div>

	  <script src="/js/admin.js"></script>
	@endif
</body>
</html>
