<?php
namespace App\Model;

use App\Database;
use PDO;

class Personne
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::getConnection();
    }

    public function findAll(): array
    {
        $stmt = $this->db->query('SELECT * FROM personne');
        return $stmt->fetchAll();
    }

    public function add(array $data): bool
    {
        $sql = "INSERT INTO personne (nom, prenom, id_presence, id_rsvp) VALUES (:nom, :prenom, :id_presence, :id_rsvp)";
        $stmt = $this->db->prepare($sql);
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

    public function insertPersonne(string $nom, string $prenom, int $id_presence, int $id_rsvp): int
{
    $stmt = $this->pdo->prepare("INSERT INTO personne (nom, prenom, id_presence, id_rsvp) VALUES (?, ?, ?, ?)");
    $stmt->execute([$nom, $prenom, $id_presence, $id_rsvp]);
    return $this->pdo->lastInsertId();
}

    public function insertMusique(string $nom, int $id_personne): void
{
    $stmt = $this->pdo->prepare("INSERT INTO musique (nom, id_personne) VALUES (?, ?)");
    $stmt->execute([$nom, $id_personne]);
}

}
