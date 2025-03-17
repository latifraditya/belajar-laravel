@extends('dashboard.layouts.main')

@section('container')

<style>
  .table-container {
      display: flex;
      justify-content: space-between;
      gap: 20px;
  }
  .table-wrapper {
      flex: 1;
  }
  .table {
      font-size: 14px;
      white-space: nowrap;
  }
  .table th, .table td {
      padding: 5px;
  }
  th {
      cursor: pointer; /* Ubah cursor menjadi tangan klik */
      user-select: none; /* Hindari teks terblok */
  }
  .chart-container {
    display: grid;
    grid-template-columns: repeat(2, 1fr); /* 2 kolom */
    grid-gap: 20px; /* Jarak antar grafik */
    justify-content: center;
    align-items: center;
  }
  canvas {
      max-width: 400px !important;
      max-height: 300px !important;
      margin: auto;
  }
</style>

<div class="container">
    <h2 class="mb-4 mt-3">Sales Reports</h2>
    <a href="/dashboard/supermarkets" class="btn btn-primary mb-2"><i class="bi bi-arrow-left-short"></i> Back</a>
    <div class="dropdown">
      <button class="btn btn-success dropdown-toggle mb-3" type="button" data-bs-toggle="dropdown" aria-expanded="false">
          <i class="bi bi-download"></i> Download
      </button>
      <ul class="dropdown-menu">
          <li>
              <a class="dropdown-item" href="{{ route('supermarkets.exportPdf') }}">
                  <i class="bi bi-file-earmark-pdf text-danger"></i> PDF
              </a>
          </li>
          <li>
              <a class="dropdown-item" href="{{ route('supermarkets.exportExcel') }}">
                  <i class="bi bi-file-earmark-excel text-success"></i> Excel
              </a>
          </li>
      </ul>
    </div>
