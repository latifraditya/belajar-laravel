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
          <td class="text-center">{{ $loop->iteration }}</td>
          <td>
            <input type="text" class="form-control edit-category" style="height: 30px;"
                   value="{{ $category->name }}">
          </td>
          <td>
            <form action="/dashboard/categories/{{ $category->id }}" method="post" class="d-inline">
              @method('delete')
              @csrf
              <button class="badge bg-danger border-0 icon-hover" title="Delete" onclick=confirmDelete(event)><span data-feather="trash"></span></button>
            </form>
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
        cancelButtonColor: "#3085d6",
        confirmButtonText: "Delete",
        cancelButtonText: "Cancel"
    }).then((result) => {
        if (result.isConfirmed) {
            event.target.closest("form").submit(); // Mengirimkan form yang benar
        }
    });
}

</script>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
  document.addEventListener("DOMContentLoaded", function () {
    if (typeof jQuery !== "undefined") {
      $(document).on("keypress", ".edit-category", function (e) {
        if (e.which == 13) { // Jika Enter ditekan
          e.preventDefault();

          let categoryId = $(this).data("id");
          let newName = $(this).val();

          $.ajax({
            url: "/dashboard/categories/update",
            type: "POST",
            data: {
              _token: "{{ csrf_token() }}",
              id: categoryId,
              name: newName
            },
            success: function () {
              alert("Kategori berhasil diperbarui!");
            },
            error: function () {
              alert("Gagal memperbarui kategori!");
            }
          });
        }
      });
    }
  });
</script>


@endsection