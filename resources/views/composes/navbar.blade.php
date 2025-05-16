<!-- Panier flottant -->
<div class="floating-cart">
    <div class="cart-icon">
        <i class="fas fa-shopping-cart fa-2x"></i>
        <span class="cart-count">0</span>
    </div>
    <div class="cart-total">
        <span>0 FCFA</span>
    </div>
</div>

<!-- Menu mobile -->
<div class="mobile-menu">
    <div class="mobile-menu-header">
        <h3>Menu</h3>
        <span class="mobile-menu-close">&times;</span>
    </div>
    <ul class="mobile-menu-nav">
    
        <li class="nav-item">
            <a class="nav-link" href="{{ route('pages.products') }}">Produits</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('pages.categories') }}">Catégories</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('pages.about') }}">À propos</a>
        </li>
         <li class="nav-item">
                        <a class="nav-link" href="#" data-bs-toggle="modal"
                            data-bs-target="#DemanderDevis">Demandez un Devis</a>
                    </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('pages.contact') }}">Contact</a>
        </li>
    </ul>
</div>

{{-- HEADER  --}}
<header class="bg-light position-fixed top-0 w-100" style="z-index: 9999;">
    <nav class="navbar navbar-expand-lg navbar-light">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center gap-3" href="#">
                <img src="{{ asset('images/logo_bignon.png') }}" alt="Logo Bignon">
                <h1 class="fs-4 d-none d-md-block text-black mb-0">BIGNON DU BENIN</h1>
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                   
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('pages.products') }}">Produits</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('pages.categories') }}">Catégories</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('pages.about') }}">À propos</a>
                    </li>
                     <li class="nav-item">
                        <a class="nav-link" href="#" data-bs-toggle="modal"
                            data-bs-target="#DemanderDevis">Demandez un Devis</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('pages.contact') }}">Contact</a>
                    </li>
                    <!-- Panier (badge) -->
                    <li class="position-relative px-2" data-bs-toggle="offcanvas" data-bs-target="#staticBackdrop"
                        aria-controls="staticBackdrop">
                        <a href="#" class="text-danger px-3 position-relative d-inline-block">
                            <i class="fa-solid fa-cart-plus fa-lg text-secondary fs-3"></i>
                            <span id="cart-badge"
                                class="position-absolute top-25 start-75 translate-middle badge rounded-pill bg-danger font-bold">
                                0
                            </span>
                        </a>
                    </li>
                </ul>

                </div>
            </div>
        </div>
    </nav>

 

<!-- Modal positionné à droite -->
<div class="offcanvas offcanvas-end" data-bs-backdrop="static" tabindex="-1" id="staticBackdrop"
    aria-labelledby="staticBackdropLabel">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="staticBackdropLabel">Panier</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Fermer"></button>
    </div>

    <div class="offcanvas-body">
        <form id="product-form" action="{ route('produits.valider') }" method="POST">
            @csrf
           
            <!-- Tableau du panier -->
            <div class="table-responsive">
                <table class="table table-striped align-middle">
                    <thead>
                        <tr>
                            <th class="bg-secondary-subtle" style="font-size: 12px">Produit</th>
                            <th class="bg-secondary-subtle" style="font-size: 12px">Quantité</th>
                            <th class="bg-secondary-subtle" style="font-size: 12px">Prix</th>
                            <th class="bg-secondary-subtle" style="font-size: 12px">Montant</th>
                            <th class="bg-secondary-subtle" style="font-size: 12px"></th>
                        </tr>
                    </thead>
                    <tbody id="cart-body">
                        <tr id="empty-row">
                            <td colspan="6" style="font-size: 12px" class="text-center text-muted">
                                Aucun produit ajouté pour l’instant.
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Montant total -->
            <div class="mt-4">
                <p class="fw-bold mb-1">Total : <span id="total-amount">0 FCFA</span></p>

                <!-- Code promo (affiché seulement si panier non vide) -->
                <div class="mb-3" id="promo-section" style="display: none;">
                    <label for="promo-code" class="form-label">Utiliser un code promo : PROMO5</label>
                    <div class="input-group">
                        <input type="text" id="promo-code" class="form-control" placeholder="Ex : PROMO5">
                        <button type="button" class="btn btn-outline" onclick="applyPromo()" style="color:white  ;  background-color: #366ba2">Appliquer</button>
                    </div>
                    <div id="promo-message" class="form-text text-success mt-1" style="display: none;">
                        ✅ Code appliqué : réduction de 5%
                    </div>
                </div>

                <!-- Montant après réduction -->
                <p class="fw-bold">Total à payer : <span id="discounted-total">0 FCFA</span></p>
            </div>

            <!-- ✅ Bouton valider -->
            <div class="d-flex justify-content-end mt-3" id="validate-button" style="display: none;">
                <button type="submit" class="btn btn-lg  rounded-5" style="color:white  ;  background-color: #366ba2" >Valider</button>
            </div>
        </form>
    </div>
</div>





</header>
