<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <script src = "https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}" />

</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav me-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto">
                        <!-- Authentication Links -->
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                </li>
                            @endif

                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>
    </div>
</body>
<script>

  function addComment(post_id,user_id) {
        var body = $('#body-'+post_id).val();
        $.ajax({
              url: "/comments",
              type: "POST",
              data: {
                  _token: $("#csrf").val(),
                  body: body,
                  post_id: post_id,
                  user_id: user_id,
              },
              cache: false,
              success: function(dataResult){
                  console.log(dataResult);
                  var dataResult = JSON.parse(dataResult);
                  if(dataResult.statusCode==200){
                    window.location = "/home";				
                  }
                  else if(dataResult.statusCode==201){
                     alert("Error occured !");
                  }
                  
              }, error: function(dataResult) { 
                    alert("Status: " + dataResult); 
                } 
          });
  }

  function addlike(post_id,user_id) {
        $.ajax({
              url: "/likes",
              type: "POST",
              data: {
                  _token: $("#csrf").val(),
                  clicked: 1,
                  post_id: post_id,
                  user_id: user_id,
              },
              cache: false,
              success: function(dataResult){
                  console.log(dataResult);
                  var dataResult = JSON.parse(dataResult);
                  if(dataResult.statusCode==200){
                    var like = document.getElementById("like-"+post_id);
                    like.remove();
                    $("#like-escop-"+post_id).append('<span class="fa-stack fa-fw stats-icon" id="liked-'+post_id+'" onclick="dislike('+post_id+','+user_id+','+dataResult.like_id+')" title="Dislike"><i class="fa fa-circle fa-stack-2x text-primary"></i><i class="fa fa-thumbs-up fa-stack-1x fa-inverse"></i></span>');
                  
                    // window.location = "/home";				
                  }
                  else if(dataResult.statusCode==201){
                     alert("Error occured !");
                  }
              }, error: function(dataResult) { 
                    alert("Status: " + dataResult); 
                } 
          });
   }

   function dislike(post_id,user_id,id) {

        $.ajax({
              url: "/likes/"+id,
              type: "DELETE",
              data: {
                  _token: $("#csrf").val(),
              },
              cache: false,
              success: function(dataResult){
                  console.log(dataResult);
                  var dataResult = JSON.parse(dataResult);
                  if(dataResult.statusCode==200){
        
                    window.location = "/home";				
                  }
                  else if(dataResult.statusCode==201){
                     alert("Error occured !");
                  }
              }, error: function(dataResult) { 
                    alert("Status: " + dataResult); 
                } 
          });
   }

   function deletePost(post_id,user_id) {
    var post = document.getElementById("post-"+post_id);
    post.remove();

        $.ajax({
              url: "/posts/"+post_id,
              type: "DELETE",
              data: {
                  _token: $("#csrf").val(),
              },
              cache: false,
              success: function(dataResult){
                  console.log(dataResult);
                  var dataResult = JSON.parse(dataResult);
                  if(dataResult.statusCode==200){
                    window.location = "/home";				
                  }
                  else if(dataResult.statusCode==201){
                     alert("Error occured !");
                  }
              }, error: function(dataResult) { 
                    alert("Status: " + dataResult); 
                } 
          });
   }
$(document).ready(function() {  
    $('#store').on('click', function() {
      var title = $('#title').val();
      var description = $('#description').val();
      var user_id = $('#user_id').val();
    //   var images = $('#images').val();
    event.preventDefault();
    let image_upload = new FormData();
    let TotalImages = $('#images-upload')[0].files.length;  //Total Images
    let images = $('#images-upload')[0];  

    for (let i = 0; i < TotalImages; i++) {
        image_upload.append('images', images.files[i]);
    }
    image_upload.append('TotalImages', TotalImages);

      if(title!="" && description!=""){
        /*  $("#butsave").attr("disabled", "disabled"); */
          $.ajax({
              url: "/posts",
              type: "POST",
              enctype: 'multipart/form-data',
              data: {
                  _token: $("#csrf").val(),
                  title: title,
                  description: description,
                  user_id: user_id,
                //   images: image_upload,
              },
              cache: false,
              success: function(dataResult){
                  console.log(dataResult);

                  var dataResult = JSON.parse(dataResult);
                  if(dataResult.statusCode==200){
                    window.location = "/home";				
                  }
                  else if(dataResult.statusCode==201){
                     alert("Error occured !");
                  }
                  
              }
          });
      }
      else{
          alert('Please fill all the field !');
      }
  });
});
</script>
</html>
