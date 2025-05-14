@extends('layouts.app')

@section('content')
    <div class="container py-5">
        <div class="row">
            <!-- Carrousel d'images -->
            <div class="col-lg-6 col-md-12 mb-4">
                <div id="productCarousel" class="carousel slide product-carousel" data-bs-ride="carousel">
                    <div class="carousel-inner">
                        @foreach ($product->images as $key => $image)
                            <div class="carousel-item {{ $key === 0 ? 'active' : '' }}">
                                <img src="{{ asset('storage/' . $image) }}" class="d-block w-100 main-image"
                                    alt="{{ $product->nombre_places }}">
                            </div>
                        @endforeach
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#productCarousel"
                        data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Précédent</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#productCarousel"
                        data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Suivant</span>
                    </button>
                </div>

                <!-- Miniatures -->
                <div class="row mt-3 thumbnails-container">
                    @foreach ($product->images as $key => $image)
                        <div class="col-3">
                            <div class="thumbnail-item {{ $key === 0 ? 'active' : '' }}"
                                onclick="changeMainImage({{ $key }})">
                                <img src="{{ asset('storage/' . $image) }}" alt="{{ $product->nombre_places }}">
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Informations du produit -->
            <div class="col-lg-6 col-md-12">
                <div class="product-details">
                    <div class="category-badge mb-3">
                        <h1 class="product-title mb-4"> <span class="badge bg-primary">{{ $product->category->name }}</span>
                        </h1>
                    </div>



                    <div class="price-container mb-4">
                        @if ($product->sale_price)
                            <span class="original-price">{{ number_format($product->price, 0, ',', ' ') }} FCFA</span>
                            <span class="sale-price">{{ number_format($product->sale_price, 0, ',', ' ') }} FCFA</span>
                            <span class="discount-badge">-{{ $product->discount_percentage }}%</span>
                        @else
                            <span class="current-price">{{ number_format($product->price, 0, ',', ' ') }} FCFA</span>
                        @endif
                    </div>

                    <div class="description-container mb-4">
                        <h5 class="section-title">Description</h5>
                        <p class="product-description">{{ $product->description }}</p>
                    </div>

                    <div class="specifications-container mb-4">
                        <h5 class="section-title">Caractéristiques</h5>
                        <div class="specs-grid">
                            <div class="spec-item">
                                <i class="bi bi-people"></i>
                                <span>Nombre de places: {{ $product->nombre_places }}</span>
                            </div>
                            <div class="spec-item">
                                <i class="bi bi-box"></i>
                                <span>Matière: {{ $product->matiere }}</span>
                            </div>
                            <div class="spec-item">
                                <i class="bi bi-check-circle"></i>
                                <span>Stock: {{ $product->stock }} unités</span>
                            </div>
                        </div>
                    </div>

                    <form action="{{ route('cart.add', $product->id) }}" method="POST" class="add-to-cart-form mb-4">
                        @csrf
                        <div class="row align-items-center">
                            {{-- <div class="col-auto">
                                <div class="quantity-selector">
                                    <button type="button" class="quantity-btn minus">-</button>
                                    <input type="number" class="form-control" id="quantity" name="quantity" value="1"
                                        min="1" max="{{ $product->stock }}">
                                    <button type="button" class="quantity-btn plus">+</button>
                                </div>
                            </div> --}}
                            <div class="col">
                                @php
                                    $currentUrl = urlencode(Request::fullUrl());
                                    $shareText = urlencode('Je veux partager ce produit : ');
                                @endphp

                                <div class="col position-relative">
                                    <!-- Bouton Partager -->
                                    <button type="button" class="btn btn-primary btn-lg w-100 add-to-cart-btn"
                                        onclick="toggleShareOptions(this)">
                                        <i class="bi bi-cart-plus"></i> Partager
                                    </button>

                                    <!-- Mini-modal de partage -->
                                    <div class="share-options d-none position-absolute start-0 mt-2 p-2 bg-white border rounded shadow z-3"
                                        style="min-width: 250px;">
                                        <div class="d-flex flex-wrap gap-2 justify-content-center">
                                            <!-- WhatsApp -->
                                            <a href="https://wa.me/?text={{ $shareText }}{{ $currentUrl }}"
                                                target="_blank" class="btn btn-success btn-sm">
                                                <i class="bi bi-whatsapp"></i>
                                            </a>

                                            <!-- Facebook -->
                                            <a href="https://www.facebook.com/sharer/sharer.php?u={{ $currentUrl }}"
                                                target="_blank" class="btn btn-primary btn-sm">
                                                <i class="bi bi-facebook"></i>
                                            </a>

                                            <!-- LinkedIn -->
                                            <a href="https://www.linkedin.com/sharing/share-offsite/?url={{ $currentUrl }}"
                                                target="_blank" class="btn btn-info btn-sm">
                                                <i class="bi bi-linkedin"></i>
                                            </a>

                                            <!-- TikTok -->
                                            <a href="https://www.tiktok.com/" target="_blank" class="btn btn-dark btn-sm">
                                                <i class="bi bi-tiktok"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="col">
                                <button type="button" class="btn btn-primary btn-lg w-100 add-to-cart-btn add-to-cart"
                                    data-name="{{ $product->matiere }}" data-price="{{ $product->sale_price }}"
                                    data-img="{{ asset('images/canape1.webp') }}">
                                    <i class="bi bi-cart-plus"></i> Ajouter au panier
                                </button>
                            </div>
                        </div>
                    </form>

                    <div class="delivery-info">
                        <h5 class="section-title">Livraison</h5>
                        <div class="delivery-options">
                            <div class="delivery-option">
                                <i class="bi bi-truck"></i>
                                <span>Livraison gratuite à partir de 100 000 FCFA</span>
                            </div>
                            <div class="delivery-option">
                                <i class="bi bi-clock"></i>
                                <span>Livraison en 2-3 jours ouvrés</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        /* Styles de base */
        .product-carousel {
            border-radius: 15px;
            overflow: hidden;
            background-color: #f8f9fa;
        }

        .product-carousel .carousel-item {
            background-color: #f8f9fa;
        }

        .product-carousel .carousel-item img {
            height: 500px;
            object-fit: contain;
            transition: transform 0.3s ease;
            background-color: #f8f9fa;
        }

        /* Styles responsifs */
        @media (max-width: 991.98px) {
            .product-carousel .carousel-item img {
                height: 350px;
            }

            .product-title {
                font-size: 1.75rem;
            }

            .price-container {
                flex-direction: column;
                align-items: flex-start;
                gap: 0.5rem;
                padding: 0.75rem;
            }

            .product-details {
                padding: 1.5rem;
            }
        }

        @media (max-width: 767.98px) {
            .product-carousel .carousel-item img {
                height: 250px;
            }

            .product-title {
                font-size: 1.5rem;
                margin-bottom: 1rem;
            }

            .product-title .badge {
                font-size: 0.8rem;
                padding: 0.4em 0.8em;
            }

            .specs-grid {
                grid-template-columns: 1fr;
                gap: 0.75rem;
            }

            .spec-item {
                padding: 0.75rem;
                font-size: 0.9rem;
            }

            .delivery-options {
                flex-direction: column;
                gap: 0.75rem;
            }

            .delivery-option {
                padding: 0.75rem;
                font-size: 0.9rem;
            }

            .quantity-selector {
                width: 100%;
                margin-bottom: 0.75rem;
            }

            .quantity-btn {
                width: 35px;
                height: 35px;
                font-size: 1rem;
            }

            .quantity-selector input {
                width: 50px;
                font-size: 0.9rem;
            }

            .add-to-cart-form .row {
                flex-direction: column;
                gap: 0.75rem;
            }

            .add-to-cart-form .col {
                width: 100%;
            }

            .add-to-cart-btn {
                padding: 0.75rem 1.5rem;
                font-size: 0.9rem;
            }

            .section-title {
                font-size: 1.1rem;
                margin-bottom: 0.75rem;
            }

            .product-description {
                font-size: 0.9rem;
                line-height: 1.4;
            }

            .thumbnail-item {
                height: 60px;
                width: 60px;
            }
        }

        @media (max-width: 575.98px) {
            .container {
                padding: 1rem;
            }

            .product-carousel .carousel-item img {
                height: 200px;
            }

            .product-title {
                font-size: 1.25rem;
                margin-bottom: 0.75rem;
            }

            .product-title .badge {
                font-size: 0.7rem;
                padding: 0.3em 0.6em;
            }



            .price-container {
                padding: 0.5rem;
                margin-bottom: 0.75rem;
            }

            .sale-price,
            .current-price {
                font-size: 1.25rem;
            }

            .original-price {
                font-size: 0.9rem;
            }

            .discount-badge {
                font-size: 0.8rem;
                padding: 0.3em 0.6em;
            }

            .product-details {
                padding: 1rem;
            }

            .spec-item {
                padding: 0.5rem;
                font-size: 0.85rem;
            }

            .spec-item i {
                font-size: 1rem;
            }

            .delivery-option {
                padding: 0.5rem;
                font-size: 0.85rem;
            }

            .delivery-option i {
                font-size: 1.2rem;
            }

            .quantity-btn {
                width: 30px;
                height: 30px;
                font-size: 0.9rem;
            }

            .quantity-selector input {
                width: 40px;
                font-size: 0.85rem;
            }

            .add-to-cart-btn {
                padding: 0.6rem 1.2rem;
                font-size: 0.85rem;
            }

            .section-title {
                font-size: 1rem;
                margin-bottom: 0.5rem;
            }

            .product-description {
                font-size: 0.85rem;
                line-height: 1.3;
            }
        }

        /* Styles communs */
        .product-carousel:hover {
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.2);
            transform: translateY(-5px);
        }

        .product-carousel:hover .carousel-item img {
            transform: scale(1.05);
        }

        .thumbnails-container {
            margin-top: 1rem;
            display: flex;
            gap: 10px;
        }

        .thumbnail-item {
            cursor: pointer;
            border: 2px solid transparent;
            transition: all 0.3s ease;
            background-color: #f8f9fa;
            border-radius: 8px;
            overflow: hidden;
        }

        .thumbnail-item:hover {
            transform: translateY(-3px);
        }

        .thumbnail-item.active {
            border-color: var(--primary-color);
        }

        .thumbnail-item img {
            width: 100%;
            height: 80px;
            object-fit: contain;
            transition: transform 0.3s ease;
            background-color: #f8f9fa;
        }

        .thumbnail-item:hover img {
            transform: scale(1.1);
        }

        .product-details {
            padding: 2rem;
            background: white;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }

        .product-details:hover {
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.15);
            transform: translateY(-5px);
        }

        .product-title {
            font-size: 2.5rem;
            font-weight: 700;
            color: var(--primary-color);
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.1);
        }

        .price-container {
            display: flex;
            align-items: center;
            gap: 1rem;
            padding: 1rem;
            background: #f8f9fa;
            border-radius: 12px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.05);
        }

        .original-price {
            text-decoration: line-through;
            color: #dc3545;
            font-size: 1.2rem;
        }

        .sale-price {
            color: #198754;
            font-size: 2rem;
            font-weight: 700;
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.1);
        }

        .current-price {
            color: var(--primary-color);
            font-size: 2rem;
            font-weight: 700;
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.1);
        }

        .discount-badge {
            background: #198754;
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 20px;
            font-weight: 600;
            box-shadow: 0 4px 8px rgba(25, 135, 84, 0.2);
        }

        .section-title {
            color: var(--primary-color);
            font-weight: 600;
            margin-bottom: 1rem;
            position: relative;
            padding-bottom: 0.5rem;
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.1);
        }

        .section-title::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 50px;
            height: 2px;
            background: var(--accent-color);
            box-shadow: 0 2px 4px rgba(231, 76, 60, 0.2);
        }

        .specs-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
        }

        .spec-item {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            padding: 1rem;
            background: #f8f9fa;
            border-radius: 8px;
            transition: all 0.3s ease;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.05);
        }

        .spec-item:hover {
            background: #e9ecef;
            transform: translateY(-3px);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
        }

        .quantity-selector {
            display: flex;
            align-items: center;
            border: 2px solid #e9ecef;
            border-radius: 25px;
            overflow: hidden;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.05);
        }

        .quantity-btn {
            width: 40px;
            height: 40px;
            border: none;
            background: #f8f9fa;
            font-size: 1.2rem;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .quantity-btn:hover {
            background: #e9ecef;
            box-shadow: inset 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .quantity-selector input {
            width: 60px;
            border: none;
            text-align: center;
            font-weight: 600;
        }

        .add-to-cart-btn {
            padding: 1rem 2rem;
            border-radius: 25px;
            font-weight: 600;
            transition: all 0.3s ease;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.1);
        }

        .add-to-cart-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
        }

        .delivery-options {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        .delivery-option {
            display: flex;
            align-items: center;
            gap: 1rem;
            padding: 1rem;
            background: #f8f9fa;
            border-radius: 8px;
            transition: all 0.3s ease;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.05);
        }

        .delivery-option:hover {
            background: #e9ecef;
            transform: translateX(5px);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
        }

        .delivery-option i {
            font-size: 1.5rem;
            color: var(--primary-color);
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

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateX(-20px);
            }

            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        .product-details>* {
            animation: fadeIn 0.5s ease-out forwards;
        }

        .spec-item,
        .delivery-option {
            animation: slideIn 0.5s ease-out forwards;
            opacity: 0;
        }

        .product-details>*:nth-child(1) {
            animation-delay: 0.1s;
        }

        .product-details>*:nth-child(2) {
            animation-delay: 0.2s;
        }

        .product-details>*:nth-child(3) {
            animation-delay: 0.3s;
        }

        .product-details>*:nth-child(4) {
            animation-delay: 0.4s;
        }

        .product-details>*:nth-child(5) {
            animation-delay: 0.5s;
        }

        .product-details>*:nth-child(6) {
            animation-delay: 0.6s;
        }

        .spec-item:nth-child(1) {
            animation-delay: 0.3s;
        }

        .spec-item:nth-child(2) {
            animation-delay: 0.4s;
        }

        .spec-item:nth-child(3) {
            animation-delay: 0.5s;
        }

        .delivery-option:nth-child(1) {
            animation-delay: 0.6s;
        }

        .delivery-option:nth-child(2) {
            animation-delay: 0.7s;
        }

        .main-image {
            transition: transform 0.3s ease;
            background-color: #f8f9fa;
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
                    // Gestion des miniatures
                    const thumbnails = document.querySelectorAll('.thumbnail-item'); <<
                    <<
                    <<
                    <
                    HEAD
                        <<
                        <<
                        <<
                        <
                        Updated upstream
                    thumbnails.forEach(thumb => {
                        thumb.addEventListener('click', function() {
                            thumbnails.forEach(t => t.classList.remove('active'));
                            this.classList.add('active');
                        }); ===
                        ===
                        = ===
                        ===
                        = >>>
                        >>>
                        >
                        4 d18588fce04aef23792227ce91fa87d3cfe4515
                        const mainImages = document.querySelectorAll('.main-image');
                        const carousel = document.querySelector('#productCarousel');
                        const bsCarousel = new bootstrap.Carousel(carousel);

                        // Fonction pour changer l'image principale
                        window.changeMainImage = function(index) {
                            // Mettre à jour le carousel
                            bsCarousel.to(index); <<
                            <<
                            <<
                            <
                            HEAD

                                ===
                                ===
                                =

                                >>>
                                >>>
                                >
                                4 d18588fce04aef23792227ce91fa87d3cfe4515
                            // Mettre à jour les miniatures
                            thumbnails.forEach(t => t.classList.remove('active'));
                            thumbnails[index].classList.add('active');
                        };

                        // Mettre à jour la miniature active lors du changement de slide
                        carousel.addEventListener('slide.bs.carousel', function(e) {
                            thumbnails.forEach(t => t.classList.remove('active'));
                            thumbnails[e.to].classList.add('active'); <<
                            <<
                            <<
                            <
                            HEAD
                                >>>
                                >>>
                                >
                                Stashed changes ===
                                ===
                                = >>>
                                >>>
                                >
                                4 d18588fce04aef23792227ce91fa87d3cfe4515
                        });

                        // Gestion du sélecteur de quantité
                        const minusBtn = document.querySelector('.minus');
                        const plusBtn = document.querySelector('.plus');
                        const quantityInput = document.querySelector('#quantity');

                        minusBtn.addEventListener('click', () => {
                            let value = parseInt(quantityInput.value);
                            if (value > 1) {
                                quantityInput.value = value - 1;
                                minusBtn.style.transform = 'scale(0.95)';
                                setTimeout(() => minusBtn.style.transform = 'scale(1)', 100);
                            }
                        });

                        plusBtn.addEventListener('click', () => {
                            let value = parseInt(quantityInput.value);
                            let max = parseInt(quantityInput.getAttribute('max'));
                            if (value < max) {
                                quantityInput.value = value + 1;
                                plusBtn.style.transform = 'scale(0.95)';
                                setTimeout(() => plusBtn.style.transform = 'scale(1)', 100);
                            }
                        });

                        // Animation au scroll avec effet de parallaxe
                        const observer = new IntersectionObserver((entries) => {
                            entries.forEach(entry => {
                                if (entry.isIntersecting) {
                                    entry.target.classList.add('visible');
                                    if (entry.target.classList.contains('product-carousel')) {
                                        entry.target.style.transform = 'translateY(0)';
                                    }
                                }
                            });
                        }, {
                            threshold: 0.1
                        });

                        document.querySelectorAll('.spec-item, .delivery-option, .product-carousel').forEach((
                            el) => {
                            observer.observe(el);
                        });

                        // Effet de parallaxe sur le carousel
                        window.addEventListener('scroll', () => {
                            const carousel = document.querySelector('.product-carousel');
                            const scrolled = window.pageYOffset;
                            if (carousel) {
                                carousel.style.transform = `translateY(${scrolled * 0.1}px)`;
                            }
                        });
                    });
    </script>
@endsection
