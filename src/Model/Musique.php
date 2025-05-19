<?php
namespace App\Model;

use PDO;

class Musique
{
    private PDO $pdo;

    public function __construct()
    {
        $this->pdo = new PDO('mysql:host=localhost;dbname=wedding_db;charset=utf8', 'root', '');
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
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
