<?php
// src/Controller/AdminController.php
namespace App\Controller;

use App\Database;
use App\Model\Personne;
use PDO;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class AdminController
{
    private Environment $twig;
    private PDO $pdo;

    public function __construct()
    {
        $loader = new FilesystemLoader(__DIR__ . '/../../templates');
        $this->twig = new Environment($loader);

        // Connexion à la BDD via Database.php
        $this->pdo = Database::getConnection();
    }

    public function index(): void
    {
        $pdo = Database::getConnection();
        $personneModel = new Personne($pdo); // ← IMPORTANT
        $personnes = $personneModel->getAllWithDetails();

        echo $this->twig->render('admin.twig', [
            'personnes' => $personnes
        ]);
    }
}
