@extends('layouts.app')

@section('content')
    <!-- Hero Section -->
    <section data-aos="fade" data-aos-duration="1500" data-aos-delay="500"  class=" py-5" style="{{ base_color() }}">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 mx-auto text-center">
                    <h1 class="display-4 mb-4 text-white fw-bold">Nos Produits</h1>
                    <p class="lead t text-white">Découvrez notre large gamme de meubles de qualité.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Filters -->
    <section data-aos="fade" data-aos-duration="1500" data-aos-delay="500"  class="py-4 bg-white border-bottom">
        <div class="container">
            <div class="row g-3">
                <div class="col-md-3">
                    <select class="form-select border-2 fw-bold" id="category-filter">
                        <option value="">Toutes les catégories</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <select class="form-select border-2 fw-bold" id="price-filter">
                        <option value="">Prix</option>
                        <option value="0-100000">0 - 100,000 FCFA</option>
                        <option value="100000-200000">100,000 - 200,000 FCFA</option>
                        <option value="200000-300000">200,000 - 300,000 FCFA</option>
                        <option value="300000+">300,000+ FCFA</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <select class="form-select border-2 fw-bold" id="sort-filter">
                        <option value="">Trier par</option>
                        <option value="price-asc">Prix croissant</option>
                        <option value="price-desc">Prix décroissant</option>
                        <option value="newest">Plus récents</option>
                        <option value="popular">Plus populaires</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <div class="input-group">
                        <input type="text" class="form-control border-2 fw-bold" id="search-input" placeholder="Rechercher...">
                        <button class="btn btn-primary" id="search-button border-0 border-danger" style="{{ base_color() }}">
                            <i class="bi bi-search"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Products Grid -->
    <section data-aos="fade" data-aos-duration="1500" data-aos-delay="500"  class="py-5">
        <div class="container">
            @foreach ($categories as $category)
                <div class="category-section mb-5">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h2 class="h3 mb-0" >{{ $category->name }}</h2>
                        <a href="{{ route('category.show', $category->slug) }}" class="btn btn-outline-primary button-hover" style="{{ border_color() }}">
                            Voir tous <i class="bi bi-arrow-right ms-2"></i>
                        </a>
                    </div>
                    <div class="row g-4" id="products-container">
                        @forelse($category->products as $product)
                            <div class="col-md-3 product-card" data-category="{{ $category->id }}"
                                data-price="{{ $product->price }}">
                                <div class="card h-100 border-0 shadow-sm">
                                    <div class="product-image-container">
                                        @if ($product->images && count($product->images) > 0)
                                            <img src="{{ asset('storage/' . $product->images[0]) }}" class="card-img-top"
                                                alt="{{ $product->nombre_places }}">
                                        @else
                                            <img src="{{ asset('images/no-image.jpg') }}" class="card-img-top"
                                                alt="{{ $product->nombre_places }}">
                                        @endif
                                        <div class="product-overlay">
                                            <a href="{{ route('pages.product.detail', $product->id) }}"
                                                class="btn btn-light btn-sm">
                                                <i class="bi bi-eye"></i> Voir plus
                                            </a>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                            <span class="badge" style="{{ base_color() }}">{{ $category->name }}</span>
                                        </div>
                                        <div class="price-wrapper mb-3">
                                            @if (isset($product->sale_price) && $product->sale_price)
                                                <span class="sale-price"
                                                    style="color:#198754 ">{{ number_format($product->sale_price, 0, ',', ' ') }}
                                                    FCFA</span>
                                            @else
                                                <span
                                                    class="text-primary fw-bold">{{ number_format($product->price, 0, ',', ' ') }}
                                                    FCFA</span>
                                            @endif
                                        </div>
                                        <p class="card-text text-muted mb-3">
                                            {{ isset($product->description) ? Str::limit($product->description, 100) : $product->nombre_places }}
                                        </p>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <a href="{{ route('pages.product.detail', $product->id) }}"
                                                class="btn btn-outline-primary btn-sm button-hover" style="{{ border_color() }}" >
                                                <i class="bi bi-eye"></i> Détails
                                            </a>
                                            <a href="{{ route('pages.product.detail', $product->id) }}"
                                                class="btn btn-primary border-0" style="{{ base_color() }}">
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
                </div>
            @endforeach
        </div>
    </section>

    @push('styles')
        <style>
            .category-section {
                position: relative;
                padding: 2rem 0;
            }

            .category-section:not(:last-child)::after {
                content: '';
                position: absolute;
                bottom: 0;
                left: 0;
                right: 0;
                height: 1px;
                background: #eee;
            }

            .product-card {
                transition: transform 0.3s ease;
            }

            .product-card:hover {
                transform: translateY(-5px);
            }

            /* Styles pour le prix original et le prix soldé */
            .original-price {
                font-size: 0.85rem;
                color:
                    #dc3545 !important;
                text-decoration: line-through;
                text-decoration-color:
                    #dc3545;
            }

            .sale-price {
                font-size: 1.1rem;
                color:
                    #198754 !important;
                font-weight: 700;
                text-shadow: 1px 1px 2px rgba(25, 135, 84, 0.1);
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
                const categoryFilter = document.getElementById('category-filter');
                const priceFilter = document.getElementById('price-filter');
                const sortFilter = document.getElementById('sort-filter');
                const searchInput = document.getElementById('search-input');
                const searchButton = document.getElementById('search-button');
                const productsContainer = document.getElementById(
                'products-container'); // Assurez-vous que cet ID est unique si vous avez plusieurs sections de produits, ou ciblez plus spécifiquement.
                const productCards = document.querySelectorAll('.product-card');

                function filterProducts() {
                    const categoryValue = categoryFilter.value;
                    const priceValue = priceFilter.value;
                    const sortValue = sortFilter.value;
                    const searchValue = searchInput.value.toLowerCase();

                    let visibleCards = [];

                    productCards.forEach(card => {
                        const category = card.dataset.category;
                        const price = parseInt(card.dataset.price);
                        const description = card.querySelector('.card-text') ? card.querySelector('.card-text')
                            .textContent.toLowerCase() : '';
                        const productNameOrBadge = card.querySelector('.badge') ? card.querySelector('.badge')
                            .textContent.toLowerCase() : ''; // Ajustez si le nom du produit est ailleurs

                        let show = true;

                        if (categoryValue && category !== categoryValue) {
                            show = false;
                        }

                        if (priceValue) {
                            const [minStr, maxStr] = priceValue.split('-');
                            const min = parseInt(minStr);
                            const max = maxStr ? parseInt(maxStr) : null;

                            if (max !== null && (price < min || price > max)) {
                                show = false;
                            } else if (max === null && price < min) { // Pour les cas comme "300000+"
                                show = false;
                            }
                        }

                        // Recherche dans la description ou le badge/nom de catégorie
                        const cardTextContent = (card.textContent || card.innerText || "").toLowerCase();
                        if (searchValue && !cardTextContent.includes(searchValue)) {
                            show = false;
                        }


                        if (show) {
                            card.style.display = 'block';
                            visibleCards.push(card);
                        } else {
                            card.style.display = 'none';
                        }
                    });

                    // Regrouper les cartes par catégorie parente (`div.row.g-4`)
                    // et appliquer le tri à l'intérieur de chaque groupe.
                    document.querySelectorAll('div.row.g-4').forEach(container => {
                        let cardsInContainer = Array.from(container.querySelectorAll('.product-card')).filter(
                            card => card.style.display !== 'none');

                        if (sortValue) {
                            cardsInContainer.sort((a, b) => {
                                const priceA = parseInt(a.dataset.price);
                                const priceB = parseInt(b.dataset.price);
                                // La date de création ou la popularité nécessiteraient des data-attributes supplémentaires
                                // const dateA = new Date(a.dataset.createdAt);
                                // const dateB = new Date(b.dataset.createdAt);
                                // const popularityA = parseInt(a.dataset.popularity);
                                // const popularityB = parseInt(b.dataset.popularity);

                                if (sortValue === 'price-asc') {
                                    return priceA - priceB;
                                } else if (sortValue === 'price-desc') {
                                    return priceB - priceA;
                                }
                                // Ajoutez ici la logique pour 'newest' et 'popular' si vous avez les données
                                // else if (sortValue === 'newest') {
                                //     return dateB - dateA;
                                // } else if (sortValue === 'popular') {
                                //     return popularityB - popularityA;
                                // }
                                return 0;
                            });
                        }

                        // Réinsérer les cartes triées dans leur conteneur
                        cardsInContainer.forEach(card => {
                            container.appendChild(card);
                        });
                    });
                }

                categoryFilter.addEventListener('change', filterProducts);
                priceFilter.addEventListener('change', filterProducts);
                sortFilter.addEventListener('change', filterProducts);
                searchButton.addEventListener('click', filterProducts);
                searchInput.addEventListener('keyup', function(event) {
                    if (event.key === 'Enter' || searchInput.value.length === 0 || searchInput.value.length >
                        2) { // Filtre à l'entrée ou si le champ est vidé
                        filterProducts();
                    }
                });

                // Initial filter call if needed, e.g. to apply default sort or filters from URL params
                // filterProducts();
            });
        </script>
    @endpush

    <!-- Newsletter -->
    <section class="py-5 bg-light">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8 text-center">
                    <h2 class="mb-4">Restez Informé</h2>
                    <p class="text-muted mb-4">Inscrivez-vous à notre newsletter pour recevoir nos dernières offres et
                        nouveautés.</p>
                    <form class="row g-3 justify-content-center">
                        <div class="col-md-8">
                            <input type="email" class="form-control form-control-lg border-2" placeholder="Votre adresse email">
                        </div>
                        <div class="col-md-4">
                            <button type="submit" class="btn btn-primary btn-lg w-100 border-0" style="{{ base_color() }}">S'inscrire</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection
