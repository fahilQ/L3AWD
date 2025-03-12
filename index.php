<?php
session_start();
$isLoggedIn = isset($_SESSION['username']);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MyPIE Journal</title>
    <link rel="stylesheet" href="styles.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .profile-menu {
            position: relative;
            display: inline-block;
        }

        .profile-button {
            background: none;
            border: none;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 8px;
            border-radius: 20px;
            transition: background-color 0.3s;
        }

        .profile-button:hover {
            background-color: rgba(0, 0, 0, 0.1);
        }

        .profile-image {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            background-color: #ddd;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .dropdown-menu {
            position: absolute;
            top: 100%;
            right: 0;
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            padding: 8px 0;
            min-width: 200px;
            display: none;
            z-index: 1000;
        }

        .dropdown-menu.show {
            display: block;
        }

        .dropdown-item {
            padding: 8px 16px;
            display: flex;
            align-items: center;
            gap: 8px;
            color: #333;
            text-decoration: none;
            transition: background-color 0.3s;
        }

        .dropdown-item:hover {
            background-color: #f5f5f5;
        }

        .dropdown-divider {
            height: 1px;
            background-color: #eee;
            margin: 8px 0;
        }

        /* Ajout des styles pour le footer */
        footer {
            background: var(--primary-color);
            color: var(--white);
            padding: 2rem 0;
            margin-top: 4rem;
            text-align: center;
        }

        .social-links {
            display: flex;
            justify-content: center;
            gap: 2rem;
            margin: 1rem 0;
        }

        .social-links a {
            color: var(--white);
            font-size: 1.5rem;
            transition: transform 0.3s ease, color 0.3s ease;
        }

        .social-links a:hover {
            transform: translateY(-3px);
            color: var(--secondary-color);
        }

        .footer-text {
            font-size: 0.9rem;
            color: var(--text-light);
            margin-top: 1rem;
        }

        .partners {
            padding: 4rem 0;
            background-color: var(--white);
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 1rem;
        }

        .partners-title {
            text-align: center;
            color: var(--primary-color);
            font-size: 2.5rem;
            margin-bottom: 3rem;
        }

        .partners-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 3rem;
        }

        .university-partners, .collaborators {
            text-align: center;
        }

        .university-partners h3, .collaborators h3 {
            color: var(--secondary-color);
            font-size: 1.8rem;
            margin-bottom: 2rem;
        }

        .university-list, .collaborator-list {
            display: flex;
            flex-direction: column;
            gap: 2rem;
        }

        .partner-item {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 1rem;
        }

        .partner-logo {
            width: 150px;
            height: 150px;
            object-fit: contain;
            transition: transform 0.3s ease;
        }

        .partner-item:hover .partner-logo {
            transform: scale(1.05);
        }

        .partner-item span {
            font-size: 1.1rem;
            color: var(--text-color);
            font-weight: 500;
        }

        @media (max-width: 768px) {
            .partners-grid {
                grid-template-columns: 1fr;
                gap: 2rem;
            }

            .partners-title {
                font-size: 2rem;
            }

            .university-partners h3, .collaborators h3 {
                font-size: 1.5rem;
            }
        }
    </style>
