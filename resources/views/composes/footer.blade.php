<div class="container-fluid card shadow py-2">
        <h2 class="text-center mb-5">Demandez un devis</h2>
    <div class="row">
        <div class="col-md-12">
            <div class="card-boby">
                <form>
                    <div class="row">
                        {{-- Nom  --}}
                        <div class="mb-3 col-12 col-lg-3">
                            <label for="name" class="col-form-label">Nom</label>
                            <input type="text" class="form-control" id="name">
                        </div>

                        {{-- Email  --}}
                        <div class="mb-3 col-12 col-lg-3">
                            <label for="email" class="col-form-label">Adresse E-mail</label>
                            <input type="email" class="form-control" id="email">
                        </div>


                        {{-- Materiel  --}}
                        <div class="mb-3 col-12 col-lg-3">
                            <label for="material" class="col-form-label">Matériel</label>
                            <input type="text" class="form-control" id="material">
                        </div>

                        {{-- Ville  --}}
                        <div class="mb-3 col-12 col-lg-3">
                            <label for="city" class="col-form-label">Ville</label>
                            <input type="email" class="form-control" id="city">
                        </div>


                        {{-- Téléphone  --}}
                        <div class="mb-3 col-12 col-lg-4">
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



                        {{-- Produit  --}}
                        <div class="mb-3 col-12 col-lg-4">
                            <label for="product" class="col-form-label">Produit</label>
                            <select class="form-select" id="product" name="product">
                                <option value="">Selectionner un produit</option>
                                @foreach (getProducts() as $product)
                                    <option value="{{ $product->id }}">{{ $product->name }}</option>
                                @endforeach
                            </select>
                        </div>


                        {{-- Delai de livraison  --}}
                        <div class="mb-3 col-12 col-lg-4">
                            <label for="delai_livraison" class="col-form-label">Délai de livraison</label>
                            <input type="number" class="form-control" id="delai_livraison" placeholder="ex: 5 jours">
                        </div>

                        {{-- Description  --}}
                        <div class="mb-3 col-12 col-lg-12">
                            <label for="message-text" class="col-form-label">Description</label>
                            <textarea class="form-control" id="message-text"></textarea>
                        </div>
                    </div>
                </form>
            </div>
            <button type="button" class="btn btn-primary col-12">Envoyer</button>
        </div>
    </div>
</div>
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
