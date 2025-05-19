<!--Section demandez un devis -->
<div id="DemanderDevis"></div>
<section class="bg-light py-5" style="margin-top: 100px">
    <div class="container">
        <div data-aos="fade" data-aos-duration="1300" data-aos-delay="300" class="row">
            <h2 class="text-center mb-5">Demandez un devis</h2>
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show position-absolute top-0 end-0"
                    role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            <div class="col-md-12">
                <form id="demandeDevisForm" action="{{ route('store.demande-devis') }}" method="POST">
                    @csrf
                    <div class="row">
                        {{-- Nom --}}
                        <div class="mb-3 col-12 col-lg-3">
                            <label for="name" class="col-form-label fw-bold">Nom <span class=" text-danger fw-bold">*</span></label>
                            <input type="text" class="form-control border-2 @error('name') is-invalid @enderror"
                                id="name" name="name" value="{{ old('name') }}">
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Email --}}
                        <div class="mb-3 col-12 col-lg-3">
                            <label for="email" class="col-form-label fw-bold">Adresse E-mail <span class=" text-danger fw-bold">*</span></label>
                            <input type="email" class="form-control border-2  @error('email') is-invalid @enderror"
                                id="email" name="email" value="{{ old('email') }}">
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Matériel --}}
                        <div class="mb-3 col-12 col-lg-3">
                            <label for="material" class="col-form-label fw-bold">Matériel <span class=" text-danger fw-bold">*</span></label>
                            <input type="text" class="form-control border-2 @error('material') is-invalid @enderror"
                                id="material" name="material" value="{{ old('material') }}">
                            @error('material')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Produit --}}
                        <div class="mb-3 col-12 col-lg-3">
                            <label for="product" class="col-form-label fw-bold">Produit <span class=" text-danger fw-bold">*</span></label>
                            <select class="form-select border-2 @error('category_id') is-invalid @enderror" id="product"
                                name="category_id">
                                <option value="">Sélectionner un produit</option>
                                @foreach (getProducts() as $product)
                                    <option value="{{ $product->id }}"
                                        {{ old('category_id') == $product->id ? 'selected' : '' }}>
                                        {{ $product->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Téléphone (indicatif + numéro) --}}
                        <div class="mb-3 col-12 col-lg-4">
                            <label for="phone" class="col-form-label me-2 fw-bold">Numéro de téléphone <span class=" text-danger fw-bold">*</span></label>
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
                                <select class="form-select w-25 border-2 @error('indicatif') is-invalid @enderror fw-bold"
                                    name="indicatif" id="indicatif">
                                    <option value="">Choisir</option>
                                    @foreach ($indicatifs as $indicatif)
                                        <option value="{{ $indicatif['code'] }}"
                                            {{ old('indicatif') == $indicatif['code'] ? 'selected' : '' }}>
                                            {{ $indicatif['label'] }}
                                        </option>
                                    @endforeach

                                </select>
                                <input type="text" class="form-control fw-bold w-75 @error('phone') is-invalid @enderror"
                                    id="phone" name="phone" value="{{ old('phone') }}">
                            </div>
                            @error('indicatif')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                            @error('phone')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Ville --}}
                        <div class="mb-3 col-12 col-lg-4">
                            <label for="city" class="col-form-label fw-bold">Ville <span class=" text-danger fw-bold">*</span></label>
                            <input type="text" class="form-control border-2 @error('city') is-invalid @enderror"
                                id="city" name="city" value="{{ old('city') }}">
                            @error('city')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Délai de livraison --}}
                        <div class="mb-3 col-12 col-lg-4">
                            <label for="delai_livraison" class="col-form-label fw-bold">Délai de livraison <span class=" text-danger fw-bold">*</span></label>
                            <input type="number" class="form-control border-2 @error('delai_livraison') is-invalid @enderror" placeholder=" ex: 5 jours"
                                id="delai_livraison" name="delai_livraison" value="{{ old('delai_livraison') }}">
                            @error('delai_livraison')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Description --}}
                        <div class="mb-3 col-12 col-lg-12">
                            <label for="message-text" class="col-form-label fw-bold">Description <span class=" text-danger fw-bold">*</span></label>
                            <textarea class="form-control border-2 @error('description') is-invalid @enderror" id="message-text" name="description">{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-lg btn-primary col-12 border-0"
                            style="{{ base_color() }}">Envoyer</button>
                </form>
            </div>
        </div>
    </div>
</section>

<!-- Footer -->
<footer data-aos="fade" data-aos-duration="1300" data-aos-delay="300" class="footer">
    <div class="container">
        <div class="row">

            <div class="col-md-3 mb-4">
                <h5>À propos de nous</h5>
                <p>BIGNON DU BENIN, votre spécialiste en meubles de qualité depuis plus de 10 ans. Nous vous offrons les
                    meilleurs produits pour votre intérieur.</p>

            </div>
            <div class="col-md-3">
                <h5>Liens Rapides</h5>
                <ul class="footer-links">
                    <li><a href="{{ route('pages.products') }}">Produits</a></li>
                    <li><a href="{{ route('pages.categories') }}">Catégories</a></li>
                    <li><a href="{{ route('pages.about') }}">À propos</a></li>
                    <li><a href="{{ route('pages.contact') }}">Contact</a></li>
                </ul>
            </div>
            <div class="col-md-3 mb-4">
                <h5>Contact</h5>
                <ul class="footer-links">
                    <li><i class="fas fa-map-marker-alt"></i> Cotonou, Cadjèhoun, à côté de la pharmacie Cadjèhoun</li>
                    <li><i class="fas fa-map-marker-alt"></i> Porto-Novo, Akonaboè, à côté de la bibliothèque nationale </li>
                    <li><i class="fas fa-phone"></i> (+229) 01 97 06 93 05</li>
                    <li><i class="fas fa-envelope"></i><a href="mailto:innobignon@gmail.com">innobignon@gmail.com</a></li>
                </ul>
            </div>
            <div class="col-md-3 mb-4">
                <h5>Nous Suivre</h5>
                <div class="social-links">
                    <a href="https://web.facebook.com/bignon00229?mibextid=ZbWKwL&_rdc=1&_rdr#"><i
                            class="fab fa-facebook"></i></a>
                    <a href="https://www.tiktok.com/@229bignon1?_t=8kGBf86zCyM&_r=1"><i class="fab fa-tiktok"></i></a>

                </div>
            </div>
            {{-- <div class="col-md-3 mb-4">
                <a class="navbar-brand d-flex align-items-center gap-3" href="#">
                <img src="{{ asset('images/logo_bignon.png') }}" alt="Logo Bignon">
                <h1 class="fs-4 d-none d-md-block text-black mb-0 text-white">BIGNON DU BENIN</h1>
            </a>
            </div> --}}
        </div>
    </div>

</footer>
<div class="container-fluid row bg-white py-3">
    <div class="d-flex bg-white flex-column flex-md-row gap-3 justify-content-center text-md-center col-12">
        <p class="mb-0 text-black">&copy; 2025 BIGNON DU BENIN. Tous droits réservés par FHC groupe sarl.</p>
        {{-- <a href="#" class="text-white text-decoration-none me-3">Conditions d'utilisation</a> --}}
        <a href="{{ route('legal-notice') }}" class="text-decoration-none text-black">Mentions légales</a>
        <a href="{{ route('privacy-policy') }}" class="text-decoration-none text-black">Politique de
            confidentialité</a>
    </div>
</div>

<!-- Bouton retour en haut -->
<a href="#" class="back-to-top">
    <i class="fas fa-arrow-up"></i>
</a>
