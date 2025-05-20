@extends('layouts.admin')

@section('content')
    <div class="container-fluid">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
            <h1 class="h2">Commandes</h1>
            <div class="btn-toolbar mb-2 mb-md-0">
                <a href="{{ route('admin.orders.export') }}" class="btn btn-sm btn-outline-secondary">
                    <i class="fas fa-download"></i> Exporter
                </a>
            </div>
        </div>

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        <div class="card shadow mb-4">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>N° Commande</th>
                                <th>Date</th>
                                <th>Client</th>
                                <th>Téléphone</th>
                                <th>Code Promo Appliqué</th>
                                <th>Total à payer</th>
                                {{-- <th>Statut</th> --}}
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($orders as $order)
                                <tr>
                                    <td class=" fw-bold">{{ $order->order_number }}</td>
                                    <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
                                    <td>{{ $order->name}}</td>
                                    <td>{{ $order->phone}}</td>
                                    <td>
                                        <span
                                            class="badge {{ $order->status_code_promo == 1 ? 'bg-success' : 'bg-danger' }}">
                                            {{ $order->status_code_promo == 1 ? 'Oui' : 'Non' }}
                                        </span>
                                    </td>

                                    <td>{{ number_format($order->total_amount_promo, 0, ',', ' ') }} FCFA</td>
                                    {{-- <td>
                                        <a href="{{ route('admin.orders.show', $order) }}" class="btn btn-sm btn-info">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.orders.edit', $order) }}" class="btn btn-sm btn-primary">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        @if ($order->status === 'cancelled')
                                            <form action="{{ route('admin.orders.destroy', $order) }}" method="POST"
                                                class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger"
                                                    onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette commande ?')">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        @endif
                                    </td> --}}
                                    <td>
                                         <a href="{{ route('admin.orders.detail', $order->id) }}"
                                                    class="btn btn-sm btn-info me-1" title="Voir">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="mt-3 d-flex justify-content-center">
                    {{ $orders->links('pagination::bootstrap-5') }}
                </div>
            </div>
        </div>
    </div>
@endsection
