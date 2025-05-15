<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use App\Models\Category;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    
    public function index()
    {
        // Statistiques pour les cartes
        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;
       
        // Récupération des commandes mensuelles
        $monthlyOrders = Order::whereMonth('created_at', $currentMonth)
            ->whereYear('created_at', $currentYear)
            ->count();
        
        // Récupération des revenus mensuels
        $monthlyRevenue = Order::whereMonth('created_at', $currentMonth)
            ->whereYear('created_at', $currentYear)
            ->sum('total');
            
      
        // Récupération du nombre de produits en stock
        $productsInStock = Product::where('is_active', true)->sum('stock');
        
        // Récupération des dernières commandes
        $latestOrders = Order::with(['user', 'items.product'])
            ->latest()
            ->take(5)
            ->get();
            
        // Données pour le graphique des ventes (6 derniers mois)
        $salesData = [];
        $salesLabels = [];
        
        for ($i = 5; $i >= 0; $i--) {
            $month = Carbon::now()->subMonths($i);
            $salesLabels[] = $month->format('M');
            
            $monthlySales = Order::whereMonth('created_at', $month->month)
                ->whereYear('created_at', $month->year)
                ->sum('total');
                
            $salesData[] = $monthlySales;
        }
        
        // Données pour le graphique des revenus par catégorie
        $categoryData = Category::withCount(['products' => function ($query) {
            $query->whereHas('orderItems', function ($q) {
                $q->whereMonth('created_at', Carbon::now()->month);
            });
        }])
        ->withSum(['products' => function ($query) {
            $query->whereHas('orderItems', function ($q) {
                $q->whereMonth('created_at', Carbon::now()->month);
            });
        }], 'price')
        ->get()
        ->sortByDesc('products_sum_price')
        ->take(3);
        
        $categoryLabels = $categoryData->pluck('name')->toArray();
        $categoryValues = $categoryData->pluck('products_sum_price')->toArray();
        
        // Préparation des statistiques complètes
        $stats = [
            'total_orders' => $monthlyOrders,
            'total_revenue' => $monthlyRevenue,
           
            'total_products' => $productsInStock,
            'recent_orders' => $latestOrders,
            'monthly_sales' => Order::select(
                DB::raw('MONTH(created_at) as month'),
                DB::raw('SUM(total) as total')
            )
                ->whereYear('created_at', Carbon::now()->year)
                ->groupBy('month')
                ->get()
                ->map(function ($item) {
                    return [
                        'month' => Carbon::create()->month($item->month)->format('M'),
                        'total' => $item->total
                    ];
                }),
            'sales_by_category' => $categoryData->map(function ($category) {
                return [
                    'name' => $category->name,
                    'total_revenue' => $category->products_sum_price ?? 0
                ];
            }),
            'sales_labels' => $salesLabels,
            'sales_data' => $salesData,
            'category_labels' => $categoryLabels,
            'category_values' => $categoryValues
        ];

        return view('admin.dashboard', compact('stats'));
    }

    public function getSalesData(Request $request)
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
