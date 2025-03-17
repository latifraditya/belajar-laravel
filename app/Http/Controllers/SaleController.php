<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sale;
use Illuminate\Support\Facades\DB;


class SaleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = Sale::query();

        // Filter berdasarkan request
        if ($request->filled('brand')) {
            $query->where('brand', $request->brand);
        }

        if ($request->filled('processor')) {
            $query->where('processor', $request->processor);
        }

        if ($request->filled('ram_gb')) {
            $query->where('ram_gb', $request->ram_gb);
        }

        if ($request->filled('storage')) {
            $query->where('storage', $request->storage);
        }

        if ($request->filled('gpu')) {
            $query->where('gpu', $request->gpu);
        }

        // Sorting
        $validColumns = ['id', 'brand', 'processor', 'ram_gb', 'storage', 'gpu', 'weight_kg', 'price_usd'];
        $sortBy = $request->get('sortBy', 'id'); // Default sorting by ID
        $sortOrder = $request->get('sortOrder', 'asc'); // Default ascending

        if (!in_array($sortBy, $validColumns)) {
            $sortBy = 'id'; // Prevent SQL injection & invalid sorting
        }

        // Terapkan sorting
        $query->orderBy($sortBy, $sortOrder);

        // Pagination setelah filter & sorting
        $sales = $query->paginate(100)->appends($request->query());

        // Ambil opsi filter
        $brands = Sale::select('brand')->distinct()->orderBy('brand')->pluck('brand');
        $processors = Sale::select('processor')->distinct()->orderBy('processor')->pluck('processor');
        $ramOptions = Sale::select('ram_gb')->distinct()->orderBy('ram_gb')->pluck('ram_gb');
        $storageOptions = Sale::select('storage')->distinct()->orderBy('storage')->pluck('storage');
        $gpuOptions = Sale::select('gpu')->distinct()->orderBy('gpu')->pluck('gpu');

        // Kirim data ke view
        return view('dashboard.sales.index', compact(
            'sales',
            'brands',
            'processors',
            'ramOptions',
            'storageOptions',
            'gpuOptions',
            'sortBy',
            'sortOrder'
        ));
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function salesChart()
{
    // Ambil data rata-rata harga berdasarkan brand
    $priceData = Sale::select('brand', DB::raw('AVG(price_usd) as avg_price'))
        ->groupBy('brand')
        ->get();

    // Ambil data rata-rata berat berdasarkan brand
    $weightData = Sale::select('brand', DB::raw('AVG(weight_kg) as avg_weight'))
        ->groupBy('brand')
        ->get();

    // Ambil data rata-rata harga berdasarkan processor
    $processorData = Sale::select('processor', DB::raw('AVG(price_usd) as avg_price'))
        ->groupBy('processor')
        ->get();

    return view('dashboard.sales.chart', compact('priceData', 'weightData', 'processorData'));
}



}
