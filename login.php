<?php
session_start();
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM utilisateurs WHERE identifiant = ? AND mot_de_passe = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $_SESSION['username'] = $username;
        header("Location: index.php");
        exit();
    } else {
        $error = "Identifiant ou mot de passe incorrect";
    }

    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion - MyPIE Journal</title>
    <link rel="stylesheet" href="styles.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .login-container {
            background: var(--white);
            padding: 3rem;
            border-radius: 12px;
            box-shadow: var(--shadow);
            width: 100%;
            max-width: 450px;
            margin: 2rem auto;
            position: relative;
            z-index: 2;
        }

        .login-container h2 {
            color: var(--primary-color);
            text-align: center;
            font-size: 2rem;
            margin-bottom: 2rem;
            font-weight: 700;
        }

        .form-group {
            margin-bottom: 1.5rem;
            position: relative;
        }

        .form-group i {
            position: absolute;
            left: 15px;
            top: 45px;
            color: var(--text-light);
        }

        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            color: var(--text-color);
            font-weight: 500;
            font-size: 0.95rem;
        }

        .form-group input {
            width: 100%;
            padding: 0.8rem 1rem 0.8rem 2.5rem;
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            font-size: 1rem;
            transition: all 0.3s ease;
            font-family: 'Poppins', sans-serif;
        }

        .form-group input:focus {
            border-color: var(--secondary-color);
            outline: none;
            box-shadow: 0 0 0 3px rgba(9, 132, 227, 0.1);
        }

        .error-message {
            background-color: rgba(231, 76, 60, 0.1);
            color: #e74c3c;
            padding: 1rem;
            border-radius: 8px;
            margin-bottom: 1.5rem;
            font-size: 0.9rem;
            border: 1px solid rgba(231, 76, 60, 0.3);
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .login-btn {
            width: 100%;
            padding: 1rem;
            background: var(--gradient-primary);
            color: var(--white);
            border: none;
            border-radius: 8px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-top: 1rem;
            font-family: 'Poppins', sans-serif;
        }

        .login-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(9, 132, 227, 0.2);
        }

        .register-link {
            text-align: center;
            margin-top: 1.5rem;
            color: var(--text-light);
        }

        .register-link a {
            color: var(--secondary-color);
            text-decoration: none;
            font-weight: 500;
            transition: color 0.3s ease;
        }

        .register-link a:hover {
            color: var(--accent-color);
        }

        @media (max-width: 768px) {
            .login-container {
                margin: 1rem;
                padding: 2rem;
            }
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
                <a href="#" class="nav-item">Quiz & Évaluation</a>
                <a href="#" class="nav-item">Outils & Ressources</a>
                <a href="#" class="nav-item">À propos</a>
            </div>
            <div class="auth-buttons">
                <a href="login.php"><button class="btn-connexion">Connexion</button></a>
            </div>
        </nav>
    </header>

    <main>
        <section class="hero">
            <div class="login-container">
                <h2>Connexion</h2>
                <?php if(isset($error)): ?>
                    <div class="error-message">
                        <i class="fas fa-exclamation-circle"></i>
                        <?php echo htmlspecialchars($error); ?>
                    </div>
                <?php endif; ?>
                <form method="post" action="login.php">
                    <div class="form-group">
                        <label for="username">Identifiant</label>
                        <i class="fas fa-user"></i>
                        <input type="text" id="username" name="username" required 
                               minlength="3" pattern="[a-zA-Z0-9_-]+" 
                               title="Caractères alphanumériques uniquement">
                    </div>
                    <div class="form-group">
                        <label for="password">Mot de passe</label>
                        <i class="fas fa-lock"></i>
                        <input type="password" id="password" name="password" required minlength="6">
                    </div>
                    <button type="submit" class="login-btn">
                        Se connecter
                    </button>
                </form>
            </div>
        </section>
    </main>

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

    <script src="script.js"></script>
</body>
</html> 