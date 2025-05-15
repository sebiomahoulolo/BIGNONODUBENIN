<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{

    public function index()
    {
        $stats = [
            'total_orders' => Order::count(),
            'total_revenue' => Order::where('payment_status', 'paid')->sum('total'),
            'total_customers' => User::count(),
            'total_products' => Product::count(),
            'recent_orders' => Order::with(['user', 'items.product'])
                ->latest()
                ->take(5)
                ->get(),
            'monthly_sales' => $this->getMonthlySales(),
            'top_products' => $this->getTopProducts(),
            'sales_by_category' => $this->getSalesByCategory()
        ];

        return view('admin.dashboard', compact('stats'));
    }

    private function getMonthlySales()
    {
        return Order::where('payment_status', 'paid')
            ->whereYear('created_at', now()->year)
            ->select(
                DB::raw('MONTH(created_at) as month'),
                DB::raw('SUM(total) as total')
            )
            ->groupBy('month')
            ->orderBy('month')
            ->get()
            ->pluck('total', 'month')
            ->toArray();
    }

    private function getTopProducts()
    {
        return Product::withCount(['orderItems as total_sales' => function ($query) {
                $query->select(DB::raw('SUM(quantity)'));
            }])
            ->orderByDesc('total_sales')
            ->take(5)
            ->get();
    }

    private function getSalesByCategory()
    {
        return DB::table('order_items')
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->join('categories', 'products.category_id', '=', 'categories.id')
            ->select('categories.name', DB::raw('SUM(order_items.total) as total'))
            ->groupBy('categories.id', 'categories.name')
            ->orderByDesc('total')
            ->get();
    }

}
