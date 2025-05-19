@extends('layouts.app')

@section('content')
    <div class="container py-5">
        <div data-aos="fade" data-aos-duration="1300" data-aos-delay="300"  class="row">
            <div class="col-md-6">
                <h1 class="display-4 mb-4">À propos de Bignon du Benin</h1>
                <p class="lead justify-text">Votre partenaire de confiance pour l'aménagement de votre intérieur depuis plus de 10 ans.
                </p>
                <p class="justify-text">Chez Bignon du Benin, nous nous engageons à fournir des meubles de qualité supérieure qui allient
                    élégance, confort et durabilité. Notre passion pour l'excellence et notre dévouement à la satisfaction
                    client nous ont permis de devenir un leader dans l'industrie du meuble au Bénin.</p>
            </div>
            <div class="col-md-6 d-flex justify-content-center">
                <img class="w-50 card" src="{{ asset('images/about-us.avif') }}" alt="Notre showroom"
                    class="img-fluid rounded shadow">
            </div>
        </div>

        <div data-aos="fade" data-aos-duration="1300" data-aos-delay="300"  class="row py-5">
            <div class="col-md-6 d-flex justify-content-center">
                <img class="w-50 card" src="{{ asset('images/vision.jpeg') }}" alt="Notre showroom"
                    class="img-fluid rounded shadow">
            </div>
            <div class="col-md-6">
                <h1 class="display-4 mb-4">Notre Vision</h1>
                <p class="hl-lg justify-text">À la tête de Bignon du Bénin, Innocent GBEDONOU a su transformer une passion en une
                    aventure. Grâce à son dynamisme et à une stratégie axée sur les réseaux sociaux, notamment TikTok, où il
                    compte plus de 250 000 abonnés, Innocent a fait connaître l'entreprise bien au-delà des frontières
                    béninoises.
                </p>
                <p class="hl-lg justify-text">Son engagement pour l'excellence a été récompensé par diverses distinctions nationales et
                    internationales, saluant la qualité de nos meubles et l'impact de notre entreprise sur la promotion du
                    savoir-faire local.</p>
            </div>
        </div>

        <div data-aos="fade" data-aos-duration="1300" data-aos-delay="300"  class="row py-5">
            <div class="col-md-6">
                <h1 class="display-4 mb-4">Notre Mission</h1>
                <p class="justify-text">
                    Chaque pièce que nous créons – fauteuils, canapés, lits ou accessoires – est le fruit d'un travail
                    minutieux réalisé par des artisans locaux hautement qualifiés. Notre mission est de valoriser le
                    savoir-faire béninois tout en offrant à nos clients des meubles qui reflètent leur style et répondent à
                    leurs besoins.</p>
            </div>
            <div class="col-md-6 d-flex justify-content-center">
                <img class="w-5à card" src="{{ asset('images/mission.webp') }}" alt="Notre showroom"
                    class="img-fluid rounded shadow">
            </div>
        </div>

        <div class="row mt-5">
            <div data-aos="fade" data-aos-duration="1300" data-aos-delay="300"  class="col-md-4">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-medal"></i>
                    </div>
                    <h4>Qualité Premium</h4>
                    <p>Nous sélectionnons uniquement les meilleurs matériaux pour garantir la durabilité de nos meubles.</p>
                </div>
            </div>
            <div data-aos="fade" data-aos-duration="1300" data-aos-delay="300"  class="col-md-4">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <h4>Service Client</h4>
                    <p>Notre équipe dévouée est à votre écoute pour vous accompagner dans tous vos projets.</p>
                </div>
            </div>
            <div data-aos="fade" data-aos-duration="1300" data-aos-delay="300"  class="col-md-4">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-truck"></i>
                    </div>
                    <h4>Livraison Rapide</h4>
                    <p>Service de livraison express dans tout le Bénin pour votre confort.</p>
                </div>
            </div>
        </div>

        {{-- <div class="row mt-5">
            <div class="col-12">
                <h2 class="text-center mb-4">Notre Histoire</h2>
                <p class="text-center">Fondée en 1970, Bignon du Benin a commencé comme une petite boutique familiale.
                    Aujourd'hui, nous sommes fiers d'être l'une des plus grandes entreprises de meubles au Bénin, avec
                    plusieurs showrooms à travers le pays.</p>
            </div>
        </div> --}}

        {{-- <div class="row mt-5">
            <div class="col-12">
                <h2 class="text-center mb-4">Notre Mission</h2>
                <p class="text-center">Notre mission est de transformer les espaces de vie de nos clients en créant des
                    environnements confortables et élégants grâce à des meubles de qualité exceptionnelle.</p>
            </div>
        </div> --}}

    </div>
@endsection
