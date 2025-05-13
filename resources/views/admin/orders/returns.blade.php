@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Gestion des retours</h1>
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

    <!-- Statistiques des retours -->
    <div class="row">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Retours en attente</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $pendingReturns }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-clock fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Retours acceptés</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $acceptedReturns }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-check-circle fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-danger shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                Retours refusés</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $rejectedReturns }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-times-circle fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Taux de retour</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ number_format($returnRate, 1) }}%</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-percentage fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Liste des retours -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Liste des retours</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>N° Commande</th>
                            <th>Client</th>
                            <th>Date de retour</th>
                            <th>Motif</th>
                            <th>Statut</th>
                            <th>Montant</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($returns as $return)
                        <tr>
                            <td>#{{ $return->order->order_number }}</td>
                            <td>{{ $return->order->user->name }}</td>
                            <td>{{ $return->created_at->format('d/m/Y H:i') }}</td>
                            <td>{{ $return->reason }}</td>
                            <td>
                                <span class="badge bg-{{ $return->status === 'accepted' ? 'success' : ($return->status === 'rejected' ? 'danger' : 'warning') }}">
                                    {{ $return->status_label }}
                                </span>
                            </td>
                            <td>{{ number_format($return->amount, 0, ',', ' ') }} FCFA</td>
                            <td>
                                <button type="button" class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#returnModal{{ $return->id }}">
                                    <i class="fas fa-eye"></i>
                                </button>
                                @if($return->status === 'pending')
                                <button type="button" class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#processModal{{ $return->id }}">
                                    <i class="fas fa-check"></i>
                                </button>
                                @endif
                            </td>
                        </tr>

                        <!-- Modal de détails -->
                        <div class="modal fade" id="returnModal{{ $return->id }}" tabindex="-1">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Détails du retour #{{ $return->id }}</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <h6>Informations de la commande</h6>
                                                <p><strong>N° Commande :</strong> #{{ $return->order->order_number }}</p>
                                                <p><strong>Date de commande :</strong> {{ $return->order->created_at->format('d/m/Y H:i') }}</p>
                                                <p><strong>Client :</strong> {{ $return->order->user->name }}</p>
                                                <p><strong>Email :</strong> {{ $return->order->user->email }}</p>
                                            </div>
                                            <div class="col-md-6">
                                                <h6>Informations du retour</h6>
                                                <p><strong>Date de retour :</strong> {{ $return->created_at->format('d/m/Y H:i') }}</p>
                                                <p><strong>Motif :</strong> {{ $return->reason }}</p>
                                                <p><strong>Statut :</strong> {{ $return->status_label }}</p>
                                                <p><strong>Montant :</strong> {{ number_format($return->amount, 0, ',', ' ') }} FCFA</p>
                                            </div>
                                        </div>

                                        <h6 class="mt-4">Produits retournés</h6>
                                        <div class="table-responsive">
                                            <table class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th>Produit</th>
                                                        <th>Quantité</th>
                                                        <th>Prix unitaire</th>
                                                        <th>Total</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($return->items as $item)
                                                    <tr>
                                                        <td>{{ $item->product->name }}</td>
                                                        <td>{{ $item->quantity }}</td>
                                                        <td>{{ number_format($item->price, 0, ',', ' ') }} FCFA</td>
                                                        <td>{{ number_format($item->total, 0, ',', ' ') }} FCFA</td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>

                                        @if($return->notes)
                                        <div class="mt-3">
                                            <h6>Notes</h6>
                                            <p>{{ $return->notes }}</p>
                                        </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Modal de traitement -->
                        @if($return->status === 'pending')
                        <div class="modal fade" id="processModal{{ $return->id }}" tabindex="-1">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Traiter le retour #{{ $return->id }}</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <form action="{{ route('admin.orders.returns.process', $return) }}" method="POST">
                                        @csrf
                                        <div class="modal-body">
                                            <div class="form-group mb-3">
                                                <label for="status" class="form-label">Décision</label>
                                                <select name="status" id="status" class="form-select" required>
                                                    <option value="accepted">Accepter le retour</option>
                                                    <option value="rejected">Refuser le retour</option>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label for="notes" class="form-label">Notes</label>
                                                <textarea name="notes" id="notes" rows="3" class="form-control"></textarea>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                                            <button type="submit" class="btn btn-primary">Enregistrer</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        @endif
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                {{ $returns->links() }}
            </div>
        </div>
    </div>
</div>
@endsection 