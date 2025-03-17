@extends('dashboard.layouts.main')

@section('container')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1>Data Harga Laptop</h1>
</div>

<a href="/dashboard/sales/chart" class="btn btn-primary mb-3">
  Lihat Grafik Penjualan
</a>

<!-- Filter & Search Form -->
<form action="{{ route('sales.index') }}" method="GET" class="mb-3">
    <div class="row col-lg-11">
        <div class="col-md-2">
            <select name="brand" class="form-control">
                <option value="">Pilih Brand</option>
                @foreach ($brands as $brand)
                    <option value="{{ $brand }}" {{ request('brand') == $brand ? 'selected' : '' }}>{{ $brand }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-2">
            <select name="processor" class="form-control">
                <option value="">Pilih Processor</option>
                @foreach ($processors as $processor)
                    <option value="{{ $processor }}" {{ request('processor') == $processor ? 'selected' : '' }}>{{ $processor }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-2">
            <select name="ram_gb" class="form-control">
                <option value="">Pilih RAM</option>
                @foreach ($ramOptions as $ram)
                    <option value="{{ $ram }}" {{ request('ram_gb') == $ram ? 'selected' : '' }}>{{ $ram }} GB</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-2">
          <select name="storage" class="form-control">
              <option value="">Pilih Storage</option>
              @foreach ($storageOptions as $storage)
                  <option value="{{ $storage }}" {{ request('storage') == $storage ? 'selected' : '' }}>{{ $storage }}</option>
              @endforeach
          </select>
        </div>
        <div class="col-md-2">
            <select name="gpu" class="form-control">
                <option value="">Pilih GPU</option>
                @foreach ($gpuOptions as $gpu)
                    <option value="{{ $gpu }}" {{ request('gpu') == $gpu ? 'selected' : '' }}>{{ $gpu }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-1">
            <button type="submit" class="btn btn-primary">Filter</button>
        </div>
    </div>
</form>

<div class="table-responsive col-lg-10">
  <table class="table table-striped" id="salesTable">
    <thead>
        <tr>
            <th><a href="#" class="sortable" style="text-decoration: none" data-column="id">No <span class="sort-icon"></span></a></th>
            <th><a href="#" class="sortable" style="text-decoration: none" data-column="brand">Brand <span class="sort-icon"></span></a></th>
            <th><a href="#" class="sortable" style="text-decoration: none" data-column="processor">Processor <span class="sort-icon"></span></a></th>
            <th><a href="#" class="sortable" style="text-decoration: none" data-column="ram_gb">RAM (GB) <span class="sort-icon"></span></a></th>
            <th><a href="#" class="sortable" style="text-decoration: none" data-column="storage">Storage <span class="sort-icon"></span></a></th>
            <th><a href="#" class="sortable" style="text-decoration: none" data-column="gpu">GPU <span class="sort-icon"></span></a></th>
            <th><a href="#" class="sortable" style="text-decoration: none" data-column="weight_kg">Weight (KG) <span class="sort-icon"></span></a></th>
            <th><a href="#" class="sortable" style="text-decoration: none" data-column="price_usd">Price ($) <span class="sort-icon"></span></a></th>
        </tr>
    </thead>
    <tbody>
      @foreach ($sales as $sale)
        <tr>
            <td>{{ $sales->firstItem() + $loop->index }}</td>
            <td>{{ $sale->brand }}</td>
            <td>{{ $sale->processor }}</td>
            <td>{{ $sale->ram_gb }}</td>
            <td>{{ $sale->storage }}</td>
            <td>{{ $sale->gpu }}</td>
            <td>{{ $sale->weight_kg }}</td>
            <td>{{ $sale->price_usd }}</td>
        </tr>
      @endforeach
    </tbody>
  </table>
</div>
<div>
  {{ $sales->appends(request()->query())->links() }}
</div>

<script>
  document.addEventListener("DOMContentLoaded", function () {
      const sortableHeaders = document.querySelectorAll(".sortable");
  
      // Ambil parameter sorting dari URL
      const urlParams = new URLSearchParams(window.location.search);
      const currentSortBy = urlParams.get("sortBy");
      const currentSortOrder = urlParams.get("sortOrder");
  
      // Tambahkan panah ke kolom yang sedang diurutkan
      if (currentSortBy) {
          const activeHeader = document.querySelector(`[data-column="${currentSortBy}"] .sort-icon`);
          if (activeHeader) {
              activeHeader.innerHTML = currentSortOrder === "asc" ? " ▲" : " ▼";
          }
      }
  
      // Tambahkan event listener untuk sorting
      sortableHeaders.forEach(header => {
          header.addEventListener("click", function (e) {
              e.preventDefault();
  
              const column = this.getAttribute("data-column");
              let sortOrder = "asc"; // Default ascending
  
              // Jika kolom yang sama diklik, ubah arah sorting
              if (currentSortBy === column && currentSortOrder === "asc") {
                  sortOrder = "desc";
              }
  
              urlParams.set("sortBy", column);
              urlParams.set("sortOrder", sortOrder);
  
              window.location.search = urlParams.toString();
          });
      });
  });
  </script>
  

@endsection