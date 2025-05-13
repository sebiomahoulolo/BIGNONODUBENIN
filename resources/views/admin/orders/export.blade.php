@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Exporter les commandes</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
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

    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <div class="row">
        <div class="col-md-8">
            <div class="card shadow mb-4">
                <div class="card-header">
                    <h6 class="m-0 font-weight-bold text-primary">Filtres d'export</h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.orders.export') }}" method="GET">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="date_start" class="form-label">Date de début</label>
                                    <input type="date" name="date_start" id="date_start" class="form-control @error('date_start') is-invalid @enderror" value="{{ request('date_start') }}">
                                    @error('date_start')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="date_end" class="form-label">Date de fin</label>
                                    <input type="date" name="date_end" id="date_end" class="form-control @error('date_end') is-invalid @enderror" value="{{ request('date_end') }}">
                                    @error('date_end')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="status" class="form-label">Statut de la commande</label>
                                    <select name="status" id="status" class="form-select @error('status') is-invalid @enderror">
                                        <option value="">Tous les statuts</option>
                                        <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>En attente</option>
                                        <option value="processing" {{ request('status') === 'processing' ? 'selected' : '' }}>En cours de traitement</option>
                                        <option value="shipped" {{ request('status') === 'shipped' ? 'selected' : '' }}>Expédiée</option>
                                        <option value="delivered" {{ request('status') === 'delivered' ? 'selected' : '' }}>Livrée</option>
                                        <option value="cancelled" {{ request('status') === 'cancelled' ? 'selected' : '' }}>Annulée</option>
                                    </select>
                                    @error('status')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="payment_status" class="form-label">Statut du paiement</label>
                                    <select name="payment_status" id="payment_status" class="form-select @error('payment_status') is-invalid @enderror">
                                        <option value="">Tous les statuts</option>
                                        <option value="pending" {{ request('payment_status') === 'pending' ? 'selected' : '' }}>En attente</option>
                                        <option value="paid" {{ request('payment_status') === 'paid' ? 'selected' : '' }}>Payé</option>
                                        <option value="failed" {{ request('payment_status') === 'failed' ? 'selected' : '' }}>Échoué</option>
                                        <option value="refunded" {{ request('payment_status') === 'refunded' ? 'selected' : '' }}>Remboursé</option>
                                    </select>
                                    @error('payment_status')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="format" class="form-label">Format d'export</label>
                                    <select name="format" id="format" class="form-select @error('format') is-invalid @enderror">
                                        <option value="csv" {{ request('format', 'csv') === 'csv' ? 'selected' : '' }}>CSV</option>
                                        <option value="excel" {{ request('format') === 'excel' ? 'selected' : '' }}>Excel</option>
                                        <option value="pdf" {{ request('format') === 'pdf' ? 'selected' : '' }}>PDF</option>
                                    </select>
                                    @error('format')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="columns" class="form-label">Colonnes à exporter</label>
                                    <select name="columns[]" id="columns" class="form-select @error('columns') is-invalid @enderror" multiple>
                                        <option value="order_number" {{ in_array('order_number', request('columns', ['order_number', 'date', 'customer', 'total', 'status'])) ? 'selected' : '' }}>N° Commande</option>
                                        <option value="date" {{ in_array('date', request('columns', ['order_number', 'date', 'customer', 'total', 'status'])) ? 'selected' : '' }}>Date</option>
                                        <option value="customer" {{ in_array('customer', request('columns', ['order_number', 'date', 'customer', 'total', 'status'])) ? 'selected' : '' }}>Client</option>
                                        <option value="total" {{ in_array('total', request('columns', ['order_number', 'date', 'customer', 'total', 'status'])) ? 'selected' : '' }}>Total</option>
                                        <option value="status" {{ in_array('status', request('columns', ['order_number', 'date', 'customer', 'total', 'status'])) ? 'selected' : '' }}>Statut</option>
                                        <option value="payment_status" {{ in_array('payment_status', request('columns', ['order_number', 'date', 'customer', 'total', 'status'])) ? 'selected' : '' }}>Statut paiement</option>
                                        <option value="payment_method" {{ in_array('payment_method', request('columns', ['order_number', 'date', 'customer', 'total', 'status'])) ? 'selected' : '' }}>Méthode paiement</option>
                                        <option value="shipping_method" {{ in_array('shipping_method', request('columns', ['order_number', 'date', 'customer', 'total', 'status'])) ? 'selected' : '' }}>Méthode livraison</option>
                                        <option value="shipping_address" {{ in_array('shipping_address', request('columns', ['order_number', 'date', 'customer', 'total', 'status'])) ? 'selected' : '' }}>Adresse livraison</option>
                                        <option value="billing_address" {{ in_array('billing_address', request('columns', ['order_number', 'date', 'customer', 'total', 'status'])) ? 'selected' : '' }}>Adresse facturation</option>
                                        <option value="notes" {{ in_array('notes', request('columns', ['order_number', 'date', 'customer', 'total', 'status'])) ? 'selected' : '' }}>Notes</option>
                                    </select>
                                    @error('columns')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-download"></i> Exporter
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow mb-4">
                <div class="card-header">
                    <h6 class="m-0 font-weight-bold text-primary">Aide</h6>
                </div>
                <div class="card-body">
                    <h6>Filtres disponibles :</h6>
                    <ul class="list-unstyled">
                        <li><i class="fas fa-calendar-alt text-primary"></i> Période</li>
                        <li><i class="fas fa-tag text-primary"></i> Statut de la commande</li>
                        <li><i class="fas fa-credit-card text-primary"></i> Statut du paiement</li>
                    </ul>

                    <h6>Formats d'export :</h6>
                    <ul class="list-unstyled">
                        <li><i class="fas fa-file-csv text-primary"></i> CSV - Pour Excel et autres tableurs</li>
                        <li><i class="fas fa-file-excel text-primary"></i> Excel - Format natif Excel</li>
                        <li><i class="fas fa-file-pdf text-primary"></i> PDF - Pour impression</li>
                    </ul>

                    <div class="alert alert-info mt-3">
                        <i class="fas fa-info-circle"></i> Sélectionnez les colonnes que vous souhaitez inclure dans l'export. Maintenez la touche Ctrl (ou Cmd sur Mac) pour sélectionner plusieurs colonnes.
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 