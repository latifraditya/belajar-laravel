<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sales Report</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        .container { display: flex; flex-wrap: wrap; justify-content: space-between; }
        .half { width: 49%; display: inline-block; vertical-align: top; }
    </style>
</head>
<body>

    <h2>Sales Report</h2>

    <div class="container">
        <div class="half">
            <h3>Total Sales per Branch</h3>
            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Branch</th>
                        <th>City</th>
                        <th>Total Sales</th>
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
            </table>
        </div>

        <div class="half">
            <h3>Total Sales per Month</h3>
            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Month</th>
                        <th>Total Sales</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($salesByMonth as $index => $sales)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ \Carbon\Carbon::parse($sales['month'])->format('M-Y') }}</td>
                        <td>${{ number_format($sales['total'], 2) }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="container">
            <h3>Total Sales per Day</h3>
            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Date</th>
                        <th>Total Sales</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($salesByDay as $index => $sales)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ \Carbon\Carbon::parse($sales['date'])->format('d-M-Y') }}</td>
                        <td>${{ number_format($sales['total'], 2) }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
    </div>

    <div class="container">
      <div class="half">
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

      <div class="half">
        <h3>Total Sales per Product Line</h3>
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Product Line</th>
                    <th>Total Sales</th>
                </tr>
            </thead>
            <tbody>
                @foreach($salesByProductLine as $index => $product)
                <tr>
                  <td>{{ $index + 1 }}</td>
                  <td>{{ $product->product_line }}</td>
                  <td>${{ number_format($product->total_sales, 2) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
      </div>

    </div>

</body>
</html>
