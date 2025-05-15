@extends('layouts.app')

@section('content')
<!-- Hero Section -->
<section class="bg-light py-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 mx-auto text-center">
                <h1 class="display-4 mb-4">{{ $category->name }}</h1>
                @if($category->description)
                    <p class="lead text-muted">{{ $category->description }}</p>
                @endif
            </div>
        </div>
    </div>
</section>

<!-- Filters -->
<section class="py-4 bg-white border-bottom">
    <div class="container">
        <div class="row g-3">
            <div class="col-md-4">
                <select class="form-select" id="price-filter">
                    <option value="">Prix</option>
                    <option value="0-100000">0 - 100,000 FCFA</option>
                    <option value="100000-200000">100,000 - 200,000 FCFA</option>
                    <option value="200000-300000">200,000 - 300,000 FCFA</option>
                    <option value="300000+">300,000+ FCFA</option>
                </select>
            </div>
            <div class="col-md-4">
                <select class="form-select" id="sort-filter">
                    <option value="">Trier par</option>
                    <option value="price-asc">Prix croissant</option>
                    <option value="price-desc">Prix décroissant</option>
                    <option value="newest">Plus récents</option>
                </select>
            </div>
            <div class="col-md-4">
                <div class="input-group">
                    <input type="text" class="form-control" id="search-input" placeholder="Rechercher...">
                    <button class="btn btn-primary" id="search-button">
                        <i class="bi bi-search"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Products Grid -->
<section class="py-5">
    <div class="container">
        <div class="row g-4" id="products-container">
            @forelse($products as $product)
                <div class="col-md-3 product-card" data-price="{{ $product->price }}">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="product-image-container">
                            @if($product->images && count($product->images) > 0)
                                <img src="{{ asset('storage/' . $product->images[0]) }}" class="card-img-top" alt="{{ $product->nombre_places }}">
                            @else
                                <img src="{{ asset('images/no-image.jpg') }}" class="card-img-top" alt="{{ $product->nombre_places }}">
                            @endif
                            <div class="product-overlay">
                                <a href="{{ route('pages.product.detail', $product->id) }}" class="btn btn-light btn-sm">
                                    <i class="bi bi-eye"></i> Voir plus
                                </a>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <span class="badge bg-primary">{{ $category->name }}</span>
                            </div>
                            <div class="price-wrapper mb-3">
                                @if(isset($product->sale_price) && $product->sale_price)

                                    <span class="sale-price" style="color:#198754 ">{{ number_format($product->sale_price, 0, ',', ' ') }} FCFA</span>
                                @else
                                    <span class="text-primary fw-bold">{{ number_format($product->price, 0, ',', ' ') }} FCFA</span>
                                @endif
                            </div>
                            <p class="card-text text-muted mb-3">{{ isset($product->description) ? Str::limit($product->description, 100) : $product->nombre_places }}</p>
                            <div class="d-flex justify-content-between align-items-center">
                                <a href="{{ route('pages.product.detail', $product->id) }}" class="btn btn-outline-primary btn-sm">
                                    <i class="bi bi-eye"></i> Détails
                                </a>
                                <a href="{{ route('pages.product.detail', $product->id) }}" class="btn btn-primary">
                                            <i class="bi bi-cart-plus"></i>
                                        </a>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="alert alert-info">
                        Aucun produit disponible dans cette catégorie.
                    </div>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        <div class="d-flex justify-content-center mt-5">
            {{ $products->links() }}
        </div>
    </div>
</section>

@push('styles')
<style>
.product-card {
    transition: transform 0.3s ease;
}

.product-card:hover {
    transform: translateY(-5px);
}

.card {
    border-radius: 10px;
    overflow: hidden;
}

.card-img-top {
    height: 200px;
    object-fit: cover;
}

.product-image-container {
    position: relative;
    overflow: hidden;
}

.product-overlay {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.3);
    display: flex;
    justify-content: center;
    align-items: center;
    opacity: 0;
    transition: opacity 0.3s ease;
}

 .original-price {
        font-size: 0.85rem;
        color: #dc3545 !important;
        text-decoration: line-through;
        text-decoration-color: #dc3545;
    }

    .sale-price {
        font-size: 1.1rem;
        color: #198754 !important;
        font-weight: 700;
        text-shadow: 1px 1px 2px rgba(25, 135, 84, 0.1);
    }
.product-card:hover .product-overlay {
    opacity: 1;
}



.btn-primary {
    background-color: #007bff;
    border: none;
}

.btn-primary:hover {
    background-color: #0056b3;
}

.btn-outline-primary {
    border-color: #007bff;
    color: #007bff;
}

