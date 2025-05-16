@extends('layouts.app')

@section('content')
   <!-- Section Détail du produit -->
<!-- Section Détail du produit -->
<div class="container py-5">
    <div class="row">
        <!-- Carrousel d'images (modifié pour n'afficher que l'image principale statique) -->
        <div class="col-lg-6 col-md-12 mb-4">
            <div class="product-carousel">
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <img id="mainProductImage" src="{{ asset('storage/' . $product->images[0]) }}" class="d-block w-100 main-image rounded" alt="{{ $product->nombre_places }}">
                    </div>
                </div>
            </div>

            <!-- Miniatures -->
            <div class="row mt-3 thumbnails-container">
                @foreach ($product->images as $key => $image)
                    <div class="col-3">
                        <div class="thumbnail-item {{ $key === 0 ? 'active' : '' }}">
                            <img src="{{ asset('storage/' . $image) }}" class="img-fluid rounded thumbnail-image" alt="{{ $product->nombre_places }}" onclick="swapImages(this)">
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Détails du produit -->
        <div class="col-lg-6 col-md-12">
            <div class="product-details">
                <h1 class="product-title mb-3">
                    <span class="badge "style="color:rgb(227, 236, 247)  ;  background-color: #366ba2">{{ $product->category->name }}</span>
                </h1>

                <div class="price-container mb-4">
                    @if ($product->sale_price)
                        <span class="original-price text-muted text-decoration-line-through me-2" >{{ number_format($product->price, 0, ',', ' ') }} FCFA</span>
                        <span class="sale-price fw-bold text-success me-2" >{{ number_format($product->sale_price, 0, ',', ' ') }} FCFA</span>
                        <span class="discount-badge badge bg-danger">{{ $product->discount_percentage }}%</span>
                    @else
                        <span class="current-price fw-bold text-primary">{{ number_format($product->price, 0, ',', ' ') }} FCFA</span>
                    @endif
                </div>

                <div class="description-container mb-4">
                    <h5 class="fw-bold">Description</h5>
                    <p>{{ $product->description }}</p>
                </div>

                <div class="specifications-container mb-4">
                    <h5 class="fw-bold">Caractéristiques</h5>
                    <ul class="list-unstyled">
                        <li style="color: #ff2c2c"><i class="bi bi-people me-2" style="color: #ff2c2c"></i>Nombre de places : {{ $product->nombre_places }}</li>
                        <li style="color:#ff2c2c"><i class="bi bi-box me-2 "style="color: #ff2c2c"></i>Matière : {{ $product->matiere }}</li>
                        <li style="color:#ff2c2c"><i class="bi bi-check-circle me-2"style="color: #ff2c2c"></i>Stock : {{ $product->stock }} unités</li>
                    </ul>
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

                                     <!-- Mini-modal de partage -->
                                    <div class="share-options d-none start-0 mb-2 p-2 bg-white border rounded-4 shadow z-5"
                                        style="min-width: 250px;">
                                        <div class="d-flex flex-wrap gap-2 justify-content-center">
                                            <!-- WhatsApp -->
                                            <a href="https://wa.me/?text={{ $shareText }}{{ $currentUrl }}"
                                                target="_blank" class="">
                                                <i class="fa-brands fa-whatsapp fs-4 text-success"></i>
                                            </a>

                                            <!-- Facebook -->
                                            <a href="https://www.facebook.com/sharer/sharer.php?u={{ $currentUrl }}"
                                                target="_blank" class="">
                                                <i class="fa-brands fa-facebook fs-4"></i>
                                            </a>

                                            <!-- LinkedIn -->
                                            <a href="https://www.linkedin.com/sharing/share-offsite/?url={{ $currentUrl }}"
                                                target="_blank" class="">
                                                <i class="fa-brands fa-linkedin fs-4 text-info"></i>


                                            </a>
                                        </div>
                                    </div>

                                    <!-- Bouton Partager -->
                                    <button type="button" class="btn  btn-lg w-100 add-to-cart-btn"
                                        onclick="toggleShareOptions(this)" style="color:rgb(227, 236, 247)  ;  background-color: #366ba2   ">
                                        <i class="bi bi-cart-plus"></i> Partager
                                    </button>


                                </div>
                            </div>


                           <div class="col">
    <button type="button" class="btn  btn-lg w-100 add-to-cart-btn add-to-cart"
        data-id="{{ $product->id }}" 
        data-name="{{ $product->category->name }}"
        data-price="{{ $product->sale_price }}"