</head>
<body>
    <header>
        <nav class="navbar">
            <div class="logo">
                <h1>MyPIE Journal</h1>
            </div>
            <div class="nav-links">
                <a href="#" class="nav-item">Accueil</a>
                <a href="#" class="nav-item">Mon Cahier</a>
                <?php if ($isLoggedIn): ?>
                    <a href="1.html" class="nav-item">Quiz & Évaluation</a>
                <?php else: ?>
                    <a href="login.php" class="nav-item">Quiz & Évaluation</a>
                <?php endif; ?>
                <a href="#" class="nav-item">Outils & Ressources</a>
                <a href="#" class="nav-item">À propos</a>
            </div>
            <div class="auth-buttons">
                <?php if ($isLoggedIn): ?>
                    <div class="profile-menu">
                        <button class="profile-button" onclick="toggleDropdown()">
                            <div class="profile-image">
                                👤
                            </div>
                            <span><?php echo htmlspecialchars($_SESSION['username']); ?></span>
                        </button>
                        <div class="dropdown-menu" id="profileDropdown">
                            <a href="#" class="dropdown-item">
                                👤 Mon Profil
                            </a>
                            <a href="mes-progres.php" class="dropdown-item">
                                📊 Mes Progrès
                            </a>
                            <a href="#" class="dropdown-item">
                                ⚙️ Paramètres
                            </a>
                            <div class="dropdown-divider"></div>
                            <a href="logout.php" class="dropdown-item">
                                🚪 Déconnexion
                            </a>
                        </div>
                    </div>
                <?php else: ?>
                    <a href="login.php"><button class="btn-connexion">Connexion</button></a>
                <?php endif; ?>
            </div>
        </nav>
    </header>

    <main>
        <section class="hero">
            <div class="hero-content">
                <h2>Introducing <span class="highlight">Educational Suite</span></h2>
                <div class="quote">
                    <h1>"Êtes-vous prêt à découvrir votre potentiel entrepreneurial ?"</h1>
                    <p>Commencez votre voyage maintenant</p>
                </div>
                <p class="subtitle">Bienvenue dans votre espace de réflexion et d'apprentissage.<br>Construisez votre parcours entrepreneurial !</p>
                <div class="cta-buttons">
                    <?php if ($isLoggedIn): ?>
                        <a href="page1.html"><button class="btn-primary">Commencer le quiz</button></a>
                    <?php else: ?>
                        <a href="login.php"><button class="btn-primary">Commencer le quiz</button></a>
                    <?php endif; ?>
                    <button class="btn-secondary">Découvrir le programme</button>
                </div>
            </div>
        </section>
    </main>

    <section class="partners">
        <div class="container">
            <h2 class="partners-title">Nos Partenaires</h2>
            <div class="partners-grid">
                <div class="university-partners">
                    <h3>Universités Partenaires</h3>
                    <div class="university-list">
                        <div class="partner-item">
                            <img src="assets/images/LOGO_Ofppt.png" alt="OFPPT" class="partner-logo">
                            <span>Office de la Formation Professionnelle et de la Promotion du Travail</span>
                        </div>
                        <div class="partner-item">
                            <img src="assets/images/UMP.png" alt="UMP" class="partner-logo">
                            <span>Université Mohammed Premier</span>
                        </div>
                    </div>
                </div>
                <div class="collaborators">
                    <h3>Collaborateurs</h3>
                    <div class="collaborator-list">
                        <div class="partner-item">
                            <img src="assets/images/Baleez.png" alt="Baleez" class="partner-logo">
                            <span>Baleez</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <footer>
        <div class="social-links">
            <a href="https://facebook.com" target="_blank" title="Facebook">
                <i class="fab fa-facebook"></i>
            </a>
            <a href="https://twitter.com" target="_blank" title="Twitter">
                <i class="fab fa-twitter"></i>
            </a>
            <a href="https://linkedin.com" target="_blank" title="LinkedIn">
                <i class="fab fa-linkedin"></i>
            </a>
            <a href="https://instagram.com" target="_blank" title="Instagram">
                <i class="fab fa-instagram"></i>
            </a>
            <a href="https://youtube.com" target="_blank" title="YouTube">
                <i class="fab fa-youtube"></i>
            </a>
        </div>
        <p class="footer-text">&copy; 2024 MyPIE Journal. Tous droits réservés.</p>
    </footer>

    <script>
    function toggleDropdown() {
        const dropdown = document.getElementById('profileDropdown');
        dropdown.classList.toggle('show');
    }

    // Fermer le menu déroulant si l'utilisateur clique en dehors
    window.onclick = function(event) {
        if (!event.target.matches('.profile-button') && !event.target.matches('.profile-image')) {
            const dropdowns = document.getElementsByClassName('dropdown-menu');
            for (let dropdown of dropdowns) {
                if (dropdown.classList.contains('show')) {
                    dropdown.classList.remove('show');
                }
            }
        }
    }
    </script>
</body>
</html> 