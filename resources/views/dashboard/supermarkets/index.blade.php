@extends('dashboard.layouts.main')

@section('container')

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
  <h2>Data Penjualan Supermarket</h2>
</div>

<style>
  .table {
      font-size: 14px; /* Mengecilkan ukuran teks */
      white-space: nowrap; /* Mencegah teks turun ke bawah */
  }
  .table th, .table td {
      padding: 5px; /* Mengurangi padding antar sel */
  }
</style>



<div class="container table-responsive table-sm"> 
    <a href="{{ route('supermarkets.chart') }}" class="btn btn-primary mb-3">
      Sales Summary
    </a>
    
    <table class="table table-striped table-bordered">
        <thead>
            <tr>
                <th><a href="#" class="sortable" style="text-decoration:none" data-column="id">No <span class="sort-icon"></span></a></th>
                <th><a href="#" class="sortable" style="text-decoration:none" data-column="branch">Branch <span class="sort-icon"></span></a></th>
                <th><a href="#" class="sortable" style="text-decoration:none" data-column="city">City <span class="sort-icon"></span></a></th>
                <th><a href="#" class="sortable" style="text-decoration:none" data-column="customer_type">Customer Type <span class="sort-icon"></span></a></th>
                <th><a href="#" class="sortable" style="text-decoration:none" data-column="gender">Gender <span class="sort-icon"></span></a></th>
                <th><a href="#" class="sortable" style="text-decoration:none" data-column="product_line">Product Line <span class="sort-icon"></span></a></th>
                <th><a href="#" class="sortable" style="text-decoration:none" data-column="unit_price">Unit Price ($)<span class="sort-icon"></span></a></th>
                <th><a href="#" class="sortable" style="text-decoration:none" data-column="quantity">Quantity <span class="sort-icon"></span></a></th>
                <th><a href="#" class="sortable" style="text-decoration:none" data-column="tax_5">Tax 5% <span class="sort-icon"></span></a></th>
                <th><a href="#" class="sortable" style="text-decoration:none" data-column="total">Total ($)<span class="sort-icon"></span></a></th>
                <th><a href="#" class="sortable" style="text-decoration:none" data-column="date">Date <span class="sort-icon"></span></a></th>
                <th><a href="#" class="sortable" style="text-decoration:none" data-column="payment">Payment <span class="sort-icon"></span></a></th>
                <th><a href="#" class="sortable" style="text-decoration:none" data-column="gross_margin_percentage">Gross Margin (%) <span class="sort-icon"></span></a></th>
                <th><a href="#" class="sortable" style="text-decoration:none" data-column="gross_income">Gross Income <span class="sort-icon"></span></a></th>
                <th><a href="#" class="sortable" style="text-decoration:none" data-column="rating">Rating <span class="sort-icon"></span></a></th>
            </tr>
        </thead>
        <tbody>
            @foreach($supermarkets as $supermarket)
            <tr>
                <td>{{ $supermarkets->firstItem() + $loop->index }}</td>
                <td>{{ $supermarket->branch }}</td>
                <td>{{ $supermarket->city }}</td>
                <td>{{ $supermarket->customer_type }}</td>
                <td>{{ $supermarket->gender }}</td>
                <td>{{ $supermarket->product_line }}</td>
                <td>{{ $supermarket->unit_price }}</td>
                <td>{{ $supermarket->quantity }}</td>
                <td>{{ $supermarket->tax_5 }}</td>
                <td>{{ $supermarket->total }}</td>
                <td>{{ \Carbon\Carbon::parse($supermarket['date'])->format('d-M-Y') }}</td>
                <td>{{ $supermarket->payment }}</td>
                <td>{{ $supermarket->gross_margin_percentage }}</td>
                <td>{{ $supermarket->gross_income }}</td>
                <td>{{ $supermarket->rating }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<div>
  {{ $supermarkets->appends(request()->query())->links() }}
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
