@extends('layouts.app')

@section('content')
    <!-- Ajout du lien CDN Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <!-- Barre de recherche -->
    <section class="py-4 bg-light">
        <div class="container">
            <div class="search-bar animate-fadeInUp">
                <input type="text" class="form-control" placeholder="Rechercher un produit...">
            </div>
        </div>
    </section>

    <section class="hero-section"
        style="background-image: url('https://static.wixstatic.com/media/641465_5fc4647dc99644749ffa3767b665ff97~mv2.png/v1/fill/w_1280,h_515,al_c,q_90,enc_avif,quality_auto/641465_5fc4647dc99644749ffa3767b665ff97~mv2.png')">
        <div class="hero-content">
            <h1 class="display-4 fw-bold mb-4">Bienvenue à Bignon du Benin</h1>
            <p class="lead">Découvrez notre collection exclusive de meubles de qualité</p>
        </div>
    </section>

    <!-- Produits en vedette -->
    <section class="py-5">
        <div class="container">
            <h2 class="text-center mb-5">Nos Produits en Vedette</h2>
            <div class="row g-4">
                @foreach ($featuredProducts as $product)
                    <div class="col-md-3">
                        <div class="card h-100 border-0 shadow-sm product-card">
                            <div class="product-image-container">
                                @if ($product->images && count($product->images) > 0)
                                    <img src="{{ asset('storage/' . $product->images[0]) }}" class="card-img-top"
                                        alt="{{ $product->name }}">
                                @else
                                    <img src="{{ asset('images/no-image.jpg') }}" class="card-img-top"
                                        alt="{{ $product->name }}">
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
                                    <span class="badge bg-primary">{{ $product->category->name }}</span>
                                </div>
                                <div class="price-wrapper mb-3">
                                    @if ($product->sale_price)
                                        <span class="original-price me-2">{{ number_format($product->price, 0, ',', ' ') }}
                                            FCFA</span>
                                        <span class="sale-price">{{ number_format($product->sale_price, 0, ',', ' ') }}
                                            FCFA</span>
                                    @else
                                        <span class="text-primary fw-bold">{{ number_format($product->price, 0, ',', ' ') }}
                                            FCFA</span>
                                    @endif
                                </div>
                                <p class="card-text text-muted mb-3">{{ Str::limit($product->description, 100) }}</p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <a href="{{ route('pages.product.detail', $product->id) }}"
                                        class="btn btn-outline-primary btn-sm">
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
    </section>

    <!-- Catégories -->
    <section class="py-5">
        <div class="container">
            <h2 class="text-center mb-5">Nos Catégories</h2>
            <div class="row g-4">
                @forelse (getCategory() as $category)
                    <div class="col-md-4">
                        <div class="category-card">
                            <a href="">
                                <img src="{{ asset('images/canape1.webp') }}" alt="{{ $category->name }}">
                                <div class="category-overlay">
                                    <h4>{{ $category->name }}</h4>
                                    <p>{{ $category->description }}</p>
                                </div>
                            </a>
                        </div>
                    </div>
                @empty
                    <div class=" col-md-12 alert alert-info text-center">
                        <h4>Aucunes catégories disponibles</h4>
                    </div>
                @endforelse
                <div class="col-md-12 py-3">
                    <a href="{{ route('pages.categories') }}" class=" w-100 btn btn-lg btn-primary">Voir plus</a>
                </div>
            </div>
        </div>
    </section>

    <!-- Pourquoi nous choisir -->
    <section class="py-5">
        <div class="container">
            <h2 class="text-center mb-5">Pourquoi nous choisir ?</h2>
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="feature-card animate-on-scroll">
                        <div class="feature-icon">
                            <i class="fas fa-medal"></i>
                        </div>
                        <h4>Qualité Premium</h4>
                        <p>Des matériaux de première qualité pour des meubles qui durent.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-card animate-on-scroll">
                        <div class="feature-icon">
                            <i class="fas fa-truck"></i>
                        </div>
                        <h4>Livraison Rapide</h4>
                        <p>Service de livraison express dans tout le Bénin.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-card animate-on-scroll">
                        <div class="feature-icon">
                            <i class="fas fa-headset"></i>
                        </div>
                        <h4>Support 24/7</h4>
                        <p>Une équipe à votre écoute pour vous accompagner.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- <section class="product-slider bg-light py-5">
        <div class="container">
            <h2 class="text-center mb-5">Nos Produits en Vedette</h2>
            <div class="swiper-container">
                <div class="swiper-wrapper">
                    <!-- Slide 1 -->
                    <div class="swiper-slide">
                        <div class="product-card">
                            <img src="{{ asset('images/canape1.webp') }}" alt="Canapé 1">
                            <div class="product-info">
                                <h5>Table à Manger</h5>
                                <p class="text-primary fw-bold">65 000 FCFA</p>
                                <button class="btn btn-success w-100">Ajouter au panier</button>
                            </div>
                        </div>
                    </div>

                    <!-- Slide 2 -->
                    <div class="swiper-slide">
                        <div class="product-card">
                            <img src="{{ asset('images/canape1.webp') }}" alt="Canapé 2">
                            <div class="product-info">
                                <h5>Table à Manger</h5>
                                <p class="text-primary fw-bold">65 000 FCFA</p>
                                <button class="btn btn-success w-100">Ajouter au panier</button>
                            </div>
                        </div>
                    </div>

                    <!-- Slide 3 -->
                    <div class="swiper-slide">
                        <div class="product-card">
                            <img src="{{ asset('images/canape1.webp') }}" alt="Canapé 3">
                            <div class="product-info">
                                <h5>Table à Manger</h5>
                                <p class="text-primary fw-bold">65 000 FCFA</p>
                                <button class="btn btn-success w-100">Ajouter au panier</button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="swiper-button-next"></div>
                <div class="swiper-button-prev"></div>
                <div class="swiper-pagination"></div>
            </div>
        </div>
    </section> --}}

    <!-- Témoignages -->
    <section class="py-5 bg-light">
        <div class="container">
            <h2 class="text-center mb-5">Ce que disent nos clients</h2>
            <div class="row">
                <div class="col-md-4">
                    <div class="testimonial-card">
                        <img src="https://via.placeholder.com/80" alt="Client" class="testimonial-avatar">
                        <h5>Marie K.</h5>
                        <p class="text-muted">"Service exceptionnel et produits de qualité. Je recommande vivement!"</p>
                        <div class="text-warning">
                            ★★★★★
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="testimonial-card">
                        <img src="https://via.placeholder.com/80" alt="Client" class="testimonial-avatar">
                        <h5>Pierre D.</h5>
                        <p class="text-muted">"Les meubles sont magnifiques et le service client est au top!"</p>
                        <div class="text-warning">
                            ★★★★★
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="testimonial-card">
                        <img src="https://via.placeholder.com/80" alt="Client" class="testimonial-avatar">
                        <h5>Sophie M.</h5>
                        <p class="text-muted">"Une expérience d'achat agréable du début à la fin."</p>
                        <div class="text-warning">
                            ★★★★★
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Statistiques -->
    <section class="stats-section">
        <div class="container">
            <div class="row">
                <div class="col-md-3">
                    <div class="stat-card animate-on-scroll">
                        <div class="stat-number" data-count="1000">0</div>
                        <h5>Clients Satisfaits</h5>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stat-card animate-on-scroll">
                        <div class="stat-number" data-count="500">0</div>
                        <h5>Produits Vendus</h5>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stat-card animate-on-scroll">
                        <div class="stat-number" data-count="50">0</div>
                        <h5>Années d'Expérience</h5>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stat-card animate-on-scroll">
                        <div class="stat-number" data-count="24">0</div>
                        <h5>Heures de Support</h5>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Newsletter -->
    <section class="newsletter-section">
        <div class="container">
            <div class="text-center mb-4">
                <h2>Restez informé de nos nouveautés</h2>
                <p class="text-muted">Inscrivez-vous à notre newsletter pour recevoir nos dernières offres</p>
            </div>
            <form class="newsletter-form">
                <div class="input-group">
                    <input type="email" class="form-control" placeholder="Votre adresse email">
                    <button type="submit" class="btn">S'inscrire</button>
                </div>
            </form>
        </div>
    </section>
