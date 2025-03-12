<?php
session_start();
if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit();
}

include 'config.php';

// Récupérer les réponses de l'utilisateur
$username = $_SESSION['username'];
$sql = "SELECT r.*, q.question_text 
        FROM reponses r 
        JOIN questions q ON r.question_id = q.id 
        WHERE r.user_id = (SELECT id FROM utilisateurs WHERE identifiant = ?)
        ORDER BY r.date_reponse DESC";

$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mes Progrès - MyPIE Journal</title>
    <link rel="stylesheet" href="styles.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .progress-container {
            max-width: 1200px;
            margin: 2rem auto;
            padding: 2rem;
            background: var(--white);
            border-radius: 12px;
            box-shadow: var(--shadow);
        }

        .progress-header {
            text-align: center;
            margin-bottom: 3rem;
        }

        .progress-header h1 {
            color: var(--primary-color);
            font-size: 2.5rem;
            margin-bottom: 1rem;
        }

        .progress-stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 2rem;
            margin-bottom: 3rem;
        }

        .stat-card {
            background: var(--light-bg);
            padding: 1.5rem;
            border-radius: 8px;
            text-align: center;
        }

        .stat-card h3 {
            color: var(--secondary-color);
            margin-bottom: 0.5rem;
        }

        .stat-card .value {
            font-size: 2rem;
            font-weight: bold;
            color: var(--primary-color);
        }

        .responses-list {
            display: flex;
            flex-direction: column;
            gap: 1.5rem;
        }

        .response-item {
            background: var(--light-bg);
            padding: 1.5rem;
            border-radius: 8px;
            border-left: 4px solid var(--primary-color);
        }

        .response-item .question {
            font-weight: 600;
            color: var(--text-color);
            margin-bottom: 0.5rem;
        }

        .response-item .answer {
            color: var(--text-color);
            margin-bottom: 0.5rem;
        }

        .response-item .date {
            font-size: 0.9rem;
            color: var(--text-light);
        }

        .no-responses {
            text-align: center;
            padding: 2rem;
            color: var(--text-light);
            font-style: italic;
        }

        @media (max-width: 768px) {
            .progress-container {
                margin: 1rem;
                padding: 1rem;
            }

            .progress-header h1 {
                font-size: 2rem;
            }

            .stat-card .value {
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
                <a href="index.php" class="nav-item">Accueil</a>
                <a href="#" class="nav-item">Mon Cahier</a>
                <a href="1.html" class="nav-item">Quiz & Évaluation</a>
                <a href="#" class="nav-item">Outils & Ressources</a>
                <a href="#" class="nav-item">À propos</a>
            </div>
            <div class="auth-buttons">
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
            </div>
        </nav>
    </header>

    <main>
        <div class="progress-container">
            <div class="progress-header">
                <h1>Mes Progrès</h1>
                <p>Suivez votre évolution et vos réponses aux questionnaires</p>
            </div>

            <div class="progress-stats">
                <div class="stat-card">
                    <h3>Questions Répondues</h3>
                    <div class="value"><?php echo $result->num_rows; ?></div>
                </div>
                <!-- Ajoutez d'autres statistiques ici si nécessaire -->
            </div>

            <div class="responses-list">
                <?php if ($result->num_rows > 0): ?>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <div class="response-item">
                            <div class="question">
                                <i class="fas fa-question-circle"></i>
                                <?php echo htmlspecialchars($row['question_text']); ?>
                            </div>
                            <div class="answer">
                                <i class="fas fa-comment"></i>
                                <?php echo htmlspecialchars($row['reponse_text']); ?>
                            </div>
                            <div class="date">
                                <i class="fas fa-calendar"></i>
                                <?php echo date('d/m/Y H:i', strtotime($row['date_reponse'])); ?>
                            </div>
                        </div>
                    <?php endwhile; ?>
                <?php else: ?>
                    <div class="no-responses">
                        <p>Vous n'avez pas encore répondu à des questions.</p>
                        <a href="1.html"><button class="btn-primary">Commencer le quiz</button></a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </main>

    <?php include 'footer.php'; ?>

    <script>
    function toggleDropdown() {
        const dropdown = document.getElementById('profileDropdown');
        dropdown.classList.toggle('show');
    }

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