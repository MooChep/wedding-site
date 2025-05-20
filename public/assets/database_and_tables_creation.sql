drop database wedding_db;
CREATE DATABASE IF NOT EXISTS wedding_db;
USE wedding_db;
CREATE TABLE IF NOT EXISTS `personne` (
  `id_personne` INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `nom` VARCHAR(100) NOT NULL,
  `prenom` VARCHAR(100) NOT NULL,
  `id_presence` INT NOT NULL,
  `id_rsvp` INT NOT NULL
);

CREATE TABLE IF NOT EXISTS `musique` (
  `id_musique` INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `nom` VARCHAR(100) NOT NULL,
  `id_personne` VARCHAR(100) NOT NULL
);

CREATE TABLE IF NOT EXISTS `RSVP` (
  `id_rsvp` INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `date_rsvp` timestamp
);

CREATE TABLE IF NOT EXISTS `presence` (
  `id_presence` INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `desc` VARCHAR(100)
);

CREATE TABLE IF NOT EXISTS `faq` (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100),
    email VARCHAR(150),
    question TEXT NOT NULL,
    reponse TEXT DEFAULT NULL,
    visible BOOLEAN DEFAULT FALSE,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);
ALTER TABLE `musique` ADD FOREIGN KEY (`id_personne`) REFERENCES `personne` (`id_personne`);

ALTER TABLE `personne` ADD FOREIGN KEY (`id_presence`) REFERENCES `presence` (`id_presence`);

ALTER TABLE `personne` ADD FOREIGN KEY (`id_rsvp`) REFERENCES `RSVP` (`id_rsvp`);
