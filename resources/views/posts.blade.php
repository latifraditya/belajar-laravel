@extends('layouts.main')

@section('container')
  <h1 class="mb-3 text-center" style="text-decoration: none" >{{ $title }}</h1>

{{-- Search bar --}}
  <div class="row justify-content-center mb-3" >
    <div class="col-md-6">
      <form action="/posts">
        @if (request('category'))
          <input type="hidden" name="category" value="{{ request('category') }}">
        @endif
        @if (request('author'))
          <input type="hidden" name="author" value="{{ request('author') }}">
        @endif
        <div class="input-group mb-3">
          <input type="text" class="form-control" placeholder="Search.." name="search" value="{{ request('search') }}">
          <button class="btn btn-dark" type="submit">Search</button>
        </div>
      </form>
    </div>
  </div>
{{-- End Search Bar --}}

{{-- If there are posts --}}
  @if ($posts->count())
    <div class="card mb-3">
      @if ($posts[0]->image)
      <div style="max-height: 350px; overflow:hidden">
        <img class="card-img-top" src="{{ asset('storage/' . $posts[0]->image) }}" alt="{{ $posts[0]->category->name }}" class="img-fluid" style="margin-top: 20px;">          
      </div>
      @else
      <img src="https://picsum.photos/1200/400?{{ $posts[0]->category->name }}" class="card-img-top" alt="{{ $posts[0]->category->name }}">
      @endif

      
      <div class="card-body text-center" >
        <h3 class="card-title" style="text-decoration: none"><a style="text-decoration: none" href="/posts/{{ $posts[0]->slug }}" class="text-dark">{{ $posts[0]->title }}</a></h3>
        <p>
          <small class="text-muted">
            By. <a style="text-decoration: none" href="/posts?author={{ $posts[0]->author->username }}">{{ $posts[0]->author->name }}</a> in <a style="text-decoration: none" href="/posts?category={{ $posts[0]->category->slug }}">{{ $posts[0]->category->name }}</a> {{ $posts[0]->created_at->diffForHumans() }}
          </small>
        </p>

        <p class="card-text">{{ $posts[0]->excerpt }}</p>

        <a href="/posts/{{ $posts[0]->slug }}" class="btn btn-primary">Read more..</a>
      </div>
    </div>
{{-- End Post --}}

{{-- Post with images --}}
  <div class="container-">
    <div class="row">
      @foreach ($posts->skip(1) as $post)
      <div class="col-md-4 mb-3">
        <div class="card">
          <div class="position-absolute" style="background-color: rgba(0, 0, 0, 0.5)">
            <a style="text-decoration: none" href="/posts?category={{ $post->category->slug }}" class="text-white" >{{ $post->category->name }}</a></div>
            @if ($post->image)
              <img class="card-img-top" src="{{ asset('storage/' . $post->image) }}" alt="{{ $post->category->name }}" class="img-fluid" style="margin-top: 20px;">          
            @else
            <img class="card-img-top" src="https://picsum.photos/600/400?{{ $post->category->name }}" alt="{{ $post->category->name }}">
                
            @endif
            
            <div class="card-body">
              <h5 class="card-title">{{ $post->title }}</h5>
              <p>
                <small class="text-muted">
                  By. <a style="text-decoration: none" href="/posts?author={{ $post->author->username }}">{{ $post->author->name }}</a> {{ $post->created_at->diffForHumans() }}
                </small>
              </p>
              <p class="card-text">{{ $post->excerpt }}</p>
              <a href="/posts/{{ $post->slug }}" class="btn btn-primary">Read more</a>
            </div>
        </div>
      </div>
      @endforeach
    </div>
  </div>
    
  @else 
  <p class="text-center fs-4">No post found.</p>
  @endif

  <div class="d-flex justify-content-end">
    {{  $posts->links() }}
  </div>
  

@endsection