@endsection

@section('scripts')
    <script>
        // Initialize Swiper
        new Swiper('.swiper-container', {
            slidesPerView: 1,
            spaceBetween: 30,
            loop: true,
            pagination: {
                el: '.swiper-pagination',
                clickable: true,
            },
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
            breakpoints: {
                640: {
                    slidesPerView: 2,
                },
                1024: {
                    slidesPerView: 3,
                },
            }
        });

        // Animation au scroll
        function animateOnScroll() {
            const elements = document.querySelectorAll('.animate-on-scroll');
            elements.forEach(element => {
                const elementTop = element.getBoundingClientRect().top;
                const elementBottom = element.getBoundingClientRect().bottom;
                const isVisible = (elementTop < window.innerHeight) && (elementBottom >= 0);
                if (isVisible) {
                    element.classList.add('visible');
                }
            });
        }

        // Compteur de statistiques
        function animateNumbers() {
            const numbers = document.querySelectorAll('.stat-number');
            numbers.forEach(number => {
                const target = parseInt(number.getAttribute('data-count'));
                const duration = 2000;
                const step = target / (duration / 16);
                let current = 0;
                const timer = setInterval(() => {
                    current += step;
                    if (current >= target) {
                        number.textContent = target;
                        clearInterval(timer);
                    } else {
                        number.textContent = Math.floor(current);
                    }
                }, 16);
            });
        }

        // Event listeners
        window.addEventListener('scroll', () => {
            animateOnScroll();
        });

        // Initial animations
        document.addEventListener('DOMContentLoaded', () => {
            animateOnScroll();
            animateNumbers();
        });
    </script>
