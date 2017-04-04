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


  <link rel="stylesheet" href="/admin_dir/css/font-awesome.min.css">
  <link rel="stylesheet" type="text/css" href="/froala-editor/css/froala_editor.pkgd.min.css">
  <link rel="stylesheet" type="text/css" href="/froala-editor/css/froala_style.min.css">
  <link rel="stylesheet" href="/admin_dir/css/admin.css">
</head>
<body {{ Auth::guest() ? 'class=login' : ''}}>
	@if (Auth::guest())
    @yield('login-section')
  @else
	  <div id="admin-app">
	  </div>
    <script type="text/javascript" src="/bn/paper-full.js"></script>
    <!-- <script src="https://cdn.ckeditor.com/4.6.2/standard-all/ckeditor.js"></script> -->
    <!-- <script src="https://cloud.tinymce.com/stable/tinymce.min.js"></script> -->
	  <script src="/admin_dir/js/app.js"></script>
	@endif
</body>
</html>
