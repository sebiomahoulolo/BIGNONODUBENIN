@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="legal-notice-container">
                <div class="legal-header">
                    <h1>Mentions légales</h1>
                    <p class="update-date">Dernière mise à jour : 04/03/2025</p>
                </div>

                <div class="legal-content">
                    <div class="intro-section">
                        <p>Conformément à la réglementation en vigueur, nous mettons à votre disposition les informations suivantes concernant l'entreprise Bignon du Bénin et son site internet.</p>
                    </div>

                    <div class="section">
                        <h2>1. Informations sur l'éditeur du site</h2>
                        <div class="info-grid">
                            <div class="info-item">
                                <span class="label">Nom de l'entreprise :</span>
                                <span class="value">Bignon du Bénin</span>
                            </div>
                            <div class="info-item">
                                <span class="label">Forme juridique :</span>
                                <span class="value">Établissement (Ets)</span>
                            </div>
                            <div class="info-item">
                                <span class="label">Siège social :</span>
                                <span class="value">Cadjèhoun, à côté de la pharmacie Cadjèhoun, Cotonou, Bénin</span>
                            </div>
                            <div class="info-item">
                                <span class="label">Téléphone :</span>
                                <span class="value">+229 01 97 06 93 05</span>
                            </div>
                            <div class="info-item">
                                <span class="label">E-mail :</span>
                                <span class="value">innobignon@gmail.com</span>
                            </div>
                            <div class="info-item">
                                <span class="label">RCCM :</span>
                                <span class="value">RB/PNO/19 A 95 46</span>
                            </div>
                            <div class="info-item">
                                <span class="label">Identifiant Fiscale Unique (IFU) :</span>
                                <span class="value">0201910594677</span>
                            </div>
                        </div>
                    </div>

                    <div class="section">
                        <h2>2. Hébergement du site</h2>
                        <div class="info-grid">
                            <div class="info-item">
                                <span class="label">Hébergeur :</span>
                                <span class="value">Wix.com Ltd.</span>
                            </div>
                            <div class="info-item">
                                <span class="label">Siège social de l'hébergeur :</span>
                                <span class="value">40 Port de Tel Aviv Jaffa 6350671 Israël</span>
                            </div>
                            <div class="info-item">
                                <span class="label">Site internet :</span>
                                <span class="value">www.wix.com</span>
                            </div>
                        </div>
                    </div>

                    <div class="section">
                        <h2>3. Propriété intellectuelle</h2>
                        <p>Le contenu du site internet Bignon du Bénin (textes, images, graphiques, logo, etc.) est protégé par les lois relatives à la propriété intellectuelle. Toute reproduction, représentation ou diffusion de ces éléments sans autorisation écrite préalable est strictement interdite et constitue une violation des droits d'auteur.</p>
                    </div>

                    <div class="section">
                        <h2>4. Limitation de responsabilité</h2>
                        <p>Bignon du Bénin s'efforce d'assurer l'exactitude et la mise à jour des informations présentes sur le site. Cependant, l'entreprise ne saurait être tenue responsable :</p>
                        <ul>
                            <li><i class="bi bi-dash-circle"></i>d'un dysfonctionnement technique rendant le site inaccessible temporairement ;</li>
                            <li><i class="bi bi-dash-circle"></i>de tout dommage direct ou indirect résultant de l'utilisation du site ou des informations qu'il contient.</li>
                        </ul>
                    </div>

                    <div class="section">
                        <h2>5. Données personnelles</h2>
                        <p>Conformément à notre <a href="{{ route('privacy-policy') }}">Politique de confidentialité</a>, Bignon du Bénin s'engage à respecter la confidentialité des données personnelles que vous fournissez via le formulaire de contact.</p>
                        <p>Nous ne collectons aucune autre donnée personnelle sans votre consentement explicite.</p>
                    </div>

                    <div class="section contact-section">
                        <h2>6. Contact</h2>
                        <p>Pour toute question ou réclamation concernant les présentes mentions légales ou le site internet, veuillez nous contacter à l'adresse suivante :</p>
                        <div class="contact-info">
                            <p><i class="bi bi-envelope-fill"></i>innobignon@gmail.com</p>
                            <p><i class="bi bi-telephone-fill"></i>+229 97 06 93 05</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.legal-notice-container {
    background: white;
    border-radius: 15px;
    padding: 2rem;
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    margin: 1rem 0;
}

