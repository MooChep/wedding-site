<?php

namespace App\Model;
use App\Database;

class FAQ {
    private $pdo;

    public function __construct()
    {
        $this->pdo = Database::getConnection();
    }

    public function getVisibleQuestions()
    {
        $stmt = $this->pdo->prepare("SELECT nom, question FROM faq WHERE visible = 1 ORDER BY id DESC");
        $stmt->execute();
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

}
