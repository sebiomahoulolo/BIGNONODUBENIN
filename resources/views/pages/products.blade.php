@extends('layouts.app')

@section('content')
<!-- Hero Section -->
<section class="bg-light py-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 mx-auto text-center">
                <h1 class="display-4 mb-4">Nos Produits</h1>
                <p class="lead text-muted">Découvrez notre large gamme de meubles de qualité.</p>
            </div>
        </div>
    </div>
</section>

<!-- Filters -->
<section class="py-4 bg-white border-bottom">
    <div class="container">
        <div class="row g-3">
            <div class="col-md-3">
                <select class="form-select">
                    <option selected>Toutes les catégories</option>
                    <option>Lits</option>
                    <option>Canapés</option>
                    <option>Tables</option>
                    <option>Chaises</option>
                    <option>Armoires</option>
                </select>
            </div>
            <div class="col-md-3">
                <select class="form-select">
                    <option selected>Prix</option>
                    <option>0 - 100,000 FCFA</option>
                    <option>100,000 - 200,000 FCFA</option>
                    <option>200,000 - 300,000 FCFA</option>
                    <option>300,000+ FCFA</option>
                </select>
            </div>
            <div class="col-md-3">
                <select class="form-select">
                    <option selected>Trier par</option>
                    <option>Prix croissant</option>
                    <option>Prix décroissant</option>
                    <option>Plus récents</option>
                    <option>Plus populaires</option>
                </select>
            </div>
            <div class="col-md-3">
                <div class="input-group">
                    <input type="text" class="form-control" placeholder="Rechercher...">
                    <button class="btn btn-primary">
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
        <div class="row g-4">
            <!-- Product Card -->
            <div class="col-md-4 col-lg-3">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="position-relative">
                        <img src="/images/products/lit-1.jpg" class="card-img-top" alt="Lit">
                        <div class="position-absolute top-0 end-0 p-2">
                            <button class="btn btn-light btn-sm rounded-circle">
                                <i class="bi bi-heart"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <h3 class="h6">Lit Moderne</h3>
                        <p class="text-muted mb-2">Chambre</p>
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="h5 mb-0">150,000 FCFA</span>
                            <button class="btn btn-primary btn-sm">
                                <i class="bi bi-cart-plus"></i> Ajouter
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Product Card -->
            <div class="col-md-4 col-lg-3">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="position-relative">
                        <img src="/images/products/canape-1.jpg" class="card-img-top" alt="Canapé">
                        <div class="position-absolute top-0 end-0 p-2">
                            <button class="btn btn-light btn-sm rounded-circle">
                                <i class="bi bi-heart"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <h3 class="h6">Canapé d'Angle</h3>
                        <p class="text-muted mb-2">Salon</p>
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="h5 mb-0">250,000 FCFA</span>
                            <button class="btn btn-primary btn-sm">
                                <i class="bi bi-cart-plus"></i> Ajouter
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Product Card -->
            <div class="col-md-4 col-lg-3">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="position-relative">
                        <img src="/images/products/table-1.jpg" class="card-img-top" alt="Table">
                        <div class="position-absolute top-0 end-0 p-2">
                            <button class="btn btn-light btn-sm rounded-circle">
                                <i class="bi bi-heart"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <h3 class="h6">Table à Manger</h3>
                        <p class="text-muted mb-2">Salle à manger</p>
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="h5 mb-0">180,000 FCFA</span>
                            <button class="btn btn-primary btn-sm">
                                <i class="bi bi-cart-plus"></i> Ajouter
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Product Card -->
            <div class="col-md-4 col-lg-3">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="position-relative">
                        <img src="/images/products/armoire-1.jpg" class="card-img-top" alt="Armoire">
                        <div class="position-absolute top-0 end-0 p-2">
                            <button class="btn btn-light btn-sm rounded-circle">
                                <i class="bi bi-heart"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <h3 class="h6">Armoire Moderne</h3>
                        <p class="text-muted mb-2">Chambre</p>
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="h5 mb-0">200,000 FCFA</span>
                            <button class="btn btn-primary btn-sm">
                                <i class="bi bi-cart-plus"></i> Ajouter
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pagination -->
        <div class="row mt-5">
            <div class="col-12">
                <nav aria-label="Page navigation">
                    <ul class="pagination justify-content-center">
                        <li class="page-item disabled">
                            <a class="page-link" href="#" tabindex="-1">Précédent</a>
                        </li>
                        <li class="page-item active"><a class="page-link" href="#">1</a></li>
                        <li class="page-item"><a class="page-link" href="#">2</a></li>
                        <li class="page-item"><a class="page-link" href="#">3</a></li>
                        <li class="page-item">
                            <a class="page-link" href="#">Suivant</a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
</section>

<!-- Newsletter -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8 text-center">
                <h2 class="mb-4">Restez Informé</h2>
                <p class="text-muted mb-4">Inscrivez-vous à notre newsletter pour recevoir nos dernières offres et nouveautés.</p>
                <form class="row g-3 justify-content-center">
                    <div class="col-md-8">
                        <input type="email" class="form-control form-control-lg" placeholder="Votre adresse email">
                    </div>
                    <div class="col-md-4">
                        <button type="submit" class="btn btn-primary btn-lg w-100">S'inscrire</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection
