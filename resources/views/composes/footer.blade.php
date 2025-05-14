<!-- Footer -->
<footer class="footer">
    <div class="container">
        <div class="row">
            <div class="col-md-4 mb-4">
                <h5>À propos de nous</h5>
                <p>BIGNON DU BENIN, votre spécialiste en meubles de qualité depuis plus de 10 ans. Nous vous offrons les meilleurs produits pour votre intérieur.</p>
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
<<<<<<< Updated upstream
        </div>
        <div class="col-md-6 text-md-end">
                    <a href="#" class="text-white text-decoration-none me-3">Conditions d'utilisation</a>
                    <a href="#" class="text-white text-decoration-none">Politique de confidentialité</a>
=======
                    {{-- <a href="#" class="text-white text-decoration-none me-3">Conditions d'utilisation</a> --}}
                     <a href="{{ route('legal-notice') }}" class="text-white text-decoration-none">Mentions légales</a>
                    <a href="{{ route('privacy-policy') }}" class="text-white text-decoration-none">Politique de confidentialité</a>
>>>>>>> Stashed changes
                </div>
    </div>
</footer>

<!-- Bouton retour en haut -->
<a href="#" class="back-to-top">
    <i class="fas fa-arrow-up"></i>
</a>
