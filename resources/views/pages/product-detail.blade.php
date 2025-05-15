@extends('layouts.app')

@section('content')
<div class="container py-5">


    <div class="row">
        <!-- Images du produit -->
        <div class="col-md-6">
            <div class="product-images">
                @if($product->images && count($product->images) > 0)
                    <div class="main-image mb-3">
                        <img src="{{ asset('storage/' . $product->images[0]) }}" 
                             class="img-fluid rounded" 
                             alt="{{ $product->nombre_places }}"
                             id="main-product-image">
                        <div class="image-overlay">
                            <button class="btn btn-light btn-sm" onclick="zoomImage()">
                                <i class="bi bi-zoom-in"></i>
                            </button>
                        </div>
                    </div>
                    <div class="thumbnail-images row g-2">
                        @foreach($product->images as $image)
                            <div class="col-3">
                                <img src="{{ asset('storage/' . $image) }}" 
                                     class="img-fluid rounded thumbnail" 
                                     alt="{{ $product->nombre_places }}"
                                     onclick="changeMainImage(this.src)">
                            </div>
                        @endforeach
                    </div>
                @else
                    <img src="{{ asset('images/no-image.jpg') }}" 
                         class="img-fluid rounded" 
                         alt="{{ $product->nombre_places }}">
                @endif
            </div>
        </div>

        <!-- Informations du produit -->
        <div class="col-md-6">
            <div class="product-header mb-4">
                
                <div class="product-meta">
                    <span class="badge bg-primary">{{ $product->category->name }}</span>
                    @if($product->stock > 0)
                        <span class="badge bg-success">En stock</span>
                    @else
                        <span class="badge bg-danger">Rupture de stock</span>
                    @endif
                </div>
            </div>

            <div class="product-description mb-4">
                <p class="text-muted">{{ $product->description }}</p>
            </div>
            
            <div class="product-price mb-4">
                <h2 class="text-primary mb-0" >{{ number_format($product->price, 0, ',', ' ') }} FCFA</h2>
                @if($product->sale_price)
                    <span class="text-decoration-line-through text-muted" style="color: #198754 ">{{ number_format($product->sale_price, 0, ',', ' ') }} FCFA</span>
                    <span class="badge bg-danger ms-2" >-{{ round((($product->price - $product->sale_price) / $product->price) * 100) }}%</span>
                @endif
            </div>

            <div class="product-details mb-4">
                <h4>Caractéristiques</h4>
                <div class="row g-3">
                    <div class="col-6">
                        <div class="detail-item">
                            <i class="bi bi-box"></i>
                            <span><strong>Stock:</strong> {{ $product->stock }} unités</span>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="detail-item">
                            <i class="bi bi-rulers"></i>
                            <span><strong>Nombres de place:</strong> {{ $product->nombre_places }}</span>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="detail-item">
                            <i class="bi bi-palette"></i>
                            <span><strong>Matériau:</strong> {{ $product->matiere }}</span>
                        </div>
                    </div>
                    <!--div class="col-6">
                        <div class="detail-item">
                            <i class="bi bi-tag"></i>
                            <span><strong>Référence:</strong> {{ $product->reference }}</span>
                        </div>
                    </div-->
                </div>
            </div>

            <div class="add-to-cart mb-4">
                <!--div class="quantity-selector mb-3">
                    <label for="quantity" class="form-label">Quantité</label>
                    <div class="input-group" style="max-width: 150px;">
                        <button class="btn btn-outline-secondary" type="button" onclick="decrementQuantity()">-</button>
                        <input type="number" class="form-control text-center" id="quantity" value="1" min="1" max="{{ $product->stock }}">
                        <button class="btn btn-outline-secondary" type="button" onclick="incrementQuantity()">+</button>
                    </div>
                </div-->
                <div class="d-grid gap-2">
                    <button class="btn btn-primary btn-lg" onclick="addToCart({
                        id: {{ $product->id }},
                        name: '{{ $product->nombre_places }}',
                        price: {{ $product->price }},
                        image: '{{ $product->images ? asset('storage/' . $product->images[0]) : asset('images/no-image.jpg') }}',
                        quantity: document.getElementById('quantity').value
                    })">
                        <i class="bi bi-cart-plus"></i> Ajouter au panier
                    </button>
                    <button class="btn btn-outline-primary" onclick="addToWishlist({{ $product->id }})">
                        <i class="bi bi-heart"></i> Ajouter aux favoris
                    </button>
                </div>
            </div>

            <div class="product-features">
                <div class="row g-3">
                    <div class="col-6">
                        <div class="feature-item text-center p-3 border rounded">
                            <i class="bi bi-truck fs-4"></i>
                            <p class="mb-0 mt-2">Livraison gratuite</p>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="feature-item text-center p-3 border rounded">
                            <i class="bi bi-shield-check fs-4"></i>
                            <p class="mb-0 mt-2">Garantie 1 an</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Produits similaires -->
    <div class="related-products mt-5">
        <h3 class="mb-4">Produits similaires</h3>
