<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Xtra Blog</title>
    <script src="{{asset('js/toastify-js.js')}}"></script>
    <script src="{{asset('js/axios.min.js')}}"></script>
    <script src="{{asset('js/config.js')}}"></script>
    <script src="{{asset('js/bootstrap.bundle.js')}}"></script>




</head>
<body>
<button type="button" class="btn btn-primary"><a href="{{route('home')}}" class="btn btn-primary">Back</a></button>

<div class="modal animated zoomIn" id="create-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="card mb-3" id="SinglePost" >
        <img src="{{asset($post->image)}}" class="card-img-top" style="width: 450px; margin-left: 600px" >
        <div class="card-body">
            <h1 class="card-title">{{$post->title}}</h1>
            <p class="card-text" style="font-size: 20px">{{$post->body}}</p>
        </div>`
    </div>
</div>

</body>
</html>
