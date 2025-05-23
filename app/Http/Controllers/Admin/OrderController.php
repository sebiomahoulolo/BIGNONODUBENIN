<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\PaymentMethod;
use App\Services\NotificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class OrderController extends Controller
{
    protected $notificationService;

    public function __construct(NotificationService $notificationService)
    {
        $this->notificationService = $notificationService;
    }

    public function index(Request $request)
    {
        $query = Order::with(['user', 'items.product'])
            ->when($request->status, function($q) use ($request) {
                return $q->where('status', $request->status);
            })
            ->when($request->payment_status, function($q) use ($request) {
                return $q->where('payment_status', $request->payment_status);
            })
            ->when($request->search, function($q) use ($request) {
                return $q->where(function($query) use ($request) {
                    $query->where('order_number', 'like', "%{$request->search}%")
                        ->orWhereHas('user', function($q) use ($request) {
                            $q->where('name', 'like', "%{$request->search}%")
                                ->orWhere('email', 'like', "%{$request->search}%");
                        });
                });
            });

        $orders = $query->latest()->paginate(10);

        return view('admin.orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        $order->load(['user', 'items.product', 'shippingAddress', 'billingAddress']);
        return view('admin.orders.show', compact('order'));
    }

    public function edit(Order $order)
    {
        $order->load(['user', 'items.product']);
        return view('admin.orders.edit', compact('order'));
    }

    public function update(Request $request, Order $order)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,processing,completed,cancelled',
            'payment_status' => 'required|in:pending,paid,failed',
            'notes' => 'nullable|string'
        ]);

        $oldStatus = $order->status;
        $oldPaymentStatus = $order->payment_status;

        $order->update($validated);

        // Notifier le changement de statut
        if ($oldStatus !== $order->status) {
            $this->notificationService->notifyOrderStatusChange($order);
        }

        // Notifier le changement de statut de paiement
        if ($oldPaymentStatus !== $order->payment_status) {
            $this->notificationService->notifyPaymentStatusChange($order);
        }

        return redirect()->route('admin.orders.show', $order)
            ->with('success', 'Commande mise à jour avec succès.');
    }

    public function destroy(Order $order)
    {
        if ($order->status !== 'cancelled') {
            return back()->with('error', 'Seules les commandes annulées peuvent être supprimées.');
        }

        $order->delete();

        return redirect()->route('admin.orders.index')
            ->with('success', 'Commande supprimée avec succès.');
    }

    public function reports(Request $request)
    {
        $startDate = $request->start_date ? Carbon::parse($request->start_date) : Carbon::now()->subDays(30);
        $endDate = $request->end_date ? Carbon::parse($request->end_date) : Carbon::now();

        $query = Order::whereBetween('created_at', [$startDate, $endDate])
            ->when($request->status, function($q) use ($request) {
                return $q->where('status', $request->status);
            })
            ->when($request->payment_status, function($q) use ($request) {
                return $q->where('payment_status', $request->payment_status);
            });

        // Statistiques générales
        $totalRevenue = $query->sum('total');
        $totalOrders = $query->count();
        $averageOrderValue = $totalOrders > 0 ? $totalRevenue / $totalOrders : 0;
        $conversionRate = $totalOrders > 0 ? ($query->where('status', 'completed')->count() / $totalOrders) * 100 : 0;

        // Données pour le graphique des ventes
        $salesData = $query->select(
            DB::raw('DATE(created_at) as date'),
            DB::raw('SUM(total) as total')
        )
        ->groupBy('date')
        ->orderBy('date')
        ->get();

        // Données pour le graphique des statuts
        $statusData = [
            $query->where('status', 'pending')->count(),
            $query->where('status', 'completed')->count(),
            $query->where('status', 'processing')->count(),
            $query->where('status', 'cancelled')->count()
        ];

        // Meilleures ventes
        $topProducts = OrderItem::whereHas('order', function($q) use ($query) {
                $q->whereIn('id', $query->pluck('id'));
            })
            ->select(
                'product_id',
                DB::raw('SUM(quantity) as total_quantity'),
                DB::raw('SUM(total) as total_revenue')
            )
            ->with('product:id,name')
            ->groupBy('product_id')
            ->orderByDesc('total_revenue')
            ->limit(10)
            ->get()
            ->map(function($item) use ($totalRevenue) {
                $item->revenue_percentage = ($item->total_revenue / $totalRevenue) * 100;
                return $item;
            });

        // Méthodes de paiement
        $paymentMethods = PaymentMethod::withCount(['orders' => function($q) use ($query) {
                $q->whereIn('id', $query->pluck('id'));
            }])
            ->withSum(['orders' => function($q) use ($query) {
                $q->whereIn('id', $query->pluck('id'));
            }], 'total')
            ->get()
            ->map(function($method) use ($totalRevenue) {
                $method->percentage = $totalRevenue > 0 ? ($method->orders_sum_total / $totalRevenue) * 100 : 0;
                return $method;
            });

        return view('admin.orders.reports', compact(
            'totalRevenue',
            'totalOrders',
            'averageOrderValue',
            'conversionRate',
            'salesData',
            'statusData',
            'topProducts',
            'paymentMethods'
        ));
    }

    public function returns()
    {
        $returns = Order::where('status', 'returned')
            ->with(['user', 'items.product'])
            ->latest()
            ->paginate(10);

        $pendingReturns = Order::where('status', 'returned')->where('return_status', 'pending')->count();
        $acceptedReturns = Order::where('status', 'returned')->where('return_status', 'accepted')->count();
        $rejectedReturns = Order::where('status', 'returned')->where('return_status', 'rejected')->count();
        $returnRate = Order::count() > 0 ? (Order::where('status', 'returned')->count() / Order::count()) * 100 : 0;

        return view('admin.orders.returns', compact(
            'returns',
            'pendingReturns',
            'acceptedReturns',
            'rejectedReturns',
            'returnRate'
        ));
    }

    public function processReturn(Request $request, Order $order)
    {
        $validated = $request->validate([
            'status' => 'required|in:accepted,rejected',
            'notes' => 'nullable|string'
        ]);

        $order->update([
            'return_status' => $validated['status'],
            'return_notes' => $validated['notes']
        ]);

        if ($validated['status'] === 'accepted') {
            // Logique de remboursement ici
            // TODO: Implémenter la logique de remboursement
        }

        return redirect()->route('admin.orders.returns')
            ->with('success', 'Retour traité avec succès.');
    }
} 