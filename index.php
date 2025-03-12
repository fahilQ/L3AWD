<?php
session_start();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MyPIE - Plateforme Interactive Éducative</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar">
        <div class="logo">
            <img src="img/logo.png" alt="MyPIE Logo">
            <h1>MyPIE</h1>
        </div>
        <div class="nav-links">
            <a href="index.php" class="active">Accueil</a>
            <a href="formulaire.php">Mon Cahier</a>
            <a href="about.php">À propos</a>
            <?php if(isset($_SESSION['username'])): ?>
                <a href="profil.php" class="user-link">
                    <i class="fas fa-user"></i> <?php echo htmlspecialchars($_SESSION['username']); ?>
                </a>
                <a href="logout.php" class="logout-btn">
                    <i class="fas fa-sign-out-alt"></i> Déconnexion
                </a>
            <?php else: ?>
                <a href="login.php" class="login-btn">
                    <i class="fas fa-sign-in-alt"></i> Connexion
                </a>
            <?php endif; ?>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero">
        <div class="hero-content">
            <h1>Bienvenue sur <span class="highlight">MyPIE</span></h1>
            <p class="subtitle">Votre plateforme d'apprentissage personnalisée</p>
            <div class="cta-buttons">
                <?php if(isset($_SESSION['username'])): ?>
                    <a href="formulaire.php" class="btn btn-primary">
                        <i class="fas fa-book-open"></i> Accéder à mon cahier
                    </a>
                <?php else: ?>
                    <a href="login.php" class="btn btn-primary">
                        <i class="fas fa-sign-in-alt"></i> Commencer
                    </a>
                <?php endif; ?>
                <a href="about.php" class="btn btn-secondary">
                    <i class="fas fa-info-circle"></i> En savoir plus
                </a>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="features">
        <h2>Découvrez nos fonctionnalités</h2>
        <div class="features-grid">
            <div class="feature-card">
                <i class="fas fa-book"></i>
                <h3>Cahier Personnel</h3>
                <p>Gardez une trace de votre progression et de vos réflexions</p>
            </div>
            <div class="feature-card">
                <i class="fas fa-chart-line"></i>
                <h3>Suivi de Progression</h3>
                <p>Visualisez votre évolution au fil du temps</p>
            </div>
            <div class="feature-card">
                <i class="fas fa-users"></i>
                <h3>Collaboration</h3>
                <p>Partagez et apprenez avec vos pairs</p>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer>
        <div class="footer-content">
            <div class="footer-section">
                <h3>MyPIE</h3>
                <p>Plateforme Interactive Éducative</p>
            </div>
            <div class="footer-section">
                <h3>Liens Rapides</h3>
                <a href="index.php">Accueil</a>
                <a href="formulaire.php">Mon Cahier</a>
                <a href="about.php">À propos</a>
            </div>
            <div class="footer-section">
                <h3>Contact</h3>
                <p><i class="fas fa-envelope"></i> contact@mypie.com</p>
                <p><i class="fas fa-phone"></i> +212 123 456 789</p>
            </div>
        </div>
        <div class="footer-bottom">
            <p>&copy; 2024 MyPIE. Tous droits réservés.</p>
        </div>
    </footer>
</body>
</html> 