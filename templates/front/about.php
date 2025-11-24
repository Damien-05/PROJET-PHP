<?php
$pageTitle = 'À propos - Cabinet Dr. Dupont';
require TEMPLATE_PATH . '/layout/header.php';
?>

<section class="page-header">
    <div class="container">
        <h2>À propos du Cabinet</h2>
    </div>
</section>

<section class="about-full">
    <div class="container">
        <div class="about-section">
            <h3>Dr. Marc Dupont</h3>
            <div class="about-content">
                <div class="about-image">
                    <img src="https://images.unsplash.com/photo-1612349317150-e413f6a5b16d?w=600&h=600&fit=crop&q=80" 
                         alt="Dr. Marc Dupont" 
                         style="border-radius: 16px; box-shadow: 0 8px 32px rgba(0,0,0,0.12); width: 100%; height: auto;">
                </div>
                <div class="about-text">
                    <p>
                        Diplômé de la Faculté de Médecine Dentaire de Paris en 2008, le Dr. Marc Dupont 
                        exerce avec passion depuis plus de 15 ans. Spécialisé en dentisterie générale et 
                        esthétique, il se forme continuellement aux dernières techniques et technologies 
                        pour offrir à ses patients les meilleurs soins possibles.
                    </p>
                    <p>
                        Sa philosophie : écouter, expliquer et soigner dans un environnement rassurant. 
                        Le Dr. Dupont prend le temps nécessaire avec chaque patient pour comprendre ses 
                        besoins et ses préoccupations.
                    </p>
                </div>
            </div>
        </div>

        <div class="qualifications">
            <h3>Qualifications & Formations</h3>
            <ul class="qualifications-list">
                <li>✓ Doctorat en Chirurgie Dentaire - Université Paris VII (2008)</li>
                <li>✓ Diplôme Universitaire en Implantologie (2012)</li>
                <li>✓ Formation en Orthodontie Invisible (2015)</li>
                <li>✓ Certification en Blanchiment Dentaire Professionnel (2018)</li>
                <li>✓ Membre de l'Ordre National des Chirurgiens-Dentistes</li>
            </ul>
        </div>

        <div class="team">
            <h3>Notre Équipe</h3>
            <div class="team-grid">
                <div class="team-member">
                    <img src="https://images.unsplash.com/photo-1594824476967-48c8b964273f?w=400&h=400&fit=crop&q=80" 
                         alt="Sophie Martin" 
                         style="border-radius: 50%; width: 200px; height: 200px; object-fit: cover; margin: 0 auto 1rem; display: block; box-shadow: 0 4px 16px rgba(0,0,0,0.1);">
                    <h4>Sophie Martin</h4>
                    <p class="role">Assistante Dentaire</p>
                    <p>Diplômée depuis 10 ans, Sophie assiste le Dr. Dupont dans tous les soins.</p>
                </div>
                <div class="team-member">
                    <img src="https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?w=400&h=400&fit=crop&q=80" 
                         alt="Julie Bernard" 
                         style="border-radius: 50%; width: 200px; height: 200px; object-fit: cover; margin: 0 auto 1rem; display: block; box-shadow: 0 4px 16px rgba(0,0,0,0.1);">
                    <h4>Julie Bernard</h4>
                    <p class="role">Secrétaire Médicale</p>
                    <p>Julie gère les rendez-vous et accueille les patients avec le sourire.</p>
                </div>
            </div>
        </div>

        <div class="cabinet-info">
            <h3>Notre Cabinet</h3>
            <p>
                Situé au cœur de la ville, notre cabinet moderne et chaleureux dispose d'équipements 
                de dernière génération pour vous garantir des soins de qualité dans les meilleures 
                conditions.
            </p>
            <ul class="features-list">
                <li>🏥 Salle de soins équipée de technologies numériques</li>
                <li>🦷 Radiologie numérique à faible dose</li>
                <li>♿ Accès PMR (Personnes à Mobilité Réduite)</li>
                <li>🅿️ Parking à proximité</li>
                <li>🚇 Métro ligne 4 - Station Cité</li>
            </ul>
        </div>
    </div>
</section>

<section class="hours">
    <div class="container">
        <h3>Horaires d'Ouverture</h3>
        <table class="hours-table">
            <tr>
                <td>Lundi - Vendredi</td>
                <td>09:00 - 18:00</td>
            </tr>
            <tr>
                <td>Samedi</td>
                <td>Fermé</td>
            </tr>
            <tr>
                <td>Dimanche</td>
                <td>Fermé</td>
            </tr>
        </table>
        <p class="note">Sur rendez-vous uniquement</p>
    </div>
</section>

<section class="cta">
    <div class="container">
        <h2>Prêt à prendre soin de votre sourire ?</h2>
        <a href="<?= APP_URL ?>/booking" class="btn btn-primary btn-large">Prendre rendez-vous</a>
    </div>
</section>

<?php require TEMPLATE_PATH . '/layout/footer.php'; ?>
