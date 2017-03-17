<!DOCTYPE HTML>
<html>
<head>
	<meta charset="utf-8">
	<title>jQuery File Upload Example</title>
	<meta name="csrf-token" content="{{ csrf_token() }}">
     <script>
       window.Laravel = {!! json_encode([
           'csrfToken' => csrf_token(),
       ]) !!};
     </script>
</head>
<body>
<form>
    <input id="fileupload" type="file" name="files[]" data-url="/api/photo/upload" multiple>
</form>


<!-- <input id="fileupload" type="file" name="files[]" data-url="/bonnak" multiple> -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script src="/js/fileupload/vendor/jquery.ui.widget.js"></script>
<script src="/js/fileupload/jquery.iframe-transport.js"></script>
<script src="/js/fileupload/jquery.fileupload.js"></script>
<script>
$(function () {
    $('#fileupload').fileupload({
        dataType: 'json',
        headers: { 'X-CSRF-TOKEN': window.Laravel.csrfToken, 'X-Requested-With': 'XMLHttpRequest' },
     //    beforeSend: function(xhr, data) {
	    //     xhr.setRequestHeader('X-CSRF-TOKEN', window.Laravel.csrfToken);
	    // },
        done: function (e, data) {
            $.each(data.result.files, function (index, file) {
                $('<p/>').text(file.name).appendTo(document.body);
            });
        }
    });
});
</script>
</body> 
</html>