<?php
namespace App\Model;

use App\Database;
use PDO;

class RSVP
{
    private PDO $pdo;

    public function __construct()
    {
        $this->pdo = Database::getConnection(); 
    }

    public function create(): int
    {
        $stmt = $this->pdo->prepare("INSERT INTO RSVP (date_rsvp) VALUES (NOW())");
        $stmt->execute();
        return $this->pdo->lastInsertId();
    }
}