<div class="row g-4">
                @foreach($relatedProducts as $product)
                <div class="col-md-3">
                    <div class="card h-100 border-0 shadow-sm product-card">
                        <div class="product-image-container">
                            @if($product->images && count($product->images) > 0)
                                <img src="{{ asset('storage/' . $product->images[0]) }}" class="card-img-top" alt="{{ $product->name }}">
                            @else
                                <img src="{{ asset('images/no-image.jpg') }}" class="card-img-top" alt="{{ $product->name }}">
                            @endif
                            <div class="product-overlay">
                                <a href="{{ route('pages.product.detail', $product->id) }}" class="btn btn-light btn-sm">
                                    <i class="bi bi-eye"></i> Voir plus
                                </a>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <span class="badge bg-primary">{{ $product->category->name }}</span>
                            </div>
                            <div class="price-wrapper mb-3">
                                    @if($product->sale_price)
                                   
                                    <span class="sale-price"style="color:#198754 ">{{ number_format($product->sale_price, 0, ',', ' ') }} FCFA</span>
                                    @else
                                        <span class="text-primary fw-bold">{{ number_format($product->price, 0, ',', ' ') }} FCFA</span>
                                    @endif
                                </div>
                            <p class="card-text text-muted mb-3">{{ Str::limit($product->description, 100) }}</p>
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
                @endforeach
    </div>
    </div>
</div>

@push('styles')
<style>
.product-images {
    position: relative;
}

.main-image {
    border: 1px solid #dee2e6;
    border-radius: 8px;
    overflow: hidden;
    position: relative;
}

.main-image img {
    width: 100%;
    height: 400px;
    object-fit: cover;
}

.image-overlay {
    position: absolute;
    top: 10px;
    right: 10px;
    opacity: 0;
    transition: opacity 0.3s ease;
}

.main-image:hover .image-overlay {
    opacity: 1;
}

