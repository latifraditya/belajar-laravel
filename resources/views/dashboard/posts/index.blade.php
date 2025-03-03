@extends('dashboard.layouts.main')

@section('container')

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
  <h1 class="h2">{{ auth()->user()->name }}'s Post</h1>
</div>

<style>
/* Menambahkan efek hover pada ikon */
.icon-hover {
    display: inline-flex;  /* Menjaga ikon agar berada dalam baris */
    justify-content: center; /* Agar ikon berada di tengah */
    align-items: center; /* Vertikal alignment */
    transition: all 0.3s ease; /* Transisi halus pada semua perubahan */
}

.icon-hover:hover {
    background-color: #007bff;  /* Mengubah background saat hover (warna biru) */
    transform: scale(1.1); /* Membesarkan elemen saat hover */
}

.icon-hover span {
    transition: transform 0.3s ease; /* Transisi yang halus untuk ikon */
}

.icon-hover:hover span {
    transform: scale(1.2);  /* Membesarkan ikon saat hover */
}
</style>

@if(session()->has('success'))
  <div class="alert alert-success col-lg-8" role="alert">
    {{ session('success') }}
  </div>
@endif

<div class="table-responsive col-lg-8">
  <a href="/dashboard/posts/create" class="btn btn-primary mb3">Create New Post</a>
  <table class="table table-striped table-sm">
    <thead>
      <tr>
        <th scope="col">No</th>
        <th scope="col">Title</th>
        <th scope="col">Category</th>
        <th scope="col">Action</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($posts as $post)
        <tr>
          <td>{{ $loop->iteration }}</td>
          <td>{{ $post->title }}</td>
          <td>{{ $post->category->name }}</td>
          <td>
            
            <a href="/dashboard/posts/{{ $post->slug }}" class="badge bg-info icon-hover" title="Lihat"><span data-feather="eye"></span></a>
            <a href="/dashboard/posts/{{ $post->slug }}/edit" class="badge bg-warning icon-hover" title="Edit"><span data-feather="edit"></span></a>
            <form action="/dashboard/posts/{{ $post->slug }}" method="post" class="d-inline">
              @method('delete')
              @csrf
              <button class="badge bg-danger border-0 icon-hover" title="Delete" onclick="return confirm('Are you sure?')"><span data-feather="trash"></span></button>
            </form>
          </td>
        </tr>
      @endforeach
    </tbody>
  </table>
</div>

@endsection