.legal-header {
    text-align: center;
    margin-bottom: 2rem;
    padding-bottom: 1rem;
    border-bottom: 2px solid var(--primary-color);
}

.legal-header h1 {
    color: var(--primary-color);
    font-size: 2.5rem;
    margin-bottom: 0.5rem;
}

.update-date {
    color: #666;
    font-size: 0.9rem;
}

.intro-section {
    background: #f8f9fa;
    padding: 1.5rem;
    border-radius: 10px;
    margin-bottom: 2rem;
}

.section {
    margin-bottom: 2rem;
    padding: 1.5rem;
    border-radius: 10px;
    transition: all 0.3s ease;
}

.section:hover {
    background: #f8f9fa;
    transform: translateX(10px);
}

.section h2 {
    color: var(--primary-color);
    font-size: 1.5rem;
    margin-bottom: 1rem;
    padding-bottom: 0.5rem;
    border-bottom: 2px solid var(--primary-color);
}

.section p {
    color: #444;
    line-height: 1.6;
    margin-bottom: 1rem;
}

.info-grid {
    display: grid;
    gap: 1rem;
}

.info-item {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
    padding: 0.8rem;
    background: #f8f9fa;
    border-radius: 8px;
    transition: all 0.3s ease;
}

.info-item:hover {
    background: #e9ecef;
    transform: translateX(5px);
}

.label {
    font-weight: 600;
    color: var(--primary-color);
}

.value {
    color: #444;
}

.section ul {
    list-style: none;
    padding-left: 0;
    margin-bottom: 1rem;
}

.section ul li {
    display: flex;
    align-items: center;
    margin-bottom: 0.5rem;
    padding: 0.5rem;
    border-radius: 5px;
    transition: all 0.3s ease;
}

.section ul li:hover {
    background: rgba(var(--primary-color-rgb), 0.1);
    transform: translateX(5px);
}

.section ul li i {
    color: var(--primary-color);
    margin-right: 0.5rem;
    font-size: 1.2rem;
}

.contact-section {
    background: #f8f9fa;
}

.contact-info {
    display: flex;
    flex-direction: column;
    gap: 1rem;
    margin-top: 1rem;
}

.contact-info p {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    margin: 0;
}

.contact-info i {
    color: var(--primary-color);
    font-size: 1.2rem;
}

.section a {
    color: var(--primary-color);
    text-decoration: none;
    transition: all 0.3s ease;
}

.section a:hover {
    text-decoration: underline;
    color: var(--primary-color-dark);
}

@media (max-width: 768px) {
    .legal-notice-container {
        padding: 1.5rem;
    }

    .legal-header h1 {
        font-size: 2rem;
    }

    .section {
        padding: 1rem;
    }

    .section h2 {
        font-size: 1.3rem;
    }

    .info-item {
        padding: 0.6rem;
    }
}

@media (max-width: 576px) {
    .legal-notice-container {
        padding: 1rem;
    }

    .legal-header h1 {
        font-size: 1.8rem;
    }

    .section {
        padding: 0.8rem;
    }

    .section h2 {
        font-size: 1.2rem;
    }

    .info-item {
        padding: 0.5rem;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Animation au scroll
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.opacity = '1';
                entry.target.style.transform = 'translateY(0)';
            }
        });
    }, {
        threshold: 0.1
    });

    // Appliquer les animations aux sections
    document.querySelectorAll('.section').forEach((section) => {
        section.style.opacity = '0';
        section.style.transform = 'translateY(20px)';
        section.style.transition = 'all 0.5s ease';
        observer.observe(section);
    });
});
</script>
@endsection 