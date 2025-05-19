<?php

namespace App\Controller;

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class ContactController
{
    private Environment $twig;

    public function __construct()
    {
        $loader = new FilesystemLoader(__DIR__ . '/../../templates');
        $this->twig = new Environment($loader);
    }

    public function index(string $method)
    {
        $data = ['title' => 'Contact'];

        if ($method === 'POST') {
            $nom = $_POST['nom'] ?? '';
            $message = $_POST['message'] ?? '';
            $data['success'] = "Merci $nom, ton message a été reçu !";
        }

        echo $this->twig->render('contact.twig', $data);
    }
}
