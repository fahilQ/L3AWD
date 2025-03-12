-- Création de la table des questions
CREATE TABLE IF NOT EXISTS questions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    question_text TEXT NOT NULL,
    categorie VARCHAR(50),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Création de la table des réponses
CREATE TABLE IF NOT EXISTS reponses (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    question_id INT NOT NULL,
    reponse_text TEXT NOT NULL,
    date_reponse TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (question_id) REFERENCES questions(id),
    FOREIGN KEY (user_id) REFERENCES utilisateurs(id)
);

-- Insérer quelques questions de test
INSERT INTO questions (question_text, categorie) VALUES
('Quels sont vos objectifs entrepreneuriaux à court terme ?', 'Objectifs'),
('Quelles sont vos principales compétences professionnelles ?', 'Compétences'),
('Quel est votre domaine d\'expertise principal ?', 'Expertise'),
('Quels sont les défis que vous anticipez dans votre projet ?', 'Défis'),
('Comment envisagez-vous de financer votre projet ?', 'Finance'); 