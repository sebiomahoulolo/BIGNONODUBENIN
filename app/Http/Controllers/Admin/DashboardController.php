<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\Customer;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    
    public function index()
    {
        // Compter les demandes de devis si la table existe
        $totalDevis = 0;
        try {
            if (DB::getSchemaBuilder()->hasTable('demande_devis')) {
                $totalDevis = DB::table('demande_devis')->count();
            }
        } catch (\Exception $e) {
            // Table n'existe pas, on garde 0
        }

        $stats = [
            'total_orders' => Order::count(),
            'total_revenue' => Order::sum('total_amount_promo') ?: Order::sum('total_amount'),
            'total_customers' => Customer::count(),
            'total_clients' => Customer::count(), // Alias pour la vue
            'total_products' => Product::count(),
            'total_devis' => $totalDevis,
            'recent_orders' => Order::with(['customer', 'items.product'])
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
        return Order::whereYear('created_at', now()->year)
            ->select(
                DB::raw('MONTH(created_at) as month'),
                DB::raw('SUM(COALESCE(total_amount_promo, total_amount)) as total')
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
