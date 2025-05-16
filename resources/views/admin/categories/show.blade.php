@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <!-- En-tête de la page -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0">{{ $category->name }}</h1>
        <div>
            <a href="{{ route('admin.categories.edit', $category) }}" class="btn btn-primary">
                <i class="fas fa-edit me-1"></i> Modifier
            </a>
            <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" class="d-inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette catégorie ?')">
                    <i class="fas fa-trash me-1"></i> Supprimer
                </button>
            </form>
        </div>
    </div>

    <!-- Statistiques -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <h5 class="card-title">Total Produits</h5>
                    <p class="card-text display-6">{{ $stats['total_products'] }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-success text-white">
                <div class="card-body">
                    <h5 class="card-title">Total Ventes</h5>
                    <p class="card-text display-6">{{ number_format($stats['total_sales'], 0, ',', ' ') }} FCFA</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-info text-white">
                <div class="card-body">
                    <h5 class="card-title">Total Commandes</h5>
                    <p class="card-text display-6">{{ $stats['total_orders'] }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-warning text-white">
                <div class="card-body">
                    <h5 class="card-title">Prix Moyen</h5>
                    <p class="card-text display-6">{{ number_format($stats['average_price'], 0, ',', ' ') }} FCFA</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Liste des produits -->
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Produits de la catégorie</h5>
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
                                <th><i class="fas fa-shopping-cart me-1"></i> Commandes</th>
                                <th><i class="fas fa-cogs me-1"></i> Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($products as $product)
                                <tr>
                                    <td>
                                        @if($product->images && count($product->images) > 0)
                                            <img src="{{ asset('storage/' . $product->images[0]) }}" alt="{{ $product->nombre_places }}" class="img-thumbnail" style="width: 50px; height: 50px; object-fit: cover;">
                                        @else
                                            <img src="{{ asset('images/no-image.jpg') }}" alt="No image" class="img-thumbnail" style="width: 50px; height: 50px; object-fit: cover;">
                                        @endif
                                    </td>
                                    <td>{{ $product->nombre_places }}</td>
                                    <td>{{ number_format($product->price, 0, ',', ' ') }} FCFA</td>
                                    <td>
                                        <span class="badge bg-{{ $product->stock > 10 ? 'success' : ($product->stock > 0 ? 'warning' : 'danger') }}">
                                            {{ $product->stock }}
                                        </span>
                                    </td>
                                    <td>{{ $product->order_items_count }}</td>
                                    <td>
                                        <div class="btn-group">
                                            <a href="{{ route('admin.products.edit', $product->id) }}" class="btn btn-sm btn-primary">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('admin.products.destroy', $product) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce produit ?')">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="d-flex justify-content-center mt-4">
                    {{ $products->links() }}
                </div>
            @else
                <div class="alert alert-info">
                    Aucun produit dans cette catégorie.
                </div>
            @endif
        </div>
    </div>

    <!-- Autres catégories -->
    @if($otherCategories->count() > 0)
        <div class="card mt-4">
            <div class="card-header">
                <h5 class="mb-0">Autres catégories</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    @foreach($otherCategories as $otherCategory)
                        <div class="col-md-4 mb-3">
                            <div class="card h-100">
                                <div class="card-body">
                                    <h6 class="card-title">{{ $otherCategory->name }}</h6>
                                    <p class="card-text text-muted">
                                        {{ $otherCategory->products_count }} produits
                                    </p>
                                    <a href="{{ route('admin.categories.show', $otherCategory) }}" class="btn btn-sm btn-outline-primary">
                                        Voir les produits
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endif
</div>
@endsection
