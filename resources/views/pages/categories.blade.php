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
            <!-- Canapés -->
            <div class="col-md-6 col-lg-4">
                <div class="category-card">
                    <img src="{{ asset('images/canape1.webp') }}" alt="Canapés">
                    <div class="category-overlay">
                        <h4>Canapés</h4>
                        <p>Confort et élégance pour votre salon</p>
                        <a href="#" class="btn btn-light mt-3">Découvrir</a>
                    </div>
                </div>
            </div>

            <!-- Lits -->
            <div class="col-md-6 col-lg-4">
                <div class="category-card">
                    <img src="{{ asset('images/canape1.webp') }}" alt="Lits">
                    <div class="category-overlay">
                        <h4>Lits</h4>
                        <p>Un sommeil de qualité garanti</p>
                        <a href="#" class="btn btn-light mt-3">Découvrir</a>
                    </div>
                </div>
            </div>

            <!-- Tables -->
            <div class="col-md-6 col-lg-4">
                <div class="category-card">
                    <img src="{{ asset('images/canape1.webp') }}" alt="Tables">
                    <div class="category-overlay">
                        <h4>Tables</h4>
                        <p>Style et fonctionnalité</p>
                        <a href="#" class="btn btn-light mt-3">Découvrir</a>
                    </div>
                </div>
            </div>

            <!-- Chaises -->
            <div class="col-md-6 col-lg-4">
                <div class="category-card">
                    <img src="{{ asset('images/canape1.webp') }}" alt="Chaises">
                    <div class="category-overlay">
                        <h4>Chaises</h4>
                        <p>Design moderne et confortable</p>
                        <a href="#" class="btn btn-light mt-3">Découvrir</a>
                    </div>
                </div>
            </div>

            <!-- Armoires -->
            <div class="col-md-6 col-lg-4">
                <div class="category-card">
                    <img src="{{ asset('images/canape1.webp') }}" alt="Armoires">
                    <div class="category-overlay">
                        <h4>Armoires</h4>
                        <p>Rangement élégant et pratique</p>
                        <a href="#" class="btn btn-light mt-3">Découvrir</a>
                    </div>
                </div>
            </div>

            <!-- Meubles TV -->
            <div class="col-md-6 col-lg-4">
                <div class="category-card">
                    <img src="{{ asset('images/canape1.webp') }}" alt="Meubles TV">
                    <div class="category-overlay">
                        <h4>Meubles TV</h4>
                        <p>Mettez en valeur votre salon</p>
                        <a href="#" class="btn btn-light mt-3">Découvrir</a>
                    </div>
                </div>
            </div>
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