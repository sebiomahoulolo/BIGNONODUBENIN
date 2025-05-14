@extends('layouts.app')

@section('content')
<!-- Hero Section -->
<section class="hero-section" style="background-image: url('{{ $category->image ? asset('storage/' . $category->image) : asset('images/categories-hero.jpg') }}')">
    <div class="hero-content">
        <h1 class="display-4 fw-bold mb-4">{{ $category->name }}</h1>
        <p class="lead">{{ $category->description }}</p>
    </div>
</section>

<!-- Produits de la catégorie -->
<section class="py-5">
    <div class="container">
        <div class="row g-4">
            @forelse($products as $product)
            <div class="col-md-6 col-lg-4">
                <div class="product-card">
                    <div class="product-image">
                        <img src="{{ $product->image ? asset('storage/' . $product->image) : asset('images/no-image.jpg') }}" 
                             alt="{{ $product->name }}"
                             class="img-fluid">
                    </div>
                    <div class="product-info">
                        <h4>{{ $product->name }}</h4>
                        <p class="price">{{ number_format($product->price, 0, ',', ' ') }} FCFA</p>
                        <div class="product-actions">
                            <a href="{{ route('pages.product.detail', $product->id) }}" class="btn btn-primary">Voir détails</a>
                            <button class="btn btn-outline-primary add-to-cart" data-product-id="{{ $product->id }}">
                                <i class="fas fa-shopping-cart"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12">
                <div class="alert alert-info">
                    Aucun produit disponible dans cette catégorie pour le moment.
                </div>
            </div>
            @endforelse
        </div>

        <!-- Pagination -->
        <div class="d-flex justify-content-center mt-4">
            {{ $products->links() }}
        </div>
    </div>
</section>
@endsection

@section('styles')
<style>
.product-card {
    background: white;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    transition: transform 0.3s ease;
    height: 100%;
}

.product-card:hover {
    transform: translateY(-5px);
}

.product-image {
    height: 200px;
    overflow: hidden;
    border-radius: 8px 8px 0 0;
}

.product-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.product-info {
    padding: 1rem;
}

.product-info h4 {
    margin-bottom: 0.5rem;
    font-size: 1.1rem;
}

.price {
    color: #007bff;
    font-weight: bold;
    font-size: 1.2rem;
    margin-bottom: 1rem;
}

.product-actions {
    display: flex;
    gap: 0.5rem;
}

.product-actions .btn {
    flex: 1;
}
</style>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Gestion du panier
    const addToCartButtons = document.querySelectorAll('.add-to-cart');
    addToCartButtons.forEach(button => {
        button.addEventListener('click', function() {
            const productId = this.dataset.productId;
            // Ajouter la logique d'ajout au panier ici
            alert('Produit ajouté au panier !');
        });
    });
});
</script>
@endsection 