.btn-outline-primary:hover {
    background-color: #007bff;
    color: white;
}
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const priceFilter = document.getElementById('price-filter');
    const sortFilter = document.getElementById('sort-filter');
    const searchInput = document.getElementById('search-input');
    const searchButton = document.getElementById('search-button');
    const productsContainer = document.getElementById('products-container');
    const productCards = document.querySelectorAll('.product-card');

    function filterProducts() {
        const priceValue = priceFilter.value;
        const sortValue = sortFilter.value;
        const searchValue = searchInput.value.toLowerCase();

        productCards.forEach(card => {
            const price = parseInt(card.dataset.price);
            const description = card.querySelector('.card-text') ? card.querySelector('.card-text').textContent.toLowerCase() : '';
            const badge = card.querySelector('.badge') ? card.querySelector('.badge').textContent.toLowerCase() : '';

            let show = true;

            if (priceValue) {
                const [min, max] = priceValue.split('-').map(Number);
                if (max && (price < min || price > max)) {
                    show = false;
                } else if (!max && price < min) {
                    show = false;
                }
            }

            if (searchValue && !description.includes(searchValue) && !badge.includes(searchValue)) {
                show = false;
            }

            card.style.display = show ? 'block' : 'none';
        });

        if (sortValue) {
            const sortedCards = Array.from(productCards).filter(card => card.style.display !== 'none').sort((a, b) => {
                const priceA = parseInt(a.dataset.price);
                const priceB = parseInt(b.dataset.price);
                if (sortValue === 'price-asc') {
                    return priceA - priceB;
                } else if (sortValue === 'price-desc') {
                    return priceB - priceA;
                }
                return 0;
            });

            sortedCards.forEach(card => {
                productsContainer.appendChild(card);
            });
        }
    }

    priceFilter.addEventListener('change', filterProducts);
    sortFilter.addEventListener('change', filterProducts);
    searchButton.addEventListener('click', filterProducts);
    searchInput.addEventListener('keyup', function(event) {
        if (event.key === 'Enter') {
            filterProducts();
        }
    });
});

// Fonction pour ajouter au panier
function addToCart(product) {
    // Récupérer le panier actuel depuis le localStorage
    let cart = JSON.parse(localStorage.getItem('cart')) || [];
    
    // Vérifier si le produit est déjà dans le panier
    const existingProductIndex = cart.findIndex(item => item.id === product.id);
    
    if (existingProductIndex > -1) {
        // Si le produit existe déjà, augmenter la quantité
        cart[existingProductIndex].quantity += 1;
    } else {
        // Sinon, ajouter le nouveau produit
        cart.push({
            id: product.id,
            name: product.name,
            price: product.price,
            image: product.image,
            quantity: 1
        });
    }
    
    // Sauvegarder le panier mis à jour
    localStorage.setItem('cart', JSON.stringify(cart));
    
    // Notification d'ajout au panier
    const toast = document.createElement('div');
    toast.classList.add('toast', 'show', 'position-fixed', 'bottom-0', 'end-0', 'm-3');
    toast.setAttribute('role', 'alert');
    toast.setAttribute('aria-live', 'assertive');
    toast.setAttribute('aria-atomic', 'true');
    toast.style.zIndex = '1050';
    
    toast.innerHTML = `
        <div class="toast-header bg-success text-white">
            <strong class="me-auto">Panier</strong>
            <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
        <div class="toast-body">
            <div class="d-flex align-items-center">
                <img src="${product.image}" alt="${product.name}" style="width: 50px; height: 50px; object-fit: cover; margin-right: 10px;">
                <div>
                    <p class="mb-0">Produit ajouté au panier</p>
                    <small>${product.name}</small>
                </div>
            </div>
        </div>
    `;
    
    document.body.appendChild(toast);
    
    // Supprimer la notification après 3 secondes
    setTimeout(() => {
        toast.remove();
    }, 3000);
    
    // Mettre à jour le compteur du panier si existe
    updateCartCounter();
}

// Fonction pour mettre à jour le compteur du panier
function updateCartCounter() {
    const cartCounter = document.getElementById('cart-counter');
    if (cartCounter) {
        const cart = JSON.parse(localStorage.getItem('cart')) || [];
        const totalItems = cart.reduce((total, item) => total + item.quantity, 0);
        cartCounter.textContent = totalItems;
        if (totalItems > 0) {
            cartCounter.classList.remove('d-none');
        } else {
            cartCounter.classList.add('d-none');
        }
    }
}

// Mettre à jour le compteur au chargement de la page
document.addEventListener('DOMContentLoaded', function() {
    updateCartCounter();
});
</script>
@endpush
@endsection