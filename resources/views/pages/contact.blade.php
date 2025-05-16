@extends('layouts.app')

@section('content')
    <!-- Hero Section -->
    <section data-aos="fade" data-aos-duration="1500" data-aos-delay="500" class=" py-5" style="{{ base_color() }}">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 mx-auto text-center">
                    <h1 class="display-4 mb-4 text-white fw-bold">Contactez-nous</h1>
                    <p class="lead text-white">Nous sommes là pour vous aider. N'hésitez pas à nous contacter pour toute
                        question.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Information -->
    <section class="py-5">
        <div class="container">
            <div class="row g-4">
                <div data-aos="fade" data-aos-duration="1500" data-aos-delay="500" class="col-md-4">
                    <div class="card h-100 border-0 shadow-lg">
                        <div class="card-body text-center p-4">
                            <i class="bi bi-geo-alt display-4 mb-3" style="{{ text_color_1() }}"></i>
                            <h3 class="h5">Notre Adresse</h3>
                            <p class="text-muted">Cotonou <br>
                                Cadjèhoun, à côté de la pharmacie Cadjèhoun</p>
                            <p class="text-muted">Porto-Novo <br>
                                Akonaboè, à côté de la bibliothèque nationale </p>
                        </div>
                    </div>
                </div>
                <div data-aos="fade" data-aos-duration="1500" data-aos-delay="500" class="col-md-4">
                    <div class="card h-100 border-0 shadow-lg">
                        <div class="card-body text-center p-4">
                            <i class="bi bi-telephone display-4  mb-3" style="{{ text_color_1() }}"></i>
                            <h3 class="h5">Téléphone</h3>
                            <p class="text-muted">(+229) 01 97 06 93 05<br>(+229)01 97 06 93 05</p>
                        </div>
                    </div>
                </div>
                <div data-aos="fade" data-aos-duration="1500" data-aos-delay="500" class="col-md-4">
                    <div class="card h-100 border-0 shadow-lg">
                        <div class="card-body text-center p-4">
                            <i class="bi bi-envelope display-4  mb-3" style="{{ text_color_1() }}"></i>
                            <h3 class="h5">Email</h3>
                            <p class="text-muted">innobignon@gmail.com</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Form -->
    <section class="py-5 bg-light">
        <div class="container">
            <div data-aos="fade" data-aos-duration="1500" data-aos-delay="500" class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="card border-0 shadow-lg">
                        <div class="card-body p-5">
                            <h2 class="text-center mb-4">Envoyez-nous un message</h2>
                            <form>
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label for="name" class="form-label">Nom complet <span
                                                class=" text-danger fw-bold">*</span></label>
                                        <input type="text" class="form-control border-2" id="name" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="email" class="form-label">Email<span
                                                class=" text-danger fw-bold">*</span></label>
                                        <input type="email" class="form-control border-2" id="email" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="phone" class="form-label">Téléphone<span
                                                class=" text-danger fw-bold">*</span></label>
                                        <input type="tel" class="form-control border-2" id="phone">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="subject" class="form-label">Sujet<span
                                                class=" text-danger fw-bold">*</span></label>
                                        <input type="text" class="form-control border-2" id="subject" required>
                                    </div>
                                    <div class="col-12">
                                        <label for="message" class="form-label">Message<span
                                                class=" text-danger fw-bold">*</span></label>
                                        <textarea class="form-control border-2" id="message" rows="5" required></textarea>
                                    </div>
                                    <div class="col-12">
                                        <button type="submit" class="btn btn-primary w-100 border-0 "
                                            style="{{ base_color() }}">Envoyer le message</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Map -->
    <section class="py-5">
        <div class="container">
            <div class="row">
                <div class="col-6">
                    <h2 class="text-center mb-4">Cotonou</h2>
                    <div class="ratio ratio-21x9">
                        <iframe
                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3965.2548493859185!2d2.3950847744796153!3d6.3610528250308525!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x102355cb15c56539%3A0x31fe17bf052a8cb5!2sPharmacie%20Cadjehoun!5e0!3m2!1sfr!2sbj!4v1747391787435!5m2!1sfr!2sbj"
                            width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"
                            referrerpolicy="no-referrer-when-downgrade"></iframe>
                    </div>
                </div>
                <div class="col-6">
                    <h2 class="text-center mb-4">Porto Novo</h2>
                    <div class="ratio ratio-21x9">
                        <iframe
                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3964.0767861355926!2d2.603674574480427!3d6.511965023298351!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x103b508a95c5defb%3A0x66c2dc5144a390f6!2sBiblioth%C3%A8que%20nationale%20du%20B%C3%A9nin%20(BnB)!5e0!3m2!1sfr!2sbj!4v1747403733477!5m2!1sfr!2sbj"
                            width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"
                            referrerpolicy="no-referrer-when-downgrade"></iframe>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Business Hours -->
    <section class="py-5 bg-light">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8 text-center">
                    <h2 class="mb-4">Heures d'Ouverture</h2>
                    <div class="row g-4">
                        <div data-aos="fade" data-aos-duration="1500" data-aos-delay="500" class="col-md-6">
                            <div class="card border-0 shadow-lg">
                                <div class="card-body">
                                    <h3 class="h5">Showroom</h3>
                                    <p class="text-muted mb-0">
                                        Lundi - Vendredi: 8h00 - 18h00<br>
                                        Samedi: 9h00 - 17h00<br>
                                        Dimanche: Fermé
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div data-aos="fade" data-aos-duration="1500" data-aos-delay="500" class="col-md-6">
                            <div class="card border-0 shadow-lg">
                                <div class="card-body">
                                    <h3 class="h5">Service Client</h3>
                                    <p class="text-muted mb-0">
                                        Lundi - Vendredi: 8h00 - 20h00<br>
                                        Samedi: 9h00 - 18h00<br>
                                        Dimanche: 10h00 - 16h00
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
