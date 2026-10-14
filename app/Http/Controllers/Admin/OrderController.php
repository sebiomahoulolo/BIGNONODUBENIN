<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\PaymentMethod;
use App\Models\Customer;
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
        $query = Order::with(['customer', 'items.product'])
            ->when($request->status, function($q) use ($request) {
                return $q->where('status', $request->status);
            })
            ->when($request->search, function($q) use ($request) {
                return $q->where(function($query) use ($request) {
                    $query->where('order_number', 'like', "%{$request->search}%")
                        ->orWhereHas('customer', function($q) use ($request) {
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
        $order->load(['customer', 'items.product']);
        return view('admin.orders.show', compact('order'));
    }

    public function edit(Order $order)
    {
        $order->load(['customer', 'items.product']);
        return view('admin.orders.edit', compact('order'));
    }

    public function update(Request $request, Order $order)
    {
        $validated = $request->validate([
            'status' => 'required|string',
        ]);

        $oldStatus = $order->status;

        $order->update($validated);

        // Notifier le changement de statut
        if ($oldStatus !== $order->status) {
            if ($this->notificationService && $order->customer_id) {
                $this->notificationService->notifyOrderStatusChange($order);
            }
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
        $totalRevenue = $query->sum('total_amount_promo');
        $totalOrders = $query->count();
        $averageOrderValue = $totalOrders > 0 ? $totalRevenue / $totalOrders : 0;
        $conversionRate = $totalOrders > 0 ? ($query->where('status', 'Livré')->count() / $totalOrders) * 100 : 0;

        // Données pour le graphique des ventes
        $salesData = $query->select(
            DB::raw('DATE(created_at) as date'),
            DB::raw('SUM(total_amount_promo) as total')
        )
        ->groupBy('date')
        ->orderBy('date')
        ->get();

        // Données pour le graphique des statuts
        $statusData = [
            $query->where('status', 'En Cours')->count(),
            $query->where('status', 'Livré')->count(),
            $query->where('status', 'Annulé')->count(),
            0 // Pas de statut "processing" dans cette structure
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
        $returns = Order::where('status', 'Annulé')
            ->with(['customer', 'items.product'])
            ->latest()
            ->paginate(10);

        $returnRate = Order::count() > 0 ? (Order::where('status', 'Annulé')->count() / Order::count()) * 100 : 0;

        return view('admin.orders.returns', compact(
            'returns',
            'returnRate'
        ));
    }

    public function storePanier(Request $request)
    {
        try {
            $validated = $request->validate([
                'produits' => 'required|array',
                'produits.*.id' => 'required|exists:products,id',
                'produits.*.quantite' => 'required|integer|min:1',
                'produits.*.prix' => 'required|numeric|min:0',
                'name' => 'required|string|max:255',
                'email' => 'required|email|max:255',
                'phone' => 'required|string|max:20',
                'indicatif' => 'nullable|string|max:10',
                'total_amount' => 'nullable|string',
                'code_promo' => 'nullable|string',
                'total_promo' => 'nullable|string',
            ]);

            DB::beginTransaction();

            // Calculer le total
            $total = 0;
            foreach ($validated['produits'] as $produit) {
                $total += floatval($produit['prix']) * intval($produit['quantite']);
            }

            // Appliquer le code promo si fourni
            $finalTotal = $total;
            if (!empty($validated['code_promo']) && !empty($validated['total_promo'])) {
                // Extraire le montant du total_promo (format: "712 500 FCFA")
                $totalPromo = preg_replace('/[^0-9]/', '', $validated['total_promo']);
                $finalTotal = floatval($totalPromo);
            }

            // Générer un numéro de commande unique
            $orderNumber = 'CMD-' . strtoupper(uniqid());

            // Créer ou récupérer le client
            $customer = Customer::firstOrCreate(
                ['email' => $validated['email']],
                [
                    'name' => $validated['name'],
                    'phone' => ($validated['indicatif'] ?? '') . $validated['phone'],
                    'is_active' => true,
                ]
            );

            // Créer la commande
            $order = Order::create([
                'customer_id' => $customer->id,
                'order_number' => $orderNumber,
                'total_amount' => $total,
                'total_amount_promo' => $finalTotal,
                'status_code_promo' => !empty($validated['code_promo']) ? 1 : 0,
                'status' => 'En Cours',
            ]);

            // Créer les items de commande
            foreach ($validated['produits'] as $produit) {
                $product = Product::findOrFail($produit['id']);
                
                // Récupérer la première image du produit
                $imagePath = null;
                if ($product->images && is_array($product->images) && count($product->images) > 0) {
                    $imagePath = $product->images[0];
                }
                
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'image_path' => $imagePath,
                    'quantity' => intval($produit['quantite']),
                    'price' => floatval($produit['prix']),
                    'total' => floatval($produit['prix']) * intval($produit['quantite']),
                ]);
            }

            // Notifier la nouvelle commande
            if ($this->notificationService && $order->customer_id) {
                $this->notificationService->notifyNewOrder($order);
            }

            DB::commit();

            // Vider le panier de la session
            session()->forget('cart');

            return redirect()->route('pages.app')
                ->with('success', 'Votre commande a été enregistrée avec succès! Numéro de commande: ' . $orderNumber);

        } catch (\Exception $e) {
            DB::rollBack();
            
            return redirect()->back()
                ->withInput()
                ->with('error', 'Une erreur est survenue lors de la création de la commande: ' . $e->getMessage());
        }
    }
} 