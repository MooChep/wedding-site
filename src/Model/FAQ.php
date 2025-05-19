<?php

namespace App\Model;
use App\Database;

class FAQ {
    private $pdo;

    public function __construct()
    {
        $this->pdo = Database::getConnection();
    }

    public function getQuestions(string $visible = "1")
    {
        $stmt = $this->pdo->prepare("SELECT id, nom, email, question FROM faq WHERE visible = :v  ORDER BY id DESC");
        $stmt->execute(['v' => $visible]);

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getPendingQuestions()
    {
        $stmt = $this->pdo->prepare("SELECT id, nom, email, question FROM faq WHERE visible = 0 ORDER BY id DESC");
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }   

    public function setVisible($id, $visible)
    {
        $stmt = $this->pdo->prepare("UPDATE faq SET visible = :v WHERE id = :id");
        $stmt->execute(['v' => $visible ? 1 : 0, 'id' => $id]);
    }

    public function deleteQuestions($id)
    {
        $stmt = $this->pdo->prepare('DELETE FROM faq WHERE id = :id');
        $stmt->execute(['id' => $id]);
    }

    public function addQuestion(array $data)
    {
        $stmt = $this->pdo->prepare('INSERT INTO faq (nom, email, question, visible) VALUES (:nom, :email, :question, :visible)');
        $stmt->execute($data);
    }
}
