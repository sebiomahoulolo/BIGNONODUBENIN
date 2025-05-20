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
    <!-- Commandes (Mois) -->
    <div class="col-xl-20p col-md-4 col-sm-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body p-2">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                            Commandes</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['total_orders'] }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-calendar fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Revenus (Mois) -->
    <div class="col-xl-20p col-md-4 col-sm-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body p-2">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                            Revenus</div>
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

    <!-- Demande de devis -->
    <div class="col-xl-20p col-md-4 col-sm-6 mb-4">
        <div class="card border-left-danger shadow h-100 py-2">
            <div class="card-body p-2">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                            Devis</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['total_devis'] }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-file-invoice-dollar fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Clients -->
    <div class="col-xl-20p col-md-6 col-sm-6 mb-4">
        <div class="card border-left-info shadow h-100 py-2">
            <div class="card-body p-2">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                            Clients</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['total_clients'] }}</div>                 
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-users fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Produits en stock -->
    <div class="col-xl-20p col-md-6 col-sm-6 mb-4">
        <div class="card border-left-warning shadow h-100 py-2">
            <div class="card-body p-2">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                            En stock</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['total_products'] }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-box fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* Définition d'une classe personnalisée pour diviser la ligne en 5 colonnes égales */
@media (min-width: 1200px) {
    .col-xl-20p {
        flex: 0 0 20%;
        max-width: 20%;
    }
}
</style>
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
            document.addEventListener('DOMContentLoaded', function() {
                // Données des graphiques avec valeurs par défaut en cas de données manquantes
                const salesLabels = @json($stats['sales_labels'] ?? []);
                const salesData = @json($stats['sales_data'] ?? []);
                const categoryLabels = @json($stats['category_labels'] ?? []);
                const categoryValues = @json($stats['category_values'] ?? []);

                // Vérification de l'existence des éléments canvas avant d'initialiser les graphiques
                const salesChartElement = document.getElementById('salesChart');
                const revenueChartElement = document.getElementById('revenueChart');

                // Initialisation du graphique des ventes
                if (salesChartElement) {
                    const salesCtx = salesChartElement.getContext('2d');
                    // Vérification de la présence de données
                    if (salesLabels.length === 0) {
                        // Données par défaut si aucune donnée n'est disponible
                        const defaultLabels = ['Jan', 'Fév', 'Mar', 'Avr', 'Mai', 'Juin'];
                        const defaultData = [0, 0, 0, 0, 0, 0];
                        
                        renderSalesChart(salesCtx, defaultLabels, defaultData);
                    } else {
                        renderSalesChart(salesCtx, salesLabels, salesData);
                    }
                }

                // Initialisation du graphique des revenus par catégorie
                if (revenueChartElement) {
                    const revenueCtx = revenueChartElement.getContext('2d');
                    // Vérification de la présence de données
                    if (categoryLabels.length === 0) {
                        // Données par défaut si aucune donnée n'est disponible
                        const defaultLabels = ['Catégorie 1', 'Catégorie 2', 'Catégorie 3'];
                        const defaultValues = [0, 0, 0];
                        
                        renderRevenueChart(revenueCtx, defaultLabels, defaultValues);
                    } else {
                        renderRevenueChart(revenueCtx, categoryLabels, categoryValues);
                    }
                }

                // Fonction pour rendre le graphique des ventes
                function renderSalesChart(ctx, labels, data) {
                    new Chart(ctx, {
                        type: 'line',
                        data: {
                            labels: labels,
                            datasets: [{
                                label: 'Ventes',
                                data: data,
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
                }

                // Fonction pour rendre le graphique des revenus
                function renderRevenueChart(ctx, labels, values) {
                    // Génération de couleurs si nécessaire
                    const backgroundColors = [
                        'rgb(255, 99, 132)',
                        'rgb(54, 162, 235)',
                        'rgb(255, 205, 86)',
                        'rgb(75, 192, 192)',
                        'rgb(153, 102, 255)',
                        'rgb(255, 159, 64)'
                    ];
                    
                    // S'assurer qu'il y a suffisamment de couleurs pour chaque catégorie
                    while (backgroundColors.length < labels.length) {
                        // Générer des couleurs aléatoires supplémentaires si nécessaire
                        backgroundColors.push(`rgb(${Math.floor(Math.random() * 255)}, ${Math.floor(Math.random() * 255)}, ${Math.floor(Math.random() * 255)})`);
                    }

                    new Chart(ctx, {
                        type: 'doughnut',
                        data: {
                            labels: labels,
                            datasets: [{
                                data: values,
                                backgroundColor: backgroundColors.slice(0, labels.length)
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
                                            const percentage = total > 0 ? Math.round((value / total) * 100) : 0;
                                            return `${label}: ${value.toLocaleString('fr-FR')} FCFA (${percentage}%)`;
                                        }
                                    }
                                }
                            }
                        }
                    });
                }
            });
        </script>
    @endpush
@endsection