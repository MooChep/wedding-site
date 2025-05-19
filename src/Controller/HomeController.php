<?php
namespace App\Controller;

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class HomeController
{
    private Environment $twig;

    public function __construct()
    {
        $loader = new FilesystemLoader(__DIR__ . '/../../templates');
        $this->twig = new Environment($loader);
    }

    public function index()
    {
        echo $this->twig->render('home.twig', [
            'title' => 'Accueil',
            'message' => 'Bienvenue dans la structure MVC !'
        ]);
    }
}
