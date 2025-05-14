@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-md-6">
            <h1 class="display-4 mb-4">À propos de Bignon du Benin</h1>
            <p class="lead">Votre partenaire de confiance pour l'aménagement de votre intérieur depuis plus de 50 ans.</p>
            <p>Chez Bignon du Benin, nous nous engageons à fournir des meubles de qualité supérieure qui allient élégance, confort et durabilité. Notre passion pour l'excellence et notre dévouement à la satisfaction client nous ont permis de devenir un leader dans l'industrie du meuble au Bénin.</p>
        </div>
        <div class="col-md-6 d-flex justify-content-center">
            <img class="w-75 card" src="{{ asset('images/about-us.avif') }}" alt="Notre showroom" class="img-fluid rounded shadow">
        </div>
    </div>

    <div class="row mt-5">
        <div class="col-md-4">
            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fas fa-medal"></i>
                </div>
                <h4>Qualité Premium</h4>
                <p>Nous sélectionnons uniquement les meilleurs matériaux pour garantir la durabilité de nos meubles.</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fas fa-users"></i>
                </div>
                <h4>Service Client</h4>
                <p>Notre équipe dévouée est à votre écoute pour vous accompagner dans tous vos projets.</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fas fa-truck"></i>
                </div>
                <h4>Livraison Rapide</h4>
                <p>Service de livraison express dans tout le Bénin pour votre confort.</p>
            </div>
        </div>
    </div>

    <div class="row mt-5">
        <div class="col-12">
            <h2 class="text-center mb-4">Notre Histoire</h2>
            <p class="text-center">Fondée en 1970, Bignon du Benin a commencé comme une petite boutique familiale. Aujourd'hui, nous sommes fiers d'être l'une des plus grandes entreprises de meubles au Bénin, avec plusieurs showrooms à travers le pays.</p>
        </div>
    </div>

    <div class="row mt-5">
        <div class="col-12">
            <h2 class="text-center mb-4">Notre Mission</h2>
            <p class="text-center">Notre mission est de transformer les espaces de vie de nos clients en créant des environnements confortables et élégants grâce à des meubles de qualité exceptionnelle.</p>
        </div>
    </div>
</div>
@endsection
