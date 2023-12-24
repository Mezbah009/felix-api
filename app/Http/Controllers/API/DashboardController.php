<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function getDashboardData()
    {
        $totalOrders = Order::count();
        $totalAmount = Order::sum('total_price');

        return response()->json([
            'total_orders' => $totalOrders,
            'total_amount' => $totalAmount,
        ]);
    }
}
