
@extends('layouts.main')

@section('container')

  <div class="container-">
    <div class="row justify-content-center mb-5">
      <div class="col-md-8">
        <h1 class = "mb-3">{{ $post->title }}</h1>
        <p>By. <a href="/posts?author={{ $post->author->username }}">{{ $post->author->name }}</a> in <a href="/posts?category={{ $post->category->slug }}">{{ $post->category->name }}</a></p>
        

        @if ($post->image)
        <div style="max-height: 350px; overflow:hidden">
          <img class="card-img-top" src="{{ asset('storage/' . $post->image) }}" alt="{{ $post->category->name }}" class="img-fluid" style="margin-top: 20px;">          
        </div>
        @else
        <img class="card-img-top" src="https://picsum.photos/1200/400?{{ $post->category->name }}" alt="{{ $post->category->name }}" class="img-fluid" style="margin-top: 20px;">
            
        @endif

        {!! $post->body !!}
    
      <a href="/posts" class="d-block-mt-3">Back to Posts</a>
      </div>
    </div>
  </div>
       

        
@endsection
