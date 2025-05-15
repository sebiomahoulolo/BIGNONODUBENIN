<!--Section demandez un devis -->
<div id="demanderDevis"></div>
<section class="bg-light py-5" style="margin-top: 100px">
    <div class="container">
        <div class="row">
            <h2 class="text-center mb-5">Demandez un devis</h2>
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show position-absolute top-0 end-0" role="alert">
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
                            <label for="name" class="col-form-label">Nom</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror"
                                id="name" name="name" value="{{ old('name') }}">
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Email --}}
                        <div class="mb-3 col-12 col-lg-3">
                            <label for="email" class="col-form-label">Adresse E-mail</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror"
                                id="email" name="email" value="{{ old('email') }}">
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Matériel --}}
                        <div class="mb-3 col-12 col-lg-3">
                            <label for="material" class="col-form-label">Matériel</label>
                            <input type="text" class="form-control @error('material') is-invalid @enderror"
                                id="material" name="material" value="{{ old('material') }}">
                            @error('material')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Produit --}}
                        <div class="mb-3 col-3 col-lg-3">
                            <label for="product" class="col-form-label">Produit</label>
                            <select class="form-select @error('category_id') is-invalid @enderror" id="product"
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
                            <label for="phone" class="col-form-label me-2">Numéro de téléphone</label>
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
                                <select class="form-select w-25 @error('indicatif') is-invalid @enderror"
                                    name="indicatif" id="indicatif">
                                    <option value="">Choisir</option>
                                    @foreach ($indicatifs as $indicatif)
                                        <option value="{{ $indicatif['code'] }}"
                                            {{ old('indicatif') == $indicatif['code'] ? 'selected' : '' }}>
                                            {{ $indicatif['label'] }}
                                        </option>
                                    @endforeach

                                </select>
                                <input type="text" class="form-control w-75 @error('phone') is-invalid @enderror"
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
                            <label for="city" class="col-form-label">Ville</label>
                            <input type="text" class="form-control @error('city') is-invalid @enderror"
                                id="city" name="city" value="{{ old('city') }}">
                            @error('city')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Délai de livraison --}}
                        <div class="mb-3 col-12 col-lg-4">
                            <label for="delai_livraison" class="col-form-label">Délai de livraison</label>
                            <input type="number" class="form-control @error('delai_livraison') is-invalid @enderror"
                                id="delai_livraison" name="delai_livraison" value="{{ old('delai_livraison') }}">
                            @error('delai_livraison')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Description --}}
                        <div class="mb-3 col-12 col-lg-12">
                            <label for="message-text" class="col-form-label">Description</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" id="message-text" name="description">{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-lg btn-primary col-12">Envoyer</button>
                </form>
            </div>
        </div>
    </div>
</section>

<!-- Footer -->
<footer class="footer">
    <div class="container">
        <div class="row">


            <div class="col-md-4 mb-4">
                <h5>À propos de nous</h5>
                <p>BIGNON DU BENIN, votre spécialiste en meubles de qualité depuis plus de 10 ans. Nous vous offrons les
                    meilleurs produits pour votre intérieur.</p>
                <div class="social-links">
                    <a href="#"><i class="fab fa-facebook"></i></a>
                    <a href="#"><i class="fab fa-instagram"></i></a>
                    <a href="#"><i class="fab fa-twitter"></i></a>
                </div>
            </div>
            <div class="col-md-4">
                <h5>Liens Rapides</h5>
                <ul class="footer-links">
                    <li><a href="{{ route('pages.products') }}">Produits</a></li>
                    <li><a href="{{ route('pages.categories') }}">Catégories</a></li>
                    <li><a href="{{ route('pages.about') }}">À propos</a></li>
                    <li><a href="{{ route('pages.contact') }}">Contact</a></li>
                </ul>
            </div>
            <div class="col-md-4 mb-4">
                <h5>Contact</h5>
                <ul class="footer-links">
                    <li><i class="fas fa-map-marker-alt"></i> 123 Rue du Commerce, Cotonou</li>
                    <li><i class="fas fa-phone"></i> +229 123 456 789</li>
                    <li><i class="fas fa-envelope"></i> contact@bignonbenin.com</li>
                </ul>
            </div>
        </div>
        <hr class="mt-4 mb-4" style="border-color: rgba(255,255,255,0.1);">
        <div class="d-flex flex-column flex-md-row gap-3 justify-content-center text-md-center col-12">
            <p class="mb-0">&copy; 2025 BIGNON DU BENIN. Tous droits réservés par FHC groupe sarl.</p>
            {{-- <a href="#" class="text-white text-decoration-none me-3">Conditions d'utilisation</a> --}}
            <a href="{{ route('legal-notice') }}" class="text-white text-decoration-none">Mentions légales</a>
            <a href="{{ route('privacy-policy') }}" class="text-white text-decoration-none">Politique de
                confidentialité</a>
        </div>
    </div>
</footer>

<!-- Bouton retour en haut -->
<a href="#" class="back-to-top">
    <i class="fas fa-arrow-up"></i>
</a>
