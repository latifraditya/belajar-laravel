@extends('dashboard.layouts.main')

@section('container')

@if(session()->has('success'))
  <div class="alert alert-success col-lg-6" role="alert">
    {{ session('success') }}
  </div>
@endif

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 mb-3 border-bottom">
<h1 class="h2">Detail User</h1>
</div>

  <div class="card-body">
    <h5 class="card-title">{{ $user->name }}</h5>
    <p class="card-text"><strong>Email:</strong> {{ $user->email }}</p>
  </div>

<div class="border-bottom">
<h3 class="mt-4">Postingan User</h3>
</div>

@if ($user->posts->count() > 0)
  <div class="table-responsive col-lg-10">
    <table class="table table-striped table-sm mt-3">
        <thead>
            <tr>
                <th>No</th>
                <th>Judul</th>
                <th>Kategori</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($user->posts as $post)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $post->title }}</td>
                <td>{{ $post->category->name ?? 'No Category'}}</td>
                <td>
                    <a href="/dashboard/posts/{{ $post->slug }}" class="btn btn-info btn-sm">Lihat</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
  </div>
@else
    <p class="mt-3">User ini belum memiliki postingan.</p>
@endif
  
@endsection
