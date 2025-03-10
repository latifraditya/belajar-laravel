@extends('dashboard.layouts.main')

@section('container')

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
  <h1 class="h2">Users</h1>
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
  <table class="table table-striped table-sm">
    <thead>
      <tr>
        <th scope="col">No</th>
        <th scope="col">Name</th>
        <th scope="col">Email</th>
        <th scope="col">Action</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($users as $user)
        <tr>
          <td>{{ $loop->iteration }}</td>
          <td>{{ $user->name }}</td>
          <td>{{ $user->email }}</td>
          <td>
            <a href="/dashboard/users/{{ $user->id }}" class="badge bg-info icon-hover" style="text-decoration: none;padding: 10px 10px;">Details</a>
          </td>
        </tr>
      @endforeach
    </tbody>
  </table>
</div>
<script>
  function confirmDelete(event) {
      event.preventDefault(); // Mencegah form langsung dikirim
  
      Swal.fire({
          title: "Apakah Anda yakin?",
          text: "Semua data postingan dalam kategori ini juga akan dihapus secara permanen!!!",
          icon: "warning",
          showCancelButton: true,
          confirmButtonColor: "#d33",
          cancelButtonColor: "#3085d6", // Warna biru untuk tombol cancel (primary)
          confirmButtonText: "Delete",
          cancelButtonText: "Cancel"
      }).then((result) => {
          if (result.isConfirmed) {
              document.getElementById("delete-form").submit();
          }
      });
  }



  
  </script>

@endsection