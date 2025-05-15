
CREATE DATABASE IF NOT EXISTS wedding_db;
USE wedding_db;
DROP TABLE contact_requests;
CREATE TABLE contact_requests (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100) NOT NULL,
    prenom VARCHAR(100) NOT NULL,
    nb_personnes INT,
    presence VARCHAR(255) NOT NULL,
    musique TEXT NOT NULL,
    participation TEXT NOT NULL,
    submitted_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);



CREATE TABLE IF NOT EXISTS faq (
    id INT AUTO_INCREMENT PRIMARY KEY,
    question TEXT,
    answer TEXT
);
