@extends('dashboard.layouts.main')

@section('container')

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
  <h1 class="h2">Post Categories</h1>
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
  <div class="alert alert-success col-lg-6" role="alert">
    {{ session('success') }}
  </div>
@endif

<div class="table-responsive col-lg-6">
  <a href="/dashboard/categories/create" class="btn btn-primary mb3">Create New Category</a>
  <table class="table table-striped table-sm">
    <thead>
      <tr>
        <th scope="col">No</th>
        <th scope="col">Category Name</th>
        <th scope="col">Action</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($categories as $category)
        <tr>
          <td>{{ $loop->iteration }}</td>
          <td>{{ $category->name }}</td>
          <td>
            
            <a href="/dashboard/categories/{{ $category->slug }}" class="badge bg-info icon-hover" title="Lihat"><span data-feather="eye"></span></a>
            <a href="/dashboard/categories/{{ $category->slug }}/edit" class="badge bg-warning icon-hover" title="Edit"><span data-feather="edit"></span></a>
            <form action="/dashboard/categories/{{ $category->slug }}" method="post" class="d-inline">
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