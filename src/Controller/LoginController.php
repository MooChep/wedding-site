<?php

namespace App\Controller;

use App\Database;
use PDO;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class LoginController
{
    private Environment $twig;
    private PDO $pdo;

    public function __construct()
    {
        $loader = new FilesystemLoader(__DIR__ . '/../../templates');
        $this->twig = new Environment($loader);
        $this->pdo = Database::getConnection();
    }

    public function showLoginForm(): void
    {
        echo $this->twig->render('login.twig', ['title' => 'Connexion Admin']);
    }

    public function login(array $post): void
    {
        $stmt = $this->pdo->prepare('SELECT * FROM admin WHERE username = :username');
        $stmt->execute(['username' => $post['username']]);
        $admin = $stmt->fetch();

        if ($admin && password_verify($post['password'], $admin['password'])) {
            $_SESSION['is_admin'] = true;
            header('Location: /admin');
            exit;
        }

        echo $this->twig->render('login.twig', [
            'error' => 'Identifiants incorrects',
            'title' => 'Connexion Admin'
        ]);
    }

    public function logout(): void
    {
        session_destroy();
        header('Location: /login');
        exit;
    }
}
