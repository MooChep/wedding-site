<?php
namespace App\Model;

use App\Database;
use PDO;

class Presence
{
    private PDO $pdo;

    public function __construct()
    {
        $this->pdo = Database::getConnection();     
    }

    public function findAll(): array
    {
        $stmt = $this->pdo->query("SELECT * FROM presence");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
