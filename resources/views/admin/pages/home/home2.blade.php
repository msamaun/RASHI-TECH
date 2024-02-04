<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RAS HI TECH</title>
    <link rel="stylesheet" href="{{asset('assets/fontawesome')}}/css/all.min.css"> <!-- https://fontawesome.com/ -->
    <link href="https://fonts.googleapis.com/css2?family=Source+Sans+Pro&display=swap" rel="stylesheet"> <!-- https://fonts.google.com/ -->
    <link href="{{asset('assets/css')}}/bootstrap.min.css" rel="stylesheet">
    <link href="{{asset('assets/css')}}/templatemo-xtra-blog.css" rel="stylesheet">

    <script src="{{asset('js/toastify-js.js')}}"></script>
    <script src="{{asset('js/axios.min.js')}}"></script>
    <script src="{{asset('js/config.js')}}"></script>
    <script src="{{asset('js/bootstrap.bundle.js')}}"></script>
</head>
<body>
<ul class="nav justify-content-end">
    <li class="nav-item">
        <a class="nav-link active" href="{{route('login')}}">Login</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{route('register')}}">Register</a>
    </li>
</ul>

<div class="row row-cols-1 row-cols-md-3 g-4" id="post"  style="background-color: #6da6d3">
    @foreach($posts as $post)
    <div class="col mb-4 ml-0">
        <div class="card mb-6">
            <img src="{{$post->image}}" class="card-img-top" alt="..." style="width: 100%; height: 300px" >
            <div class="card-body">
                <h5 class="card-title">{{$post->title}}</h5>
                <p class="card-text">{{Str::words($post->body,20)}}</p>
                <a href="/singlePost/{{$post->id}}" class="btn btn-primary">Read More</a>
            </div>
        </div>
    </div>
    @endforeach
</div>
{{$posts ->links()}}

</body>
</html>

