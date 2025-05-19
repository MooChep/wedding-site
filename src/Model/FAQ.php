<?php
namespace App\Model;

use PDO;

class FAQ
{
    private PDO $pdo;

    public function __construct()
    {
        $this->pdo = new PDO('mysql:host=localhost;dbname=wedding_db;charset=utf8', 'root', '');
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public function submit(string $nom, string $prenom, string $email, string $question): void
    {
        $stmt = $this->pdo->prepare("INSERT INTO faq (nom, prenom, email, question) VALUES (:nom, :prenom, :email, :question)");
        $stmt->execute([
            ':nom' => $nom,
            ':prenom' => $prenom,
            ':email' => $email,
            ':question' => $question
        ]);
    }

    public function findAll(): array
    {
        $stmt = $this->pdo->query("SELECT * FROM faq");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
