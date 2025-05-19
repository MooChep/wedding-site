<?php
namespace App\Model;

use PDO;

class Presence
{
    private PDO $pdo;

    public function __construct()
    {
        $this->pdo = new PDO('mysql:host=localhost;dbname=wedding_db;charset=utf8', 'root', '');
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public function findAll(): array
    {
        $stmt = $this->pdo->query("SELECT * FROM presence");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
