<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Product;
use App\Models\Customer;
use App\Models\DemandeDevis;
use App\Models\User;
use App\Models\Category;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    
    public function index()
    {
        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;

        // Commandes du mois en cours
        $monthlyOrders = Order::whereMonth('created_at', $currentMonth)
            ->whereYear('created_at', $currentYear)
            ->count();

        // Liste des commandes avec pagination
        $orders = Order::join('customers', 'orders.customer_id', '=', 'customers.id')
            ->select('orders.*', 'customers.name', 'customers.phone')
            ->orderBy('orders.id', 'desc')
            ->paginate(10);

        // Revenus du mois en cours
        $monthlyRevenue = Order::whereMonth('created_at', $currentMonth)
            ->whereYear('created_at', $currentYear)
            ->sum('total_amount_promo');

        // Produits en stock
        $productsInStock = Product::where('is_active', true)
            ->where('stock', '>', 0)
            ->count();

        // Totaux
        $totalDevis = DemandeDevis::count();
        $totalClients = Customer::count();

        // Dernières commandes
        $latestOrders = Order::with(['user', 'items.product'])
            ->latest()
            ->take(5)
            ->get();

        // Données pour le graphique des ventes sur 6 mois
        $salesData = [];
        $salesLabels = [];

        for ($i = 5; $i >= 0; $i--) {
            $month = Carbon::now()->subMonths($i);
            $salesLabels[] = $month->format('M');

            $monthlySales = Order::whereMonth('created_at', $month->month)
                ->whereYear('created_at', $month->year)
                ->sum('total_amount_promo');

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

        // Préparation des données pour le graphique circulaire
        $categoryLabels = [];
        $categoryValues = [];

        foreach ($categoryData as $category) {
            $categoryLabels[] = $category->name;
            $categoryValues[] = $category->products_sum_price ?? 0;
        }

        // Si aucune catégorie n'a de ventes, ajouter une valeur par défaut
        if (empty($categoryLabels)) {
            $categoryLabels = ['Aucune vente'];
            $categoryValues = [0];
        }

        $stats = [
            'total_orders' => $monthlyOrders,
            'total_revenue' => $monthlyRevenue,
            'total_products' => $productsInStock,
            'total_devis' => $totalDevis, 
            'total_clients' => $totalClients,
            'recent_orders' => $latestOrders,
            'monthly_sales' => Order::select(
                DB::raw('MONTH(created_at) as month'),
                DB::raw('SUM(total_amount_promo) as total')
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

        return view('admin.dashboard', compact(['stats', 'orders']));
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