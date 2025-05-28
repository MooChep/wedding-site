<?php
namespace App\Model;

use APP\Database;
use PDO;

class Musique
{
    private PDO $pdo;

    public function __construct()
    {
        $this->pdo = Database::getConnection();
    }

    public function add(string $nom, int $idPersonne): void
    {
        $stmt = $this->pdo->prepare("INSERT INTO musique (nom, id_personne) VALUES (:nom, :id_personne)");
        $stmt->execute([
            ':nom' => $nom,
            ':id_personne' => $idPersonne
        ]);
    }
}