</div>
  
  
    <div class="table-container">
        <!-- Tabel Total Sales per Branch -->
        <div class="table-wrapper">
            <h4 class="mb-3">Total Sales per Branch</h4>
            <table id="sortable-branch" class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th onclick="sortTable('sortable-branch',0)">No</th>
                        <th onclick="sortTable('sortable-branch',1)">Branch <span class="sort-icon"></span></th>
                        <th onclick="sortTable('sortable-branch',2)">City <span class="sort-icon"></span></th>
                        <th onclick="sortTable('sortable-branch',3)">Total Sales <span class="sort-icon"></span></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($salesByBranch as $index => $sales)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $sales['branch'] }}</td>
                        <td>{{ $sales['city'] }}</td>
                        <td>${{ number_format($sales['total'], 2) }}</td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="3"><strong>Grand Total</strong></td>
                        <td><strong>${{ number_format($grandTotal, 2) }}</strong></td>
                    </tr>
                </tfoot>
            </table>
        </div>

        <!-- Tabel Total Sales per Month -->
        <div class="table-wrapper">
            <h4 class="mb-3">Total Sales per Month</h4>
            <table id="sortable-month" class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>No</th>
                        <th onclick="sortTable('sortable-month',1)">Month <span class="sort-icon"></span></th>
                        <th onclick="sortTable('sortable-month',2)">Total Sales <span class="sort-icon"></span></th>
                    </tr>
                </thead>
                <tbody id="tbody-month">
                    @foreach($salesByMonth as $index => $sales)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ \Carbon\Carbon::parse($sales['month'])->format('M-Y') }}</td>
                        <td>${{ number_format($sales['total'], 2) }}</td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                  <tr>
                      <td colspan="2"><strong>Grand Total</strong></td>
                      <td><strong>${{ number_format($grandTotal, 2) }}</strong></td>
                  </tr>
              </tfoot>
            </table>
        </div>

        {{-- Tabel Sales per Day --}}
        <div class="table-wrapper">
          <h4 class="mb-3">Total Sales per Day</h4>

          <div class="table-responsive" style="max-height: 353px; overflow-y: auto;">
            <table id="sortable-day" class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>No <span class="sort-icon"></span></th>
                        <th onclick="sortTable('sortable-day',1)">Date <span class="sort-icon"></span></th>
                        <th onclick="sortTable('sortable-day',2)">Total Sales <span class="sort-icon"></span></th>
                    </tr>
                </thead>
                <tbody id="tbody-day">
                    @foreach($salesByDay as $index => $sales)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ \Carbon\Carbon::parse($sales['date'])->format('d-M-Y') }}</td>
                        <td class="total-sales">${{ number_format($sales['total'], 2) }}</td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="2"><strong>Grand Total</strong></td>
                        <td><strong>${{ number_format($grandTotal, 2) }}</strong></td>
                    </tr>
                </tfoot>
            </table>
          </div>
        </div>
    </div>


    <div class="table-container table-responsive table-sm mt-4">
        {{-- Customer Data --}}
        <div class="table-wrapper">
          <h4 class="mb-3">Customer Gender & Type Distribution</h4>

          <table class="table table-striped table-bordered">
              <thead>
                  <tr>
                      <th>Customer Type</th>
                      <th>Female</th>
                      <th>Male</th>
                      <th>Total</th>
                  </tr>
              </thead>
              <tbody>
                  <tr>
                      <td>Member</td>
                      <td>{{ $customerTypeCounts['Female']['Member'] ?? 0 }}</td>
                      <td>{{ $customerTypeCounts['Male']['Member'] ?? 0 }}</td>
                      <td>
                          {{ ($customerTypeCounts['Female']['Member'] ?? 0) + ($customerTypeCounts['Male']['Member'] ?? 0) }}
                      </td>
                  </tr>
                  <tr>
                      <td>Normal</td>
                      <td>{{ $customerTypeCounts['Female']['Normal'] ?? 0 }}</td>
                      <td>{{ $customerTypeCounts['Male']['Normal'] ?? 0 }}</td>
                      <td>
                          {{ ($customerTypeCounts['Female']['Normal'] ?? 0) + ($customerTypeCounts['Male']['Normal'] ?? 0) }}
                      </td>
                  </tr>
              </tbody>
              <tfoot>
                  <tr>
                      <td><strong>Total</strong></td>
                      <td>
                          <strong>
                              {{ ($customerTypeCounts['Female']['Member'] ?? 0) + ($customerTypeCounts['Female']['Normal'] ?? 0) }}
                          </strong>
                      </td>
                      <td>
                          <strong>
                              {{ ($customerTypeCounts['Male']['Member'] ?? 0) + ($customerTypeCounts['Male']['Normal'] ?? 0) }}
                          </strong>
                      </td>
                      <td>
                          <strong>
                              {{ array_sum(array_column($customerTypeCounts, 'Member')) + array_sum(array_column($customerTypeCounts, 'Normal')) }}
                          </strong>
                      </td>
                  </tr>
              </tfoot>
          </table>
        </div>

        {{-- Total Sales by Product Line --}}
        <div class="table-wrapper">
              <h4 class="mb-3">Total Sales by Product Line</h4>
              <table id="sortable-product" class="table table-striped table-bordered">
                <thead>
                  <tr>
                    <th>No</th>
                    <th>Product Line  </th>
                    <th onclick="sortTable('sortable-product',2)">Quantity <span class="sort-icon"></span></th>
                    <th onclick="sortTable('sortable-product',3)">Total Sales <span class="sort-icon"></span></th>
                  </tr>
                </thead>
                <tbody id="tbody-product">
                  @foreach($salesByProductLine as $index => $product)
                  <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $product->product_line }}</td>
                    <td>{{ $product->quantity }}</td>
                    <td>${{ number_format($product->total_sales, 2) }}</td>
                  </tr>
                  @endforeach
                </tbody>
                <tfoot>
                  <tr>
                    <td colspan="2"><strong>Grand Total</strong></td>
                    <td><strong>{{ number_format($totalQuantity) }}</strong></td>
                    <td><strong>${{ number_format($grandTotal, 2) }}</strong></td>
                  </tr>
                </tfoot>
              </table>
        </div> 
    </div>



{{-- Chart Image --}}
<div class="container mt-4">
  <div class="table-wrapper">
    <h2 class="mb-4">Sales Charts</h2>
    <div class="chart-container mt-5">
      <canvas id="branchChart"></canvas>
      <canvas id="monthChart"></canvas>
      <canvas id="dayChart"></canvas>
      <canvas id="customerTypeChart"></canvas>
    </div>
  </div>
</div>



