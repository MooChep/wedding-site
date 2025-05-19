<?php
namespace App\Model;

use PDO;

class Personne
{
    private PDO $pdo; // ← OBLIGATOIRE pour éviter l’erreur

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function findAll(): array
    {
        $stmt = $this->pdo->query('SELECT * FROM personne');
        return $stmt->fetchAll();
    }

    public function add(array $data): bool
    {
        $sql = "INSERT INTO personne (nom, prenom, id_presence, id_rsvp) VALUES (:nom, :prenom, :id_presence, :id_rsvp)";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            ':nom' => $data['nom'],
            ':prenom' => $data['prenom'],
            ':id_presence' => $data['id_presence'],
            ':id_rsvp' => $data['id_rsvp'],
        ]);
    }

    public function insertRSVP(): int
{
    $stmt = $this->pdo->prepare("INSERT INTO RSVP (date_rsvp) VALUES (NOW())");
    $stmt->execute();
    return $this->pdo->lastInsertId();
}

public function insertPersonne($nom, $prenom, $id_presence, $id_rsvp)
{
    $query = "INSERT INTO personne (nom, prenom, id_presence, id_rsvp) 
              VALUES (:nom, :prenom, :presence, :rsvp)";
    
    $stmt = $this->pdo->prepare($query);
    $stmt->bindParam(':nom', $nom);
    $stmt->bindParam(':prenom', $prenom);
    $stmt->bindParam(':presence', $id_presence);
    $stmt->bindParam(':rsvp', $id_rsvp);
    $stmt->execute();

    return $this->pdo->lastInsertId();
}


    public function insertMusique(string $nom, int $id_personne): void
{
    $stmt = $this->pdo->prepare("INSERT INTO musique (nom, id_personne) VALUES (?, ?)");
    $stmt->execute([$nom, $id_personne]);
}

    public function getAllWithDetails(): array
    {
        $query = $this->pdo->query("
            SELECT 
                personne.id_personne, 
                personne.nom, 
                personne.prenom,
                presence.desc AS presence,
                rsvp.date_rsvp,
                musique.nom AS musique
            FROM personne
            LEFT JOIN presence ON personne.id_presence = presence.id_presence
            LEFT JOIN rsvp ON personne.id_rsvp = rsvp.id_rsvp
            LEFT JOIN musique ON musique.id_personne = personne.id_personne
            ORDER BY rsvp.date_rsvp DESC, personne.nom ASC
        ");

        return $query->fetchAll(PDO::FETCH_ASSOC);
    }
}
