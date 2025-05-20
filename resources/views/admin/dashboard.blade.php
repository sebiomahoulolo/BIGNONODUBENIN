@extends('layouts.admin')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <!-- Main content -->
            <main class="col-md-12 px-md-4">
                <div
                    class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">Tableau de bord</h1>
                    <div class="btn-toolbar mb-2 mb-md-0">
                        <div class="btn-group me-2">
                            <button type="button" class="btn btn-sm btn-outline-secondary">Exporter</button>
                            <button type="button" class="btn btn-sm btn-outline-secondary">Imprimer</button>
                        </div>
                    </div>
                </div>

                <!-- Statistiques -->
                <div class="row">
                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card border-left-primary shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                            Commandes (Mois)</div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['total_orders'] }}
                                        </div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-calendar fa-2x text-gray-300"></i>
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
                                            Revenus (Mois)</div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                                            {{ number_format($stats['total_revenue'], 0, ',', ' ') }} FCFA</div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
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
                                            Clients</div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800"></div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-users fa-2x text-gray-300"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card border-left-warning shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                            Produits en stock</div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['total_products'] }}
                                        </div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-box fa-2x text-gray-300"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Graphiques -->
                <div class="row">
                    <div class="col-xl-8 col-lg-7">
                        <div class="card shadow mb-4">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-primary">Vue d'ensemble des ventes</h6>
                            </div>
                            <div class="card-body">
                                <div class="chart-area">
                                    <canvas id="salesChart"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-4 col-lg-5">
                        <div class="card shadow mb-4">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-primary">Sources de revenus</h6>
                            </div>
                            <div class="card-body">
                                <div class="chart-pie pt-4">
                                    <canvas id="revenueChart"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Dernières commandes -->
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
            </main>
        </div>
    </div>

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            // Données des graphiques
            const salesLabels = @json($stats['sales_labels'] ?? []);
            const salesData = @json($stats['sales_data'] ?? []);
            const categoryLabels = @json($stats['category_labels'] ?? []);
            const categoryValues = @json($stats['category_values'] ?? []);

            // Graphique des ventes
            const salesCtx = document.getElementById('salesChart').getContext('2d');
            new Chart(salesCtx, {
                type: 'line',
                data: {
                    labels: salesLabels,
                    datasets: [{
                        label: 'Ventes',
                        data: salesData,
                        borderColor: 'rgb(75, 192, 192)',
                        tension: 0.1,
                        fill: false
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                callback: function(value) {
                                    return value.toLocaleString('fr-FR') + ' FCFA';
                                }
                            }
                        }
                    },
                    plugins: {
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    return context.dataset.label + ': ' + context.raw.toLocaleString('fr-FR') +
                                        ' FCFA';
                                }
                            }
                        }
                    }
                }
            });

            // Graphique des revenus
            const revenueCtx = document.getElementById('revenueChart').getContext('2d');
            new Chart(revenueCtx, {
                type: 'doughnut',
                data: {
                    labels: categoryLabels,
                    datasets: [{
                        data: categoryValues,
                        backgroundColor: [
                            'rgb(255, 99, 132)',
                            'rgb(54, 162, 235)',
                            'rgb(255, 205, 86)'
                        ]
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom'
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    const label = context.label || '';
                                    const value = context.raw || 0;
                                    const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                    const percentage = Math.round((value / total) * 100);
                                    return `${label}: ${value.toLocaleString('fr-FR')} FCFA (${percentage}%)`;
                                }
                            }
                        }
                    }
                }
            });
        </script>
    @endpush
@endsection
