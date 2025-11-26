<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderDetail;
use Carbon\Carbon;

class ReportController extends Controller
{
     public function daily(){
        $today = Carbon::today();

        $orders = Order::with('customer')
        ->whereDate('created_at', $today)
        ->orderBy('created_at','desc')
        ->get();

        $totalSales = $orders->sum('total');
        $totalOrders = $orders->count();
        $orderIds = $orders->pluck('id');
        $totalItems = $orderIds->isNotEmpty()
            ? OrderDetail::whereIn('order_id', $orderIds)->sum('qty')
            : 0;


        return view('report.daily', [
            'date' => $today->format('d M Y'),
            'orders' => $orders,
            'totalSales' => $totalSales,
            'totalOrders'=> $totalOrders,
            'totalItems' => $totalItems,
        ]);
    }
}