@endsection

@section('styles')
    <style>
        .product-card {
            background: white;
            border-radius: 15px;
            overflow: hidden;
            transition: all 0.3s ease;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            position: relative;
        }

        .product-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.2);
        }

        .product-image-container {
            position: relative;
            overflow: hidden;
            height: 250px;
        }

        .product-image-container img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s ease;
        }

        .product-card:hover .product-image-container img {
            transform: scale(1.1);
        }

        .product-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.5);
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .product-card:hover .product-overlay {
            opacity: 1;
        }

        .product-overlay .btn {
            transform: translateY(20px);
            transition: transform 0.3s ease;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        .product-card:hover .product-overlay .btn {
            transform: translateY(0);
        }

        .card-body {
            padding: 1.5rem;
        }

        .badge {
            font-size: 0.8rem;
            padding: 0.5em 1em;
            border-radius: 20px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .card-text {
            font-size: 0.9rem;
            line-height: 1.5;
            color: #666;
            margin-bottom: 1rem;
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
            text-overflow: ellipsis;
            max-height: 4.5em;
            /* 3 lignes * 1.5 line-height */
        }

        .btn {
            transition: all 0.3s ease;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
        }

        .btn-primary {
            border-radius: 25px;
            padding: 0.5rem 1.5rem;
        }

        .btn-outline-primary {
            border-radius: 25px;
            padding: 0.5rem 1.5rem;
        }

        .text-primary {
            color: var(--primary-color) !important;
            font-weight: 600;
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.1);
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .product-card {
            animation: fadeIn 0.5s ease-out forwards;
        }

        .product-card:nth-child(1) {
            animation-delay: 0.1s;
        }

        .product-card:nth-child(2) {
            animation-delay: 0.2s;
        }

        .product-card:nth-child(3) {
            animation-delay: 0.3s;
        }

        .product-card:nth-child(4) {
            animation-delay: 0.4s;
        }

        .price-wrapper {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            background: rgba(0, 0, 0, 0.03);
            padding: 0.5rem 1rem;
            border-radius: 20px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
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

        .text-primary {
            font-size: 1.1rem;
            color: var(--primary-color) !important;
            font-weight: 700;
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.1);
        }
    </style>
@endsection
