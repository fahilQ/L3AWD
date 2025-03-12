<?php
session_start();
if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MyPIE - Cahier Personnel</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #34495e;
            --secondary-color: #2980b9;
            --accent-color: #c0392b;
            --success-color: #27ae60;
            --background-color: #ecf0f1;
        }

        body {
            font-family: 'Roboto', sans-serif;
            margin: 0;
            padding: 20px;
            background: linear-gradient(135deg, var(--background-color) 0%, #bdc3c7 100%);
            min-height: 100vh;
        }

        .container {
            max-width: 900px;
            margin: auto;
            background: white;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        }

        .section {
            margin-bottom: 30px;
            padding: 25px;
            border-radius: 8px;
            background: #fff;
            box-shadow: 0 1px 5px rgba(0,0,0,0.1);
            transition: transform 0.3s ease;
            animation: slideIn 0.5s ease forwards;
        }

        .section:hover {
            transform: translateY(-3px);
        }

        h1, h2 {
            color: var(--primary-color);
            text-align: center;
            margin-bottom: 20px;
        }

        .question {
            color: var(--primary-color);
            font-size: 1.2rem;
            margin-bottom: 15px;
            padding-bottom: 8px;
            border-bottom: 2px solid var(--secondary-color);
        }

        .numbered-input {
            margin-bottom: 20px;
            position: relative;
        }

        .numbered-input label {
            display: inline-block;
            width: 50px;
            color: var(--primary-color);
            font-weight: 600;
        }

        input[type="text"], textarea {
            width: calc(100% - 60px);
            padding: 10px;
            border: 1px solid #bdc3c7;
            border-radius: 5px;
            font-size: 1rem;
            transition: all 0.3s ease;
        }

        input[type="text"]:focus, textarea:focus {
            border-color: var(--secondary-color);
            box-shadow: 0 0 0 3px rgba(41, 128, 185, 0.2);
            outline: none;
        }

        textarea {
            min-height: 120px;
            width: 100%;
            resize: vertical;
        }

        table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            margin: 20px 0;
            border-radius: 8px;
            overflow: hidden;
        }

        th, td {
            padding: 12px;
            text-align: left;
            border: 1px solid #bdc3c7;
        }

        th {
            background: var(--secondary-color);
            color: white;
            font-weight: 600;
        }

        td {
            background: white;
        }
        .action_1{
            width: 50%;
        }
        .nav-buttons {
            position: fixed;
            bottom: 20px;
            right: 20px;
            display: flex;
            gap: 10px;
            z-index: 1000;
        }

        .nav-btn {
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            background: var(--secondary-color);
            color: white;
            cursor: pointer;
            font-weight: 600;
            transition: transform 0.2s, background 0.3s;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .nav-btn:hover {
            transform: translateY(-2px);
            background: #1f618d;
        }

        .nav-btn.save {
            background: var(--success-color);
        }

        .nav-btn.save:hover {
            background: #27ae60;
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .progress-container {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 4px;
            background: #eee;
            z-index: 1000;
        }

        .progress-bar {
            height: 100%;
            background: var(--secondary-color);
            width: 0%;
            transition: width 0.3s ease;
        }

        @media (max-width: 768px) {
            .container {
                padding: 20px;
                margin: 10px;
            }

            input[type="text"], textarea {
                width: 90%;
            }

            .nav-buttons {
                bottom: 10px;
                right: 10px;
            }

            table {
                display: block;
                overflow-x: auto;
            }
        }
    </style>
</head>
<body>
    <div class="progress-container">
        <div class="progress-bar" id="progressBar"></div>
    </div>

    <div class="container">
        <h1>CAHIER PERSONNEL DU STAGIAIRE</h1>
        
        <form id="pieForm" method="POST" action="#">
            <!-- Section 1: Tags personnels -->
            <div class="section active">
                <p class="question">1. Chacun écrit sur son cahier les 3 mots (tags) que vous voulez que les gens retiennent de vous :</p>
                <div class="numbered-input">
                    <label>1.1.</label>
                    <input type="text" name="tag_1" id="tag_1" required>
                </div>
                <div class="numbered-input">
                    <label>1.2.</label>
                    <input type="text" name="tag_2" id="tag_2" required>
                </div>
                <div class="numbered-input">
                    <label>1.3.</label>
                    <input type="text" name="tag_3" id="tag_3" required>
                </div>
            </div>

            <!-- Section 2: Actions quotidiennes -->
            <div class="section">
                <p class="question">2. Quelles sont les actions du quotidien que vous faites aujourd'hui qui vous permettent de justifier cela ?</p>
                <table>
                    <thead>
                        <tr>
                            <th>Mon Tag (reprenez les 3 mots que vous venez d'indiquer)</th>
                            <th>Donnez un exemple d'une action que vous faites au quotidien qui prouve votre tag</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1-</td>
                            <td><textarea name="action_1" id="action_1" required></textarea></td>
                        </tr>
                        <tr>
                            <td>2-</td>
                            <td><textarea name="action_2" id="action_2" required></textarea></td>
                        </tr>
                        <tr>
                            <td>3-</td>
                            <td><textarea name="action_3" id="action_3" required></textarea></td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Section 3: Confiance -->
            <div class="section">
                <p class="question">3. Êtes vous une personne de confiance ? Si oui, pourquoi ? Si non, pourquoi ?</p>
                <textarea name="confiance" id="confiance" required></textarea>
            </div>

            <!-- Section 4: Mots des collègues -->
            <div class="section">
                <p class="question">4. Quels sont les mots qu'ont écrit vos collègues</p>
                <?php for($i = 1; $i <= 11; $i++): ?>
                    <div class="numbered-input">
                        <label>4.<?php echo $i; ?>.</label>
                        <input type="text" name="mot_collegue_<?php echo $i; ?>" id="mot_collegue_<?php echo $i; ?>" required>
                    </div>
                <?php endfor; ?>

                <p class="question" style="margin-top: 20px;">Quels sont les points communs ? Les différences ?</p>
                <textarea name="points_communs" id="points_communs" required></textarea>
            </div>

            <!-- Section 5: Réputation -->
            <div class="section">
                <p class="question">Comment construire votre réputation autour des mots clés que vous voulez ? même si vous n'êtes pas encore aujourd'hui ce que vous voulez devenir</p>
                <textarea name="construction_reputation" id="construction_reputation" required></textarea>
            </div>

            <!-- Section 6-8: Exemplarité -->
            <div class="section">
                <p class="question">Que signifie "être exemplaire" ?</p>
                <textarea name="etre_exemplaire" id="etre_exemplaire" required></textarea>
            </div>

            <div class="section">
                <p class="question">Comment pouvez-vous devenir exemplaire ?</p>
                <textarea name="devenir_exemplaire" id="devenir_exemplaire" required></textarea>
            </div>

            <div class="section">
                <p class="question">Que devez vous apprendre pour devenir exemplaire ?</p>
                <textarea name="apprentissage_exemplaire" id="apprentissage_exemplaire" required></textarea>
            </div>

            <!-- Section 9: Les Valeurs -->
            <div class="section">
                <h2>LES VALEURS</h2>
                
                <div class="subsection">
                    <p class="question">Réflexion individuelle : Quelles sont vos 5 valeurs clés avec lesquelles vous vivez au quotidien ?</p>
                    <?php for($i = 1; $i <= 5; $i++): ?>
                        <div class="numbered-input">
                            <label><?php echo $i; ?>.</label>
                            <input type="text" name="valeur_perso_<?php echo $i; ?>" id="valeur_perso_<?php echo $i; ?>" required>
                        </div>
                    <?php endfor; ?>
                </div>

                <div class="subsection">
                    <p class="question">Demandez à vos collègues de faire une liste des 5 valeurs qui vous caractérisent</p>
                    <?php for($i = 1; $i <= 5; $i++): ?>
                        <div class="numbered-input">
                            <label><?php echo $i; ?>.</label>
                            <input type="text" name="valeur_collegue_<?php echo $i; ?>" id="valeur_collegue_<?php echo $i; ?>" required>
                        </div>
                    <?php endfor; ?>
                </div>

                <div class="subsection">
                    <p class="question">Débrief collectif en groupe sur les écarts ou les similarités</p>
                    <textarea name="debrief_valeurs" id="debrief_valeurs" required></textarea>
                </div>
            </div>

            <!-- Section 10: Les Causes -->
            <div class="section">
                <h2>LES CAUSES</h2>
                
                <div class="subsection">
                    <p class="question">Y-a-t-il des causes qui te tiennent à cœur sur lesquelles tu veux contribuer ?</p>
                    <?php for($i = 1; $i <= 5; $i++): ?>
                        <div class="numbered-input">
                            <input type="text" name="cause_<?php echo $i; ?>" id="cause_<?php echo $i; ?>" 
                                   placeholder="Cause <?php echo $i; ?>" required>
                        </div>
                    <?php endfor; ?>
                </div>

                <div class="subsection">
                    <p class="question">Quelles sont les actions concrètes que tu fais aujourd'hui qui prouvent que ces causes te tiennent à cœur ?</p>
                    <table>
                        <thead>
                            <tr>
                                <th>La cause</th>
                                <th>Actions concrètes</th>
                                <th>Lectures</th>
                                <th>Actualité</th>
                                <th>Engagement</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php for($i = 1; $i <= 5; $i++): ?>
                            <tr>
                                <td><?php echo $i; ?></td>
                                <td><textarea name="actions_cause_<?php echo $i; ?>" required></textarea></td>
                                <td><textarea name="lectures_cause_<?php echo $i; ?>" required></textarea></td>
                                <td><textarea name="actualite_cause_<?php echo $i; ?>" required></textarea></td>
                                <td><textarea name="engagement_cause_<?php echo $i; ?>" required></textarea></td>
                            </tr>
                            <?php endfor; ?>
                        </tbody>
                    </table>
                </div>

                <div class="subsection">
                    <p class="question">Si tu ne fais pas d'actions aujourd'hui, souhaiterais-tu t'engager dans une cause pour le mois prochain ?</p>
                    <textarea name="engagement_futur" id="engagement_futur" required></textarea>
                </div>
            </div>

            <!-- Boutons de navigation -->
            <div class="nav-buttons">
                <button type="button" class="nav-btn" id="prevBtn">
                    <i class="fas fa-arrow-left"></i> Précédent
                </button>
                <button type="button" class="nav-btn" id="nextBtn">
                    Terminer <i class="fas fa-arrow-right"></i>
                </button>
            </div>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('pieForm');
            const sections = document.querySelectorAll('.section');
            const progressBar = document.getElementById('progressBar');
            const prevBtn = document.getElementById('prevBtn');
            const nextBtn = document.getElementById('nextBtn');
            
            let currentSection = 0;
            updateProgress();

            // Navigation
            prevBtn.addEventListener('click', () => {
                if (currentSection > 0) {
                    sections[currentSection].style.display = 'none';
                    currentSection--;
                    sections[currentSection].style.display = 'block';
                    updateProgress();
                }
            });

            nextBtn.addEventListener('click', () => {
                if (currentSection < sections.length - 1) {
                    if (validateSection(sections[currentSection])) {
                        sections[currentSection].style.display = 'none';
                        currentSection++;
                        sections[currentSection].style.display = 'block';
                        updateProgress();
                    }
                } else {
                    // If it's the last section and it's valid
                    if (validateSection(sections[currentSection])) {
                        // Display confirmation message
                        alert('Vos réponses ont été enregistrées avec succès !');
                        // Redirect to homepage
                        window.location.href = 'index.php'; // Change 'index.php' to your homepage URL
                    }
                }
            });

            function validateSection(section) {
                const requiredInputs = section.querySelectorAll('[required]');
                let isValid = true;

                requiredInputs.forEach(input => {
                    if (!input.value.trim()) {
                        isValid = false;
                        input.style.borderColor = 'var(--accent-color)';
                    } else {
                        input.style.borderColor = '#e0e0e0';
                    }
                });

                if (!isValid) {
                    alert('Veuillez remplir tous les champs obligatoires.');
                }

                return isValid;
            }

            function updateProgress() {
                const progress = ((currentSection + 1) / sections.length) * 100;
                progressBar.style.width = `${progress}%`;
                prevBtn.style.display = currentSection === 0 ? 'none' : 'block';
                nextBtn.textContent = currentSection === sections.length - 1 ? 'Terminer' : 'Suivant';
            }

            // Initialisation
            sections.forEach((section, index) => {
                if (index !== 0) section.style.display = 'none';
            });
        });
    </script>
</body>
</html> 