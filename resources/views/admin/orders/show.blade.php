@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Commande #{{ $order->order_number }}</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
            <a href="{{ route('admin.orders.edit', $order) }}" class="btn btn-sm btn-primary me-2">
                <i class="fas fa-edit"></i> Modifier
            </a>
            <a href="{{ route('admin.orders.index') }}" class="btn btn-sm btn-secondary">
                <i class="fas fa-arrow-left"></i> Retour
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="row">
        <!-- Informations de la commande -->
        <div class="col-md-6">
            <div class="card shadow mb-4">
                <div class="card-header">
                    <h6 class="m-0 font-weight-bold text-primary">Informations de la commande</h6>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <p class="mb-1"><strong>Date de commande :</strong></p>
                            <p>{{ $order->created_at->format('d/m/Y H:i') }}</p>
                        </div>
                        <div class="col-md-6">
                            <p class="mb-1"><strong>Statut :</strong></p>
                            <p>
                                <span class="badge bg-{{ $order->status === 'delivered' ? 'success' : ($order->status === 'cancelled' ? 'danger' : 'warning') }}">
                                    {{ $order->status_label }}
                                </span>
                            </p>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <p class="mb-1"><strong>Méthode de paiement :</strong></p>
                            <p>{{ $order->payment_method }}</p>
                        </div>
                        <div class="col-md-6">
                            <p class="mb-1"><strong>Statut du paiement :</strong></p>
                            <p>
                                <span class="badge bg-{{ $order->payment_status === 'paid' ? 'success' : ($order->payment_status === 'failed' ? 'danger' : 'warning') }}">
                                    {{ $order->payment_status_label }}
                                </span>
                            </p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <p class="mb-1"><strong>Méthode de livraison :</strong></p>
                            <p>{{ $order->shipping_method }}</p>
                        </div>
                        <div class="col-md-6">
                            <p class="mb-1"><strong>Frais de livraison :</strong></p>
                            <p>{{ number_format($order->shipping_cost, 0, ',', ' ') }} FCFA</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Informations du client -->
        <div class="col-md-6">
            <div class="card shadow mb-4">
                <div class="card-header">
                    <h6 class="m-0 font-weight-bold text-primary">Informations du client</h6>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <p class="mb-1"><strong>Nom :</strong></p>
                            <p>{{ $order->user->name }}</p>
                        </div>
                        <div class="col-md-6">
                            <p class="mb-1"><strong>Email :</strong></p>
                            <p>{{ $order->user->email }}</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <p class="mb-1"><strong>Téléphone :</strong></p>
                            <p>{{ $order->user->phone ?? 'Non renseigné' }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Adresses -->
    <div class="row">
        <div class="col-md-6">
            <div class="card shadow mb-4">
                <div class="card-header">
                    <h6 class="m-0 font-weight-bold text-primary">Adresse de livraison</h6>
                </div>
                <div class="card-body">
                    <p>{{ $order->shipping_address['address'] }}</p>
                    <p>{{ $order->shipping_address['city'] }}, {{ $order->shipping_address['postal_code'] }}</p>
                    <p>{{ $order->shipping_address['country'] }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card shadow mb-4">
                <div class="card-header">
                    <h6 class="m-0 font-weight-bold text-primary">Adresse de facturation</h6>
                </div>
                <div class="card-body">
                    <p>{{ $order->billing_address['address'] }}</p>
                    <p>{{ $order->billing_address['city'] }}, {{ $order->billing_address['postal_code'] }}</p>
                    <p>{{ $order->billing_address['country'] }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Produits commandés -->
    <div class="card shadow mb-4">
        <div class="card-header">
            <h6 class="m-0 font-weight-bold text-primary">Produits commandés</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Produit</th>
                            <th>Prix unitaire</th>
                            <th>Quantité</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($order->items as $item)
                        <tr>
                            <td>{{ $item->product->name }}</td>
                            <td>{{ number_format($item->price, 0, ',', ' ') }} FCFA</td>
                            <td>{{ $item->quantity }}</td>
                            <td>{{ number_format($item->total, 0, ',', ' ') }} FCFA</td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="3" class="text-end"><strong>Sous-total :</strong></td>
                            <td>{{ number_format($order->subtotal, 0, ',', ' ') }} FCFA</td>
                        </tr>
                        <tr>
                            <td colspan="3" class="text-end"><strong>Frais de livraison :</strong></td>
                            <td>{{ number_format($order->shipping_cost, 0, ',', ' ') }} FCFA</td>
                        </tr>
                        <tr>
                            <td colspan="3" class="text-end"><strong>Total :</strong></td>
                            <td><strong>{{ number_format($order->total, 0, ',', ' ') }} FCFA</strong></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>

    <!-- Notes -->
    @if($order->notes)
    <div class="card shadow mb-4">
        <div class="card-header">
            <h6 class="m-0 font-weight-bold text-primary">Notes</h6>
        </div>
        <div class="card-body">
            <p>{{ $order->notes }}</p>
        </div>
    </div>
    @endif
</div>
@endsection 