@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="privacy-policy-container">
                <div class="privacy-header">
                    <h1>Politique de confidentialité</h1>
                    <p class="update-date">Dernière mise à jour : 04/03/2025</p>
                </div>

                <div class="privacy-content">
                    <div class="intro-section">
                        <p>Chez Bignon du Bénin, nous respectons et protégeons la vie privée de nos clients. Cette politique de confidentialité décrit comment nous collectons, utilisons et protégeons vos informations personnelles lorsque vous visitez notre site internet.</p>
                    </div>

                    <div class="section">
                        <h2>1. Informations collectées</h2>
                        <p>Nous collectons uniquement les informations que vous nous fournissez via le formulaire de contact présent sur notre site internet. Ces informations incluent :</p>
                        <ul>
                            <li><i class="bi bi-check-circle-fill"></i>Votre adresse e-mail</li>
                            <li><i class="bi bi-check-circle-fill"></i>Votre numéro de téléphone</li>
                        </ul>
                        <p>Ces données sont collectées dans le but de vous recontacter si vous avez exprimé un besoin concernant un service sur mesure ou toute autre demande liée à nos articles.</p>
                    </div>

                    <div class="section">
                        <h2>2. Utilisation des informations</h2>
                        <p>Les informations collectées sont utilisées exclusivement pour :</p>
                        <ul>
                            <li><i class="bi bi-check-circle-fill"></i>Répondre à vos demandes ou vous fournir des informations sur nos services.</li>
                            <li><i class="bi bi-check-circle-fill"></i>Vous contacter pour un suivi ou des précisions supplémentaires sur votre requête.</li>
                        </ul>
                        <p>Nous ne partageons, ne vendons ni ne louons vos informations personnelles à des tiers.</p>
                    </div>

                    <div class="section">
                        <h2>3. Sécurité des informations</h2>
                        <p>Nous mettons tout en œuvre pour protéger vos données personnelles contre l'accès non autorisé, la perte ou la modification.</p>
                    </div>

                    <div class="section">
                        <h2>4. Durée de conservation des données</h2>
                        <p>Les informations que vous fournissez via le formulaire de contact sont conservées uniquement pour la durée nécessaire à répondre à votre demande.</p>
                    </div>

                    <div class="section">
                        <h2>5. Vos droits</h2>
                        <p>En vertu des lois sur la protection des données, vous disposez des droits suivants :</p>
                        <ul>
                            <li><i class="bi bi-check-circle-fill"></i>Accéder aux informations que nous détenons à votre sujet.</li>
                            <li><i class="bi bi-check-circle-fill"></i>Demander la correction ou la suppression de vos données personnelles.</li>
                            <li><i class="bi bi-check-circle-fill"></i>Vous opposer à l'utilisation de vos informations.</li>
                        </ul>
                        <p>Pour exercer ces droits, contactez-nous par mail, WhatsApp ou tout autre canal par lequel nous sommes joignable.</p>
                    </div>

                    <div class="section">
                        <h2>6. Collecte de données supplémentaires</h2>
                        <p>Nous tenons à préciser que nous ne collectons aucune autre information personnelle via notre site internet. Nous n'utilisons pas de cookies ou d'outils de suivi.</p>
                    </div>

                    <div class="section">
                        <h2>7. Modification de notre politique</h2>
                        <p>Nous nous réservons le droit de mettre à jour cette politique de confidentialité pour refléter les changements dans nos pratiques ou les exigences légales. Toute modification sera publiée sur cette page avec une date de mise à jour.</p>
                    </div>

                    <div class="section contact-section">
                        <h2>8. Contactez-nous</h2>
                        <p>Pour toute question concernant notre politique de confidentialité ou la manière dont vos données sont traitées, vous pouvez nous contacter :</p>
                        <div class="contact-info">
                            <p><i class="bi bi-envelope-fill"></i>innobignon@gmail.com</p>
                            <p><i class="bi bi-telephone-fill"></i>+229 01 97 06 93 05</p>
                        </div>
                    </div>

                    <div class="conclusion">
                        <p>Nous vous remercions de votre confiance et de votre intérêt pour Bignon du Bénin.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.privacy-policy-container {
    background: white;
    border-radius: 15px;
    padding: 2rem;
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    margin: 1rem 0;
}

.privacy-header {
    text-align: center;
    margin-bottom: 2rem;
    padding-bottom: 1rem;
    border-bottom: 2px solid var(--primary-color);
}

.privacy-header h1 {
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

.conclusion {
    text-align: center;
    margin-top: 2rem;
    padding: 1.5rem;
    background: #f8f9fa;
    border-radius: 10px;
}

@media (max-width: 768px) {
    .privacy-policy-container {
        padding: 1.5rem;
    }

    .privacy-header h1 {
        font-size: 2rem;
    }

    .section {
        padding: 1rem;
    }

    .section h2 {
        font-size: 1.3rem;
    }
}

@media (max-width: 576px) {
    .privacy-policy-container {
        padding: 1rem;
    }

    .privacy-header h1 {
        font-size: 1.8rem;
    }

    .section {
        padding: 0.8rem;
    }

    .section h2 {
        font-size: 1.2rem;
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