.thumbnail {
    cursor: pointer;
    height: 80px;
    object-fit: cover;
    border: 1px solid #dee2e6;
    transition: all 0.3s ease;
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

.thumbnail:hover {
    border-color: #0d6efd;
    transform: scale(1.05);
}

.feature-item {
    transition: all 0.3s ease;
}

.feature-item:hover {
    background-color: #f8f9fa;
    transform: translateY(-2px);
}

.quantity-selector .input-group {
    width: auto;
}

.quantity-selector input[type="number"] {
    text-align: center;
    -moz-appearance: textfield;
}

.quantity-selector input[type="number"]::-webkit-outer-spin-button,
.quantity-selector input[type="number"]::-webkit-inner-spin-button {
    -webkit-appearance: none;
    margin: 0;
}

.detail-item {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 10px;
    background: #f8f9fa;
    border-radius: 8px;
    transition: all 0.3s ease;
}

.detail-item:hover {
    background: #e9ecef;
    transform: translateX(5px);
}

.detail-item i {
    color: #0d6efd;
    font-size: 1.2rem;
}

.product-meta {
    display: flex;
    gap: 10px;
}

.breadcrumb {
    background: #f8f9fa;
    padding: 10px 15px;
    border-radius: 8px;
}

.card {
    transition: all 0.3s ease;
}

.card:hover {
    transform: translateY(-5px);
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
}

.card-img-top {
    height: 200px;
    object-fit: cover;
}
</style>
@endpush

@push('scripts')
<script>
function changeMainImage(src) {
    document.getElementById('main-product-image').src = src;
}

function incrementQuantity() {
    const input = document.getElementById('quantity');
    const max = parseInt(input.getAttribute('max'));
    const currentValue = parseInt(input.value);
    if (currentValue < max) {
        input.value = currentValue + 1;
    }
}

function decrementQuantity() {
    const input = document.getElementById('quantity');
    const currentValue = parseInt(input.value);
    if (currentValue > 1) {
        input.value = currentValue - 1;
    }
}

function addToCart(product) {
    // Récupérer le panier actuel
    let cart = JSON.parse(localStorage.getItem('cart')) || [];
    
    // Vérifier si le produit existe déjà dans le panier
    const existingProductIndex = cart.findIndex(item => item.id === product.id);
    
    if (existingProductIndex > -1) {
        // Mettre à jour la quantité si le produit existe déjà
        cart[existingProductIndex].quantity += parseInt(product.quantity);
    } else {
        // Ajouter le nouveau produit
        cart.push(product);
    }
    
    // Sauvegarder le panier mis à jour
    localStorage.setItem('cart', JSON.stringify(cart));
    
    // Afficher une notification
    showNotification('Produit ajouté au panier !', 'success');
    
    // Mettre à jour le compteur du panier
    updateCartCount();
}

function addToWishlist(productId) {
    // Récupérer la liste des favoris
    let wishlist = JSON.parse(localStorage.getItem('wishlist')) || [];
    
    // Vérifier si le produit est déjà dans les favoris
    if (!wishlist.includes(productId)) {
        wishlist.push(productId);
        localStorage.setItem('wishlist', JSON.stringify(wishlist));
        showNotification('Produit ajouté aux favoris !', 'success');
    } else {
        showNotification('Ce produit est déjà dans vos favoris', 'info');
    }
}

function showNotification(message, type = 'info') {
    const toast = document.createElement('div');
    toast.className = `toast align-items-center text-white bg-${type} border-0 position-fixed bottom-0 end-0 m-3`;
    toast.setAttribute('role', 'alert');
    toast.setAttribute('aria-live', 'assertive');
    toast.setAttribute('aria-atomic', 'true');
    
    toast.innerHTML = `
        <div class="d-flex">
            <div class="toast-body">
                ${message}
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
        </div>
    `;
    
    document.body.appendChild(toast);
    const bsToast = new bootstrap.Toast(toast);
    bsToast.show();
    
    toast.addEventListener('hidden.bs.toast', () => {
        toast.remove();
    });
}

function zoomImage() {
    const mainImage = document.getElementById('main-product-image');
    const modal = document.createElement('div');
    modal.className = 'modal fade';
    modal.id = 'imageModal';
    
    modal.innerHTML = `
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body p-0">
                    <button type="button" class="btn-close position-absolute top-0 end-0 m-3" data-bs-dismiss="modal"></button>
                    <img src="${mainImage.src}" class="img-fluid" alt="Image agrandie">
                </div>
            </div>
        </div>
    `;
    
    document.body.appendChild(modal);
    const bsModal = new bootstrap.Modal(modal);
    bsModal.show();
    
    modal.addEventListener('hidden.bs.modal', () => {
        modal.remove();
    });
}
</script>
@endpush
@endsection
