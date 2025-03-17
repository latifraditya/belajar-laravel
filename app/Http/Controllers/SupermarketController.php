<?php

namespace App\Http\Controllers;

use App\Models\Supermarket;
use App\Http\Requests\StoreSupermarketRequest;
use App\Http\Requests\UpdateSupermarketRequest;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class SupermarketController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // $query = Supermarket::query();
        $sortBy = $request->query('sortBy', 'id'); // Default sorting berdasarkan id
        $sortOrder = $request->query('sortOrder', 'asc'); // Default ascending

        $supermarkets = Supermarket::orderBy($sortBy, $sortOrder)->paginate(100);
        return view('dashboard.supermarkets.index', compact('supermarkets'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreSupermarketRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreSupermarketRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Supermarket  $supermarket
     * @return \Illuminate\Http\Response
     */
    public function show(Supermarket $supermarket)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Supermarket  $supermarket
     * @return \Illuminate\Http\Response
     */
    public function edit(Supermarket $supermarket)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateSupermarketRequest  $request
     * @param  \App\Models\Supermarket  $supermarket
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateSupermarketRequest $request, Supermarket $supermarket)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Supermarket  $supermarket
     * @return \Illuminate\Http\Response
     */
    public function destroy(Supermarket $supermarket)
    {
        //
    }

    public function chart()
    {
        return view('dashboard.supermarkets.chart', [
            'salesByBranch' => Supermarket::getSalesByBranch(),
            'salesByMonth' => Supermarket::getSalesByMonth(),
            'salesByDay' => Supermarket::getSalesByDay(),
            'genderCounts' => Supermarket::getGenderCounts(),
            'totalGender' => Supermarket::getGenderCounts()->sum('count'),
            'customerTypeCounts' => Supermarket::getCustomerTypeCounts(),
            'grandTotal' => Supermarket::getGrandTotal(),
            'salesByProductLine' => Supermarket::getSalesByProductLine(),
            'totalQuantity' => Supermarket::getSalesByProductLine()->sum('quantity')
        ]);
    }

    public function exportPdf()
    {
        $data = [
            'salesByBranch' => Supermarket::getSalesByBranch(),
            'salesByMonth' => Supermarket::getSalesByMonth(),
            'salesByDay' => Supermarket::getSalesByDay(),
            'genderCounts' => Supermarket::getGenderCounts(),
            'totalGender' => Supermarket::getGenderCounts()->sum('count'),
            'customerTypeCounts' => Supermarket::getCustomerTypeCounts(),
            'grandTotal' => Supermarket::getGrandTotal(),
            'salesByProductLine' => Supermarket::getSalesByProductLine()
        ];

        $pdf = Pdf::loadView('dashboard.supermarkets.pdf', $data);
        return $pdf->download('sales_report.pdf');
    }

    public function exportExcel()
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $data = Supermarket::getAllReportData();

        $row = 1; // Mulai dari baris pertama

      // 🔹 1. Total Sales per Branch
      $sheet->setCellValue("A$row", "Total Sales per Branch");
      $row++;
      $sheet->fromArray(["No", "Branch", "City", "Total Sales"], null, "A$row");
      $row++;
      foreach ($data['salesByBranch'] as $index => $sales) {
          $sheet->fromArray([$index + 1, $sales['branch'], $sales['city'], $sales['total']], null, "A$row");
          $row++;
      }
      $row += 2; // Spasi antar tabel

      // 🔹 2. Total Sales per Month
      $sheet->setCellValue("A$row", "Total Sales per Month");
      $row++;
      $sheet->fromArray(["No", "Month", "Total Sales"], null, "A$row");
      $row++;
      foreach ($data['salesByMonth'] as $index => $sales) {
          $sheet->fromArray([$index + 1, \Carbon\Carbon::parse($sales['month'])->format('M-Y'), $sales['total']], null, "A$row");
          $row++;
      }
      $row += 2;

      // 🔹 3. Total Sales per Day
      $sheet->setCellValue("A$row", "Total Sales per Day");
      $row++;
      $sheet->fromArray(["No", "Date", "Total Sales"], null, "A$row");
      $row++;
      foreach ($data['salesByDay'] as $index => $sales) {
          $sheet->fromArray([$index + 1, \Carbon\Carbon::parse($sales['date'])->format('d-M-Y'), $sales['total']], null, "A$row");
          $row++;
      }
      $row += 2;

      // 🔹 4. Customer Gender & Type Distribution
      $sheet->setCellValue("A$row", "Customer Gender & Type Distribution");
      $row++;
      $sheet->fromArray(["Customer Type", "Female", "Male", "Total"], null, "A$row");
      $row++;
      foreach (["Member", "Normal"] as $type) {
          $female = $data['customerTypeCounts']['Female'][$type] ?? 0;
          $male = $data['customerTypeCounts']['Male'][$type] ?? 0;
          $sheet->fromArray([$type, $female, $male, $female + $male], null, "A$row");
          $row++;
      }
      $row += 2;

      // 🔹 5. Sales by Product Line
      $sheet->setCellValue("A$row", "Total Sales by Product Line");
      $row++;
      $sheet->fromArray(["No", "Product Line", "Total Sales"], null, "A$row");
      $row++;
      foreach ($data['salesByProductLine'] as $index => $product) {
          $sheet->fromArray([$index + 1, $product->product_line, $product->total_sales], null, "A$row");
          $row++;
      }
      $row += 2;

      // 🔹 6. Grand Total
      $sheet->setCellValue("A$row", "Grand Total Sales:");
      $sheet->setCellValue("B$row", $data['grandTotal']);

      // Simpan file Excel dan kirim ke user
      $writer = new Xlsx($spreadsheet);
      $fileName = 'sales_report.xlsx';

      header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
      header('Content-Disposition: attachment; filename="' . $fileName . '"');
      $writer->save('php://output');
      exit;
    }
}
