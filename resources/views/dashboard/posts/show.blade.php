@extends('dashboard.layouts.main')

@section('container')

<div class="container-">
  <div class="row my-3">
    <div class="col-lg-8">
      <h1 class = "mb-3">{{ $post->title }}</h1>
      
      <a href="/dashboard/posts" class="btn btn-success"><span data-feather="arrow-left"></span> Back to all my posts</a>
      
      <a href="/dashboard/posts/{{ $post->slug }}/edit" class="btn btn-warning"><span data-feather="edit"></span> Edit</a>
      @can('admin')
      <form action="/dashboard/posts/{{ $post->slug }}" method="post" class="d-inline">
        @method('delete')
        @csrf
        <button class="btn btn-danger" onclick="return confirm('Are you sure?')"><span data-feather="trash"></span>Delete</button>
      </form>
      @endcan
      

      @if ($post->image)
      <div style="max-height: 350px; overflow:hidden">
        <img class="card-img-top" src="{{ asset('storage/' . $post->image) }}" alt="{{ $post->category->name }}" class="img-fluid mt-3" style="margin-top: 20px;">          
      </div>
      @else
      <img class="card-img-top" src="https://picsum.photos/800/400?{{ $post->category->name }}" alt="{{ $post->category->name }}" class="img-fluid mt-3" style="margin-top: 20px;">
          
      @endif

      {!! $post->body !!}
  
    </div>
  </div>
</div>

@endsection