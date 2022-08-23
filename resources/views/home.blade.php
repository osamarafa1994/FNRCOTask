@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <div class="container">
                    <div class="row">
	    
                        <div class="col-md-8 col-md-offset-2">
                            
                            <h1>Create post</h1>
                            
                            <form  class="btn-submit"  method="post"  enctype="multipart/form-data" id="add-post">
                                
                            
                            <input type="hidden" name="_token" id="csrf" value="{{Session::token()}}">
                            <input type="hidden" name="user_id" id="user_id" value="{{ Auth::user()->id }}">
                            
                                <div class="form-group">
                                    <label for="title">Title <span class="require">*</span></label>
                                    <input type="text" class="form-control" name="title"  id="title" />
                                </div>
                                
                                <div class="form-group">
                                    <label for="description">Description*</label>
                                    <textarea rows="5" class="form-control" name="description"  id="description"  required="required"></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="description">Photos</label>
                                    <input class="form-control" name="images-upload[]" id="images-upload" type="file"  multiple>
                                </div>
                                <div class="form-group">
                                    <p><span class="require">*</span> - required fields</p>
                                </div>
                            
                                <div class="form-group">
                                    <button  type="button" class="btn btn-primary" id="store">
                                        Create
                                    </button>
                                    
                                </div>
                                
                            </form>
                        </div>
                        
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-12">
                        <h1>All Posts</h1>

                            <div id="content" class="content content-full-width">
                            
                                <!-- begin profile-content -->
                                <div class="profile-content">
                                <!-- begin tab-content -->
                                <div class="tab-content p-0">
                                    <!-- begin #profile-post tab -->
                                    <div class="tab-pane fade active show" id="profile-post">
                                        <!-- begin timeline -->
                                        <ul class="timeline">
                                        
                                            
                                            <!-- begin timeline-body -->
                                            @foreach($posts as $post)
                                            <div class="timeline-body" style="border: 10px solid lightblue; background-color: lightblue;" id="post-{{$post->id}}">
                                            
                                                <div class="timeline-content">
                                                    <p>
                                                       {{ $post->description }}
                                                    </p>
                                                </div>
                                                <div class="accordion" id="accordionExample">
                                                    <div class="card">
                                                        <div class="card-header" id="headingOne">
                                                        <h2 class="mb-0">
                                                            <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                                            Comments
                                                            </button>
                                                        </h2>
                                                        </div>

                                                        <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordionExample">
                                                        @foreach($post->comments as $comment)
                                                        <div class="card-body">
                                                            {{$comment->body}}
                                                        </div>
                                                        <hr>
                                                        @endforeach
                                                        
                                                        </div>
                                                    </div>
                                                 </div>
                                                <div class="timeline-likes">
                                                    <div class="stats-right">
                                                        <span class="stats-text">{{ $post->comments->count() }} Comments </span>
                                                        <span class="stats-text" ><span id="likes-{{ $post->id }}">{{ $post->likes->count() }}</span> Likes </span>
                                                    </div>
                                                    
                                                </div>
                                                <div class="timeline-footer" >
                                                  
                                                   <div class="stats" id="like-escop-{{ $post->id }}">
                                                        @if(!$post->user_like)
                                                            <a href="javascript:;" id="like-{{ $post->id }}" class="m-r-15 text-inverse-lighter"><i class="fa fa-thumbs-up fa-fw fa-lg m-r-3" onclick="addlike({{ $post->id }},{{ Auth::user()->id }})"></i></a>
                                                        @else
                                                        <span class="fa-stack fa-fw stats-icon" id="liked-{{ $post->id }}" onclick="dislike({{ $post->id }},{{ Auth::user()->id }},{{$post->user_like->id}})" title="Dislike">
                                                        <i class="fa fa-circle fa-stack-2x text-primary"></i>
                                                        <i class="fa fa-thumbs-up fa-stack-1x fa-inverse"></i>
                                                        </span>
                                                        @endif
                                                    </div>
                                                   
                                                    

                                                </div>
                                                <div class="timeline-comment-box">
                                                    <div class="input">
                                                        <form action="">
                                                        <div class="input-group">
                                                            <input type="text" class="form-control rounded-corner" name="body" id="body-{{$post->id}}" placeholder="Write a comment...">
                                                            <span class="input-group-btn p-l-10">
                                                            <button class="btn btn-primary f-s-12 rounded-corner" type="button" onclick="addComment({{ $post->id }},{{ Auth::user()->id }})">Comment</button>
                                                            </span>
                                                        </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                            <br>
                                            @if($post->user_id == Auth::user()->id)
                                            <button type="button" class="btn btn-danger float-right" onclick="deletePost({{ $post->id }},{{ Auth::user()->id }})">Delete</button>
                                            @endif
                                            <hr>
                                            @endforeach
                                            <!-- end timeline-body -->
                                        
                                          
                                        </ul>
                                        <!-- end timeline -->
                                    </div>
                                    <!-- end #profile-post tab -->
                                </div>
                                <!-- end tab-content -->
                                </div>
                                <!-- end profile-content -->
                            </div>
                        </div>
                    </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection
