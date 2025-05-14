@extends('layouts.app')

@section('content')
<!-- Hero Section -->
<section class="hero-section" style="background-image: url('{{ asset('images/categories-hero.jpg') }}')">
    <div class="hero-content">
        <h1 class="display-4 fw-bold mb-4">Nos Catégories</h1>
        <p class="lead">Découvrez notre large gamme de meubles pour tous vos besoins</p>
    </div>
</section>

<!-- Catégories principales -->
<section class="py-5">
    <div class="container">
        <div class="row g-4">
            @forelse($categories as $category)
            <div class="col-md-6 col-lg-4">
                <div class="category-card">
                    <img src="{{ $category->image ? asset('storage/' . $category->image) : asset('images/canape1.webp') }}" alt="{{ $category->name }}">
                    <div class="category-overlay">
                        <h4>{{ $category->name }}</h4>
                        <p>{{ $category->description }}</p>
                        <a href="{{ route('pages.category.show', $category->slug) }}" class="btn btn-light mt-3">Découvrir</a>
                    </div>
                </div>

                <!-- Produits de la catégorie -->
                @if($category->products->isNotEmpty())
                <div class="category-products mt-3">
                    <div class="row g-3">
                        @foreach($category->products as $product)
                        <div class="col-4">
                            <div class="product-thumbnail">
                                <a href="{{ route('pages.product.detail', $product->id) }}">
                                    <img src="{{ $product->image ? asset('storage/' . $product->image) : asset('images/no-image.jpg') }}" 
                                         alt="{{ $product->name }}"
                                         class="img-fluid">
                                </a>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif
            </div>
            @empty
            <div class="col-12">
                <div class="alert alert-info">
                    Aucune catégorie disponible pour le moment.
                </div>
            </div>
            @endforelse
        </div>
    </div>
</section>

<!-- Pourquoi choisir nos catégories -->
<section class="py-5 bg-light">
    <div class="container">
        <h2 class="text-center mb-5">Pourquoi choisir nos catégories ?</h2>
        <div class="row g-4">
            <div class="col-md-4">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <h4>Qualité Garantie</h4>
                    <p>Tous nos meubles sont fabriqués avec des matériaux de première qualité pour une durabilité optimale.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-palette"></i>
                    </div>
                    <h4>Design Moderne</h4>
                    <p>Des designs contemporains qui s'adaptent à tous les styles d'intérieur.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-truck"></i>
                    </div>
                    <h4>Livraison Rapide</h4>
                    <p>Service de livraison express dans tout le Bénin pour votre confort.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Call to Action -->
<section class="py-5">
    <div class="container text-center">
        <h2 class="mb-4">Besoin d'aide pour choisir ?</h2>
        <p class="lead mb-4">Notre équipe d'experts est là pour vous conseiller dans le choix de vos meubles.</p>
        <a href="{{ route('pages.contact') }}" class="btn btn-primary btn-lg">Contactez-nous</a>
    </div>
</section>
@endsection

@section('styles')
<style>
.category-card {
    position: relative;
    overflow: hidden;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    transition: transform 0.3s ease;
}

.category-card:hover {
    transform: translateY(-5px);
}

.category-card img {
    width: 100%;
    height: 250px;
    object-fit: cover;
}

.category-overlay {
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    background: linear-gradient(to top, rgba(0,0,0,0.8), transparent);
    padding: 20px;
    color: white;
}

.product-thumbnail {
    border-radius: 4px;
    overflow: hidden;
    box-shadow: 0 1px 3px rgba(0,0,0,0.1);
}

.product-thumbnail img {
    width: 100%;
    height: 80px;
    object-fit: cover;
}

.feature-card {
    text-align: center;
    padding: 20px;
    background: white;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.feature-icon {
    font-size: 2rem;
    color: #007bff;
    margin-bottom: 15px;
}
</style>
@endsection

@section('scripts')
<script>
    // Animation au scroll pour les cartes de catégories
    function animateOnScroll() {
        const elements = document.querySelectorAll('.category-card');
        elements.forEach(element => {
            const elementTop = element.getBoundingClientRect().top;
            const elementBottom = element.getBoundingClientRect().bottom;
            const isVisible = (elementTop < window.innerHeight) && (elementBottom >= 0);
            if (isVisible) {
                element.classList.add('visible');
            }
        });
    }

    // Event listener pour l'animation au scroll
    window.addEventListener('scroll', animateOnScroll);
    document.addEventListener('DOMContentLoaded', animateOnScroll);
</script>
@endsection 