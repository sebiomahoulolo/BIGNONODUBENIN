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
<header class="bg-light">
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
                <div class="d-flex align-items-center">
                    @auth
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                {{ Auth::user()->name }}
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                @if (Auth::user()->is_admin)
                                    <li>
                                        <a class="dropdown-item" href="{{ route('admin.dashboard') }}">
                                            <i class="fas fa-tachometer-alt"></i> Tableau de bord
                                        </a>
                                    </li>
                                    <li>
                                        <hr class="dropdown-divider">
                                    </li>
                                @endif
                                <li>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="dropdown-item">
                                            <i class="fas fa-sign-out-alt"></i> Déconnexion
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @else

                    @endauth
                </div>
            </div>
        </div>
    </nav>

    {{-- Modal Demandez un devis  --}}
    <div class="modal fade" id="DemanderDevis" tabindex="-1" aria-labelledby="DemanderDevis" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-sm-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="DemanderDevisLabel">Demandez un devis</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="row">
                            {{-- Nom  --}}
                            <div class="mb-3 col-12 col-lg-6">
                                <label for="name" class="col-form-label">Nom</label>
                                <input type="text" class="form-control" id="name">
                            </div>

                            {{-- Email  --}}
                            <div class="mb-3 col-12 col-lg-6">
                                <label for="email" class="col-form-label">Adresse E-mail</label>
                                <input type="email" class="form-control" id="email">
                            </div>

                            {{-- Téléphone  --}}
                            <div class="mb-3 col-12 col-lg-6">
                                <label for="phone" class="col-form-label me-2">Numéro de téléphone</label>
                                <div class=" d-flex align-items-center gap-2">
                                    <select class="form-select w-25" name="indicatif" id="indicatif" required>
                                        <option value="+229">🇧🇯 (+229)</option>
                                        <option value="+225">🇨🇮 (+225)</option>
                                        <option value="+226">🇧🇫 (+226)</option>
                                        <option value="+228">🇹🇬 (+228)</option>
                                        <option value="+237">🇨🇲 (+237)</option>
                                        <option value="+33">🇫🇷 (+33)</option>
                                        <option value="+1">🇺🇸 (+1)</option>
                                        <option value="+44">🇬🇧 (+44)</option>
                                        <option value="+49">🇩🇪 (+49)</option>
                                        <option value="+34">🇪🇸 (+34)</option>
                                        <option value="+39">🇮🇹 (+39)</option>
                                        <option value="+212">🇲🇦 (+212)</option>
                                        <option value="+216">🇹🇳 (+216)</option>
                                        <option value="+213">🇩🇿 (+213)</option>
                                    </select>
                                    <input type="phone" class="form-control w-75" id="phone2" placeholder="">
                                </div>
                            </div>

                            {{-- Ville  --}}
                            <div class="mb-3 col-12 col-lg-6">
                                <label for="city" class="col-form-label">Ville</label>
                                <input type="email" class="form-control" id="city">
                            </div>

                            {{-- Produit  --}}
                            <div class="mb-3 col-12 col-lg-6">
                                <label for="product" class="col-form-label">Produit</label>
                                <select class="form-select" id="product" name="product">
                                    <option value="">Selectionner un produit</option>
                                    @foreach (getProducts() as $product)
                                        <option value="{{ $product->id }}">{{ $product->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- Materiel  --}}
                            <div class="mb-3 col-12 col-lg-6">
                                <label for="material" class="col-form-label">Matériel</label>
                                <input type="text" class="form-control" id="material">
                            </div>

                            {{-- Delai de livraison  --}}
                            <div class="mb-3 col-12 col-lg-12">
                                <label for="delai_livraison" class="col-form-label">Délai de livraison</label>
                                <input type="number" class="form-control" id="delai_livraison"
                                    placeholder="ex: 5 jours">
                            </div>

                            {{-- Description  --}}
                            <div class="mb-3 col-12 col-lg-12">
                                <label for="message-text" class="col-form-label">Description</label>
                                <textarea class="form-control" id="message-text"></textarea>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="button" class="btn btn-primary">Envoyer</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal positionné à droite -->
    <div class="offcanvas offcanvas-end" data-bs-backdrop="static" tabindex="-1" id="staticBackdrop"
        aria-labelledby="staticBackdropLabel">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="staticBackdropLabel">Panier</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <div class=" table-responsive">
                <table class="table table-striped ">
                    <thead>
                        <tr>
                            <th class=" bg-secondary-subtle" style=" font-size: 12px">Produit</th>
                            <th class=" bg-secondary-subtle" style=" font-size: 12px">Quantité</th>
                            <th class=" bg-secondary-subtle" style=" font-size: 12px">Prix</th>
                            <th class=" bg-secondary-subtle" style=" font-size: 12px">Montant</th>
                            <th class=" bg-secondary-subtle" style=" font-size: 12px"></th>
                        </tr>
                    </thead>
                    <tbody id="cart-body">
                        <tr id="empty-row">
                            <td colspan="5" style=" font-size: 12px" class="text-center text-muted">
                                Aucun produit ajouté pour l’instant.
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>


</header>