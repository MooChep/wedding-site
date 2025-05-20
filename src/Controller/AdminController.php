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

    private function requireAdmin(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (empty($_SESSION['is_admin'])) {
            header('Location: /login');
            exit;
        }
    }

    public function __construct()
    {
        $this->requireAdmin();
        $loader = new FilesystemLoader(__DIR__ . '/../../templates');
        $this->twig = new Environment($loader);

        // Connexion à la BDD via Database.php
        $this->pdo = Database::getConnection();
    }
    public function index(): void
    {
        $this->requireAdmin();
        echo $this->twig->render(name: 'admin/admin.twig');
    }
    public function showRsvpStatus(): void
    {
        $this->requireAdmin();
        $pdo = Database::getConnection();
        $personneModel = new Personne(pdo: $pdo); // ← IMPORTANT
        $personnes = $personneModel->getAllWithDetails();

        echo $this->twig->render(name: 'admin/admin_rsvp.twig', context: [
            'personnes' => $personnes
        ]);
    }

    public function showFAQModeration(): void
    {
        $this->requireAdmin();

        $faqModel = new FAQ();
        $validated = $faqModel->getQuestions();
        $pending = $faqModel->getPendingQuestions();
        $refused = $faqModel->getQuestions("0");

        echo $this->twig->render(name: 'admin/admin_faq.twig', context: [
            'validated' => $validated,
            'pending' => $pending,
            'refused' => $refused,
            'title' => 'Modération FAQ'
        ]);
    }

    public function handleFAQ(array $get): never
    {
        $this->requireAdmin();

        $faqModel = new FAQ();
        foreach ($_GET as $key => $value) {
            switch ($key) {
                case 'validate':
                    // Exemple : valider la question ID $value
                    $id = $get["validate"] ?? NULL;
                    $faqModel->setVisible(id: $id, visible: true);
                    break;
                case 'delete':
                    $id = $get['delete'] ?? NULL;
                    $faqModel->deleteQuestions(id: $id);
                    break;
                case 'mask':
                    $id = $get["mask"] ?? NULL;
                    $faqModel->setVisible(id: $id, visible: false);
                    break;
                default:

                    break;
            }
        }
        
        exit;
    }

}
