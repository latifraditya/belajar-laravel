<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Supermarket extends Model
{
    use HasFactory;

    protected $guarded = [
    ];

    // Total sales per branch
    public static function getSalesByBranch()
    {
        return self::select('branch', 'city', DB::raw('SUM(total) AS total'))
            ->groupBy('branch', 'city')
            ->orderBy('total', 'ASC')
            ->get();
    }

    // Total sales per month
    public static function getSalesByMonth()
    {
        return self::select(DB::raw("DATE_FORMAT(date, '%Y-%m') AS month"), DB::raw('SUM(total) AS total'))
            ->groupBy('month')
            ->orderBy('month', 'ASC')
            ->get();
    }

    // Total sales per day
    public static function getSalesByDay()
    {
        return self::select(DB::raw('DATE(date) as date'), DB::raw('SUM(total) as total'))
            ->groupBy('date')
            ->orderBy('date')
            ->get();
    }

    // Persentase gender
    public static function getGenderCounts()
    {
        return self::select('gender', DB::raw('COUNT(*) as count'))
            ->groupBy('gender')
            ->get();
    }

    public static function getSalesByProductLine()
    {
        return self::select('product_line', DB::raw('SUM(quantity) AS quantity'),DB::raw('SUM(total) AS total_sales'))
            ->groupBy('product_line')
            ->orderBy('total_sales', 'DESC')
            ->get();
    }
    
        public static function getCustomerTypeCounts()
    {
        return self::selectRaw('gender, customer_type, COUNT(*) as count')
            ->groupBy('gender', 'customer_type')
            ->get()
            ->groupBy('gender')
            ->map(function ($group) {
                return $group->pluck('count', 'customer_type');
            })
            ->toArray();
    }


    // Total seluruh penjualan
    public static function getGrandTotal()
    {
        return self::sum('total');
    }

    public static function getAllReportData()
    {
        return [
            'salesByBranch' => self::getSalesByBranch(),
            'salesByMonth' => self::getSalesByMonth(),
            'salesByDay' => self::getSalesByDay(),
            'genderCounts' => self::getGenderCounts(),
            'totalGender' => self::getGenderCounts()->sum('count'),
            'customerTypeCounts' => self::getCustomerTypeCounts(),
            'grandTotal' => self::getGrandTotal(),
            'salesByProductLine' => self::getSalesByProductLine()
        ];
    }
}
