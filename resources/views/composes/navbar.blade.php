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
            <a class="nav-link" href="{{ route('pages.products') }}"><b>Produits</b></a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('pages.categories') }}"><b>Catégories</b></a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('pages.about') }}"><b>À propos</b></a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#" data-bs-toggle="modal" data-bs-target="#DemanderDevis"><b>Demandez un
                    Devis</b></a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('pages.contact') }}"><b>Contact</b></a>
        </li>
    </ul>
</div>

{{-- HEADER  grand ecran --}}
<hr>
<header class="bg-light position-fixed top-0 w-100" style="z-index: 9999;">


    <!-- Bannière (Visible uniquement sur les grands écrans) -->
    <div class="banner d-none d-md-flex justify-content-between align-items-center px-4 py-2 border-2 border-bottom border-t-white"
        style="color:white  ;  background-color:rgb(45, 85, 128)">
        <div class="info d-flex gap-4 align-items-center  small">
            <span><i class="bi bi-geo-alt-fill me-1"></i> Cotonou, Cadjèhoun, à côté de la pharmacie Cadjèhoun</span>
            <span><i class="bi bi-geo-alt-fill me-1"></i> Porto-Novo, Akonaboè, à côté de la bibliothèque
                nationale</span>
            <span><i class="bi bi-telephone-fill me-1"></i> 24h/7j (+229) 01 97 06 93 05</span>
            <span id="date-time" class="date-time"><i class="bi bi-clock me-1"></i> Chargement...</span>
        </div>
        <div class="social-icons d-flex gap-3">
            <a href="https://web.facebook.com/bignon00229?mibextid=ZbWKwL&_rdc=1&_rdr#" target="_blank"
                class="text-dark"><i class="bi bi-facebook fs-5"style="color:white"></i></a>

            <a href="https://www.tiktok.com/@229bignon1?_t=8kGBf86zCyM&_r=1" target="_blank" class="text-dark"><i
                    class="fa-brands fa-tiktok fs-5"style="color:white"></i></a>
            <a href="https://wa.me/+22997069305" target="_blank" class="text-dark"><i class="bi bi-whatsapp fs-5"
                    style="color:white"></i></a>
        </div>
    </div>

    <!-- Script pour afficher l'heure -->
    <script>
        function updateDateTime() {
            const now = new Date();
            const options = {
                weekday: 'long',
                year: 'numeric',
                month: 'long',
                day: 'numeric',
                hour: '2-digit',
                minute: '2-digit',
                second: '2-digit'
            };
            const formatter = new Intl.DateTimeFormat('fr-FR', options);
            document.getElementById('date-time').innerHTML = '<i class="bi bi-clock me-1"></i> ' + formatter.format(now);
        }

        // Met à jour l'heure chaque seconde
        setInterval(updateDateTime, 1000);
        updateDateTime(); // Première exécution immédiate
    </script>

    <nav class="navbar navbar-expand-lg navbar-light">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center gap-3" href="/">
                <img src="{{ asset('images/logo_bignon.png') }}" alt="Logo Bignon">
                <h1 class="fs-4 d-none d-md-block text-black mb-0">BIGNON DU BENIN</h1>
            </a>

            <div class="d-md-none position-relative px-2 " data-bs-toggle="offcanvas" data-bs-target="#staticBackdrop"
                aria-controls="staticBackdrop">
                <a href="#" class="text-danger px-3 position-relative d-inline-block">
                    <i class="fa-solid fa-cart-plus fa-lg text-secondary fs-3"></i>
                    <span id="cart-badge"
                        class="position-absolute top-25 start-75 translate-middle badge rounded-pill bg-danger font-bold cart-badge">
                        0
                    </span>
                </a>
            </div>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link fw-bold" href="/">Accueil</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link fw-bold" href="{{ route('pages.products') }}">Produits</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link fw-bold" href="{{ route('pages.categories') }}">Catégories</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link fw-bold" href="{{ route('pages.about') }}">À propos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link fw-bold" href="#DemanderDevis">Demandez un Devis</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link fw-bold" href="{{ route('pages.contact') }}">Contact</a>
                    </li>
                    <!-- Panier (badge) -->
                    <li class="d-none d-md-block position-relative px-2" data-bs-toggle="offcanvas"
                        data-bs-target="#staticBackdrop" aria-controls="staticBackdrop">
                        <a href="#" class="text-danger px-3 position-relative d-inline-block">
                            <i class="fa-solid fa-cart-plus fa-lg text-secondary fs-3"></i>
                            <span id="cart-badge"
                                class="position-absolute top-25 start-75 translate-middle badge rounded-pill bg-danger font-bold cart-badge">
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
    <form id="product-form" action="{{ route('store-panier-valider') }}" method="POST">
        <div class="offcanvas offcanvas-end" data-bs-backdrop="static" tabindex="-1" id="staticBackdrop"
            aria-labelledby="staticBackdropLabel">
            <div class="offcanvas-header">
                <h5 class="offcanvas-title" id="staticBackdropLabel">Panier</h5>
                <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body">
                @csrf
                <div class="table-responsive">
                    <table class="table table-striped" id="table-id">
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
                                <td colspan="5" style="font-size: 12px" class="text-center text-muted">
                                    Aucun produit ajouté pour l’instant.
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <!-- Montant total -->
                <div class="mt-4">
                    {{-- <p class="fw-bold mb-1">Total : <span id="total-amount">0 FCFA</span></p> --}}
                    <div class=" row d-flex align-items-center">
                        <label for="total-amount-input" class="fw-bold mb-1 col">Total :</label>
                        <input type="text" id="total-amount-input" name="total_amount" value="0 FCFA"
                            class="form-control fw-bold mb-1 total-amount border-0 col" />
                    </div>

                    <!-- Code promo (affiché seulement si panier non vide) -->
                    <div class="mb-3" id="promo-section" style="display: none;">
                        <label for="promo-code" class="form-label">Utiliser un code promo : PROMO5</label>
                        <div class="input-group">
                            <input type="text" id="promo-code" name="code_promo" class="form-control"
                                placeholder="Ex : PROMO5">
                            <button type="button" class="btn btn-outline" onclick="applyPromo()"
                                style="color:white  ;  background-color: #366ba2">Appliquer</button>
                        </div>
                        <div id="promo-message" class="form-text text-success mt-1" style="display: none;">
                            ✅ Code appliqué : réduction de 5%
                        </div>
                    </div>

                    <!-- Montant après réduction -->
                    {{-- <p class="fw-bold">Total à payer : <span id="discounted-total">0 FCFA</span></p> --}}
                    <div class=" row d-flex align-items-center">
                        <label for="total-promo-code" class="fw-bold mb-1 col">Total à payer :</label>
                        <input type="text" id="total-promo-code" name="total_promo"
                            class="form-control fw-bold mb-1 total-amount border-0 col" value="0 FCFA">
                    </div>
                </div>

                <!-- ✅ Bouton valider -->
                <div class="d-flex justify-content-end mt-3" id="validate-button" style="display: none;">
                    <button type="button" class="btn btn-lg  rounded-5" data-bs-toggle="modal"
                        data-bs-target="#confirmModal" id="btn-valider"
                        style="color:white  ;  background-color: #366ba2">Valider</button>
                </div>

                <!-- Modal -->
                <div class="modal fade" id="confirmModal" data-bs-backdrop="static" data-bs-keyboard="false"
                    tabindex="-1" aria-labelledby="confirmModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="staticBackdropLabel">Informations</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="invalid-feedback">
                                        Veuillez renseigner ce champ correctement.
                                    </div>

                                    <div class="col-md-12 mb-3">
                                        <label for="name" class="fw-bold">Nom Complet <span
                                                class=" text-danger fw-bold">*</span></label>
                                        <input type="text" name="name" id="name"
                                            placeholder="Jean Roland" class=" form-control border-2 fw-bold" required>
                                        <div class="invalid-feedback">Veuillez entrer votre nom complet.</div>
                                    </div>
                                    <div class="col-md-12 mb-3">
                                        <label for="name" class="fw-bold">Adresse E-mail <span
                                                class=" text-danger fw-bold">*</span></label>
                                        <input type="email" name="email" id="email"
                                            placeholder="jean@gmail.com" class=" form-control border-2 fw-bold"
                                            required>
                                        <div class="invalid-feedback">Veuillez entrer votre adresse email.</div>
                                    </div>
                                    <div class="mb-3 col-md-12">
                                        <label for="phone" class="col-form-label me-2 fw-bold">Numéro de téléphone
                                            <span class=" text-danger fw-bold">*</span></label>
                                        <div class="d-flex align-items-center gap-2">
                                            @php
                                                $indicatifs = [
                                                    ['code' => '+229', 'label' => '🇧🇯 (+229)'],
                                                    ['code' => '+225', 'label' => '🇨🇮 (+225)'],
                                                    ['code' => '+226', 'label' => '🇧🇫 (+226)'],
                                                    ['code' => '+228', 'label' => '🇹🇬 (+228)'],
                                                    ['code' => '+237', 'label' => '🇨🇲 (+237)'],
                                                    ['code' => '+33', 'label' => '🇫🇷 (+33)'],
                                                    ['code' => '+1', 'label' => '🇺🇸 (+1)'],
                                                    ['code' => '+44', 'label' => '🇬🇧 (+44)'],
                                                    ['code' => '+49', 'label' => '🇩🇪 (+49)'],
                                                    ['code' => '+34', 'label' => '🇪🇸 (+34)'],
                                                    ['code' => '+39', 'label' => '🇮🇹 (+39)'],
                                                    ['code' => '+212', 'label' => '🇲🇦 (+212)'],
                                                    ['code' => '+216', 'label' => '🇹🇳 (+216)'],
                                                    ['code' => '+213', 'label' => '🇩🇿 (+213)'],
                                                ];
                                            @endphp
                                            <select
                                                class="form-select w-25 border-2 @error('indicatif') is-invalid @enderror fw-bold"
                                                name="indicatif" id="indicatif">
                                                <option value="">Choisir</option>
                                                @foreach ($indicatifs as $indicatif)
                                                    <option value="{{ $indicatif['code'] }}"
                                                        {{ old('indicatif') == $indicatif['code'] ? 'selected' : '' }}>
                                                        {{ $indicatif['label'] }}
                                                    </option>
                                                @endforeach

                                            </select>
                                            <input type="number" class="form-control fw-bold w-75 " name="phone"
                                                id="phone" placeholder="ex:0197222222">
                                            <div class="invalid-feedback">Veuillez entrer votre numéro de téléphone.
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary"
                                        data-bs-dismiss="modal">Annuler</button>
                                    <button type="button" class="btn btn-primary border-0" style="{{ base_color() }}"
                                        id="button-send">Soumettre</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </form>

    </div>
</header>
