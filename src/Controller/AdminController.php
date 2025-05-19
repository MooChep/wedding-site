<?php
// src/Controller/AdminController.php
namespace App\Controller;

use App\Database;
use App\Model\Personne;
use PDO;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;
use App\Model\FAQ;

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
        $personneModel = new Personne(pdo: $pdo); // ← IMPORTANT
        $personnes = $personneModel->getAllWithDetails();

        echo $this->twig->render(name: 'admin/admin.twig', context: [
            'personnes' => $personnes
        ]);
    }

    public function showFAQModeration(): void
    {
        $faqModel = new FAQ();
        $pending = $faqModel->getPendingQuestions();

        echo $this->twig->render(name: 'admin/faq_admin.twig', context: [
            'questions' => $pending,
            'title' => 'Modération FAQ'
        ]);
    }

    public function validateFAQ(array $get): never
    {
        $id = $get["validate"] ?? NULL;
        $faqModel = new FAQ();
        $faqModel->setVisible(id: $id, visible: true);

        header(header: 'Location: /admin/faq');
        exit;
    }
}
