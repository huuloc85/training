<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Customer;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;

class DashBoardController extends Controller
{
    public function index()
    {
        $totalProducts = Product::count();
        $totalCategories = Category::count();
        $totalOrders = Order::count();
        $totalCustomers = Customer::count();
        $totalRevenue = Order::sum('total');
        $topCustomers = Customer::withCount('orders')
            ->orderByDesc('orders_count')
            ->limit(10)
            ->get();

        return view('admin.index', compact(
            'totalProducts',
            'totalCategories',
            'totalOrders',
            'totalCustomers',
            'totalRevenue',
            'topCustomers'
        ));
    }
}