data-img="{{ asset('storage/' . $product->images[0]) }}"
 style="color:rgb(227, 236, 247)  ;  background-color: #366ba2  ">
        <i class="bi bi-cart-plus"></i> Ajouter au panier
    </button>
</div>
<script>
    document.querySelectorAll('.add-to-cart-btn').forEach(button => {
        button.addEventListener('click', function () {
            const name = this.getAttribute('data-name');
            const price = this.getAttribute('data-price');
            const image = document.getElementById('mainProductImage').src;

            // Exemple d'action : afficher dans la console
            console.log('Produit ajouté au panier :');
            console.log('Nom :', name);
            console.log('Prix :', price);
            console.log('Image principale :', image);

          
        });
    });
</script>

                        </div>
                    </form>

              
                
            </div>
        </div>
    </div>
</div>

<!-- Script JS pour le swap des images -->
<script>
    function swapImages(thumbnailImg) {
        const mainImage = document.getElementById('mainProductImage');
        const tempSrc = mainImage.src;
        mainImage.src = thumbnailImg.src;
        thumbnailImg.src = tempSrc;
    }
</script>

<!-- Style pour surligner les miniatures (facultatif mais recommandé) -->
<style>
    .thumbnail-item img {
        cursor: pointer;
        border: 2px solid transparent;
        transition: border 0.3s;
    }

    .thumbnail-item img:hover {
        border: 2px solid #366ba2;
    }
</style>




   <!-- Section Produits similaires -->
<section class="produits-similaires-section my-5">
    <div class="container p-4 border border-primary rounded-4 shadow-sm">
        <h3 class=" mb-4 text-center">Produits similaires</h3>

        <div class="row g-4">
            @foreach($relatedProducts as $product)
                <div class="col-lg-3 col-md-4 col-sm-6 col-12">
                    <div class="card h-100 border-0 shadow-md product-card">
                        <div class="position-relative">
                            @if($product->images && count($product->images) > 0)
                                <img src="{{ asset('storage/' . $product->images[0]) }}" class="card-img-top rounded-top" alt="{{ $product->name }}">
                            @else
                                <img src="{{ asset('images/no-image.jpg') }}" class="card-img-top rounded-top" alt="{{ $product->name }}">
                            @endif

                            <div class="product-overlay position-absolute top-0 end-0 m-2">
                                <a href="{{ route('pages.product.detail', $product->id) }}" class="btn btn-light btn-sm shadow-sm">
                                    <i class="bi bi-eye"></i>
                                </a>
                            </div>
                        </div>

                        <div class="card-body d-flex flex-column">
                            <span class="badge  mb-2" style="color:white  ;  background-color: #366ba2">{{ $product->category->name }}</span>

                            <div class="mb-2">
                                @if($product->sale_price)
                                    <span class="text-success fw-bold">{{ number_format($product->sale_price, 0, ',', ' ') }} FCFA</span>
                                @else
                                    <span class="text-primary fw-bold">{{ number_format($product->price, 0, ',', ' ') }} FCFA</span>
                                @endif
                            </div>

                            <p class="text-muted small flex-grow-1">{{ Str::limit($product->description, 100) }}</p>

                            <div class="d-flex justify-content-between mt-3">
                                <a href="{{ route('pages.product.detail', $product->id) }}" class="btn btn-outline btn-sm" style="color:white  ;  background-color: #366ba2">
                                    <i class="bi bi-eye"></i> Détails
                                </a>
                                <a href="{{ route('pages.product.detail', $product->id) }}" class="btn btn btn-sm" style="color:white  ;  background-color: #366ba2">
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
