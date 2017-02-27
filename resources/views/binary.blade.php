@extends('layouts.app')
@section('content')
<section class="focus" id="focus">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <button class="zoom" id="zoom_in">+</button>
                <button class="zoom" id="zoom_out">-</button>
                <canvas id="myCanvas" resize style="width: 100%; height: 100%; background-color: #ddd"></canvas>
            </div>
        </div>
    </div>
</section>
@endsection

@section('script')
<script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.15.3/axios.min.js"></script>
<script type="text/javascript">
    // axios.get('/binary/json').then(function(response){
    //     console.log(response);
    // });
</script>
<script type="text/javascript" src="bn/paper-full.js"></script>
<script type="text/paperscript" canvas="myCanvas">
    paper.install(window);
</script>
<script type="text/paperscript" src="bn/mycanvas.js" canvas="myCanvas"></script>
<script type="text/paperscript" src="bn/zoomTest.js" canvas="myCanvas"></script>
@endsection