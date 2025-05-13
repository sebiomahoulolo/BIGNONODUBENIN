@extends('layouts.app')

@section('content')
<!-- Hero Section -->
<section class="hero-section">
    <div class="container text-center">
        <h1 class="display-4 mb-4">Bienvenue sur Bignon du Bénin</h1>
        <p class="lead mb-4">Votre destination pour des meubles de qualité au Bénin</p>
        <a href="{{ route('pages.products') }}" class="btn btn-primary btn-lg">Découvrir nos produits</a>
    </div>
</section>

<!-- Featured Categories -->
<section class="py-5">
    <div class="container">
        <h2 class="text-center mb-5">Nos Catégories Populaires</h2>
        <div class="row g-4">
            <div class="col-md-4">
                <a href="{{ route('pages.chambres') }}" class="text-decoration-none">
                    <div class="card h-100 border-0 shadow-sm">
                        <img src="/images/categories/chambres.jpg" class="card-img-top" alt="Chambres">
                        <div class="card-body text-center">
                            <h3 class="h5 text-dark">Chambres</h3>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-4">
                <a href="{{ route('pages.salons') }}" class="text-decoration-none">
                    <div class="card h-100 border-0 shadow-sm">
                        <img src="/images/categories/salons.jpg" class="card-img-top" alt="Salons">
                        <div class="card-body text-center">
                            <h3 class="h5 text-dark">Salons</h3>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-4">
                <a href="{{ route('pages.cuisines') }}" class="text-decoration-none">
                    <div class="card h-100 border-0 shadow-sm">
                        <img src="/images/categories/cuisines.jpg" class="card-img-top" alt="Cuisines">
                        <div class="card-body text-center">
                            <h3 class="h5 text-dark">Cuisines</h3>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Featured Products -->
<section class="py-5 bg-light">
    <div class="container">
        <h2 class="text-center mb-5">Nos Produits en Vedette</h2>
        <div class="row g-4">
            <div class="col-md-3">
                <div class="card h-100 border-0 shadow-sm">
                    <img src="/images/products/lit-1.jpg" class="card-img-top" alt="Lit">
                    <div class="card-body">
                        <h3 class="h6">Lit Moderne</h3>
                        <p class="text-muted">À partir de 150,000 FCFA</p>
                        <a href="{{ route('pages.lits') }}" class="btn btn-outline-primary btn-sm">Voir plus</a>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card h-100 border-0 shadow-sm">
                    <img src="/images/products/canape-1.jpg" class="card-img-top" alt="Canapé">
                    <div class="card-body">
                        <h3 class="h6">Canapé d'Angle</h3>
                        <p class="text-muted">À partir de 250,000 FCFA</p>
                        <a href="{{ route('pages.canapes') }}" class="btn btn-outline-primary btn-sm">Voir plus</a>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card h-100 border-0 shadow-sm">
                    <img src="/images/products/table-1.jpg" class="card-img-top" alt="Table">
                    <div class="card-body">
                        <h3 class="h6">Table à Manger</h3>
                        <p class="text-muted">À partir de 180,000 FCFA</p>
                        <a href="{{ route('pages.tables') }}" class="btn btn-outline-primary btn-sm">Voir plus</a>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card h-100 border-0 shadow-sm">
                    <img src="/images/products/armoire-1.jpg" class="card-img-top" alt="Armoire">
                    <div class="card-body">
                        <h3 class="h6">Armoire Moderne</h3>
                        <p class="text-muted">À partir de 200,000 FCFA</p>
                        <a href="{{ route('pages.armoires') }}" class="btn btn-outline-primary btn-sm">Voir plus</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Why Choose Us -->
<section class="py-5">
    <div class="container">
        <h2 class="text-center mb-5">Pourquoi Nous Choisir ?</h2>
        <div class="row g-4">
            <div class="col-md-4">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-body text-center p-4">
                        <i class="bi bi-truck display-4 text-primary mb-3"></i>
                        <h3 class="h5">Livraison Rapide</h3>
                        <p class="text-muted">Livraison à domicile partout au Bénin</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-body text-center p-4">
                        <i class="bi bi-shield-check display-4 text-primary mb-3"></i>
                        <h3 class="h5">Qualité Garantie</h3>
                        <p class="text-muted">Des meubles de qualité supérieure</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-body text-center p-4">
                        <i class="bi bi-headset display-4 text-primary mb-3"></i>
                        <h3 class="h5">Support 24/7</h3>
                        <p class="text-muted">Une équipe à votre écoute</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Newsletter -->
<section class="py-5 bg-primary text-white">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 text-center">
                <h2 class="mb-4">Restez Informé</h2>
                <p class="mb-4">Inscrivez-vous à notre newsletter pour recevoir nos dernières offres et nouveautés.</p>
                <form class="row g-3 justify-content-center">
                    <div class="col-md-8">
                        <input type="email" class="form-control form-control-lg" placeholder="Votre adresse email">
                    </div>
                    <div class="col-md-4">
                        <button type="submit" class="btn btn-light btn-lg w-100">S'inscrire</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection 