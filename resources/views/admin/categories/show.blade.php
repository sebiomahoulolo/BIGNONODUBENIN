@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <!-- En-tête avec boutons de navigation -->
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <div>
            <h1 class="h2">
                <i class="fas fa-folder-open me-2"></i> Détails de la catégorie
            </h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="fas fa-home"></i> Tableau de bord</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.categories.index') }}"><i class="fas fa-folder"></i> Catégories</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ $category->name }}</li>
                </ol>
            </nav>
        </div>
        <div class="btn-toolbar mb-2 mb-md-0">
            <div class="btn-group me-2">
                <a href="{{ route('admin.categories.edit', $category) }}" class="btn btn-sm btn-outline-primary">
                    <i class="fas fa-edit me-1"></i> Modifier
                </a>
                <button type="button" class="btn btn-sm btn-outline-danger" data-bs-toggle="modal" data-bs-target="#deleteModal">
                    <i class="fas fa-trash-alt me-1"></i> Supprimer
                </button>
            </div>
            <a href="{{ route('admin.categories.index') }}" class="btn btn-sm btn-outline-secondary">
                <i class="fas fa-arrow-left me-1"></i> Retour
            </a>
        </div>
    </div>

    <!-- Messages de notification -->
    @if(session('success'))
        <div class="alert alert-success d-flex align-items-center alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i>
            <div>{{ session('success') }}</div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fermer"></button>
        </div>
    @endif

    <div class="row">
        <!-- Informations principales -->
        <div class="col-md-8">
            <div class="card shadow-sm mb-4">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-info-circle me-2"></i> Informations de la catégorie
                    </h6>
                    <span class="badge {{ $category->is_active ? 'bg-success' : 'bg-danger' }}">
                        <i class="fas {{ $category->is_active ? 'fa-check-circle' : 'fa-times-circle' }} me-1"></i>
                        {{ $category->is_active ? 'Actif' : 'Inactif' }}
                    </span>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-borderless">
                            <tbody>
                                <tr>
                                    <th class="text-muted" style="width: 200px;">
                                        <i class="fas fa-tag me-2"></i> Nom :
                                    </th>
                                    <td>{{ $category->name }}</td>
                                </tr>
                                <tr>
                                    <th class="text-muted">
                                        <i class="fas fa-key me-2"></i> Identifiant :
                                    </th>
                                    <td>{{ $category->id }}</td>
                                </tr>
                                <tr>
                                    <th class="text-muted">
                                        <i class="fas fa-link me-2"></i> Slug :
                                    </th>
                                    <td>{{ $category->slug ?? 'Non défini' }}</td>
                                </tr>
                                <tr>
                                    <th class="text-muted">
                                        <i class="fas fa-align-left me-2"></i> Description :
                                    </th>
                                    <td>{{ $category->description ?? 'Aucune description' }}</td>
                                </tr>
                                <tr>
                                    <th class="text-muted">
                                        <i class="fas fa-box me-2"></i> Nombre de produits :
                                    </th>
                                    <td>
                                        <span class="badge bg-info text-white">
                                            {{ $category->products_count }} produits
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <th class="text-muted">
                                        <i class="fas fa-calendar-alt me-2"></i> Créé le :
                                    </th>
                                    <td>{{ $category->created_at->format('d/m/Y à H:i') }}</td>
                                </tr>
                                <tr>
                                    <th class="text-muted">
                                        <i class="fas fa-edit me-2"></i> Dernière modification :
                                    </th>
                                    <td>{{ $category->updated_at->format('d/m/Y à H:i') }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Liste des produits associés -->
            <div class="card shadow-sm mb-4">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-box me-2"></i> Produits associés 
                        <span class="badge bg-secondary ms-2">{{ $category->products_count }}</span>
                    </h6>
                    <a href="{{ route('admin.products.create', ['category_id' => $category->id]) }}" class="btn btn-sm btn-primary">
                        <i class="fas fa-plus-circle me-1"></i> Ajouter un produit
                    </a>
                </div>
                <div class="card-body">
                    @if($products->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead class="bg-light">
                                <tr>
                                    <th><i class="fas fa-image me-1"></i> Image</th>
                                    <th><i class="fas fa-box me-1"></i> Nom</th>
                                    <th><i class="fas fa-tag me-1"></i> Prix</th>
                                    <th><i class="fas fa-boxes me-1"></i> Stock</th>
                                    <th><i class="fas fa-cogs me-1"></i> Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($products as $product)
                                <tr>
                                    <td class="text-center" style="width: 80px;">
                                        @if($product->image)
                                            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="img-thumbnail" style="max-width: 50px; max-height: 50px;">
                                        @else
                                            <i class="fas fa-image text-muted fa-2x"></i>
                                        @endif
                                    </td>
                                    <td>
                                        <strong>{{ $product->name }}</strong>
                                        <div class="small text-muted">ID: {{ $product->id }}</div>
                                    </td>
                                    <td>{{ number_format($product->price, 0, ',', ' ') }} FCFA</td>
                                    <td class="text-center">
                                        @if($product->stock > 10)
                                            <span class="badge bg-success">{{ $product->stock }}</span>
                                        @elseif($product->stock > 0)
                                            <span class="badge bg-warning text-dark">{{ $product->stock }}</span>
                                        @else
                                            <span class="badge bg-danger">Rupture</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('admin.products.show', $product) }}" class="btn btn-sm btn-info me-1" title="Voir">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('admin.products.edit', $product) }}" class="btn btn-sm btn-primary me-1" title="Modifier">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-3">
                        {{ $products->links() }}
                    </div>
                    @else
                    <div class="text-center py-4">
                        <i class="fas fa-box-open fa-3x text-muted mb-3"></i>
                        <p class="text-muted">Aucun produit n'est associé à cette catégorie.</p>
                        <a href="{{ route('admin.products.create', ['category_id' => $category->id]) }}" class="btn btn-sm btn-primary">
                            <i class="fas fa-plus-circle me-1"></i> Ajouter un produit
                        </a>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Sidebar avec image et stats -->
        <div class="col-md-4">
            <!-- Image de la catégorie -->
            <div class="card shadow-sm mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-image me-2"></i> Image de la catégorie
                    </h6>
                </div>
                <div class="card-body text-center">
                    @if($category->image)
                        <img src="{{ asset('storage/' . $category->image) }}" class="img-fluid rounded" alt="{{ $category->name }}">
                        <div class="mt-3">
                            <a href="{{ asset('storage/' . $category->image) }}" target="_blank" class="btn btn-sm btn-outline-secondary">
                                <i class="fas fa-external-link-alt me-1"></i> Voir en taille réelle
                            </a>
                        </div>
                    @else
                        <div class="text-center py-5 bg-light rounded">
                            <i class="fas fa-image fa-4x text-muted mb-3"></i>
                            <p class="text-muted">Aucune image disponible</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Statistiques -->
            <div class="card shadow-sm mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-chart-pie me-2"></i> Statistiques
                    </h6>
                </div>
                <div class="card-body">
                    <div class="row g-0">
                        <div class="col-6 border-end border-bottom p-3 text-center">
                            <h3 class="mb-1">{{ $category->products_count }}</h3>
                            <div class="small text-muted">Produits</div>
                        </div>
                        <div class="col-6 border-bottom p-3 text-center">
                            <h3 class="mb-1">{{ $totalViews ?? 0 }}</h3>
                            <div class="small text-muted">Vues</div>
                        </div>
                        <div class="col-6 border-end p-3 text-center">
                            <h3 class="mb-1">{{ $totalOrders ?? 0 }}</h3>
                            <div class="small text-muted">Commandes</div>
                        </div>
                        <div class="col-6 p-3 text-center">
                            <h3 class="mb-1">{{ $totalSales ?? 0 }}</h3>
                            <div class="small text-muted">Ventes</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Autres catégories -->
            <div class="card shadow-sm mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-folder me-2"></i> Autres catégories
                    </h6>
                </div>
                <div class="card-body p-0">
                    <div class="list-group list-group-flush">
                        @foreach($otherCategories as $otherCategory)
                            <a href="{{ route('admin.categories.show', $otherCategory) }}" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                                <span>
                                    <i class="fas fa-folder{{ $otherCategory->id == $category->id ? '-open' : '' }} me-2"></i>
                                    {{ $otherCategory->name }}
                                </span>
                                <span class="badge bg-primary rounded-pill">{{ $otherCategory->products_count }}</span>
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal de confirmation de suppression -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">Confirmer la suppression</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
            </div>
            <div class="modal-body">
                <p>Êtes-vous sûr de vouloir supprimer la catégorie <strong>{{ $category->name }}</strong> ?</p>
                <div class="alert alert-warning">
                    <i class="fas fa-exclamation-triangle me-2"></i> Cette action est irréversible et pourrait affecter les produits associés.
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="fas fa-times me-1"></i> Annuler
                </button>
                <form action="{{ route('admin.categories.destroy', $category) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-trash-alt me-1"></i> Supprimer définitivement
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection 