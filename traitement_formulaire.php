<?php
session_start();
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_SESSION['username'])) {
    try {
        $conn->begin_transaction();
        
        // Utiliser l'identifiant de l'utilisateur connecté
        $identifiant = $_SESSION['username'];

        // Insérer d'abord dans pie_formulaire
        $stmt = $conn->prepare("INSERT INTO pie_formulaire (identifiant) VALUES (?)");
        $stmt->bind_param("s", $identifiant);
        $stmt->execute();

        // 2. Traiter les tags personnels (Question 1)
        for ($i = 1; $i <= 3; $i++) {
            $tag = $POST["tag$i"] ?? '';
            if (!empty($tag)) {
                $stmt = $conn->prepare("INSERT INTO tags_personnels (identifiant, tag_numero, tag_texte) VALUES (?, ?, ?)");
                $stmt->bind_param("sis", $identifiant, $i, $tag);
                $stmt->execute();
                $tag_id = $stmt->insert_id;

                // Insérer l'action quotidienne correspondante (Question 2)
                $action = $POST["action$i"] ?? '';
                if (!empty($action)) {
                    $stmt = $conn->prepare("INSERT INTO actions_quotidiennes (identifiant, tag_id, action_texte) VALUES (?, ?, ?)");
                    $stmt->bind_param("sis", $identifiant, $tag_id, $action);
                    $stmt->execute();
                }
            }
        }

        // 3. Traiter la réponse sur la confiance (Question 3)
        $confiance = $_POST['confiance'] ?? '';
        if (!empty($confiance)) {
            $stmt = $conn->prepare("INSERT INTO confiance (identifiant, reponse) VALUES (?, ?)");
            $stmt->bind_param("ss", $identifiant, $confiance);
            $stmt->execute();
        }

        // 4. Traiter les mots des collègues (Question 4)
        for ($i = 1; $i <= 11; $i++) {
            $mot = $POST["mot_collegue$i"] ?? '';
            if (!empty($mot)) {
                $stmt = $conn->prepare("INSERT INTO mots_collegues (identifiant, numero, mot) VALUES (?, ?, ?)");
                $stmt->bind_param("sis", $identifiant, $i, $mot);
                $stmt->execute();
            }
        }

        // 5. Traiter les réflexions
        $types_reflexion = [
            'points_communs' => $_POST['points_communs'] ?? '',
            'construction_reputation' => $_POST['construction_reputation'] ?? '',
            'etre_exemplaire' => $_POST['etre_exemplaire'] ?? '',
            'devenir_exemplaire' => $_POST['devenir_exemplaire'] ?? '',
            'apprentissage_exemplaire' => $_POST['apprentissage_exemplaire'] ?? ''
        ];

        foreach ($types_reflexion as $type => $contenu) {
            if (!empty($contenu)) {
                $stmt = $conn->prepare("INSERT INTO reflexions (identifiant, type_reflexion, contenu) VALUES (?, ?, ?)");
                $stmt->bind_param("sss", $identifiant, $type, $contenu);
                $stmt->execute();
            }
        }

        // 6. Traiter les valeurs personnelles
        for ($i = 1; $i <= 5; $i++) {
            // Valeurs personnelles
            $valeur_perso = $POST["valeur_perso$i"] ?? '';
            if (!empty($valeur_perso)) {
                $type = 'personnelle';
                $stmt = $conn->prepare("INSERT INTO valeurs_personnelles (identifiant, numero, valeur, type) VALUES (?, ?, ?, ?)");
                $stmt->bind_param("sis", $identifiant, $i, $valeur_perso, $type);
                $stmt->execute();
            }

            // Valeurs des collègues
            $valeur_collegue = $POST["valeur_collegue$i"] ?? '';
            if (!empty($valeur_collegue)) {
                $type = 'collegues';
                $stmt = $conn->prepare("INSERT INTO valeurs_personnelles (identifiant, numero, valeur, type) VALUES (?, ?, ?, ?)");
                $stmt->bind_param("sis", $identifiant, $i, $valeur_collegue, $type);
                $stmt->execute();
            }
        }

        // 7. Traiter le débrief des valeurs
        $debrief = $_POST['debrief_valeurs'] ?? '';
        if (!empty($debrief)) {
            $stmt = $conn->prepare("INSERT INTO debrief_valeurs (identifiant, reflexion) VALUES (?, ?)");
            $stmt->bind_param("ss", $identifiant, $debrief);
            $stmt->execute();
        }

        // 8. Traiter les causes
        for ($i = 1; $i <= 5; $i++) {
            $cause = $POST["cause$i"] ?? '';
            if (!empty($cause)) {
                $stmt = $conn->prepare("INSERT INTO causes (identifiant, cause) VALUES (?, ?)");
                $stmt->bind_param("ss", $identifiant, $cause);
                $stmt->execute();
                $cause_id = $stmt->insert_id;

                // Insérer les actions liées aux causes
                $actions = $POST["actions_cause$i"] ?? '';
                $lectures = $POST["lectures_cause$i"] ?? '';
                $actualite = $POST["actualite_cause$i"] ?? '';
                $engagement = $POST["engagement_cause$i"] ?? '';

                $stmt = $conn->prepare("INSERT INTO actions_causes (cause_id, actions_concretes, lectures, actualite, engagement) VALUES (?, ?, ?, ?, ?)");
                $stmt->bind_param("issss", $cause_id, $actions, $lectures, $actualite, $engagement);
                $stmt->execute();
            }
        }

        // 9. Traiter l'engagement futur
        $engagement_futur = $_POST['engagement_futur'] ?? '';
        if (!empty($engagement_futur)) {
            $stmt = $conn->prepare("INSERT INTO engagement_futur (identifiant, engagement) VALUES (?, ?)");
            $stmt->bind_param("ss", $identifiant, $engagement_futur);
            $stmt->execute();
        }

        $conn->commit();
        $_SESSION['message'] = "Vos réponses ont été enregistrées avec succès.";
        header("Location: succes.php");
        exit();

    } catch (Exception $e) {
        $conn->rollback();
        $_SESSION['error'] = "Une erreur est survenue lors de l'enregistrement.";
        header("Location: erreur.php");
        exit();
    }
} else {
    $_SESSION['error'] = "Vous devez être connecté pour soumettre le formulaire.";
    header("Location: login.php");
    exit();
}
?>