{{-- Script Sorting Semua Kolom --}}
<script>
  let sortDirections = {}; // Simpan status sorting tiap kolom

  function sortTable(tableId, columnIndex) {
      let table = document.getElementById(tableId);
      let tbody = table.querySelector("tbody");
      let rows = Array.from(tbody.querySelectorAll("tr"));

      // Toggle sorting direction
      let key = tableId + '-' + columnIndex;
      sortDirections[key] = sortDirections[key] === 'asc' ? 'desc' : 'asc';
      let direction = sortDirections[key] === 'asc' ? 1 : -1;

      rows.sort((a, b) => {
          let aVal = a.cells[columnIndex].textContent.trim();
          let bVal = b.cells[columnIndex].textContent.trim();

          // Jika kolom adalah angka (Total Sales), konversi ke float
          if (columnIndex === 2) {
              aVal = parseFloat(aVal.replace('$', '').replace(',', ''));
              bVal = parseFloat(bVal.replace('$', '').replace(',', ''));
          } 
          // Jika kolom adalah tanggal, konversi ke Date
          else if (columnIndex === 1) {
              aVal = new Date(aVal);
              bVal = new Date(bVal);
          }

          return (aVal > bVal ? 1 : -1) * direction;
      });

      // Reset tabel dan tambahkan kembali row yang sudah diurutkan
      tbody.innerHTML = "";
      rows.forEach((row, index) => {
          row.cells[0].textContent = index + 1; // Update nomor urut
          tbody.appendChild(row);
      });

      // Perbarui ikon sorting
      updateSortIcons(tableId, columnIndex);
  }
  
  function updateSortIcons(tableId, activeColumn) {
    let table = document.getElementById(tableId);
    let headers = table.querySelectorAll("th");
    
    headers.forEach((header, index) => {
        let icon = header.querySelector(".sort-icon");
        if (icon) {
            if (index === activeColumn) {
                icon.textContent = sortDirections[tableId + '-' + activeColumn] === 'asc' ? "⇧" : "⇩";
            } else {
                icon.textContent = " "; // Reset ikon di kolom lain
            }
        }
    });
}
</script>


<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>


<script>
  document.addEventListener("DOMContentLoaded", function() {
      // Data untuk branchChart (Bar Chart)
      const branchData = @json($salesByBranch);
      const branchLabels = branchData.map(item => item.branch);
      const branchSales = branchData.map(item => item.total);
      new Chart(document.getElementById("branchChart"), {
          type: 'bar',
          data: {
              labels: branchLabels,
              datasets: [{
                  label: 'Total Sales by Branch',
                  data: branchSales,
                  backgroundColor: 'rgba(75, 192, 192, 0.6)',
                  borderColor: 'rgba(75, 192, 192, 1)',
                  borderWidth: 2
              }]
          },
          options: {
              responsive: true,
              plugins: { legend: { display: true } },
              scales: { y: { beginAtZero: true } }
          }
      });

      // Data untuk monthChart (Bar Chart)
      const monthData = @json($salesByMonth);
      const monthLabels = monthData.map(item => item.month);
      const monthSales = monthData.map(item => item.total);

      new Chart(document.getElementById("monthChart"), {
          type: 'bar',
          data: {
              labels: monthLabels,
              datasets: [{
                  label: 'Total Sales',
                  data: monthSales,
                  backgroundColor: 'rgba(54, 162, 235, 0.6)',
                  borderColor: 'rgba(54, 162, 235, 1)',
                  borderWidth: 1
              }]
          },
          options: {
              responsive: true,
              plugins: {
                  legend: { display: true }
              },
              scales: {
                  y: {
                      beginAtZero: true
                  }
              }
          }
      });

      // Data untuk dayChart (Line Chart)
      const dayData = @json($salesByDay);
      const dayLabels = dayData.map(item => item.date);
      const daySales = dayData.map(item => item.total);
      new Chart(document.getElementById("dayChart"), {
          type: 'line',
          data: {
              labels: dayLabels,
              datasets: [{
                  label: 'Total Sales',
                  data: daySales,
                  borderColor: 'rgba(54, 162, 235, 1)',
                  backgroundColor: 'rgba(54, 162, 235, 0.2)',
                  fill: true,
                  tension: 0.4
              }]
          },
          options: {
              responsive: true,
              plugins: { legend: { display: true } }
          }
      });

      // Data untuk customerTypeChart (Bar Chart)
      const customerTypeCounts = @json($customerTypeCounts);

    // Labels (Kategori Customer Type)
    const customerLabels = ["Member", "Normal"];

    // Data untuk Female dan Male
    const femaleData = customerLabels.map(type => customerTypeCounts['Female'][type] ?? 0);
    const maleData = customerLabels.map(type => customerTypeCounts['Male'][type] ?? 0);

    // Buat bar chart menggunakan Chart.js
    new Chart(document.getElementById("customerTypeChart"), {
        type: 'bar',
        data: {
            labels: customerLabels,
            datasets: [
                {
                    label: 'Female',
                    data: femaleData,
                    backgroundColor: 'rgba(255, 99, 132, 0.6)',
                    borderColor: 'rgba(255, 99, 132, 1)',
                    borderWidth: 1
                },
                {
                    label: 'Male',
                    data: maleData,
                    backgroundColor: 'rgba(54, 162, 235, 0.6)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }
            ]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: true }
            },
            scales: {
                y: { beginAtZero: true }
            }
        }
    });
  });
</script>


@endsection
